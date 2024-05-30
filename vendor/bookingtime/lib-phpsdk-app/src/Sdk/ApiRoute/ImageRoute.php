<?php

namespace bookingtime\phpsdkapp\Sdk\ApiRoute;
use bookingtime\phpsdkapp\Sdk\Route;
use bookingtime\phpsdkapp\Lib\BasicLib;



/**
 * handle specific API requests
 *
 * @author <bookingtime GmbH>
 */
class ImageRoute extends Route {



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

		//make mock request with dummi content
		if($this->httpClient->getMock()) {
			$fakeId='rO'.BasicLib::getRandomHash(30);
			$response=$this->httpClient->mockRequest('POST','image/add',$expectedResponseCode,[
				'class'=>'IMAGE_SHORT',
				'id'=>$fakeId,
				'url'=>'http://localhost/image/'.$fakeId,
			],[
				['class'=>'MESSAGE','type'=>'success','parameter'=>NULL,'text'=>'Image successfully uploaded.'],
			]);
			return $response['content'];
		}

		//make request to API
		$this->checkUrlParameters(['organizationId'],$urlParameter);
		$response=$this->httpClient->request('POST','/organization/'.$urlParameter['organizationId'].'/image/add',$requestContent,$expectedResponseCode);
		#die(BasicLib::debug($response));
		return $response['content'];
	}
}
