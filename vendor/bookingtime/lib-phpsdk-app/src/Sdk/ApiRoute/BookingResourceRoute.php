<?php

namespace bookingtime\phpsdkapp\Sdk\ApiRoute;
use bookingtime\phpsdkapp\Sdk\Route;
use bookingtime\phpsdkapp\Lib\BasicLib;



/**
 * handle specific API requests
 *
 * @author <bookingtime GmbH>
 */
class BookingResourceRoute extends Route {



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
		$this->checkUrlParameters(['organizationId','bookingResourceId'],$urlParameter);
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/bookingResource/'.$urlParameter['bookingResourceId'].'/show',[],$expectedResponseCode);
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
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/bookingResource/'.$urlParameter['customId'].'/identify',[],$expectedResponseCode);
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
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/bookingResource/'.($all?'indexAll':'index').'/'.($urlParameter['page']?$urlParameter['page']:'1'),[],$expectedResponseCode);
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
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/bookingResource/'.($all?'filterAll':'filter').'/'.($urlParameter['page']?$urlParameter['page']:'1').'?searchQuery='.$urlParameter['searchQuery'],[],$expectedResponseCode);
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
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/bookingResource/'.($all?'listAll':'list'),[],$expectedResponseCode);
		#die(BasicLib::debug($response));
		return $response['content'];
	}



	/**
	 * availability listDay
	 *
	 * @param	array		$urlParameter: list of url paramerts like ids
	 * @param	integer	$expectedResponseCode: expected http response code for http-client
	 * @return	array		reponse content
	 */
	public function availabilityListDay(array $urlParameter,$expectedResponseCode) {
		//check submitted parameters
		BasicLib::checkType('integer',$expectedResponseCode,__METHOD__.'(): expectedResponseCode');

		//make mock request with dummi content
		if($this->httpClient->getMock()) {
			$response=$this->httpClient->mockRequest('POST','bookingResource/availability/listDay',$expectedResponseCode,[
				'class'=>'RANGE_LIST',
				'rangeStart'=>'2021-09-28T00:00:00+02:00',
				'rangeEnd'=>'2021-09-29T00:00:00+02:00',
				'timeZone'=>'Europe/Berlin',
				'list'=>[
					[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-09-28',
						'availabilityList'=>[],
					],
				],
			],[
				['class'=>'MESSAGE','type'=>'success','parameter'=>NULL,'text'=>''],
			]);
			return $response['content'];
		}

		//make request to API
		$this->checkUrlParameters(['organizationId','bookingResourceId'],$urlParameter);
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/bookingResource/'.$urlParameter['bookingResourceId'].'/availability/year/'.$urlParameter['year'].'/month/'.$urlParameter['month'].'/day/'.$urlParameter['day'].'/listDay',[],$expectedResponseCode);
		#die(BasicLib::debug($response));
		return $response['content'];
	}



	/**
	 * availability listWeek
	 *
	 * @param	array		$urlParameter: list of url paramerts like ids
	 * @param	integer	$expectedResponseCode: expected http response code for http-client
	 * @return	array		reponse content
	 */
	public function availabilityListWeek(array $urlParameter,$expectedResponseCode) {
		//check submitted parameters
		BasicLib::checkType('integer',$expectedResponseCode,__METHOD__.'(): expectedResponseCode');

		//make mock request with dummi content
		if($this->httpClient->getMock()) {
			$response=$this->httpClient->mockRequest('POST','bookingResource/availability/listWeek',$expectedResponseCode,[
				'class'=>'RANGE_LIST',
				'rangeStart'=>'2021-09-27T00:00:00+02:00',
				'rangeEnd'=>'2021-10-04T00:00:00+02:00',
				'timeZone'=>'Europe/Berlin',
				'list'=>[
					[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-09-27',
						'availabilityList'=>[],
					],[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-09-28',
						'availabilityList'=>[],
					],[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-09-29',
						'availabilityList'=>[],
					],[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-09-30',
						'availabilityList'=>[],
					],[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-10-01',
						'availabilityList'=>[],
					],[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-10-02',
						'availabilityList'=>[],
					],[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-10-03',
						'availabilityList'=>[],
					],[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-10-04',
						'availabilityList'=>[],
					],
				],
			],[
				['class'=>'MESSAGE','type'=>'success','parameter'=>NULL,'text'=>''],
			]);
			return $response['content'];
		}

		//make request to API
		$this->checkUrlParameters(['organizationId','bookingResourceId'],$urlParameter);
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/bookingResource/'.$urlParameter['bookingResourceId'].'/availability/year/'.$urlParameter['year'].'/week/'.$urlParameter['week'].'/listWeek',[],$expectedResponseCode);
		#die(BasicLib::debug($response));
		return $response['content'];
	}



	/**
	 * availability listMonth
	 *
	 * @param	array		$urlParameter: list of url paramerts like ids
	 * @param	integer	$expectedResponseCode: expected http response code for http-client
	 * @return	array		reponse content
	 */
	public function availabilityListMonth(array $urlParameter,$expectedResponseCode) {
		//check submitted parameters
		BasicLib::checkType('integer',$expectedResponseCode,__METHOD__.'(): expectedResponseCode');

		//make mock request with dummi content
		if($this->httpClient->getMock()) {
			$response=$this->httpClient->mockRequest('POST','bookingResource/availability/listWeek',$expectedResponseCode,[
				'class'=>'RANGE_LIST',
				'rangeStart'=>'2021-09-01T00:00:00+02:00',
				'rangeEnd'=>'2021-10-01T00:00:00+02:00',
				'timeZone'=>'Europe/Berlin',
				'list'=>[
					[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-09-01',
						'availabilityList'=>[],
					],[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-09-02',
						'availabilityList'=>[],
					],[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-09-03',
						'availabilityList'=>[],
					],[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-09-04',
						'availabilityList'=>[],
					],[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-09-05',
						'availabilityList'=>[],
					],[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-09-06',
						'availabilityList'=>[],
					],[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-09-07',
						'availabilityList'=>[],
					],[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-09-08',
						'availabilityList'=>[],
					],[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-09-09',
						'availabilityList'=>[],
					],[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-09-10',
						'availabilityList'=>[],
					],[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-09-11',
						'availabilityList'=>[],
					],[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-09-12',
						'availabilityList'=>[],
					],[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-09-13',
						'availabilityList'=>[],
					],[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-09-14',
						'availabilityList'=>[],
					],[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-09-15',
						'availabilityList'=>[],
					],[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-09-16',
						'availabilityList'=>[],
					],[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-09-17',
						'availabilityList'=>[],
					],[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-09-18',
						'availabilityList'=>[],
					],[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-09-19',
						'availabilityList'=>[],
					],[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-09-20',
						'availabilityList'=>[],
					],[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-09-21',
						'availabilityList'=>[],
					],[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-09-22',
						'availabilityList'=>[],
					],[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-09-23',
						'availabilityList'=>[],
					],[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-09-24',
						'availabilityList'=>[],
					],[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-09-25',
						'availabilityList'=>[],
					],[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-09-26',
						'availabilityList'=>[],
					],[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-09-27',
						'availabilityList'=>[],
					],[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-09-28',
						'availabilityList'=>[],
					],[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-09-29',
						'availabilityList'=>[],
					],[
						'class'=>'AVAILABILITY_DAY',
						'date'=>'2021-09-30',
						'availabilityList'=>[],
					],
				],
			],[
				['class'=>'MESSAGE','type'=>'success','parameter'=>NULL,'text'=>''],
			]);
			return $response['content'];
		}

		//make request to API
		$this->checkUrlParameters(['organizationId','bookingResourceId'],$urlParameter);
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/bookingResource/'.$urlParameter['bookingResourceId'].'/availability/year/'.$urlParameter['year'].'/month/'.$urlParameter['month'].'/listMonth',[],$expectedResponseCode);
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
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/customEntity/'.$urlParameter['customEntityType'].'/'.$urlParameter['customEntityId'].'/bookingResource/index/'.($urlParameter['page']?$urlParameter['page']:'1'),[],$expectedResponseCode);
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
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/customEntity/'.$urlParameter['customEntityType'].'/'.$urlParameter['customEntityId'].'/bookingResource/filter/'.($urlParameter['page']?$urlParameter['page']:'1').'?searchQuery='.$urlParameter['searchQuery'],[],$expectedResponseCode);
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
		$response=$this->httpClient->request('GET','/organization/'.$urlParameter['organizationId'].'/customEntity/'.$urlParameter['customEntityType'].'/'.$urlParameter['customEntityId'].'/bookingResource/list',[],$expectedResponseCode);
		#die(BasicLib::debug($response));
		return $response['content'];
	}
}
