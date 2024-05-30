<?php

namespace bookingtime\phpsdkapp\Sdk\ApiRoute;
use bookingtime\phpsdkapp\Sdk\Route;
use bookingtime\phpsdkapp\Lib\BasicLib;



/**
 * handle specific API requests
 *
 * @author <bookingtime GmbH>
 */
class AppointmentRoute extends Route {



	/**
	 * add an entity
	 *
	 * @param	array		$urlParameter: list of url paramerts like ids
	 * @param	array		$requestContent: send this content to api
	 * @param	integer	$expectedResponseCode: expected http response code for http-client
	 * @return	array		reponse content
	 */
	public function add(array $urlParameter,array $requestContent,$expectedResponseCode) {
		//check submitted parameters
		BasicLib::checkType('integer',$expectedResponseCode,__METHOD__.'(): expectedResponseCode');

		//make request to API
		$this->checkUrlParameters(['organizationId'],$urlParameter);
		$response=$this->httpClient->request('POST','/organization/'.$urlParameter['organizationId'].'/appointment/add',$requestContent,$expectedResponseCode);
		#die(BasicLib::debug($response));
		return $response['content'];
	}



	/**
	 * show an entity
	 *
	 * @param	array		$urlParameter: list of url paramerts like ids
	 * @param	integer	$expectedResponseCode: expected http response code for http-client
	 * @return	array		reponse content
	 */
	public function show(array $urlParameter,$expectedResponseCode) {
		//check submitted parameters
		BasicLib::checkType('integer',$expectedResponseCode,__METHOD__.'(): expectedResponseCode');

		//make request to API
		$this->checkUrlParameters(['organizationId','appointmentId'],$urlParameter);
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/appointment/'.$urlParameter['appointmentId'].'/show',[],$expectedResponseCode);
		#die(BasicLib::debug($response));
		return $response['content'];
	}



	/**
	 * identify an entity
	 *
	 * @param	array		$urlParameter: list of url paramerts like ids
	 * @param	integer	$expectedResponseCode: expected http response code for http-client
	 * @return	array		reponse content
	 */
	public function identify(array $urlParameter,$expectedResponseCode) {
		//check submitted parameters
		BasicLib::checkType('integer',$expectedResponseCode,__METHOD__.'(): expectedResponseCode');

		//make request to API
		$this->checkUrlParameters(['organizationId','customId'],$urlParameter);
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/appointment/'.$urlParameter['customId'].'/identify',[],$expectedResponseCode);
		#die(BasicLib::debug($response));
		return $response['content'];
	}



	/**
	 * list day
	 *
	 * @param	array		$urlParameter: list of url paramerts like ids
	 * @param	integer	$expectedResponseCode: expected http response code for http-client
	 * @return	array		reponse content
	 */
	public function listDay(array $urlParameter,$expectedResponseCode) {
		//check submitted parameters
		BasicLib::checkType('integer',$expectedResponseCode,__METHOD__.'(): expectedResponseCode');

		//make request to API
		$this->checkUrlParameters(['organizationId','year','month','day'],$urlParameter);
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/appointment/year/'.$urlParameter['year'].'/month/'.$urlParameter['month'].'/day/'.$urlParameter['day'].'/listDay',[],$expectedResponseCode);
		#die(BasicLib::debug($response));
		return $response['content'];
	}



	/**
	 * list week
	 *
	 * @param	array		$urlParameter: list of url paramerts like ids
	 * @param	integer	$expectedResponseCode: expected http response code for http-client
	 * @return	array		reponse content
	 */
	public function listWeek(array $urlParameter,$expectedResponseCode) {
		//check submitted parameters
		BasicLib::checkType('integer',$expectedResponseCode,__METHOD__.'(): expectedResponseCode');

		//make request to API
		$this->checkUrlParameters(['organizationId','year','week'],$urlParameter);
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/appointment/year/'.$urlParameter['year'].'/week/'.$urlParameter['week'].'/listWeek',[],$expectedResponseCode);
		#die(BasicLib::debug($response));
		return $response['content'];
	}



	/**
	 * list month
	 *
	 * @param	array		$urlParameter: list of url paramerts like ids
	 * @param	integer	$expectedResponseCode: expected http response code for http-client
	 * @return	array		reponse content
	 */
	public function listMonth(array $urlParameter,$expectedResponseCode) {
		//check submitted parameters
		BasicLib::checkType('integer',$expectedResponseCode,__METHOD__.'(): expectedResponseCode');

		//make mock request with dummi content
		if($this->httpClient->getMock()) {
			$response=$this->httpClient->mockRequest('GET','appointment/year/2024/month/1/listMonth',$expectedResponseCode,[
				'class'=>'RANGE_LIST',
				'rangeStart'=>'2024-01-01T00:00:00+01:00',
				'rangeEnd'=>'2024-01-31T23:59:59+01:00',
				'timeZone'=>'Europe/Berlin',
				'list'=>[],
			],[
				['class'=>'MESSAGE','type'=>'success','parameter'=>NULL,'text'=>''],
			]);
			return $response['content'];
		}

		//make request to API
		$this->checkUrlParameters(['organizationId','year','month'],$urlParameter);
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/appointment/year/'.$urlParameter['year'].'/month/'.$urlParameter['month'].'/listMonth',[],$expectedResponseCode);
		#die(BasicLib::debug($response));
		return $response['content'];
	}



	/**
	 * edit an entity
	 *
	 * @param	array		$urlParameter: list of url paramerts like ids
	 * @param	array		$requestContent: send this content to api
	 * @param	integer	$expectedResponseCode: expected http response code for http-client
	 * @return	array		reponse content
	 */
	public function bookingResourceReplaceList(array $urlParameter,$expectedResponseCode) {
		//check submitted parameters
		BasicLib::checkType('integer',$expectedResponseCode,__METHOD__.'(): expectedResponseCode');

		//make mock request with dummi content
		if($this->httpClient->getMock()) {
			$fakeId='rO'.BasicLib::getRandomHash(30);
			$response=$this->httpClient->mockRequest('GET','appointment/bookingResourceReplaceList',$expectedResponseCode,[
				'class'=>'BOOKING_RESOURCE_REPLACE',
				'bookingResourceOld'=>[
					'class'=>'BOOKING_RESOURCE_SHORT',
					'id'=>'brXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
					'customId'=>'MA1',
					'type'=>'EMPLOYEE',
					'name'=>'Max Mustermann',
					'organizationId'=>'Max Mustermann',
				],
				'bookingResourceNew'=>[
					'class'=>'BOOKING_RESOURCE_SHORT',
					'id'=>'brXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
					'customId'=>'MA1',
					'type'=>'EMPLOYEE',
					'name'=>'Maxi Musterfrau',
					'organizationId'=>'Max Mustermann',
				],
				'bookingResourceIdList'=>['brXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX','brXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX'],
				'type'=>'EMPLOYEE',
			],[
				['class'=>'MESSAGE','type'=>'success','parameter'=>NULL,'text'=>''],
			]);
			return $response['content'];
		}

		//make request to API
		$this->checkUrlParameters(['organizationId','appointmentId'],$urlParameter);
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/appointment/'.$urlParameter['appointmentId'].'/bookingResourceReplaceList',[],$expectedResponseCode);
		#die(BasicLib::debug($response));
		return $response['content'];
	}



	/**
	 * edit an entity
	 *
	 * @param	array		$urlParameter: list of url paramerts like ids
	 * @param	array		$requestContent: send this content to api
	 * @param	integer	$expectedResponseCode: expected http response code for http-client
	 * @return	array		reponse content
	 */
	public function edit(array $urlParameter,array $requestContent,$expectedResponseCode) {
		//check submitted parameters
		BasicLib::checkType('integer',$expectedResponseCode,__METHOD__.'(): expectedResponseCode');

		//make request to API
		$this->checkUrlParameters(['organizationId','appointmentId'],$urlParameter);
		$response=$this->httpClient->request('PUT','/organization/'.$urlParameter['organizationId'].'/appointment/'.$urlParameter['appointmentId'].'/edit',$requestContent,$expectedResponseCode);
		#die(BasicLib::debug($response));
		return $response['content'];
	}



	/**
	 * move an entity
	 *
	 * @param	array		$urlParameter: list of url paramerts like ids
	 * @param	array		$requestContent: send this content to api
	 * @param	integer	$expectedResponseCode: expected http response code for http-client
	 * @return	array		reponse content
	 */
	public function move(array $urlParameter,array $requestContent,$expectedResponseCode) {
		//check submitted parameters
		BasicLib::checkType('integer',$expectedResponseCode,__METHOD__.'(): expectedResponseCode');

		//make request to API
		$this->checkUrlParameters(['organizationId','appointmentId'],$urlParameter);
		$response=$this->httpClient->request('PUT','/organization/'.$urlParameter['organizationId'].'/appointment/'.$urlParameter['appointmentId'].'/move',$requestContent,$expectedResponseCode);
		#die(BasicLib::debug($response));
		return $response['content'];
	}



	/**
	 * cancel an entity
	 *
	 * @param	array		$urlParameter: list of url paramerts like ids
	 * @param	integer	$expectedResponseCode: expected http response code for http-client
	 * @return	array		reponse content
	 */
	public function cancel(array $urlParameter,$expectedResponseCode) {
		//check submitted parameters
		BasicLib::checkType('integer',$expectedResponseCode,__METHOD__.'(): expectedResponseCode');

		//make request to API
		$this->checkUrlParameters(['organizationId','appointmentId'],$urlParameter);
		$response=$this->httpClient->request('PUT','/organization/'.$urlParameter['organizationId'].'/appointment/'.$urlParameter['appointmentId'].'/cancel',[],$expectedResponseCode);
		#die(BasicLib::debug($response));
		return $response['content'];
	}



	/**
	 * customEntity index
	 *
	 * @param	array		$urlParameter: list of url paramerts like ids
	 * @param	integer	$expectedResponseCode: expected http response code for http-client
	 * @return	array		reponse content
	 */
	public function customEntityIndex(array $urlParameter,$expectedResponseCode) {
		//check submitted parameters
		BasicLib::checkType('integer',$expectedResponseCode,__METHOD__.'(): expectedResponseCode');

		//make request to API
		$this->checkUrlParameters(['organizationId','customEntityId','customEntityType','page'],$urlParameter);
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/customEntity/'.$urlParameter['customEntityType'].'/'.$urlParameter['customEntityId'].'/appointment/index/'.($urlParameter['page']?$urlParameter['page']:'1'),[],$expectedResponseCode);
		#die(BasicLib::debug($response));
		return $response['content'];
	}



	/**
	 * customEntity filter
	 *
	 * @param	array		$urlParameter: list of url paramerts like ids
	 * @param	integer	$expectedResponseCode: expected http response code for http-client
	 * @return	array		reponse content
	 */
	public function customEntityFilter(array $urlParameter,$expectedResponseCode) {
		//check submitted parameters
		BasicLib::checkType('integer',$expectedResponseCode,__METHOD__.'(): expectedResponseCode');

		//make request to API
		$this->checkUrlParameters(['organizationId','customEntityId','customEntityType','page'],$urlParameter);
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/customEntity/'.$urlParameter['customEntityType'].'/'.$urlParameter['customEntityId'].'/appointment/filter/'.($urlParameter['page']?$urlParameter['page']:'1').'?searchQuery='.$urlParameter['searchQuery'],[],$expectedResponseCode);
		#die(BasicLib::debug($response));
		return $response['content'];
	}



	/**
	 * customEntity list
	 *
	 * @param	array		$urlParameter: list of url paramerts like ids
	 * @param	integer	$expectedResponseCode: expected http response code for http-client
	 * @return	array		reponse content
	 */
	public function customEntityList(array $urlParameter,$expectedResponseCode) {
		//check submitted parameters
		BasicLib::checkType('integer',$expectedResponseCode,__METHOD__.'(): expectedResponseCode');

		//make request to API
		$this->checkUrlParameters(['organizationId','customEntityId','customEntityType'],$urlParameter);
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/customEntity/'.$urlParameter['customEntityType'].'/'.$urlParameter['customEntityId'].'/appointment/list',[],$expectedResponseCode);
		#die(BasicLib::debug($response));
		return $response['content'];
	}



	/**
	 * customer index
	 *
	 * @param	array		$urlParameter: list of url paramerts like ids
	 * @param	integer	$expectedResponseCode: expected http response code for http-client
	 * @return	array		reponse content
	 */
	public function customerIndex(array $urlParameter,$expectedResponseCode) {
		//check submitted parameters
		BasicLib::checkType('integer',$expectedResponseCode,__METHOD__.'(): expectedResponseCode');

		//make request to API
		$this->checkUrlParameters(['organizationId','customerId'],$urlParameter);
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/customer/'.$urlParameter['customerId'].'/appointment/index/'.($urlParameter['page']?$urlParameter['page']:'1'),[],$expectedResponseCode);
		#die(BasicLib::debug($response));
		return $response['content'];
	}



	/**
	 * customer filter
	 *
	 * @param	array		$urlParameter: list of url paramerts like ids
	 * @param	integer	$expectedResponseCode: expected http response code for http-client
	 * @return	array		reponse content
	 */
	public function customerFilter(array $urlParameter,$expectedResponseCode) {
		//check submitted parameters
		BasicLib::checkType('integer',$expectedResponseCode,__METHOD__.'(): expectedResponseCode');

		//make request to API
		$this->checkUrlParameters(['organizationId','customerId'],$urlParameter);
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/customer/'.$urlParameter['customerId'].'/appointment/filter/'.($urlParameter['page']?$urlParameter['page']:'1').'?searchQuery='.$urlParameter['searchQuery'],[],$expectedResponseCode);
		#die(BasicLib::debug($response));
		return $response['content'];
	}



	/**
	 * customer list
	 *
	 * @param	array		$urlParameter: list of url paramerts like ids
	 * @param	integer	$expectedResponseCode: expected http response code for http-client
	 * @return	array		reponse content
	 */
	public function customerList(array $urlParameter,$expectedResponseCode) {
		//check submitted parameters
		BasicLib::checkType('integer',$expectedResponseCode,__METHOD__.'(): expectedResponseCode');

		//make request to API
		$this->checkUrlParameters(['organizationId','customerId'],$urlParameter);
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/customer/'.$urlParameter['customerId'].'/appointment/list',[],$expectedResponseCode);
		#die(BasicLib::debug($response));
		return $response['content'];
	}



	/**
	 * link/unlink entity
	 *
	 * @param	array		$urlParameter: list of url paramerts like ids
	 * @param	boolean	$unlink: true - unlink | false - link
	 * @param	integer	$expectedResponseCode: expected http response code for http-client
	 * @return	array		reponse content
	 */
	public function customerLink(array $urlParameter,$unlink,$expectedResponseCode) {
		//check submitted parameters
		BasicLib::checkType('boolean',$unlink,__METHOD__.'(): unlink');
		BasicLib::checkType('integer',$expectedResponseCode,__METHOD__.'(): expectedResponseCode');

		//make request to API
		$this->checkUrlParameters(['organizationId','appointmentId'],$urlParameter);
		$response=$this->httpClient->request($unlink?'UNLINK':'LINK','/organization/'.$urlParameter['organizationId'].'/appointment/'.$urlParameter['appointmentId'].'/customer/'.$urlParameter['customerId'].'/'.($unlink?'unlink':'link'),[],$expectedResponseCode);
		#die(BasicLib::debug($response));
		return $response['content'];
	}



	/**
	 * link/unlink entity
	 *
	 * @param	array		$urlParameter: list of url paramerts like ids
	 * @param	boolean	$unlink: true - unlink | false - link
	 * @param	integer	$expectedResponseCode: expected http response code for http-client
	 * @return	array		reponse content
	 */
	public function fileLink(array $urlParameter,$unlink,$expectedResponseCode) {
		//check submitted parameters
		BasicLib::checkType('boolean',$unlink,__METHOD__.'(): unlink');
		BasicLib::checkType('integer',$expectedResponseCode,__METHOD__.'(): expectedResponseCode');

		//make request to API
		$this->checkUrlParameters(['organizationId','appointmentId'],$urlParameter);
		$response=$this->httpClient->request($unlink?'UNLINK':'LINK','/organization/'.$urlParameter['organizationId'].'/appointment/'.$urlParameter['appointmentId'].'/file/'.$urlParameter['fileId'].'/'.($unlink?'unlink':'link'),[],$expectedResponseCode);
		#die(BasicLib::debug($response));
		return $response['content'];
	}
}
