<?php

namespace bookingtime\phpsdkapp\Sdk\ApiRoute;
use bookingtime\phpsdkapp\Sdk\Route;
use bookingtime\phpsdkapp\Lib\BasicLib;



/**
 * handle specific API requests
 *
 * @author <bookingtime GmbH>
 */
class OnlineMeetingConnectionLogRoute extends Route {



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
		$this->checkUrlParameters(['organizationId','onlineMeetingConnectionId','onlineMeetingConnectionLogId'],$urlParameter);
		$response=$this->httpClient->request('GET','organization/'.$urlParameter['organizationId'].'/onlineMeetingConnection/'.$urlParameter['onlineMeetingConnectionId'].'/onlineMeetingConnectionLog/'.$urlParameter['onlineMeetingConnectionLogId'].'/show',[],$expectedResponseCode);
		#die(BasicLib::debug($response));
		return $response['content'];
	}



	/**
	 * index
	 *
	 * @param	array		$urlParameter: list of url paramerts like ids
	 * @param	integer	$expectedResponseCode: expected http response code for http-client
	 * @return	array		reponse content
	 */
	public function index(array $urlParameter,$expectedResponseCode) {
		//check submitted parameters
		BasicLib::checkType('integer',$expectedResponseCode,__METHOD__.'(): expectedResponseCode');

		//make request to API
		$this->checkUrlParameters(['organizationId','onlineMeetingConnectionId','page'],$urlParameter);
		$response=$this->httpClient->request('GET','organization/'.$urlParameter['organizationId'].'/onlineMeetingConnection/'.$urlParameter['onlineMeetingConnectionId'].'/index',[],$expectedResponseCode);
		#die(BasicLib::debug($response));
		return $response['content'];
	}
}
