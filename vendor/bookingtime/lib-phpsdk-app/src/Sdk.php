<?php

namespace bookingtime\phpsdkapp;
use bookingtime\phpsdkapp\Sdk\ApiRoute;
use bookingtime\phpsdkapp\Sdk\HttpClient;
use bookingtime\phpsdkapp\Lib\BasicLib;



/**
 * main SDK
 *
 *                         *,,,*    /*,*
 *                     ,,,(((((,,,/&%%%##/,,.
 *                  ,,,((//,,,&&&&((((((((((,,,,,,,,,,,,,,,,,,,,,,,,,,,,*
 *          .,,,,*(%&&&&&#&&&%((((((((((((((((,(%%%%%%%%%%%%%%%%%%%%%%%%%#*,,,.
 *      ,,,/&&&&&&&&&&%&&&((((((((((((((((((((*,(((((((((((((//////////////%%%%,,,           ,,,,(,,
 *    ,,(&&&&&%##########((((((((((((((((((((((,,((((((((((((///////////////////(#,,,,,,,,,,,,,**,,,
 *   ,*&&&&#,,,,(###/####((((((((((((((((((((((,,((((((((((/////////////////////////,,,,,,,,,,,,,,,,,,,
 *  ,*&&&##((############((((((((((((((((((((((*,((((((((/@,,,#@//////////////////////,,     .,,,,,,,
 * ,,%&&#######,,,(######((((((((((((((((((((((*,@@@#/(((@(,,.@@@@@&(///&@@@@@@@@&/////,,
 * ,,%&%######,,@@,/%*###((((((((((((((((((((((,,,,,,,*@/@,,,,,,,,,,,(@@,,,,,,,,,,,.@(//,,
 * ,,%&########,&@&(*####(#((((/*(((((((((((((*,((%@,,,,@(,,,@///@.,,.@@,,,,/@@@,,,,,@//,,
 * ,,%&##################(((*,*((((((((((((((,,(((&@,,,#@,,,(@//#@,,,@@*,,,,@@@@,,,,.@//,,
 * ,,%&##################(((#,(((((((((/,,,,,@@@&/,,,,&@(,,,@///@.,,.@@,,,,,,,,,,,,*@ //,,
 * ,,%&##################(((,/((((((,,((@.,,,,,,,,/@@#/@.,,#@///@,,,@@*,,,,,,,,*&@&/////,,
 * ,,%&##################(#,(((((((*.((@#,,,@((((((((((((((((////////@,,,%&////////////,,
 * ,,%&##############(((*,(((((((((((((@@@@@@((((((((((((((((///////#@@@@@/////////////,,
 * ,,%&##########*,,    ,*(/,,,,*((((((((((((((((((((((((((((//////////////////////////,,
 * ,,%&#########,,      ,*((((#,*((((((((((((((((((((((((((((//////////////////////////,,
 * ,,%&########/,       ,*((((#,*((((((((((((((((((((((((((((//////////////////////////,,
 * ,,%%########,,       ,*((((#,*((((((((((((((((((((,,(((((((///,/////////////////////,,
 * ,,%%########,,       ,*((((#,*((((((((((((((((((((,,   ,,////(,/////////////////////,,
 * ,,%%########,,       ,,##,(#,*((((((((((((((((((((,,   ,,((//(,/////////////////////,,
 * ,,%%#######(,        ,/#/,.#,*((((,/((((((((((((((,,   ,*(**,(,////##(//////////////,,
 * ,,%########*,        ,,/*##.,*,%,####.((((((((((((,,   ,**(((,,/.#,####,////////////,,
 * ,,#########.,         ,,###(,,#.####.##.((((((((((,,   ,,,(((*,,#.###,###.//////////,,
 * *,#########,,          ,,,*#.,#,###.####/(((((((((,,     ,,,((,,#.###,#####/////////,,
 *   ,,,,,,,,,.                .,,,###.####/(((((((,,/          .,,,,*##.###(///////,,,
 *                                 ,,,,,,,,,,,,,,,*                    ,,,,,,,,,,,,
 *
 * @author DKone <bookingtime GmbH>
 */
class Sdk {
	//class properties
	protected $httpClient;
	protected $config=[];//current config
	const DEFAULT_CONFIG=[
		'appApiUrl'=>'https://api.bookingtime.com/app/v3/',
		'oauthUrl'=>'https://auth.bookingtime.com/oauth/token',
		'locale'=>'en_EN',
		'timeout'=>30,
		'mock'=>FALSE,
	];



	/**
	 * set client_id, client_secret and optional configuration
	 *
	 * @param	string	$client_id: from app
	 * @param	string	$client_secret: from app or "anonymous"
	 * @param	array		$config: configuration for the sdk - optional
	 * @return	void
	 */
	public function __construct($client_id,$client_secret,array $config=[]) {
		//check submitted parameters
		BasicLib::checkType('string',$client_id,__METHOD__.'(): client_id');
		BasicLib::checkType('string',$client_secret,__METHOD__.'(): client_secret');

		//merge submitted configuration with default config
		$config=array_merge(self::DEFAULT_CONFIG,$config);
		$this->config=$config;
		#die(BasicLib::debug($config));

		//make http client and start authentication
		$this->httpClient=new HttpClient($client_id,$client_secret,$config);
	}



	/**
	 * get all messages from last api call
	 *
	 * @return	array		messages like [["type":"failure","parameter":"firstName","text":"This parameter is missing."], ...]
	 */
	public function getMessageArray():array {
		return $this->httpClient->messageArray;
	}



	/**
	 * get all messages from last api call as string seperated by newlines
	 *
	 * @return	string		like "failure[firstName]: This parameter is missing.\n ..."
	 */
	public function getMessageArrayAsString():string {
		$content='';
		foreach($this->httpClient->messageArray as $item) {
			$content.=$item['type'].(!empty($item['parameter'])?'['.$item['parameter'].']':'').': '.$item['text']."\n";
		}
		return $content;
	}



	/**
	 * get last request method, url and responseCode
	 *
	 * @return	array		like ['method'=>'POST','requestUrl'=>'...','responseCode'=>201]
	 */
	public function getLastRequestInfo():array {
		return $this->httpClient->lastRequestInfo;
	}



	/**
	 * get current config
	 *
	 * @return	array		self::config
	 */
	public function getConfig():array {
		return $this->config;
	}



	/**
	 * wrapper for all api calls
	 * NOTE: throw exeption if no 200 http reponse code of api request
	 *
	 * @param	string	$name: name of called method
	 * @param	array		$args: submitted method parameters - args[0]=urlParameter(required) // args[1]=data(optional)
	 * @return	mixed		depends on api call
	 */
	public function __call($name,array $args) {
		//check submitted parameters
		BasicLib::checkType('string',$name,__METHOD__.'(): name');

		//check argument count and type
		if(count($args)<1 || count($args)>2) {throw new \InvalidArgumentException('Expected one or two parameters for method: '.$name);}
		if(!is_array($args[0]) || (count($args)==2 && !is_array($args[1]))) {throw new \InvalidArgumentException('Expected parameters of type array for method: '.$name);}

		//make apiRoute object
		$strpos=strpos($name,'_');
		if($strpos===FALSE || $strpos<1) {throw new \BadMethodCallException('Undefined method called: '.$name);}
		switch(substr($name,0,$strpos)) {
			default: {
				throw new \BadMethodCallException('Undefined method called: '.$name);
			} case('appConfig'): {
				$apiRoute=new ApiRoute\AppConfigRoute($this->httpClient);
				break(1);
			} case('app'): {
				$apiRoute=new ApiRoute\AppRoute($this->httpClient);
				break(1);
			} case('appointment'): {
				$apiRoute=new ApiRoute\AppointmentRoute($this->httpClient);
				break(1);
			} case('appointmentTemplate'): {
				$apiRoute=new ApiRoute\AppointmentTemplateRoute($this->httpClient);
				break(1);
			} case('appointmentTemplateStep'): {
				$apiRoute=new ApiRoute\AppointmentTemplateStepRoute($this->httpClient);
				break(1);
			} case('availabilityException'): {
				$apiRoute=new ApiRoute\AvailabilityExceptionRoute($this->httpClient);
				break(1);
			} case('bookingResource'): {
				$apiRoute=new ApiRoute\BookingResourceRoute($this->httpClient);
				break(1);
			} case('bookingSlot'): {
				$apiRoute=new ApiRoute\BookingSlotRoute($this->httpClient);
				break(1);
			} case('bookingTemplate'): {
				$apiRoute=new ApiRoute\BookingTemplateRoute($this->httpClient);
				break(1);
			} case('contractAccount'): {
				$apiRoute=new ApiRoute\ContractAccountRoute($this->httpClient);
				break(1);
			} case('customEntity'): {
				$apiRoute=new ApiRoute\CustomEntityRoute($this->httpClient);
				break(1);
			} case('customer'): {
				$apiRoute=new ApiRoute\CustomerRoute($this->httpClient);
				break(1);
			} case('customerGroup'): {
				$apiRoute=new ApiRoute\CustomerGroupRoute($this->httpClient);
				break(1);
			} case('email'): {
				$apiRoute=new ApiRoute\EmailRoute($this->httpClient);
				break(1);
			} case('emailTemplate'): {
				$apiRoute=new ApiRoute\EmailTemplateRoute($this->httpClient);
				break(1);
			} case('employee'): {
				$apiRoute=new ApiRoute\EmployeeRoute($this->httpClient);
				break(1);
			} case('employeeGroup'): {
				$apiRoute=new ApiRoute\EmployeeGroupRoute($this->httpClient);
				break(1);
			} case('file'): {
				$apiRoute=new ApiRoute\FileRoute($this->httpClient);
				break(1);
			} case('image'): {
				$apiRoute=new ApiRoute\ImageRoute($this->httpClient);
				break(1);
			} case('license'): {
				$apiRoute=new ApiRoute\LicenseRoute($this->httpClient);
				break(1);
			} case('licenseConfig'): {
				$apiRoute=new ApiRoute\LicenseConfigRoute($this->httpClient);
				break(1);
			} case('log'): {
				$apiRoute=new ApiRoute\LogRoute($this->httpClient);
				break(1);
			} case('moduleConfig'): {
				$apiRoute=new ApiRoute\ModuleConfigRoute($this->httpClient);
				break(1);
			} case('module'): {
				$apiRoute=new ApiRoute\ModuleRoute($this->httpClient);
				break(1);
			} case('organization'): {
				$apiRoute=new ApiRoute\OrganizationRoute($this->httpClient);
				break(1);
			} case('packet'): {
				$apiRoute=new ApiRoute\PacketRoute($this->httpClient);
				break(1);
			} case('reportingJob'): {
				$apiRoute=new ApiRoute\ReportingJobRoute($this->httpClient);
				break(1);
			} case('resource'): {
				$apiRoute=new ApiRoute\ResourceRoute($this->httpClient);
				break(1);
			} case('sms'): {
				$apiRoute=new ApiRoute\SmsRoute($this->httpClient);
				break(1);
			} case('smsTemplate'): {
				$apiRoute=new ApiRoute\SmsTemplateRoute($this->httpClient);
				break(1);
			} case('static'): {
				$apiRoute=new ApiRoute\StaticRoute($this->httpClient);
				break(1);
			} case('synchronization'): {
				$apiRoute=new ApiRoute\SynchronizationRoute($this->httpClient);
				break(1);
			} case('synchronizationAppointment'): {
				$apiRoute=new ApiRoute\SynchronizationAppointmentRoute($this->httpClient);
				break(1);
			} case('synchronizationLog'): {
				$apiRoute=new ApiRoute\SynchronizationLogRoute($this->httpClient);
				break(1);
			}
		}

		//appConfig
		switch($name) {
			case('appConfig_add'): {
				return $apiRoute->add($args[0],$args[1],201);
			} case('appConfig_show'): {
				return $apiRoute->show($args[0],200);
			} case('appConfig_identify'): {
				return $apiRoute->identify($args[0],200);
			} case('appConfig_index'): {
				return $apiRoute->index($args[0],FALSE,200);
			} case('appConfig_filter'): {
				return $apiRoute->filter($args[0],FALSE,200);
			} case('appConfig_list'): {
				return $apiRoute->list($args[0],FALSE,200);
			} case('appConfig_indexAll'): {
				return $apiRoute->index($args[0],TRUE,200);
			} case('appConfig_filterAll'): {
				return $apiRoute->filter($args[0],TRUE,200);
			} case('appConfig_listAll'): {
				return $apiRoute->list($args[0],TRUE,200);
			} case('appConfig_edit'): {
				return $apiRoute->edit($args[0],$args[1],200);
			} case('appConfig_delete'): {
				return $apiRoute->delete($args[0],200);
			} case('appConfig_app_show'): {
				return $apiRoute->appShow($args[0],200);
			}
		}

		//app
		switch($name) {
			 case('app_show'): {
				return $apiRoute->show($args[0],200);
			} case('app_index'): {
				return $apiRoute->index($args[0],200);
			} case('app_filter'): {
				return $apiRoute->filter($args[0],200);
			} case('app_list'): {
				return $apiRoute->list($args[0],200);
			}
		}

		//appointment
		switch($name) {
			case('appointment_add'): {
				return $apiRoute->add($args[0],$args[1],201);
			} case('appointment_show'): {
				return $apiRoute->show($args[0],200);
			} case('appointment_identify'): {
				return $apiRoute->identify($args[0],200);
			} case('appointment_index'): {
				return $apiRoute->index($args[0],FALSE,200);
			} case('appointment_filter'): {
				return $apiRoute->filter($args[0],FALSE,200);
			} case('appointment_list'): {
				return $apiRoute->list($args[0],FALSE,200);
			} case('appointment_listDay'): {
				return $apiRoute->listDay($args[0],200);
			} case('appointment_listWeek'): {
				return $apiRoute->listWeek($args[0],200);
			} case('appointment_listMonth'): {
				return $apiRoute->listMonth($args[0],200);
			} case('appointment_indexAll'): {
				return $apiRoute->index($args[0],TRUE,200);
			} case('appointment_filterAll'): {
				return $apiRoute->filter($args[0],TRUE,200);
			} case('appointment_listAll'): {
				return $apiRoute->list($args[0],TRUE,200);
			} case('appointment_edit'): {
				return $apiRoute->edit($args[0],$args[1],200);
			} case('appointment_cancel'): {
				return $apiRoute->cancel($args[0],200);
			} case('appointment_customer_index'): {
				return $apiRoute->customerIndex($args[0],200);
			} case('appointment_customer_filter'): {
				return $apiRoute->customerFilter($args[0],200);
			} case('appointment_customer_list'): {
				return $apiRoute->customerList($args[0],200);
			} case('appointment_file_link'): {
				return $apiRoute->fileLink($args[0],FALSE,200);
			} case('appointment_file_unlink'): {
				return $apiRoute->fileLink($args[0],TRUE,200);
			}
		}

		//appointmentTemplate
		switch($name) {
			case('appointmentTemplate_add'): {
				return $apiRoute->add($args[0],$args[1],201);
			} case('appointmentTemplate_show'): {
				return $apiRoute->show($args[0],200);
			} case('appointmentTemplate_identify'): {
				return $apiRoute->identify($args[0],200);
			} case('appointmentTemplate_index'): {
				return $apiRoute->index($args[0],FALSE,200);
			} case('appointmentTemplate_filter'): {
				return $apiRoute->filter($args[0],FALSE,200);
			} case('appointmentTemplate_list'): {
				return $apiRoute->list($args[0],FALSE,200);
			} case('appointmentTemplate_indexAll'): {
				return $apiRoute->index($args[0],TRUE,200);
			} case('appointmentTemplate_filterAll'): {
				return $apiRoute->filter($args[0],TRUE,200);
			} case('appointmentTemplate_listAll'): {
				return $apiRoute->list($args[0],TRUE,200);
			} case('appointmentTemplate_edit'): {
				return $apiRoute->edit($args[0],$args[1],200);
			} case('appointmentTemplate_delete'): {
				return $apiRoute->delete($args[0],200);
			} case('appointmentTemplate_bookingResource_link'): {
				return $apiRoute->bookingResourceLink($args[0],FALSE,200);
			} case('appointmentTemplate_bookingResource_unlink'): {
				return $apiRoute->bookingResourceLink($args[0],TRUE,200);
			} case('appointmentTemplate_emailTemplate_link'): {
				return $apiRoute->emailTemplateLink($args[0],FALSE,200);
			} case('appointmentTemplate_emailTemplate_unlink'): {
				return $apiRoute->emailTemplateLink($args[0],TRUE,200);
			} case('appointmentTemplate_smsTemplate_link'): {
				return $apiRoute->smsTemplateLink($args[0],FALSE,200);
			} case('appointmentTemplate_smsTemplate_unlink'): {
				return $apiRoute->smsTemplateLink($args[0],TRUE,200);
			} case('appointmentTemplate_timeGrid_listWeek'): {
				return $apiRoute->timeGridListWeek($args[0],200);
			} case('appointmentTemplate_timeGrid_edit'): {
				return $apiRoute->timeGridEdit($args[0],$args[1],200);
			}
		}

		//appointmentTemplateStep
		switch($name) {
			case('appointmentTemplateStep_add'): {
				return $apiRoute->add($args[0],$args[1],201);
			} case('appointmentTemplateStep_edit'): {
				return $apiRoute->edit($args[0],$args[1],200);
			} case('appointmentTemplateStep_delete'): {
				return $apiRoute->delete($args[0],200);
			} case('appointmentTemplateStep_bookingResource_link'): {
				return $apiRoute->bookingResourceLink($args[0],FALSE,200);
			} case('appointmentTemplateStep_bookingResource_unlink'): {
				return $apiRoute->bookingResourceLink($args[0],TRUE,200);
			}
		}

		//availabilityException
		switch($name) {
			case('availabilityException_add'): {
				return $apiRoute->add($args[0],$args[1],201);
			} case('availabilityException_show'): {
				return $apiRoute->show($args[0],200);
			} case('availabilityException_identify'): {
				return $apiRoute->identify($args[0],200);
			} case('availabilityException_index'): {
				return $apiRoute->index($args[0],FALSE,200);
			} case('availabilityException_filter'): {
				return $apiRoute->filter($args[0],FALSE,200);
			} case('availabilityException_list'): {
				return $apiRoute->list($args[0],FALSE,200);
			} case('availabilityException_indexAll'): {
				return $apiRoute->index($args[0],TRUE,200);
			} case('availabilityException_filterAll'): {
				return $apiRoute->filter($args[0],TRUE,200);
			} case('availabilityException_listAll'): {
				return $apiRoute->list($args[0],TRUE,200);
			} case('availabilityException_edit'): {
				return $apiRoute->edit($args[0],$args[1],200);
			} case('availabilityException_delete'): {
				return $apiRoute->delete($args[0],200);
			} case('availabilityException_appointmentTemplate_index'): {
				return $apiRoute->appointmentTemplateIndex($args[0],200);
			} case('availabilityException_appointmentTemplate_filter'): {
				return $apiRoute->appointmentTemplateFilter($args[0],200);
			} case('availabilityException_appointmentTemplate_list'): {
				return $apiRoute->appointmentTemplateList($args[0],200);
			} case('availabilityException_bookingResource_index'): {
				return $apiRoute->bookingResourceIndex($args[0],200);
			} case('availabilityException_bookingResource_filter'): {
				return $apiRoute->bookingResourceFilter($args[0],200);
			} case('availabilityException_bookingResource_list'): {
				return $apiRoute->bookingResourceList($args[0],200);
			}
		}

		//bookingResource
		switch($name) {
			 case('bookingResource_show'): {
				return $apiRoute->show($args[0],200);
			} case('bookingResource_identify'): {
				return $apiRoute->identify($args[0],200);
			} case('bookingResource_index'): {
				return $apiRoute->index($args[0],FALSE,200);
			} case('bookingResource_filter'): {
				return $apiRoute->filter($args[0],FALSE,200);
			} case('bookingResource_list'): {
				return $apiRoute->list($args[0],FALSE,200);
			} case('bookingResource_indexAll'): {
				return $apiRoute->index($args[0],TRUE,200);
			} case('bookingResource_filterAll'): {
				return $apiRoute->filter($args[0],TRUE,200);
			} case('bookingResource_listAll'): {
				return $apiRoute->list($args[0],TRUE,200);
			}
		}

		//bookingSlot
		switch($name) {
			 case('bookingSlot_earliest'): {
				return $apiRoute->earliest($args[0],200);
			} case('bookingSlot_listDay'): {
				return $apiRoute->listDay($args[0],200);
			} case('bookingSlot_listWeek'): {
				return $apiRoute->listWeek($args[0],200);
			} case('bookingSlot_listMonth'): {
				return $apiRoute->listMonth($args[0],200);
			}
		}

		//bookingTemplate
		switch($name) {
			 case('bookingTemplate_show'): {
				return $apiRoute->show($args[0],200);
			} case('bookingTemplate_identify'): {
				return $apiRoute->identify($args[0],200);
			} case('bookingTemplate_index'): {
				return $apiRoute->index($args[0],FALSE,200);
			} case('bookingTemplate_filter'): {
				return $apiRoute->filter($args[0],FALSE,200);
			} case('bookingTemplate_list'): {
				return $apiRoute->list($args[0],FALSE,200);
			} case('bookingTemplate_indexAll'): {
				return $apiRoute->index($args[0],TRUE,200);
			} case('bookingTemplate_filterAll'): {
				return $apiRoute->filter($args[0],TRUE,200);
			} case('bookingTemplate_listAll'): {
				return $apiRoute->list($args[0],TRUE,200);
			} case('bookingTemplate_bookingResource_index'): {
				return $apiRoute->bookingResourceIndex($args[0],200);
			} case('bookingTemplate_bookingResource_filter'): {
				return $apiRoute->bookingResourceFilter($args[0],200);
			} case('bookingTemplate_bookingResource_list'): {
				return $apiRoute->bookingResourceList($args[0],200);
			}
		}

		//contractAccount
		switch($name) {
			 case('contractAccount_add'): {
				return $apiRoute->add($args[0],$args[1],201);
			}
		}

		//customEntity
		switch($name) {
			case('customEntity_add'): {
				return $apiRoute->add($args[0],$args[1],201);
			} case('customEntity_show'): {
				return $apiRoute->show($args[0],200);
			} case('customEntity_identify'): {
				return $apiRoute->identify($args[0],200);
			} case('customEntity_index'): {
				return $apiRoute->index($args[0],FALSE,200);
			} case('customEntity_filter'): {
				return $apiRoute->filter($args[0],FALSE,200);
			} case('customEntity_list'): {
				return $apiRoute->list($args[0],FALSE,200);
			} case('customEntity_indexAll'): {
				return $apiRoute->index($args[0],TRUE,200);
			} case('customEntity_filterAll'): {
				return $apiRoute->filter($args[0],TRUE,200);
			} case('customEntity_listAll'): {
				return $apiRoute->list($args[0],TRUE,200);
			} case('customEntity_edit'): {
				return $apiRoute->edit($args[0],$args[1],200);
			} case('customEntity_delete'): {
				return $apiRoute->delete($args[0],200);
			} case('customEntity_appointment_index'): {
				return $apiRoute->appointmentIndex($args[0],200);
			} case('customEntity_appointment_filter'): {
				return $apiRoute->appointmentFilter($args[0],200);
			} case('customEntity_appointment_list'): {
				return $apiRoute->appointmentList($args[0],200);
			} case('customEntity_appointmentTemplate_index'): {
				return $apiRoute->appointmentTemplateIndex($args[0],200);
			} case('customEntity_appointmentTemplate_filter'): {
				return $apiRoute->appointmentTemplateFilter($args[0],200);
			} case('customEntity_appointmentTemplate_list'): {
				return $apiRoute->appointmentTemplateList($args[0],200);
			} case('customEntity_bookingResource_index'): {
				return $apiRoute->bookingResourceIndex($args[0],200);
			} case('customEntity_bookingResource_filter'): {
				return $apiRoute->bookingResourceFilter($args[0],200);
			} case('customEntity_bookingResource_list'): {
				return $apiRoute->bookingResourceList($args[0],200);
			} case('customEntity_bookingTemplate_index'): {
				return $apiRoute->bookingTemplateIndex($args[0],200);
			} case('customEntity_bookingTemplate_filter'): {
				return $apiRoute->bookingTemplateFilter($args[0],200);
			} case('customEntity_bookingTemplate_list'): {
				return $apiRoute->bookingTemplateList($args[0],200);
			} case('customEntity_customEntity_index'): {
				return $apiRoute->customEntityIndex($args[0],200);
			} case('customEntity_customEntity_filter'): {
				return $apiRoute->customEntityFilter($args[0],200);
			} case('customEntity_customEntity_list'): {
				return $apiRoute->customEntityList($args[0],200);
			} case('customEntity_customer_index'): {
				return $apiRoute->customerIndex($args[0],200);
			} case('customEntity_customer_filter'): {
				return $apiRoute->customerFilter($args[0],200);
			} case('customEntity_customer_list'): {
				return $apiRoute->customerList($args[0],200);
			} case('customEntity_employee_index'): {
				return $apiRoute->employeeIndex($args[0],200);
			} case('customEntity_employee_filter'): {
				return $apiRoute->employeeFilter($args[0],200);
			} case('customEntity_employee_list'): {
				return $apiRoute->employeeList($args[0],200);
			} case('customEntity_resource_index'): {
				return $apiRoute->resourceIndex($args[0],200);
			} case('customEntity_resource_filter'): {
				return $apiRoute->resourceFilter($args[0],200);
			} case('customEntity_resource_list'): {
				return $apiRoute->resourceList($args[0],200);
			} case('customEntity_file_link'): {
				return $apiRoute->fileLink($args[0],FALSE,200);
			} case('customEntity_file_unlink'): {
				return $apiRoute->fileLink($args[0],TRUE,200);
			}
		}

		//customer
		switch($name) {
			case('customer_add'): {
				return $apiRoute->add($args[0],$args[1],201);
			} case('customer_show'): {
				return $apiRoute->show($args[0],200);
			} case('customer_identify'): {
				return $apiRoute->identify($args[0],200);
			} case('customer_index'): {
				return $apiRoute->index($args[0],FALSE,200);
			} case('customer_filter'): {
				return $apiRoute->filter($args[0],FALSE,200);
			} case('customer_list'): {
				return $apiRoute->list($args[0],FALSE,200);
			} case('customer_indexAll'): {
				return $apiRoute->index($args[0],TRUE,200);
			} case('customer_filterAll'): {
				return $apiRoute->filter($args[0],TRUE,200);
			} case('customer_listAll'): {
				return $apiRoute->list($args[0],TRUE,200);
			} case('customer_edit'): {
				return $apiRoute->edit($args[0],$args[1],200);
			} case('customer_delete'): {
				return $apiRoute->delete($args[0],200);
			} case('customer_customerGroup_link'): {
				return $apiRoute->customerGroupLink($args[0],FALSE,200);
			} case('customer_customerGroup_unlink'): {
				return $apiRoute->customerGroupLink($args[0],TRUE,200);
			} case('customer_file_link'): {
				return $apiRoute->fileLink($args[0],FALSE,200);
			} case('customer_file_unlink'): {
				return $apiRoute->fileLink($args[0],TRUE,200);
			}
		}

		//customerGroup
		switch($name) {
			case('customerGroup_add'): {
				return $apiRoute->add($args[0],$args[1],201);
			} case('customerGroup_show'): {
				return $apiRoute->show($args[0],200);
			} case('customerGroup_identify'): {
				return $apiRoute->identify($args[0],200);
			} case('customerGroup_index'): {
				return $apiRoute->index($args[0],FALSE,200);
			} case('customerGroup_filter'): {
				return $apiRoute->filter($args[0],FALSE,200);
			} case('customerGroup_list'): {
				return $apiRoute->list($args[0],FALSE,200);
			} case('customerGroup_indexAll'): {
				return $apiRoute->index($args[0],TRUE,200);
			} case('customerGroup_filterAll'): {
				return $apiRoute->filter($args[0],TRUE,200);
			} case('customerGroup_listAll'): {
				return $apiRoute->list($args[0],TRUE,200);
			} case('customerGroup_edit'): {
				return $apiRoute->edit($args[0],$args[1],200);
			} case('customerGroup_delete'): {
				return $apiRoute->delete($args[0],200);
			}
		}

		//email
		switch($name) {
			 case('email_show'): {
				return $apiRoute->show($args[0],200);
			} case('email_index'): {
				return $apiRoute->index($args[0],FALSE,200);
			} case('email_filter'): {
				return $apiRoute->filter($args[0],FALSE,200);
			} case('email_list'): {
				return $apiRoute->list($args[0],FALSE,200);
			} case('email_indexAll'): {
				return $apiRoute->index($args[0],TRUE,200);
			} case('email_filterAll'): {
				return $apiRoute->filter($args[0],TRUE,200);
			} case('email_listAll'): {
				return $apiRoute->list($args[0],TRUE,200);
			} case('email_resend'): {
				return $apiRoute->resend($args[0],201);
			} case('email_customer_index'): {
				return $apiRoute->customerIndex($args[0],200);
			} case('email_customer_filter'): {
				return $apiRoute->customerFilter($args[0],200);
			} case('email_customer_list'): {
				return $apiRoute->customerList($args[0],200);
			}
		}

		//emailTemplate
		switch($name) {
			case('emailTemplate_add'): {
				return $apiRoute->add($args[0],$args[1],201);
			} case('emailTemplate_show'): {
				return $apiRoute->show($args[0],200);
			} case('emailTemplate_identify'): {
				return $apiRoute->identify($args[0],200);
			} case('emailTemplate_index'): {
				return $apiRoute->index($args[0],FALSE,200);
			} case('emailTemplate_filter'): {
				return $apiRoute->filter($args[0],FALSE,200);
			} case('emailTemplate_list'): {
				return $apiRoute->list($args[0],FALSE,200);
			} case('emailTemplate_indexAll'): {
				return $apiRoute->index($args[0],TRUE,200);
			} case('emailTemplate_filterAll'): {
				return $apiRoute->filter($args[0],TRUE,200);
			} case('emailTemplate_listAll'): {
				return $apiRoute->list($args[0],TRUE,200);
			} case('emailTemplate_edit'): {
				return $apiRoute->edit($args[0],$args[1],200);
			} case('emailTemplate_delete'): {
				return $apiRoute->delete($args[0],200);
			} case('emailTemplate_file_link'): {
				return $apiRoute->fileLink($args[0],FALSE,200);
			} case('emailTemplate_file_unlink'): {
				return $apiRoute->fileLink($args[0],TRUE,200);
			}
		}

		//employee
		switch($name) {
			case('employee_add'): {
				return $apiRoute->add($args[0],$args[1],201);
			} case('employee_show'): {
				return $apiRoute->show($args[0],200);
			} case('employee_identify'): {
				return $apiRoute->identify($args[0],200);
			} case('employee_index'): {
				return $apiRoute->index($args[0],FALSE,200);
			} case('employee_filter'): {
				return $apiRoute->filter($args[0],FALSE,200);
			} case('employee_list'): {
				return $apiRoute->list($args[0],FALSE,200);
			} case('employee_indexAll'): {
				return $apiRoute->index($args[0],TRUE,200);
			} case('employee_filterAll'): {
				return $apiRoute->filter($args[0],TRUE,200);
			} case('employee_listAll'): {
				return $apiRoute->list($args[0],TRUE,200);
			} case('employee_permission'): {
				return $apiRoute->permission($args[0],200);
			} case('employee_edit'): {
				return $apiRoute->edit($args[0],$args[1],200);
			} case('employee_delete'): {
				return $apiRoute->delete($args[0],200);
			} case('employee_availability_listWeek'): {
				return $apiRoute->availabilityListWeek($args[0],200);
			} case('employee_availability_edit'): {
				return $apiRoute->availabilityEdit($args[0],$args[1],200);
			} case('employee_employeeGroup_link'): {
				return $apiRoute->employeeGroupLink($args[0],FALSE,200);
			} case('employee_employeeGroup_unlink'): {
				return $apiRoute->employeeGroupLink($args[0],TRUE,200);
			}
		}

		//employeeGroup
		switch($name) {
			case('employeeGroup_add'): {
				return $apiRoute->add($args[0],$args[1],201);
			} case('employeeGroup_show'): {
				return $apiRoute->show($args[0],200);
			} case('employeeGroup_identify'): {
				return $apiRoute->identify($args[0],200);
			} case('employeeGroup_index'): {
				return $apiRoute->index($args[0],FALSE,200);
			} case('employeeGroup_filter'): {
				return $apiRoute->filter($args[0],FALSE,200);
			} case('employeeGroup_list'): {
				return $apiRoute->list($args[0],FALSE,200);
			} case('employeeGroup_indexAll'): {
				return $apiRoute->index($args[0],TRUE,200);
			} case('employeeGroup_filterAll'): {
				return $apiRoute->filter($args[0],TRUE,200);
			} case('employeeGroup_listAll'): {
				return $apiRoute->list($args[0],TRUE,200);
			} case('employeeGroup_edit'): {
				return $apiRoute->edit($args[0],$args[1],200);
			} case('employeeGroup_delete'): {
				return $apiRoute->delete($args[0],200);
			} case('employeeGroup_appConfig_link'): {
				return $apiRoute->appConfigLink($args[0],FALSE,200);
			} case('employeeGroup_appConfig_unlink'): {
				return $apiRoute->appConfigLink($args[0],TRUE,200);
			}
		}

		//file
		switch($name) {
			case('file_add'): {
				return $apiRoute->add($args[0],$args[1],201);
			} case('file_show'): {
				return $apiRoute->show($args[0],200);
			} case('file_download'): {
				return $apiRoute->download($args[0],200);
			} case('file_identify'): {
				return $apiRoute->identify($args[0],200);
			} case('file_index'): {
				return $apiRoute->index($args[0],FALSE,200);
			} case('file_filter'): {
				return $apiRoute->filter($args[0],FALSE,200);
			} case('file_list'): {
				return $apiRoute->list($args[0],FALSE,200);
			} case('file_indexAll'): {
				return $apiRoute->index($args[0],TRUE,200);
			} case('file_filterAll'): {
				return $apiRoute->filter($args[0],TRUE,200);
			} case('file_listAll'): {
				return $apiRoute->list($args[0],TRUE,200);
			} case('file_edit'): {
				return $apiRoute->edit($args[0],$args[1],200);
			} case('file_delete'): {
				return $apiRoute->delete($args[0],200);
			} case('file_customEntity_index'): {
				return $apiRoute->customEntityIndex($args[0],200);
			} case('file_customEntity_filter'): {
				return $apiRoute->customEntityFilter($args[0],200);
			} case('file_customEntity_list'): {
				return $apiRoute->customEntityList($args[0],200);
			} case('file_customer_index'): {
				return $apiRoute->customerIndex($args[0],200);
			} case('file_customer_filter'): {
				return $apiRoute->customerFilter($args[0],200);
			} case('file_customer_list'): {
				return $apiRoute->customerList($args[0],200);
			}
		}

		//image
		switch($name) {
			case('image_add'): {
				return $apiRoute->add($args[0],$args[1],201);
			}
		}

		//license
		switch($name) {
			 case('license_show'): {
				return $apiRoute->show($args[0],200);
			} case('license_index'): {
				return $apiRoute->index($args[0],200);
			} case('license_filter'): {
				return $apiRoute->filter($args[0],200);
			} case('license_list'): {
				return $apiRoute->list($args[0],200);
			}
		}

		//licenseConfig
		switch($name) {
			case('licenseConfig_add'): {
				return $apiRoute->add($args[0],$args[1],201);
			} case('licenseConfig_show'): {
				return $apiRoute->show($args[0],200);
			} case('licenseConfig_identify'): {
				return $apiRoute->identify($args[0],200);
			} case('licenseConfig_index'): {
				return $apiRoute->index($args[0],FALSE,200);
			} case('licenseConfig_filter'): {
				return $apiRoute->filter($args[0],FALSE,200);
			} case('licenseConfig_list'): {
				return $apiRoute->list($args[0],FALSE,200);
			} case('licenseConfig_indexAll'): {
				return $apiRoute->index($args[0],TRUE,200);
			} case('licenseConfig_filterAll'): {
				return $apiRoute->filter($args[0],TRUE,200);
			} case('licenseConfig_listAll'): {
				return $apiRoute->list($args[0],TRUE,200);
			} case('licenseConfig_edit'): {
				return $apiRoute->edit($args[0],$args[1],200);
			} case('licenseConfig_delete'): {
				return $apiRoute->delete($args[0],200);
			}
		}

		//log
		switch($name) {
			 case('log_show'): {
				return $apiRoute->show($args[0],200);
			} case('log_index'): {
				return $apiRoute->index($args[0],FALSE,200);
			} case('log_filter'): {
				return $apiRoute->filter($args[0],FALSE,200);
			}
		}

		//moduleConfig
		switch($name) {
			case('moduleConfig_add'): {
				return $apiRoute->add($args[0],$args[1],201);
			} case('moduleConfig_show'): {
				return $apiRoute->show($args[0],200);
			} case('moduleConfig_identify'): {
				return $apiRoute->identify($args[0],200);
			} case('moduleConfig_index'): {
				return $apiRoute->index($args[0],FALSE,200);
			} case('moduleConfig_filter'): {
				return $apiRoute->filter($args[0],FALSE,200);
			} case('moduleConfig_list'): {
				return $apiRoute->list($args[0],FALSE,200);
			} case('moduleConfig_indexAll'): {
				return $apiRoute->index($args[0],TRUE,200);
			} case('moduleConfig_filterAll'): {
				return $apiRoute->filter($args[0],TRUE,200);
			} case('moduleConfig_listAll'): {
				return $apiRoute->list($args[0],TRUE,200);
			} case('moduleConfig_edit'): {
				return $apiRoute->edit($args[0],$args[1],200);
			} case('moduleConfig_delete'): {
				return $apiRoute->delete($args[0],200);
			}
		}

		//module
		switch($name) {
			 case('module_show'): {
				return $apiRoute->show($args[0],200);
			} case('module_index'): {
				return $apiRoute->index($args[0],200);
			} case('module_filter'): {
				return $apiRoute->filter($args[0],200);
			} case('module_list'): {
				return $apiRoute->list($args[0],200);
			}
		}

		//organization
		switch($name) {
			case('organization_add'): {
				return $apiRoute->add($args[0],$args[1],201);
			} case('organization_copy'): {
				return $apiRoute->copy($args[0],$args[1],201);
			} case('organization_show'): {
				return $apiRoute->show($args[0],200);
			} case('organization_move'): {
				return $apiRoute->move($args[0],$args[1],200);
			} case('organization_app_index'): {
				return $apiRoute->appIndex($args[0],200);
			} case('organization_app_filter'): {
				return $apiRoute->appFilter($args[0],200);
			} case('organization_app_list'): {
				return $apiRoute->appList($args[0],200);
			} case('organization_app_tree'): {
				return $apiRoute->appTree($args[0],200);
			} case('organization_availability_listWeek'): {
				return $apiRoute->availabilityListWeek($args[0],200);
			} case('organization_availability_edit'): {
				return $apiRoute->availabilityEdit($args[0],$args[1],200);
			} case('organization_emailTemplate_link'): {
				return $apiRoute->emailTemplateLink($args[0],FALSE,200);
			} case('organization_emailTemplate_unlink'): {
				return $apiRoute->emailTemplateLink($args[0],TRUE,200);
			} case('organization_smsTemplate_link'): {
				return $apiRoute->smsTemplateLink($args[0],FALSE,200);
			} case('organization_smsTemplate_unlink'): {
				return $apiRoute->smsTemplateLink($args[0],TRUE,200);
			} case('organization_subOrganization_addRoot'): {
				return $apiRoute->subOrganizationAddRoot($args[0],$args[1],201);
			} case('organization_subOrganization_addSub'): {
				return $apiRoute->subOrganizationAddSub($args[0],$args[1],201);
			} case('organization_subOrganization_identify'): {
				return $apiRoute->subOrganizationIdentify($args[0],200);
			} case('organization_subOrganization_index'): {
				return $apiRoute->subOrganizationIndex($args[0],200);
			} case('organization_subOrganization_filter'): {
				return $apiRoute->subOrganizationFilter($args[0],200);
			} case('organization_subOrganization_list'): {
				return $apiRoute->subOrganizationList($args[0],200);
			} case('organization_subOrganization_tree'): {
				return $apiRoute->subOrganizationTree($args[0],200);
			} case('organization_timeGrid_listWeek'): {
				return $apiRoute->timeGridListWeek($args[0],200);
			} case('organization_timeGrid_edit'): {
				return $apiRoute->timeGridEdit($args[0],$args[1],200);
			} case('organization_edit'): {
				return $apiRoute->edit($args[0],$args[1],200);
			} case('organization_delete'): {
				return $apiRoute->delete($args[0],200);
			}
		}

		//packet
		switch($name) {
			 case('packet_show'): {
				return $apiRoute->show($args[0],200);
			} case('packet_index'): {
				return $apiRoute->index($args[0],200);
			} case('packet_filter'): {
				return $apiRoute->filter($args[0],200);
			} case('packet_list'): {
				return $apiRoute->list($args[0],200);
			} case('packet_purchase'): {
				return $apiRoute->purchase($args[0],201);
			}
		}

		//resource
		switch($name) {
			case('resource_add'): {
				return $apiRoute->add($args[0],$args[1],201);
			} case('resource_show'): {
				return $apiRoute->show($args[0],200);
			} case('resource_identify'): {
				return $apiRoute->identify($args[0],200);
			} case('resource_index'): {
				return $apiRoute->index($args[0],FALSE,200);
			} case('resource_filter'): {
				return $apiRoute->filter($args[0],FALSE,200);
			} case('resource_list'): {
				return $apiRoute->list($args[0],FALSE,200);
			} case('resource_indexAll'): {
				return $apiRoute->index($args[0],TRUE,200);
			} case('resource_filterAll'): {
				return $apiRoute->filter($args[0],TRUE,200);
			} case('resource_listAll'): {
				return $apiRoute->list($args[0],TRUE,200);
			} case('resource_edit'): {
				return $apiRoute->edit($args[0],$args[1],200);
			} case('resource_delete'): {
				return $apiRoute->delete($args[0],200);
			} case('resource_availability_listWeek'): {
				return $apiRoute->availabilityListWeek($args[0],200);
			} case('resource_availability_edit'): {
				return $apiRoute->availabilityEdit($args[0],$args[1],200);
			}
		}

		//reportingJob
		switch($name) {
			case('reportingJob_add'): {
				return $apiRoute->add($args[0],$args[1],201);
			} case('reportingJob_show'): {
				return $apiRoute->show($args[0],200);
			} case('reportingJob_identify'): {
				return $apiRoute->identify($args[0],200);
			} case('reportingJob_index'): {
				return $apiRoute->index($args[0],FALSE,200);
			} case('reportingJob_filter'): {
				return $apiRoute->filter($args[0],FALSE,200);
			} case('reportingJob_list'): {
				return $apiRoute->list($args[0],FALSE,200);
			} case('reportingJob_indexAll'): {
				return $apiRoute->index($args[0],TRUE,200);
			} case('reportingJob_filterAll'): {
				return $apiRoute->filter($args[0],TRUE,200);
			} case('reportingJob_listAll'): {
				return $apiRoute->list($args[0],TRUE,200);
			} case('reportingJob_edit'): {
				return $apiRoute->edit($args[0],$args[1],200);
			} case('reportingJob_delete'): {
				return $apiRoute->delete($args[0],200);
			}
		}

		//sms
		switch($name) {
			 case('sms_show'): {
				return $apiRoute->show($args[0],200);
			} case('sms_index'): {
				return $apiRoute->index($args[0],FALSE,200);
			} case('sms_filter'): {
				return $apiRoute->filter($args[0],FALSE,200);
			} case('sms_list'): {
				return $apiRoute->list($args[0],FALSE,200);
			} case('sms_indexAll'): {
				return $apiRoute->index($args[0],TRUE,200);
			} case('sms_filterAll'): {
				return $apiRoute->filter($args[0],TRUE,200);
			} case('sms_listAll'): {
				return $apiRoute->list($args[0],TRUE,200);
			} case('sms_resend'): {
				return $apiRoute->resend($args[0],201);
			} case('sms_customer_index'): {
				return $apiRoute->customerIndex($args[0],200);
			} case('sms_customer_filter'): {
				return $apiRoute->customerFilter($args[0],200);
			} case('sms_customer_list'): {
				return $apiRoute->customerList($args[0],200);
			}
		}

		//smsTemplate
		switch($name) {
			case('smsTemplate_add'): {
				return $apiRoute->add($args[0],$args[1],201);
			} case('smsTemplate_show'): {
				return $apiRoute->show($args[0],200);
			} case('smsTemplate_identify'): {
				return $apiRoute->identify($args[0],200);
			} case('smsTemplate_index'): {
				return $apiRoute->index($args[0],FALSE,200);
			} case('smsTemplate_filter'): {
				return $apiRoute->filter($args[0],FALSE,200);
			} case('smsTemplate_list'): {
				return $apiRoute->list($args[0],FALSE,200);
			} case('smsTemplate_indexAll'): {
				return $apiRoute->index($args[0],TRUE,200);
			} case('smsTemplate_filterAll'): {
				return $apiRoute->filter($args[0],TRUE,200);
			} case('smsTemplate_listAll'): {
				return $apiRoute->list($args[0],TRUE,200);
			} case('smsTemplate_edit'): {
				return $apiRoute->edit($args[0],$args[1],200);
			} case('smsTemplate_delete'): {
				return $apiRoute->delete($args[0],200);
			}
		}

		//staticc
		switch($name) {
			case('static_country_list'): {
				return $apiRoute->countryList($args[0],200);
			} case('static_currency_list'): {
				return $apiRoute->currencyList($args[0],200);
			} case('static_error_show'): {
				return $apiRoute->errorShow($args[0],intval($args[0]['errorCode']));
			} case('static_language_list'): {
				return $apiRoute->languageList($args[0],200);
			} case('static_logCategory_list'): {
				return $apiRoute->logCategoryList($args[0],200);
			} case('static_permission_list'): {
				return $apiRoute->permissionList($args[0],200);
			} case('static_sector_list'): {
				return $apiRoute->sectorList($args[0],200);
			} case('static_timeZone_list'): {
				return $apiRoute->timeZoneList($args[0],200);
			}
		}

		//synchronization
		switch($name) {
			case('synchronization_add'): {
				return $apiRoute->add($args[0],$args[1],201);
			} case('synchronization_show'): {
				return $apiRoute->show($args[0],200);
			} case('synchronization_identify'): {
				return $apiRoute->identify($args[0],200);
			} case('synchronization_index'): {
				return $apiRoute->index($args[0],FALSE,200);
			} case('synchronization_filter'): {
				return $apiRoute->filter($args[0],FALSE,200);
			} case('synchronization_list'): {
				return $apiRoute->list($args[0],FALSE,200);
			} case('synchronization_indexAll'): {
				return $apiRoute->index($args[0],TRUE,200);
			} case('synchronization_filterAll'): {
				return $apiRoute->filter($args[0],TRUE,200);
			} case('synchronization_listAll'): {
				return $apiRoute->list($args[0],TRUE,200);
			} case('synchronization_edit'): {
				return $apiRoute->edit($args[0],$args[1],200);
			} case('synchronization_delete'): {
				return $apiRoute->delete($args[0],200);
			} case('synchronization_reset'): {
				return $apiRoute->reset($args[0],200);
			}
		}

		//synchronizationAppointment
		switch($name) {
			case('synchronizationAppointment_show'): {
				return $apiRoute->show($args[0],200);
			} case('synchronizationAppointment_index'): {
				return $apiRoute->index($args[0],200);
			} case('synchronizationAppointment_filter'): {
				return $apiRoute->filter($args[0],200);
			} case('synchronizationAppointment_list'): {
				return $apiRoute->list($args[0],200);
			} case('synchronizationAppointment_listDay'): {
				return $apiRoute->listDay($args[0],200);
			} case('synchronizationAppointment_listWeek'): {
				return $apiRoute->listWeek($args[0],200);
			} case('synchronizationAppointment_listMonth'): {
				return $apiRoute->listMonth($args[0],200);
			}
		}

		//synchronizationLog
		switch($name) {
			case('synchronizationLog_show'): {
				return $apiRoute->show($args[0],200);
			} case('synchronizationLog_index'): {
				return $apiRoute->index($args[0],FALSE,200);
			}
		}

		//unknown
		throw new \BadMethodCallException('Undefined method called: '.$name);
	}
}
