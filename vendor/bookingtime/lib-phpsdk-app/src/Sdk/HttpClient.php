<?php

namespace bookingtime\phpsdkapp\Sdk;
use Nyholm\Psr7\Factory\Psr17Factory;
use Buzz\{Browser,Client\Curl};
use bookingtime\phpsdkapp\Sdk\Exception\AuthenticationException;
use bookingtime\phpsdkapp\Sdk\Exception\RequestException;
use bookingtime\phpsdkapp\Lib\BasicLib;



/**
 * http client for api requests
 *
 * @author <bookingtime GmbH>
 */
class HttpClient {
	//class properties
	protected $config=[];//reference to current sdk configuration
	protected $buzz;//buzz http client
	protected $client_id='';//from app
	protected $client_secret='';//from app
	protected $urlPrefix='';//url prefix for the api
	protected $refreshToken='';//refesh-token from oauth
	protected $accessToken='';//current access-token from oauth
	protected $accessTokenOrganizationId='';//organizationId of current access-token
	protected $requestHeader=['Content-Type'=>'application/json; charset=utf-8','Authorization'=>''];//array with request headers for api
	protected $accessTokenExpireTimestamp=0;//save expire timestamp of current access-token as unix timestamp
	public $messageArray=[];//save messages from last api call here
	public $lastRequestInfo=[];//save the last request method, url and responseCode here



	/**
	 * set some class properties
	 *
	 * @param	string	$client_id: from app
	 * @param	string	$client_secret: from app or "anonymous"
	 * @param	array		$config: reference to configuration of SDK
	 * @return	void
	 */
	public function __construct($client_id,$client_secret,array &$config) {
		//check submitted parameters
		BasicLib::checkType('string',$client_id,__METHOD__.'(): client_id');
		BasicLib::checkType('string',$client_secret,__METHOD__.'(): client_secret');

		//save main sdk configuration
		$this->config=$config;

		//set class properties
		$this->client_id=$client_id;
		$this->client_secret=$client_secret;

		//build url prefix
		$this->urlPrefix=$this->config['appApiUrl'];
		if(substr($this->urlPrefix,-1)!='/') {$this->urlPrefix.='/';}
		$this->urlPrefix.=$this->config['locale'].'/';

		//buzz browser
		$this->buzz=new Browser(new Curl(new Psr17Factory(),[
			'allow_redirects'=>FALSE,//the client should follow HTTP redirects
			'timeout'=>$this->config['timeout'],//timeout in seconds
			'verify'=>TRUE,//check ssl certificates
		]),new Psr17Factory());

		//make request to authentication endpoint
		$this->getRefreshToken();
	}



	/**
	 * check if SDK is in mock-mode
	 *
	 * @return	bool
	 */
	public function getMock():bool {
		return ($this->config['mock']?TRUE:FALSE);
	}



	/**
	 * wrapper for buzz requests
	 *
	 * @param	string	$method: HTTP method
	 * @param	string	$requestUrlSuffix: last part of the request url
	 * @param	array		$requestContent: send this content to api
	 * @param	integer	$expectedResponseCode: throw exeption if we got an other response-code
	 * @param	boolean	$expectedJsonReponse: if TRUEm throw exeption if no JSON responsem otherwise return response-content directly
	 * @return	mixed		buzz response with message and content or string for file download
	 */
	public function request($method,$requestUrlSuffix,array $requestContent,$expectedResponseCode,$expectedJsonReponse=TRUE) {
		//check submitted parameters
		BasicLib::checkType('string',$method,__METHOD__.'(): method');
		BasicLib::checkType('string',$requestUrlSuffix,__METHOD__.'(): requestUrlSuffix');
		BasicLib::checkType('integer',$expectedResponseCode,__METHOD__.'(): expectedResponseCode');
		BasicLib::checkType('boolean',$expectedJsonReponse,__METHOD__.'(): expectedJsonReponse');

		//mock
		if($this->config['mock']) {return $this->mockRequest($method,$requestUrlSuffix,$expectedResponseCode,['mock-content'=>1]);}

		//make request url
		if($requestUrlSuffix[0]=='/') {$requestUrlSuffix=substr($requestUrlSuffix,1);}
		$requestUrl=$this->urlPrefix.$requestUrlSuffix;
		$this->lastRequestInfo=['method'=>$method,'requestUrl'=>$requestUrl,'responseCode'=>0];

		//check for organizationID
		$organizationId=[];
		$success=preg_match('/\/organization\/(f6[a-zA-Z0-9]{30})\//',$requestUrl,$organizationId);
		$organizationId=($success===1?$organizationId[1]:'');
		#die(BasicLib::debug($success,$organizationId));

		//get access-token the first time or if expired
		if(empty($this->accessToken) || time()>$this->accessTokenExpireTimestamp) {$this->getAccessToken($organizationId);}

		//check if existing accessToken is matching the organizationId
		if($organizationId!=$this->accessTokenOrganizationId) {$this->getAccessToken($organizationId);}

		//make api request
		$response=$this->buzz->request($method,$requestUrl,$this->requestHeader,(!empty($requestContent)?json_encode($requestContent):''));
		#die(BasicLib::debug('response',$response->getStatusCode(),$response->getBody()->__toString()));

		//check response
		$responseCode=$response->getStatusCode();
		$this->lastRequestInfo['responseCode']=$responseCode;
		#die(BasicLib::debug('response',$response->getStatusCode(),$response->getBody()->__toString()));
		if($responseCode!=$expectedResponseCode) {
			if($responseCode>=400 && $responseCode<=499) {throw new RequestException('client error: '.substr($response->getBody()->__toString(),0,9999),$responseCode);}
			if($responseCode>=500 && $responseCode<=599) {throw new RequestException('server error: '.substr($response->getBody()->__toString(),0,9999),$responseCode);}
			throw new RequestException('unknown error: '.substr($response->getBody()->__toString(),0,9999),$responseCode);
		}

		//check responseContent
		$responseContent=$response->getBody()->__toString();
		if(!$expectedJsonReponse) {return $responseContent;}//f.e. file download
		if($expectedJsonReponse && !basicLib::isJSON($responseContent)) {throw new \BadMethodCallException('JSON Response expected!');}
		$responseArray=json_decode($responseContent,TRUE);

		//save messages from api
		$this->messageArray=[];
		if(array_key_exists('messageList',$responseArray) && !empty($responseArray['messageList'])) {$this->messageArray=$responseArray['messageList'];}

		//return content as array
		return $responseArray;
	}



	/**
	 * wrapper for buzz requests
	 *
	 * @param	string	$method: HTTP method
	 * @param	string	$requestUrlSuffix: last part of the request url
	 * @param	integer	$expectedResponseCode: use return-code for fake response
	 * @param	array		$responseContent: fake content
	 * @param	array		$messageArray: fake messages
	 * @return	array		fake response with message and content
	 */
	public function mockRequest($method,$requestUrlSuffix,$expectedResponseCode,array $responseContent,array $messageArray=[]):array {
		//check submitted parameters
		BasicLib::checkType('string',$method,__METHOD__.'(): method');
		BasicLib::checkType('string',$requestUrlSuffix,__METHOD__.'(): requestUrlSuffix');
		BasicLib::checkType('integer',$expectedResponseCode,__METHOD__.'(): expectedResponseCode');

		//exception if not in mock-mode
		if(!$this->config['mock']) {throw new \RuntimeException(__METHOD__.'() #'.__LINE__.': For calling mockRequest() mock-mode must be on!');}

		//make request url
		if($requestUrlSuffix[0]=='/') {$requestUrlSuffix=substr($requestUrlSuffix,1);}
		$requestUrl=$this->urlPrefix.$requestUrlSuffix;
		$this->lastRequestInfo=['method'=>$method,'requestUrl'=>$requestUrl,'responseCode'=>$expectedResponseCode];
		$this->messageArray=$messageArray;

		//return fake content
		return ['messageList'=>$messageArray,'content'=>$responseContent];
	}



	/*******************************************************************
	 *
	 * INTERNAL HELPER FUNCTIONS
	 *
	 *******************************************************************/
	/**
	 * make first request to authentication endpoint to get the refreshToken
	 *
	 * @return	void
	 */
	protected function getRefreshToken():void {
		//mock
		if($this->config['mock']) {
			$this->lastRequestInfo=['method'=>'POST','requestUrl'=>$this->config['oauthUrl'],'responseCode'=>200];
			$this->accessTokenExpireTimestamp=time()+999999999999999;
			return;
		}

		//make request to authentication endpoint
		$requestBody=[
			'grant_type'=>'client_credentials',
			'client_id'=>$this->client_id,
			'client_secret'=>$this->client_secret,
		];
		$this->lastRequestInfo=['method'=>'POST','requestUrl'=>$this->config['oauthUrl'],'responseCode'=>0];
		$response=$this->buzz->submitForm($this->config['oauthUrl'],$requestBody,'POST',['Content-Type'=>'multipart/form-data']);
		#die(BasicLib::debug('response',$response->getStatusCode(),$response->getBody()->__toString()));
		$this->lastRequestInfo['responseCode']=$response->getStatusCode();
		if($response->getStatusCode()!=200) {
			throw new AuthenticationException('Authentication failed: '.substr($response->getBody()->__toString(),0,9999),$response->getStatusCode());
		}
		$responseArray=json_decode($response->getBody()->__toString(),TRUE);

		//proccess response informations
		$this->refreshToken=$responseArray['refresh_token'];
	}



	/**
	 * get access-token with refresh-token for optional organizationId
	 *
	 * @param	string	$organizationId: organizationId of current access-token, if empty -> no organization in access-token
	 * @return	void
	 */
	protected function getAccessToken($organizationId):void {
		//check submitted parameters
		BasicLib::checkType('string',$organizationId,__METHOD__.'(): organizationId');

		//mock
		if($this->config['mock']) {
			$this->lastRequestInfo=['method'=>'POST','requestUrl'=>$this->config['oauthUrl'],'responseCode'=>200];
			$this->accessTokenExpireTimestamp=time()+999999999999999;
			return;
		}

		//make request to authentication endpoint
		$requestBody=[
			'grant_type'=>'refresh_token',
			'client_id'=>$this->client_id,
			'refresh_token'=>$this->refreshToken,
		];
		if(!empty($organizationId)) {$requestBody['organization_id']=$organizationId;}
		$this->accessTokenOrganizationId=$organizationId;
		#echo('get accessToken for organizationId: '.$organizationId."\n");
		$this->lastRequestInfo=['method'=>'POST','requestUrl'=>$this->config['oauthUrl'],'responseCode'=>0];
		$response=$this->buzz->submitForm($this->config['oauthUrl'],$requestBody,'POST',['Content-Type'=>'multipart/form-data']);
		#die(BasicLib::debug('response',$response->getStatusCode(),$response->getBody()->__toString()));
		$this->lastRequestInfo['responseCode']=$response->getStatusCode();
		if($response->getStatusCode()!=200) {
			throw new AuthenticationException('Authentication refresh failed: '.substr($response->getBody()->__toString(),0,9999),$response->getStatusCode());
		}

		//proccess new token informations
		$responseArray=json_decode($response->getBody()->__toString(),TRUE);
		$this->accessToken=$responseArray['access_token'];
		$this->requestHeader['Authorization']='Bearer '.$this->accessToken;
		$this->accessTokenExpireTimestamp=intval(time()+$responseArray['expires_in']-60);//crop 1 minute to be save ;)
	}
}
