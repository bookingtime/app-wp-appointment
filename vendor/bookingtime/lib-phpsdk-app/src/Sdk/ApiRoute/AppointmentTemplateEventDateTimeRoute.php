<?php

namespace bookingtime\phpsdkapp\Sdk\ApiRoute;
use bookingtime\phpsdkapp\Sdk\Route;
use bookingtime\phpsdkapp\Lib\BasicLib;



/**
 * handle specific API requests
 *
 * @author <bookingtime GmbH>
 */
class AppointmentTemplateEventDateTimeRoute extends Route {



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
		$this->checkUrlParameters(['organizationId','appointmentTemplateId'],$urlParameter);
		$response=$this->httpClient->request('POST','/organization/'.$urlParameter['organizationId'].'/appointmentTemplate/'.$urlParameter['appointmentTemplateId'].'/appointmentTemplateEventDateTime/add',$requestContent,$expectedResponseCode);
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
		$this->checkUrlParameters(['organizationId','appointmentTemplateId','appointmentTemplateEventDateTimeId'],$urlParameter);
		$response=$this->httpClient->request('PUT','/organization/'.$urlParameter['organizationId'].'/appointmentTemplate/'.$urlParameter['appointmentTemplateId'].'/appointmentTemplateEventDateTime/'.$urlParameter['appointmentTemplateEventDateTimeId'].'/edit',$requestContent,$expectedResponseCode);
		#die(BasicLib::debug($response));
		return $response['content'];
	}



	/**
	 * delete an entity
	 *
	 * @param	array		$urlParameter: list of url paramerts like ids
	 * @param	integer	$expectedResponseCode: expected http response code for http-client
	 * @return	array		reponse content
	 */
	public function delete(array $urlParameter,$expectedResponseCode) {
		//check submitted parameters
		BasicLib::checkType('integer',$expectedResponseCode,__METHOD__.'(): expectedResponseCode');

		//make request to API
		$this->checkUrlParameters(['organizationId','appointmentTemplateId','appointmentTemplateEventDateTimeId'],$urlParameter);
		$response=$this->httpClient->request('DELETE','/organization/'.$urlParameter['organizationId'].'/appointmentTemplate/'.$urlParameter['appointmentTemplateId'].'/appointmentTemplateEventDateTime/'.$urlParameter['appointmentTemplateEventDateTimeId'].'/delete',[],$expectedResponseCode);
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
	public function bookingResourceLink(array $urlParameter,$unlink,$expectedResponseCode) {
		//check submitted parameters
		BasicLib::checkType('boolean',$unlink,__METHOD__.'(): unlink');
		BasicLib::checkType('integer',$expectedResponseCode,__METHOD__.'(): expectedResponseCode');

		//make request to API
		$this->checkUrlParameters(['organizationId','appointmentTemplateId','appointmentTemplateEventDateTimeId','bookingResourceId'],$urlParameter);
		$response=$this->httpClient->request($unlink?'UNLINK':'LINK','/organization/'.$urlParameter['organizationId'].'/appointmentTemplate/'.$urlParameter['appointmentTemplateId'].'/appointmentTemplateEventDateTime/'.$urlParameter['appointmentTemplateEventDateTimeId'].'/bookingResource/'.$urlParameter['bookingResourceId'].'/'.($unlink?'unlink':'link'),[],$expectedResponseCode);
		#die(BasicLib::debug($response));
		return $response['content'];
	}
}
