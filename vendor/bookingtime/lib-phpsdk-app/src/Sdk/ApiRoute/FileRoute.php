<?php

namespace bookingtime\phpsdkapp\Sdk\ApiRoute;
use bookingtime\phpsdkapp\Sdk\Route;
use bookingtime\phpsdkapp\Lib\BasicLib;



/**
 * handle specific API requests
 *
 * @author <bookingtime GmbH>
 */
class FileRoute extends Route {



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
		$response=$this->httpClient->request('POST','/organization/'.$urlParameter['organizationId'].'/file/add',$requestContent,$expectedResponseCode);
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
		$this->checkUrlParameters(['organizationId','fileId'],$urlParameter);
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/file/'.$urlParameter['fileId'].'/show',[],$expectedResponseCode);
		#die(BasicLib::debug($response));
		return $response['content'];
	}



	/**
	 * download an entity
	 *
	 * @param	array		$urlParameter: list of url paramerts like ids
	 * @param	integer	$expectedResponseCode: expected http response code for http-client
	 * @return	string	reponse content
	 */
	public function download(array $urlParameter,$expectedResponseCode) {
		//check submitted parameters
		BasicLib::checkType('integer',$expectedResponseCode,__METHOD__.'(): expectedResponseCode');

		//make request to API
		$this->checkUrlParameters(['organizationId','fileId'],$urlParameter);
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/file/'.$urlParameter['fileId'].'/download',[],$expectedResponseCode,FALSE);
		#die(BasicLib::debug($response));
		return $response;
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
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/file/'.$urlParameter['customId'].'/identify',[],$expectedResponseCode);
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
		$this->checkUrlParameters(['organizationId','page'],$urlParameter);
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/file/'.($all?'indexAll':'index').'/'.($urlParameter['page']?$urlParameter['page']:'1'),[],$expectedResponseCode);
		#die(BasicLib::debug($response));
		return $response['content'];
	}



	/**
	 * filter entities
	 *
	 * @param	array		$urlParameter: list of url paramerts like ids
	 * @param	boolean	$all: true - shows all in a short version | false - shows just a few in a detailed version
	 * @param	integer	$expectedResponseCode: expected http response code for http-client
	 * @return	array		reponse content
	 */
	public function filter(array $urlParameter,$all,$expectedResponseCode) {
		//check submitted parameters
		BasicLib::checkType('boolean',$all,__METHOD__.'(): all');
		BasicLib::checkType('integer',$expectedResponseCode,__METHOD__.'(): expectedResponseCode');

		//make request to API
		$this->checkUrlParameters(['organizationId','searchQuery','page'],$urlParameter);
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/file/'.($all?'filterAll':'filter').'/'.($urlParameter['page']?$urlParameter['page']:'1').'?searchQuery='.$urlParameter['searchQuery'],[],$expectedResponseCode);
		#die(BasicLib::debug($response));
		return $response['content'];
	}



	/**
	 * list entities
	 *
	 * @param	array		$urlParameter: list of url paramerts like ids
	 * @param	boolean	$all: true - shows all in a short version | false - shows just a few in a detailed version
	 * @param	integer	$expectedResponseCode: expected http response code for http-client
	 * @return	array		reponse content
	 */
	public function list(array $urlParameter,$all,$expectedResponseCode) {
		//check submitted parameters
		BasicLib::checkType('boolean',$all,__METHOD__.'(): all');
		BasicLib::checkType('integer',$expectedResponseCode,__METHOD__.'(): expectedResponseCode');

		//make request to API
		$this->checkUrlParameters(['organizationId'],$urlParameter);
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/file/'.($all?'listAll':'list'),[],$expectedResponseCode);
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
		$this->checkUrlParameters(['organizationId','fileId'],$urlParameter);
		$response=$this->httpClient->request('PUT','/organization/'.$urlParameter['organizationId'].'/file/'.$urlParameter['fileId'].'/edit',$requestContent,$expectedResponseCode);
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
		$this->checkUrlParameters(['organizationId','fileId'],$urlParameter);
		$response=$this->httpClient->request('DELETE','/organization/'.$urlParameter['organizationId'].'/file/'.$urlParameter['fileId'].'/delete',[],$expectedResponseCode);
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
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/customEntity/'.$urlParameter['customEntityType'].'/'.$urlParameter['customEntityId'].'/file/index/'.($urlParameter['page']?$urlParameter['page']:'1'),[],$expectedResponseCode);
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
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/customEntity/'.$urlParameter['customEntityType'].'/'.$urlParameter['customEntityId'].'/file/filter/'.($urlParameter['page']?$urlParameter['page']:'1').'?searchQuery='.$urlParameter['searchQuery'],[],$expectedResponseCode);
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
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/customEntity/'.$urlParameter['customEntityType'].'/'.$urlParameter['customEntityId'].'/file/list',[],$expectedResponseCode);
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
		$this->checkUrlParameters(['organizationId','customerId','page'],$urlParameter);
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/customer/'.$urlParameter['customerId'].'/file/index/'.($urlParameter['page']?$urlParameter['page']:'1'),[],$expectedResponseCode);
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
		$this->checkUrlParameters(['organizationId','customerId','page'],$urlParameter);
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/customer/'.$urlParameter['customerId'].'/file/filter/'.($urlParameter['page']?$urlParameter['page']:'1').'?searchQuery='.$urlParameter['searchQuery'],[],$expectedResponseCode);
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
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/customer/'.$urlParameter['customerId'].'/file/list',[],$expectedResponseCode);
		#die(BasicLib::debug($response));
		return $response['content'];
	}
}
