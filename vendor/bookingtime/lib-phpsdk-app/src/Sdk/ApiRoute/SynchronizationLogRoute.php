<?php

namespace bookingtime\phpsdkapp\Sdk\ApiRoute;
use bookingtime\phpsdkapp\Sdk\Route;
use bookingtime\phpsdkapp\Lib\BasicLib;



/**
 * handle specific API requests
 *
 * @author <bookingtime GmbH>
 */
class SynchronizationLogRoute extends Route {



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
		$this->checkUrlParameters(['organizationId','synchronizationId','synchronizationLogId'],$urlParameter);
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/synchronization/'.$urlParameter['synchronizationId'].'/synchronizationLog/'.$urlParameter['synchronizationLogId'].'/show',[],$expectedResponseCode);
		#die(BasicLib::debug($response));
		return $response['content'];
	}



	/**
	 * index
	 *
	 * @param	array		$urlParameter: list of url paramerts like ids
	 * @param	boolean	$all: true - shows all in a short version | false - shows just a few in a detailed version
	 * @param	integer	$expectedResponseCode: expected http response code for http-client
	 * @return	array		reponse content
	 */
	public function index(array $urlParameter,$all,$expectedResponseCode) {
		//check submitted parameters
		BasicLib::checkType('boolean',$all,__METHOD__.'(): all');
		BasicLib::checkType('integer',$expectedResponseCode,__METHOD__.'(): expectedResponseCode');

		//make request to API
		$this->checkUrlParameters(['organizationId','synchronizationId','page'],$urlParameter);
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/synchronization/'.$urlParameter['synchronizationId'].'/synchronizationLog/index/'.($urlParameter['page']?$urlParameter['page']:'1'),[],$expectedResponseCode);
		#die(BasicLib::debug($response));
		return $response['content'];
	}
}
