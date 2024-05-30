<?php

namespace bookingtime\phpsdkapp\Tests;
use PHPUnit\Framework\TestCase;
use bookingtime\phpsdkapp\Sdk;
use bookingtime\phpsdkapp\Lib\BasicLib;



/**
 * a test
 *
 * @author <bookingtime GmbH>
 */
class SdkTest extends TestCase {



	/**
	 * test all SDK methods with mock data
	 *
	 * @return void
	 */
	public function testSdk():void {
		//init SDK
		$sdk=new Sdk('xxx','xxx',[
			'locale'=>'de_DE',
			'timeout'=>15,
			'mock'=>TRUE,
		]);

		#APPCONFIG
		$data=[
			'appId'=>'70xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
			'settingList'=>[
				['key'=>'appSetting1_checkbox','value'=>'true'],
				['key'=>'appSetting2_input','value'=>'hallo'],
				['key'=>'appSetting3_textArea','value'=>'test'],
				['key'=>'appSetting4_date','value'=>'2021-09-28'],
				['key'=>'appSetting5_time','value'=>'09:33:00'],
				['key'=>'appSetting6_dateTime','value'=>'2021-09-29T12:00:00+01:00'],
				['key'=>'appSetting7_color','value'=>'#ffcc00'],
				['key'=>'appSetting9_email','value'=>'testest@bookingtime.com'],
				['key'=>'appSetting10_mobile','value'=>'+4917012345678'],
				['key'=>'appSetting11_url','value'=>'http://www.musterfirma.de'],
				['key'=>'appSetting12_number','value'=>'123457'],
				['key'=>'appSetting13_alpha','value'=>'abcdefghijkm'],
				['key'=>'appSetting14_alphaNum','value'=>'abcdefghijkm123456'],
				['key'=>'appSetting15_digit','value'=>'123456'],
				['key'=>'appSetting16_hex','value'=>'abc123456789123456'],
			],
		];
		$appConfig=$sdk->appConfig_add(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($appConfig['mock-content'],1);
		$appConfig=$sdk->appConfig_show(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appConfigId'=>'c3xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($appConfig['mock-content'],1);
		$appConfig=$sdk->appConfig_identify(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customId'=>'666']);
		$this->assertEquals($appConfig['mock-content'],1);
		$appConfigArray=$sdk->appConfig_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'2']);#page optional
		$this->assertEquals($appConfigArray['mock-content'],1);
		$appConfigArray=$sdk->appConfig_indexAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($appConfigArray['mock-content'],1);
		$appConfigArray=$sdk->appConfig_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'2']);#page optional
		$this->assertEquals($appConfigArray['mock-content'],1);
		$appConfigArray=$sdk->appConfig_filterAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($appConfigArray['mock-content'],1);
		$appConfigArray=$sdk->appConfig_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($appConfigArray['mock-content'],1);
		$appConfigArray=$sdk->appConfig_listAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($appConfigArray['mock-content'],1);
		$data=['name'=>'Test App edited2'];
		$appConfig=$sdk->appConfig_edit(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appConfigId'=>'c3xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($appConfig['mock-content'],1);
		$appConfig=$sdk->appConfig_app_show(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appId'=>'70xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($appConfig['mock-content'],1);
		$appConfig=$sdk->appConfig_delete(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appConfigId'=>'c3xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($appConfig['mock-content'],1);

		#APP
		$app=$sdk->app_show(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appId'=>'70xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($app['mock-content'],1);
		$appArray=$sdk->app_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($appArray['mock-content'],1);
		$appArray=$sdk->app_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($appArray['mock-content'],1);
		$appArray=$sdk->app_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($appArray['mock-content'],1);

		#APPOINTMENT
		$data=['bookingSlotId'=>'4fxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customerId'=>'d3xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'];
		$appointment=$sdk->appointment_add(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($appointment['mock-content'],1);
		$appointment=$sdk->appointment_show(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentId'=>'edxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($appointment['mock-content'],1);
		$appointment=$sdk->appointment_identify(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customId'=>'123']);
		$this->assertEquals($appointment['mock-content'],1);
		$appointmentArray=$sdk->appointment_listDay(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','year'=>'2021','month'=>'9','day'=>'28']);
		$this->assertEquals($appointmentArray['mock-content'],1);
		$appointmentArray=$sdk->appointment_listWeek(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','year'=>'2021','week'=>'39']);
		$this->assertEquals($appointmentArray['mock-content'],1);
		$appointmentArray=$sdk->appointment_listMonth(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','year'=>'2021','month'=>'9']);
		$this->assertEquals($appointmentArray['class'],'RANGE_LIST');
		$appointmentArray=$sdk->appointment_bookingResourceReplaceList(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentId'=>'edxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($appointmentArray['class'],'BOOKING_RESOURCE_REPLACE');
		$data=['notes'=>'Test Appointment edited'];
		$appointment=$sdk->appointment_edit(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentId'=>'edxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($appointment['mock-content'],1);
		$data=['bookingSlotId'=>'4fxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'];
		$appointment=$sdk->appointment_move(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentId'=>'edxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($appointment['mock-content'],1);
		$appointment=$sdk->appointment_cancel(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentId'=>'edxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($appointment['mock-content'],1);
		$appointmentArray=$sdk->appointment_customEntity_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','page'=>'1']);
		$this->assertEquals($appointmentArray['mock-content'],1);
		$appointmentArray=$sdk->appointment_customEntity_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','searchQuery'=>'test','page'=>'2']);
		$this->assertEquals($appointmentArray['mock-content'],1);
		$appointmentArray=$sdk->appointment_customEntity_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar']);
		$this->assertEquals($appointmentArray['mock-content'],1);
		$appointmentArray=$sdk->appointment_customer_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customerId'=>'d3xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);
		$this->assertEquals($appointmentArray['mock-content'],1);
		$appointmentArray=$sdk->appointment_customer_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customerId'=>'d3xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'2']);
		$this->assertEquals($appointmentArray['mock-content'],1);
		$appointmentArray=$sdk->appointment_customer_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customerId'=>'d3xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($appointmentArray['mock-content'],1);

		#APPOINTMENTTEMPLATE
		$appointmentTemplateArray=$sdk->appointmentTemplate_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'2']);#page optional
		$this->assertEquals($appointmentTemplateArray['mock-content'],1);
		$appointmentTemplateArray=$sdk->appointmentTemplate_indexAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($appointmentTemplateArray['mock-content'],1);
		$appointmentTemplateArray=$sdk->appointmentTemplate_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'2']);#page optional
		$this->assertEquals($appointmentTemplateArray['mock-content'],1);
		$appointmentTemplateArray=$sdk->appointmentTemplate_filterAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($appointmentTemplateArray['mock-content'],1);
		$appointmentTemplateArray=$sdk->appointmentTemplate_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($appointmentTemplateArray['mock-content'],1);
		$appointmentTemplateArray=$sdk->appointmentTemplate_listAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($appointmentTemplateArray['mock-content'],1);
		$appointmentTemplateArray=$sdk->appointmentTemplate_customEntity_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','page'=>'1']);
		$this->assertEquals($appointmentTemplateArray['mock-content'],1);
		$appointmentTemplateArray=$sdk->appointmentTemplate_customEntity_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','searchQuery'=>'test','page'=>'2']);
		$this->assertEquals($appointmentTemplateArray['mock-content'],1);
		$appointmentTemplateArray=$sdk->appointmentTemplate_customEntity_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar']);
		$this->assertEquals($appointmentTemplateArray['mock-content'],1);

		#APPOINTMENTTEMPLATESIMPLE
		$data=[
			'type'=>'SIMPLE',
			'name'=>'Terminvorlage simple',
			'publicName'=>'Terminvorlage simple',
			'publicNameI18nList'=>[['key'=>'en','value'=>'AppointmentTemplate simple']],
			'description'=>'Terminvorlage simple',
			'descriptionI18nList'=>[],
			'duration'=>60,
			'externalCalendarContentCustomer'=>['value'=>'[ORGANIZATION]','inheritance'=>'OFF'],
			'externalCalendarContentCustomerI18nList'=>['value'=>[['key'=>'en','value'=>'[ORGANIZATION]']],'inheritance'=>'OFF'],
			'moduleMultiFactorProtection'=>[
				'value'=>'OFF',
				'inheritance'=>'OFF',
			],
			'customerAddressRequired'=>[
				'value'=>FALSE,
				'inheritance'=>'OFF',
			],
			'customerEmailRequired'=>[
				'value'=>FALSE,
				'inheritance'=>'OFF',
			],
			'customerMobileRequired'=>[
				'value'=>FALSE,
				'inheritance'=>'OFF',
			],
		];
		$appointmentTemplateSimple=$sdk->appointmentTemplate_add(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($appointmentTemplateSimple['mock-content'],1);
		$appointmentTemplateSimple=$sdk->appointmentTemplate_show(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($appointmentTemplateSimple['mock-content'],1);
		$appointmentTemplateSimple=$sdk->appointmentTemplate_identify(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customId'=>'666']);
		$this->assertEquals($appointmentTemplateSimple['mock-content'],1);
		$data=['name'=>'Terminvorlage simple edited'];
		$appointmentTemplateSimple=$sdk->appointmentTemplate_edit(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($appointmentTemplateSimple['mock-content'],1);
		$appointmentTemplateSimple=$sdk->appointmentTemplate_bookingResource_link(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','bookingResourceId'=>'brxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($appointmentTemplateSimple['mock-content'],1);
		$appointmentTemplateSimple=$sdk->appointmentTemplate_bookingResource_unlink(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','bookingResourceId'=>'brxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($appointmentTemplateSimple['mock-content'],1);
		$appointmentTemplateSimple=$sdk->appointmentTemplate_emailTemplate_link(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','emailTemplateId'=>'46xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($appointmentTemplateSimple['mock-content'],1);
		$appointmentTemplateSimple=$sdk->appointmentTemplate_emailTemplate_unlink(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','emailTemplateId'=>'46xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($appointmentTemplateSimple['mock-content'],1);
		$appointmentTemplateSimple=$sdk->appointmentTemplate_smsTemplate_link(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','smsTemplateId'=>'6Gxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($appointmentTemplateSimple['mock-content'],1);
		$appointmentTemplateSimple=$sdk->appointmentTemplate_smsTemplate_unlink(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','smsTemplateId'=>'6Gxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($appointmentTemplateSimple['mock-content'],1);
		$appointmentTemplateSimple=$sdk->appointmentTemplate_timeGrid_listWeek(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','year'=>'2021','week'=>'41']);
		$this->assertEquals($appointmentTemplateSimple['mock-content'],1);
		$data=['rangeStart'=>'2021-11-11T12:00:00+02:00','rangeEnd'=>'2021-11-19T19:00:00+02:00','timeGrid'=>['2021-11-11T12:00:00+02:00','2021-11-11T12:30:00+02:00']];
		$appointmentTemplateSimple=$sdk->appointmentTemplate_timeGrid_edit(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($appointmentTemplateSimple['mock-content'],1);
		$appointmentTemplateSimple=$sdk->appointmentTemplate_delete(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($appointmentTemplateSimple['mock-content'],1);

		#APPOINTMENTTEMPLATECOMPLEX
		$data=[
			'type'=>'COMPLEX',
			'name'=>'Terminvorlage COMPLEX',
			'duration'=>90,
			'moduleMultiFactorProtection'=>[
				'value'=>'OFF',
				'inheritance'=>'OFF',
			],
			'customerAddressRequired'=>[
				'value'=>FALSE,
				'inheritance'=>'OFF',
			],
			'customerEmailRequired'=>[
				'value'=>FALSE,
				'inheritance'=>'OFF',
			],
			'customerMobileRequired'=>[
				'value'=>FALSE,
				'inheritance'=>'OFF',
			],
		];
		$appointmentTemplateComplex=$sdk->appointmentTemplate_add(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($appointmentTemplateComplex['mock-content'],1);
		$appointmentTemplateComplex=$sdk->appointmentTemplate_show(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($appointmentTemplateComplex['mock-content'],1);
		$appointmentTemplateComplex=$sdk->appointmentTemplate_identify(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customId'=>'1234']);
		$this->assertEquals($appointmentTemplateComplex['mock-content'],1);
		$data=['name'=>'Terminvorlage complex edited'];
		$appointmentTemplateComplex=$sdk->appointmentTemplate_edit(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($appointmentTemplateComplex['mock-content'],1);
		$appointmentTemplateComplex=$sdk->appointmentTemplate_emailTemplate_link(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','emailTemplateId'=>'46xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($appointmentTemplateComplex['mock-content'],1);
		$appointmentTemplateComplex=$sdk->appointmentTemplate_emailTemplate_unlink(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','emailTemplateId'=>'46xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($appointmentTemplateComplex['mock-content'],1);
		$appointmentTemplateComplex=$sdk->appointmentTemplate_smsTemplate_link(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','smsTemplateId'=>'6Gxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($appointmentTemplateComplex['mock-content'],1);
		$appointmentTemplateComplex=$sdk->appointmentTemplate_smsTemplate_unlink(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','smsTemplateId'=>'6Gxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($appointmentTemplateComplex['mock-content'],1);
		$appointmentTemplateComplex=$sdk->appointmentTemplate_timeGrid_listWeek(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','year'=>'2021','week'=>'41']);
		$this->assertEquals($appointmentTemplateComplex['mock-content'],1);
		$data=['rangeStart'=>'2021-10-11T12:00:00+02:00','rangeEnd'=>'2021-10-19T19:00:00+02:00','timeGrid'=>['2021-10-11T12:00:00+02:00','2021-10-11T12:30:00+02:00']];
		$appointmentTemplateComplex=$sdk->appointmentTemplate_timeGrid_edit(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($appointmentTemplateComplex['mock-content'],1);
		$appointmentTemplateComplex=$sdk->appointmentTemplate_delete(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($appointmentTemplateComplex['mock-content'],1);

		#APPOINTMENTTEMPLATE_EVENT_DATE_TIME
		$data=[
			'customId'=>'sdk1test',
			'start'=>'2024-10-29T12:00:00+01:00',
			'bookingResourceIdList'=>['brxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],
			'appointmentEventAttendanceCountMax'=>10,
		];
		$appointmentTemplateEventDateTime=$sdk->appointmentTemplateEventDateTime_add(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'6txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($appointmentTemplateEventDateTime['mock-content'],1);
		$data=['customId'=>'sdk1testedited'];
		$appointmentTemplateEventDateTime=$sdk->appointmentTemplateEventDateTime_edit(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'6txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateEventDateTimeId'=>'psxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($appointmentTemplateEventDateTime['mock-content'],1);
		$appointmentTemplateEventDateTime=$sdk->appointmentTemplateEventDateTime_delete(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'6txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateEventDateTimeId'=>'psxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($appointmentTemplateEventDateTime['mock-content'],1);
		$appointmentTemplateEventDateTime=$sdk->appointmentTemplateEventDateTime_bookingResource_link(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'6txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateEventDateTimeId'=>'psxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','bookingResourceId'=>'brxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($appointmentTemplateEventDateTime['mock-content'],1);
		$appointmentTemplateEventDateTime=$sdk->appointmentTemplateEventDateTime_bookingResource_unlink(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'6txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateEventDateTimeId'=>'psxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','bookingResourceId'=>'brxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($appointmentTemplateEventDateTime['mock-content'],1);

		#APPOINTMENTTEMPLATESTEP
		$data=[
			'name'=>'Buchungsschritt',
			'nameI18nList'=>[['key'=>'en','value'=>'appointmentTemplateStep']],
			'description'=>'Buchungsschritt',
			'descriptionI18nList'=>[['key'=>'en','value'=>'This is an appointmentTemplateStep']],
		];
		$appointmentTemplateStep=$sdk->appointmentTemplateStep_add(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($appointmentTemplateStep['mock-content'],1);
		$data=['name'=>'Buchungsschritt edited'];
		$appointmentTemplateStep=$sdk->appointmentTemplateStep_edit(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateStepId'=>'b8xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($appointmentTemplateStep['mock-content'],1);
		$appointmentTemplateStep=$sdk->appointmentTemplateStep_delete(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateStepId'=>'b8xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($appointmentTemplateStep['mock-content'],1);
		$appointmentTemplateStep=$sdk->appointmentTemplateStep_bookingResource_link(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateStepId'=>'b8xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','bookingResourceId'=>'brxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($appointmentTemplateStep['mock-content'],1);
		$appointmentTemplateStep=$sdk->appointmentTemplateStep_bookingResource_unlink(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateStepId'=>'b8xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','bookingResourceId'=>'brxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($appointmentTemplateStep['mock-content'],1);

		#AVAILABILITYEXCEPTION
		$data=[
			'name'=>'Ausnahme Test',
			'type'=>'FREE',
			'appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
			'bookingResourceId'=>'brxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
			'start'=>'2021-10-29T12:00:00+01:00',
			'end'=>'2021-10-29T19:00:00+01:00',
		];
		$availabilityException=$sdk->availabilityException_add(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($availabilityException['mock-content'],1);
		$availabilityException=$sdk->availabilityException_show(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','availabilityExceptionId'=>'acxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($availabilityException['mock-content'],1);
		$availabilityException=$sdk->availabilityException_identify(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customId'=>'4446611']);
		$this->assertEquals($availabilityException['mock-content'],1);
		$availabilityExceptionArray=$sdk->availabilityException_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($availabilityExceptionArray['mock-content'],1);
		$availabilityExceptionArray=$sdk->availabilityException_indexAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($availabilityExceptionArray['mock-content'],1);
		$availabilityExceptionArray=$sdk->availabilityException_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($availabilityExceptionArray['mock-content'],1);
		$availabilityExceptionArray=$sdk->availabilityException_filterAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($availabilityExceptionArray['mock-content'],1);
		$availabilityExceptionArray=$sdk->availabilityException_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($availabilityExceptionArray['mock-content'],1);
		$availabilityExceptionArray=$sdk->availabilityException_listAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($availabilityExceptionArray['mock-content'],1);
		$data=['name'=>'Ausnahme Test edited'];
		$availabilityException=$sdk->availabilityException_edit(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','availabilityExceptionId'=>'acxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($availabilityException['mock-content'],1);
		$availabilityExceptionArray=$sdk->availabilityException_appointmentTemplate_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);
		$this->assertEquals($availabilityExceptionArray['mock-content'],1);
		$availabilityExceptionArray=$sdk->availabilityException_appointmentTemplate_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);
		$this->assertEquals($availabilityExceptionArray['mock-content'],1);
		$availabilityExceptionArray=$sdk->availabilityException_appointmentTemplate_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($availabilityExceptionArray['mock-content'],1);
		$availabilityExceptionArray=$sdk->availabilityException_bookingResource_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','bookingResourceId'=>'brxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);
		$this->assertEquals($availabilityExceptionArray['mock-content'],1);
		$availabilityExceptionArray=$sdk->availabilityException_bookingResource_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','bookingResourceId'=>'brxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);
		$this->assertEquals($availabilityExceptionArray['mock-content'],1);
		$availabilityExceptionArray=$sdk->availabilityException_bookingResource_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','bookingResourceId'=>'brxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($availabilityExceptionArray['mock-content'],1);
		$availabilityException=$sdk->availabilityException_delete(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','availabilityExceptionId'=>'acxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],[]);
		$this->assertEquals($availabilityException['mock-content'],1);

		#BOOKINGRESOURCE
		$bookingResource=$sdk->bookingResource_show(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','bookingResourceId'=>'brxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($bookingResource['mock-content'],1);
		$bookingResource=$sdk->bookingResource_identify(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customId'=>'dk']);
		$this->assertEquals($bookingResource['mock-content'],1);
		$bookingResourceArray=$sdk->bookingResource_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($bookingResourceArray['mock-content'],1);
		$bookingResourceArray=$sdk->bookingResource_indexAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($bookingResourceArray['mock-content'],1);
		$bookingResourceArray=$sdk->bookingResource_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($bookingResourceArray['mock-content'],1);
		$bookingResourceArray=$sdk->bookingResource_filterAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($bookingResourceArray['mock-content'],1);
		$bookingResourceArray=$sdk->bookingResource_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($bookingResourceArray['mock-content'],1);
		$bookingResourceArray=$sdk->bookingResource_listAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($bookingResourceArray['mock-content'],1);
		$bookingResourceArray=$sdk->bookingResource_availability_listDay(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','bookingResourceId'=>'brxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','year'=>'2021','month'=>'1','day'=>'30']);
		$this->assertEquals($bookingResourceArray['class'],'RANGE_LIST');
		$bookingResourceArray=$sdk->bookingResource_availability_listWeek(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','bookingResourceId'=>'brxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','year'=>'2021','week'=>'41']);
		$this->assertEquals($bookingResourceArray['class'],'RANGE_LIST');
		$bookingResourceArray=$sdk->bookingResource_availability_listMonth(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','bookingResourceId'=>'brxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','year'=>'2021','month'=>'1']);
		$this->assertEquals($bookingResourceArray['class'],'RANGE_LIST');
		$bookingResourceArray=$sdk->bookingResource_customEntity_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','page'=>'1']);
		$this->assertEquals($bookingResourceArray['mock-content'],1);
		$bookingResourceArray=$sdk->bookingResource_customEntity_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','searchQuery'=>'test','page'=>'2']);
		$this->assertEquals($bookingResourceArray['mock-content'],1);
		$bookingResourceArray=$sdk->bookingResource_customEntity_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar']);
		$this->assertEquals($bookingResourceArray['mock-content'],1);

		#BOOKINGSLOT
		$bookingSlotArray=$sdk->bookingSlot_earliest(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','bookingTemplateId'=>'fcxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($bookingSlotArray['mock-content'],1);
		$bookingSlotArray=$sdk->bookingSlot_listDay(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','bookingTemplateId'=>'fcxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','year'=>'2021','month'=>'9','day'=>'30']);
		$this->assertEquals($bookingSlotArray['mock-content'],1);
		$bookingSlotArray=$sdk->bookingSlot_listWeek(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','bookingTemplateId'=>'fcxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','year'=>'2021','week'=>'39']);
		$this->assertEquals($bookingSlotArray['mock-content'],1);
		$bookingSlotArray=$sdk->bookingSlot_listMonth(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','bookingTemplateId'=>'fcxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','year'=>'2021','month'=>'9']);
		$this->assertEquals($bookingSlotArray['mock-content'],1);

		#BOOKINGTEMPLATE
		$bookingTemplate=$sdk->bookingTemplate_show(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','bookingTemplateId'=>'fcxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($bookingTemplate['mock-content'],1);
		$bookingTemplate=$sdk->bookingTemplate_identify(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customId'=>'666']);
		$this->assertEquals($bookingTemplate['mock-content'],1);
		$bookingTemplateArray=$sdk->bookingTemplate_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($bookingTemplateArray['mock-content'],1);
		$bookingTemplateArray=$sdk->bookingTemplate_indexAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($bookingTemplateArray['mock-content'],1);
		$bookingTemplateArray=$sdk->bookingTemplate_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($bookingTemplateArray['mock-content'],1);
		$bookingTemplateArray=$sdk->bookingTemplate_filterAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($bookingTemplateArray['mock-content'],1);
		$bookingTemplateArray=$sdk->bookingTemplate_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($bookingTemplateArray['mock-content'],1);
		$bookingTemplateArray=$sdk->bookingTemplate_listAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($bookingTemplateArray['mock-content'],1);
		$bookingTemplateArray=$sdk->bookingTemplate_bookingResource_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','bookingResourceId'=>'brxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);
		$this->assertEquals($bookingTemplateArray['mock-content'],1);
		$bookingTemplateArray=$sdk->bookingTemplate_bookingResource_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','bookingResourceId'=>'brxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);
		$this->assertEquals($bookingTemplateArray['mock-content'],1);
		$bookingTemplateArray=$sdk->bookingTemplate_bookingResource_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','bookingResourceId'=>'brxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($bookingTemplateArray['mock-content'],1);
		$bookingTemplateArray=$sdk->bookingTemplate_customEntity_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','page'=>'1']);
		$this->assertEquals($bookingTemplateArray['mock-content'],1);
		$bookingTemplateArray=$sdk->bookingTemplate_customEntity_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','searchQuery'=>'test','page'=>'2']);
		$this->assertEquals($bookingTemplateArray['mock-content'],1);
		$bookingTemplateArray=$sdk->bookingTemplate_customEntity_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar']);
		$this->assertEquals($bookingTemplateArray['mock-content'],1);

		#CONRACTACCOUNT
		$data=[
			'tariffId'=>'tFb41cqMdgahwFep4nIlwXSfc1ZuT89B',//Super-Master-Tarif
			'customId'=>'acmeSDK',
			'name'=>'ACME ContractAccountSDK',

			'locale'=>'en',
			'timeZone'=>'Europe/Berlin',

			'admin'=>[
				'gender'=>'MALE',
				'firstName'=>'Max',
				'lastName'=>'Mustermann',
				'email'=>'dk@acme-gmbh.de',
				'mobile'=>'+491701234567',
			],

			'contactPerson'=>[
				'gender'=>'MALE',
				'title'=>'Dr.',
				'firstName'=>'Max',
				'lastName'=>'Mustermann',
				'telephone'=>'040/12345678',
				'email'=>'dk@acme-gmbh.de',
				'mobile'=>'+491701234567',
			],

			'address'=>[
				'name'=>'ACME ContractAccountSDK',
				'street'=>'Masterstreet',
				'extra'=>'',
				'zip'=>'12345',
				'city'=>'Mastertown',
				'country'=>'DE',
			],
			'invoiceEmail'=>'dk@acme-gmbh.de',
			'memberList'=>[],
		];
		$contractAccount=$sdk->contractAccount_add([],$data);
		$this->assertEquals($contractAccount['mock-content'],1);

		#CUSTOMENTITY
		$data=['customId'=>'667','name'=>'CB Testentity'];
		$customEntity=$sdk->customEntity_add(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar'],$data);
		$this->assertEquals($customEntity['class'],'CUSTOM_ENTITY_SHORT');
		$customEntity=$sdk->customEntity_show(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($customEntity['class'],'CUSTOM_ENTITY');
		$customEntity=$sdk->customEntity_identify(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','customId'=>'666']);
		$this->assertEquals($customEntity['class'],'CUSTOM_ENTITY');
		$customEntityArray=$sdk->customEntity_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','page'=>'2']);#page optional
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_indexAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','page'=>'1']);#page optional
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','searchQuery'=>'test','page'=>'2']);#page optional
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_filterAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar']);
		$this->assertEquals($customEntityArray['class'],'LIST');
		$customEntityArray=$sdk->customEntity_listAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar']);
		$this->assertEquals($customEntityArray['class'],'LIST');
		$data=['notes'=>'Test customEntity edited'];
		$customEntity=$sdk->customEntity_edit(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar'],$data);
		$this->assertEquals($customEntity['mock-content'],1);
		$customEntity=$sdk->customEntity_delete(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar']);
		$this->assertEquals($customEntity['mock-content'],1);
		$customEntityArray=$sdk->customEntity_appointment_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentId'=>'edxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','page'=>'1']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_appointment_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentId'=>'edxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','searchQuery'=>'Testentity','page'=>'1']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_appointment_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentId'=>'edxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_appointment_link(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentId'=>'edxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_appointment_unlink(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentId'=>'edxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_appointmentTemplate_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','page'=>'1']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_appointmentTemplate_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','searchQuery'=>'test','page'=>'2']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_appointmentTemplate_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_appointmentTemplate_link(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_appointmentTemplate_unlink(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_bookingResource_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','bookingResourceId'=>'brxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','page'=>'1']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_bookingResource_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','bookingResourceId'=>'brxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','searchQuery'=>'test','page'=>'2']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_bookingResource_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','bookingResourceId'=>'brxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_bookingResource_link(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','bookingResourceId'=>'brxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_bookingResource_unlink(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','bookingResourceId'=>'brxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_bookingTemplate_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','bookingTemplateId'=>'fcxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','page'=>'1']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_bookingTemplate_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','bookingTemplateId'=>'fcxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','searchQuery'=>'test','page'=>'2']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_bookingTemplate_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','bookingTemplateId'=>'fcxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_bookingTemplate_link(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','bookingTemplateId'=>'fcxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_bookingTemplate_unlink(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','bookingTemplateId'=>'fcxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_customEntity_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','page'=>'1']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_customEntity_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','searchQuery'=>'test','page'=>'2']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_customEntity_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_customEntity_link(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','customEntityRelatedId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_customEntity_unlink(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','customEntityRelatedId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_customer_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customerId'=>'d3xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','page'=>'1']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_customer_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customerId'=>'d3xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','searchQuery'=>'test','page'=>'2']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_customer_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customerId'=>'d3xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_customer_link(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customerId'=>'d3xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_customer_unlink(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customerId'=>'d3xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_employee_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','employeeId'=>'Ehxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','page'=>'1']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_employee_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','employeeId'=>'Ehxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','searchQuery'=>'test','page'=>'2']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_employee_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','employeeId'=>'Ehxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_employee_link(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','employeeId'=>'Ehxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_employee_unlink(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','employeeId'=>'Ehxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_resource_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','resourceId'=>'73xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','page'=>'1']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_resource_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','resourceId'=>'73xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','searchQuery'=>'test','page'=>'2']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_resource_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','resourceId'=>'73xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_resource_link(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','resourceId'=>'73xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($customEntityArray['mock-content'],1);
		$customEntityArray=$sdk->customEntity_resource_unlink(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','resourceId'=>'73xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($customEntityArray['mock-content'],1);

		#CUSTOMER
		$data=[
			'firstName'=>'Kunde',
			'lastName'=>'van Test',
			'gender'=>'FEMALE',
			'email'=>'support@bookingtime.com',
			'locale'=>'de',
		];
		$customer=$sdk->customer_add(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($customer['mock-content'],1);
		$customer=$sdk->customer_show(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customerId'=>'d3xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($customer['mock-content'],1);
		$customer=$sdk->customer_identify(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customId'=>'666']);
		$this->assertEquals($customer['mock-content'],1);
		$customerArray=$sdk->customer_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($customerArray['mock-content'],1);
		$customerArray=$sdk->customer_indexAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($customerArray['mock-content'],1);
		$customerArray=$sdk->customer_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($customerArray['mock-content'],1);
		$customerArray=$sdk->customer_filterAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($customerArray['mock-content'],1);
		$customerArray=$sdk->customer_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($customerArray['mock-content'],1);
		$customerArray=$sdk->customer_listAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($customerArray['mock-content'],1);
		$data=['notes'=>'test edit'];
		$customer=$sdk->customer_edit(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customerId'=>'Ehxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($customer['mock-content'],1);
		$customerArray=$sdk->customer_customEntity_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','page'=>'1']);
		$this->assertEquals($customerArray['mock-content'],1);
		$customerArray=$sdk->customer_customEntity_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','searchQuery'=>'test','page'=>'2']);
		$this->assertEquals($customerArray['mock-content'],1);
		$customerArray=$sdk->customer_customEntity_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar']);
		$this->assertEquals($customerArray['mock-content'],1);
		$customer=$sdk->customer_customerGroup_link(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customerId'=>'d3xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customerGroupId'=>'7bxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($customer['mock-content'],1);
		$customer=$sdk->customer_customerGroup_unlink(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customerId'=>'d3xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customerGroupId'=>'7bxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($customer['mock-content'],1);
		$customer=$sdk->customer_delete(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customerId'=>'d3xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($customer['mock-content'],1);

		#CUSTOMERGROUP
		$data=[
			'name'=>'Kundengruppe Test',
			'customId'=>'1563',
		];
		$customerGroup=$sdk->customerGroup_add(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($customerGroup['mock-content'],1);
		$customerGroup=$sdk->customerGroup_show(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customerGroupId'=>'7bxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($customerGroup['mock-content'],1);
		$customerGroup=$sdk->customerGroup_identify(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customId'=>'1563']);
		$this->assertEquals($customerGroup['mock-content'],1);
		$customerGroupArray=$sdk->customerGroup_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($customerGroupArray['mock-content'],1);
		$customerGroupArray=$sdk->customerGroup_indexAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($customerGroupArray['mock-content'],1);
		$customerGroupArray=$sdk->customerGroup_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($customerGroupArray['mock-content'],1);
		$customerGroupArray=$sdk->customerGroup_filterAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($customerGroupArray['mock-content'],1);
		$customerGroupArray=$sdk->customerGroup_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($customerGroupArray['mock-content'],1);
		$customerGroupArray=$sdk->customerGroup_listAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($customerGroupArray['mock-content'],1);
		$data=['name'=>'Kundengruppe Test edited'];
		$customerGroup=$sdk->customerGroup_edit(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customerGroupId'=>'7bxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($customerGroup['mock-content'],1);
		$customerGroup=$sdk->customerGroup_delete(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customerGroupId'=>'7bxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],[]);
		$this->assertEquals($customerGroup['mock-content'],1);

		#EMAIL
		$email=$sdk->email_show(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','emailId'=>'5dxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($email['mock-content'],1);
		$emailArray=$sdk->email_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($emailArray['mock-content'],1);
		$emailArray=$sdk->email_indexAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($emailArray['mock-content'],1);
		$emailArray=$sdk->email_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($emailArray['mock-content'],1);
		$emailArray=$sdk->email_filterAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($emailArray['mock-content'],1);
		$emailArray=$sdk->email_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($emailArray['mock-content'],1);
		$emailArray=$sdk->email_listAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($emailArray['mock-content'],1);
		$email=$sdk->email_resend(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','emailId'=>'5dxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($email['mock-content'],1);
		$emailArray=$sdk->email_customer_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customerId'=>'d3xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($emailArray['mock-content'],1);
		$emailArray=$sdk->email_customer_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customerId'=>'d3xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($emailArray['mock-content'],1);
		$emailArray=$sdk->email_customer_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customerId'=>'d3xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($emailArray['mock-content'],1);

		#EMAILTEMPLATE
		$data=[
			'name'=>'EmailTemplate Test',
			'active'=>true,
			'event'=>'APPOINTMENT_ADD',
			'subject'=>'Hello hello',
			'subjectI18nList'=>[],
			'bodyPlain'=>'Juten Tach',
			'bodyPlainI18nList'=>[['key'=>'en','value'=>'good day']],
			'bodyHtml'=>'Juten Tach',
			'bodyHtmlI18nList'=>[['key'=>'en','value'=>'good day']],
			'externalCalendarContentCustomer'=>['value'=>'[ORGANIZATION]','inheritance'=>'OFF'],
			'externalCalendarContentCustomerI18nList'=>['value'=>[['key'=>'en','value'=>'[ORGANIZATION]']],'inheritance'=>'OFF'],
		];
		$emailTemplate=$sdk->emailTemplate_add(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($emailTemplate['mock-content'],1);
		$emailTemplate=$sdk->emailTemplate_show(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','emailTemplateId'=>'46xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($emailTemplate['mock-content'],1);
		$emailTemplate=$sdk->emailTemplate_identify(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customId'=>'1234']);
		$this->assertEquals($emailTemplate['mock-content'],1);
		$emailTemplateArray=$sdk->emailTemplate_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($emailTemplateArray['mock-content'],1);
		$emailTemplateArray=$sdk->emailTemplate_indexAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($emailTemplateArray['mock-content'],1);
		$emailTemplateArray=$sdk->emailTemplate_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($emailTemplateArray['mock-content'],1);
		$emailTemplateArray=$sdk->emailTemplate_filterAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($emailTemplateArray['mock-content'],1);
		$emailTemplateArray=$sdk->emailTemplate_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($emailTemplateArray['mock-content'],1);
		$emailTemplateArray=$sdk->emailTemplate_listAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($emailTemplateArray['mock-content'],1);
		$data=['name'=>'EmailTemplate Test edited'];
		$emailTemplate=$sdk->emailTemplate_edit(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','emailTemplateId'=>'46xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($emailTemplate['mock-content'],1);
		$emailTemplate=$sdk->emailTemplate_delete(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','emailTemplateId'=>'46xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],[]);
		$this->assertEquals($emailTemplate['mock-content'],1);

		#EMPLOYEE
		$data=[
			'firstName'=>'CB',
			'lastName'=>'van Test',
			'gender'=>'MALE',
			'email'=>'support@bookingtime.com',
			'description'=>['value'=>'Das ist ein Mitarbeiter','inheritance'=>'OFF'],
			'descriptionI18nList'=>['value'=>[['key'=>'en','value'=>'This is an employee']],'inheritance'=>'OFF'],
		];
		$employee=$sdk->employee_add(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($employee['mock-content'],1);
		$employee=$sdk->employee_show(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','employeeId'=>'Ehxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($employee['mock-content'],1);
		$employee=$sdk->employee_identify(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customId'=>'dk']);
		$this->assertEquals($employee['mock-content'],1);
		$employeeArray=$sdk->employee_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($employeeArray['mock-content'],1);
		$employeeArray=$sdk->employee_indexAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($employeeArray['mock-content'],1);
		$employeeArray=$sdk->employee_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($employeeArray['mock-content'],1);
		$employeeArray=$sdk->employee_filterAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($employeeArray['mock-content'],1);
		$employeeArray=$sdk->employee_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($employeeArray['class'],'LIST');
		$employeeArray=$sdk->employee_listAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($employeeArray['class'],'LIST');
		$employee=$sdk->employee_permission(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','employeeId'=>'Ehxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($emailTemplate['mock-content'],1);
		$data=['notes'=>'test edit'];
		$employee=$sdk->employee_edit(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','employeeId'=>'Ehxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($employee['mock-content'],1);
		$employeeArray=$sdk->employee_customEntity_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','page'=>'1']);
		$this->assertEquals($employeeArray['mock-content'],1);
		$employeeArray=$sdk->employee_customEntity_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','searchQuery'=>'test','page'=>'2']);
		$this->assertEquals($employeeArray['mock-content'],1);
		$employeeArray=$sdk->employee_customEntity_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar']);
		$this->assertEquals($employeeArray['mock-content'],1);
		$employee=$sdk->employee_employeeGroup_link(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','employeeId'=>'Ehxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','employeeGroupId'=>'jsxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($employee['mock-content'],1);
		$employee=$sdk->employee_employeeGroup_unlink(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','employeeId'=>'Ehxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','employeeGroupId'=>'jsxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($employee['mock-content'],1);
		$employee=$sdk->employee_availability_listDay(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','employeeId'=>'Ehxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','year'=>'2021','month'=>'1','day'=>'01']);
		$this->assertEquals($employee['mock-content'],1);
		$employee=$sdk->employee_availability_listWeek(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','employeeId'=>'Ehxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','year'=>'2021','week'=>'41']);
		$this->assertEquals($employee['mock-content'],1);
		$employee=$sdk->employee_availability_listMonth(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','employeeId'=>'Ehxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','year'=>'2021','month'=>'1']);
		$this->assertEquals($employee['mock-content'],1);
		$data=['rangeStart'=>'2021-11-11T12:00:00+02:00','rangeEnd'=>'2021-11-19T19:00:00+02:00','availability'=>[['start'=>'2021-11-11T12:00:00+02:00','end'=>'2021-11-11T12:30:00+02:00']]];
		$employee=$sdk->employee_availability_edit(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','employeeId'=>'Ehxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($employee['mock-content'],1);
		$employee=$sdk->employee_delete(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','employeeId'=>'Ehxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($employee['mock-content'],1);


		#EMPLOYEEGROUP
		$data=[
			'name'=>'CB Mitarbeitergruppe Test',
			'customId'=>'Test123',
		];
		$employeeGroup=$sdk->employeeGroup_add(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($employeeGroup['mock-content'],1);
		$employeeGroup=$sdk->employeeGroup_show(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','employeeGroupId'=>'jsxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($employeeGroup['mock-content'],1);
		$employeeGroup=$sdk->employeeGroup_identify(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customId'=>'Test123']);
		$this->assertEquals($employeeGroup['mock-content'],1);
		$employeeGroupArray=$sdk->employeeGroup_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($employeeGroupArray['mock-content'],1);
		$employeeGroupArray=$sdk->employeeGroup_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($employeeGroupArray['mock-content'],1);
		$employeeGroupArray=$sdk->employeeGroup_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($employeeGroupArray['mock-content'],1);
		$data=['name'=>'CB Mitarbeitergruppe Test edited'];
		$employeeGroup=$sdk->employeeGroup_edit(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','employeeGroupId'=>'jsxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($employeeGroup['mock-content'],1);
		$employeeGroup=$sdk->employeeGroup_appConfig_link(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','employeeGroupId'=>'jsxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appConfigId'=>'c3xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($employeeGroup['mock-content'],1);
		$employeeGroup=$sdk->employeeGroup_appConfig_unlink(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','employeeGroupId'=>'jsxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appConfigId'=>'c3xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($employeeGroup['mock-content'],1);
		$employeeGroup=$sdk->employeeGroup_delete(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','employeeGroupId'=>'jsxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($employeeGroup['mock-content'],1);

		#FILE
		$data=[
			'name'=>'testDatei2',
			'fileName'=>'testDatei2',
			'fileContent'=>base64_encode('Dies ist eine Textdatei'),
			'customId'=>'1234',
		];
		$file=$sdk->file_add(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($file['mock-content'],1);
		$file=$sdk->file_show(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','fileId'=>'w1xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($file['mock-content'],1);
		$file=$sdk->file_download(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','fileId'=>'w1xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($file['content']['mock-content'],1);
		$file=$sdk->file_identify(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customId'=>'123']);
		$this->assertEquals($file['mock-content'],1);
		$fileArray=$sdk->file_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'2']);#page optional
		$this->assertEquals($fileArray['mock-content'],1);
		$fileArray=$sdk->file_indexAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($fileArray['mock-content'],1);
		$fileArray=$sdk->file_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'2']);#page optional
		$this->assertEquals($fileArray['mock-content'],1);
		$fileArray=$sdk->file_filterAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($fileArray['mock-content'],1);
		$fileArray=$sdk->file_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($fileArray['mock-content'],1);
		$fileArray=$sdk->file_listAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($fileArray['mock-content'],1);
		$data=['notes'=>'Test file edited'];
		$file=$sdk->file_edit(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','fileId'=>'w1xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($file['mock-content'],1);
		$file=$sdk->file_delete(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','fileId'=>'w1xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($file['mock-content'],1);
		$fileArray=$sdk->file_customEntity_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','page'=>'1']);
		$this->assertEquals($fileArray['mock-content'],1);
		$fileArray=$sdk->file_customEntity_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','searchQuery'=>'test','page'=>'2']);
		$this->assertEquals($fileArray['mock-content'],1);
		$fileArray=$sdk->file_customEntity_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar']);
		$this->assertEquals($fileArray['mock-content'],1);
		$fileArray=$sdk->file_customer_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customerId'=>'d3xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);
		$this->assertEquals($fileArray['mock-content'],1);
		$fileArray=$sdk->file_customer_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customerId'=>'d3xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'2']);
		$this->assertEquals($fileArray['mock-content'],1);
		$fileArray=$sdk->file_customer_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customerId'=>'d3xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($fileArray['mock-content'],1);

		#LICENSE
		$license=$sdk->license_show(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','licenseId'=>'23xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($license['mock-content'],1);
		$licenseArray=$sdk->license_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($licenseArray['mock-content'],1);
		$licenseArray=$sdk->license_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($licenseArray['mock-content'],1);
		$licenseArray=$sdk->license_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($licenseArray['mock-content'],1);

		#LICENSECONFIG
		$data=[
			'licenseId'=>'70xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
			'validationPeriodRenew'=>TRUE,
		];
		$licenseConfig=$sdk->licenseConfig_add(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($licenseConfig['mock-content'],1);
		$licenseConfig=$sdk->licenseConfig_show(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','licenseConfigId'=>'c3xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($licenseConfig['mock-content'],1);
		$licenseConfig=$sdk->licenseConfig_identify(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customId'=>'666']);
		$this->assertEquals($licenseConfig['mock-content'],1);
		$licenseConfigArray=$sdk->licenseConfig_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'2']);#page optional
		$this->assertEquals($licenseConfigArray['mock-content'],1);
		$licenseConfigArray=$sdk->licenseConfig_indexAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($licenseConfigArray['mock-content'],1);
		$licenseConfigArray=$sdk->licenseConfig_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'2']);#page optional
		$this->assertEquals($licenseConfigArray['mock-content'],1);
		$licenseConfigArray=$sdk->licenseConfig_filterAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($licenseConfigArray['mock-content'],1);
		$licenseConfigArray=$sdk->licenseConfig_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($licenseConfigArray['mock-content'],1);
		$licenseConfigArray=$sdk->licenseConfig_listAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($licenseConfigArray['mock-content'],1);
		$data=[
			'licenseId'=>'70xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
			'validationPeriodRenew'=>FALSE
		];
		$licenseConfig=$sdk->licenseConfig_edit(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','licenseConfigId'=>'c3xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($licenseConfig['mock-content'],1);
		$licenseConfig=$sdk->licenseConfig_delete(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','licenseConfigId'=>'c3xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($licenseConfig['mock-content'],1);

		#LOG
		$log=$sdk->log_show(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','logId'=>'34xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($log['mock-content'],1);
		$log=$sdk->log_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($log['mock-content'],1);
		$log=$sdk->log_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($log['mock-content'],1);

		#MODULECONFIG
		$data=[
			'moduleId'=>'23xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
			'settingList'=>[
				['key'=>'moduleSetting1_checkbox','value'=>'true'],
				['key'=>'moduleSetting2_input','value'=>'hallo'],
				['key'=>'moduleSetting3_textArea','value'=>'test'],
				['key'=>'moduleSetting4_date','value'=>'2021-09-28'],
				['key'=>'moduleSetting5_time','value'=>'09:33:00'],
				['key'=>'moduleSetting6_dateTime','value'=>'2021-09-29T12:00:00+01:00'],
				['key'=>'moduleSetting7_color','value'=>'#ffcc00'],
				['key'=>'moduleSetting9_email','value'=>'devtest@bookingtime.com'],
				['key'=>'moduleSetting10_mobile','value'=>'+4917012345678'],
				['key'=>'moduleSetting11_url','value'=>'http://wwwmusterfirma.de'],
				['key'=>'moduleSetting12_number','value'=>'123456'],
				['key'=>'moduleSetting13_alpha','value'=>'abcdefghijkm'],
				['key'=>'moduleSetting14_alphaNum','value'=>'abcdefghijkm123456'],
				['key'=>'moduleSetting15_digit','value'=>'123456'],
				['key'=>'moduleSetting16_hex','value'=>'abc123456789123456'],
			],
		];
		$moduleConfig=$sdk->moduleConfig_add(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($moduleConfig['mock-content'],1);
		$moduleConfig=$sdk->moduleConfig_show(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','moduleConfigId'=>'5fxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($moduleConfig['mock-content'],1);
		$moduleConfig=$sdk->moduleConfig_identify(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customId'=>'666']);
		$this->assertEquals($moduleConfig['mock-content'],1);
		$moduleConfigArray=$sdk->moduleConfig_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'2']);#page optional
		$this->assertEquals($moduleConfigArray['mock-content'],1);
		$moduleConfigArray=$sdk->moduleConfig_indexAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($moduleConfigArray['mock-content'],1);
		$moduleConfigArray=$sdk->moduleConfig_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'2']);#page optional
		$this->assertEquals($moduleConfigArray['mock-content'],1);
		$moduleConfigArray=$sdk->moduleConfig_filterAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($moduleConfigArray['mock-content'],1);
		$moduleConfigArray=$sdk->moduleConfig_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($moduleConfigArray['mock-content'],1);
		$moduleConfigArray=$sdk->moduleConfig_listAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($moduleConfigArray['mock-content'],1);
		$data=['name'=>'Test Module edited2'];
		$moduleConfig=$sdk->moduleConfig_edit(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','moduleConfigId'=>'5fxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($moduleConfig['mock-content'],1);
		$moduleConfig=$sdk->moduleConfig_appointmentTemplate_link(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','moduleConfigId'=>'5fxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($moduleConfig['mock-content'],1);
		$moduleConfig=$sdk->moduleConfig_appointmentTemplate_unlink(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','moduleConfigId'=>'5fxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','appointmentTemplateId'=>'eaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($moduleConfig['mock-content'],1);
		$moduleConfig=$sdk->moduleConfig_delete(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','moduleConfigId'=>'5fxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($moduleConfig['mock-content'],1);

		#MODULE
		$module=$sdk->module_show(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','moduleId'=>'23xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($module['mock-content'],1);
		$moduleArray=$sdk->module_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($moduleArray['mock-content'],1);
		$moduleArray=$sdk->module_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($moduleArray['mock-content'],1);
		$moduleArray=$sdk->module_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($moduleArray['mock-content'],1);

		#ONLINEMEETINGCONNECTION
		$data=[
			'type'=>'TEAMS',
			'email'=>'c.scheerer@bookingtime.com',
			'bookingResourceId'=>'brxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
			'customId'=>'111',
		];
		$onlineMeetingConnection=$sdk->onlineMeetingConnection_add(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($onlineMeetingConnection['mock-content'],1);
		$onlineMeetingConnection=$sdk->onlineMeetingConnection_show(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','onlineMeetingConnectionId'=>'bKxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($onlineMeetingConnection['mock-content'],1);
		$onlineMeetingConnection=$sdk->onlineMeetingConnection_identify(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customId'=>'666']);
		$this->assertEquals($onlineMeetingConnection['mock-content'],1);
		$onlineMeetingConnectionArray=$sdk->onlineMeetingConnection_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'2']);#page optional
		$this->assertEquals($onlineMeetingConnectionArray['mock-content'],1);
		$onlineMeetingConnectionArray=$sdk->onlineMeetingConnection_indexAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($onlineMeetingConnectionArray['mock-content'],1);
		$onlineMeetingConnectionArray=$sdk->onlineMeetingConnection_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'2']);#page optional
		$this->assertEquals($onlineMeetingConnectionArray['mock-content'],1);
		$onlineMeetingConnectionArray=$sdk->onlineMeetingConnection_filterAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($onlineMeetingConnectionArray['mock-content'],1);
		$onlineMeetingConnectionArray=$sdk->onlineMeetingConnection_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($onlineMeetingConnectionArray['mock-content'],1);
		$onlineMeetingConnectionArray=$sdk->onlineMeetingConnection_listAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($onlineMeetingConnectionArray['mock-content'],1);
		$data=['name'=>'Test Module edited2'];
		$onlineMeetingConnection=$sdk->onlineMeetingConnection_edit(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','onlineMeetingConnectionId'=>'bKxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($onlineMeetingConnection['mock-content'],1);
		$onlineMeetingConnection=$sdk->onlineMeetingConnection_delete(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','onlineMeetingConnectionId'=>'bKxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($onlineMeetingConnection['mock-content'],1);

		#ONLINEMEETINGCONNECTIONLOG
		$onlineMeetingConnectionLog=$sdk->onlineMeetingConnectionLog_show(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','onlineMeetingConnectionId'=>'bKxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','onlineMeetingConnectionLogId'=>'v6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($onlineMeetingConnectionLog['mock-content'],1);
		$onlineMeetingConnectionLogArray=$sdk->onlineMeetingConnectionLog_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','onlineMeetingConnectionId'=>'bKxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'2']);#page optional
		$this->assertEquals($onlineMeetingConnectionLogArray['mock-content'],1);

		#ORGANIZATION
		$data=[
			'customId'=>'sdkTest',
			'contractAccountId'=>'c4xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
			'name'=>'SDK GmbH - Mutterkonzern',
			'notes'=>'Die grosse SDK Konzernmutter',
			'address'=>['value'=>[
				'name'=>'Firma ACME GmbH Zentrale',
				'extra'=>'',
				'street'=>'Musterstraße 1',
				'zip'=>'12345',
				'city'=>'Bonn',
				'country'=>'DE',
			]],
			'email'=>['value'=>'max@mustermann.de'],
			'description'=>['value'=>'Die erste Firma aus dem SDK...'],
			'descriptionI18nList'=>['value'=>[['key'=>'en','value'=>'First organization from sdk...']],'inheritance'=>'OFF'],
			'contactPerson'=>[
				'value'=>[
					'firstName'=>'Cathrin',
					'lastName'=>'B',
					'email'=>'max@mustermann.de',
				],
			],
			'admin'=>[
				'firstName'=>'Cathrin',
				'lastName'=>'B',
				'email'=>'max@mustermann.de',
			],
			'sector'=>['value'=>'01ab'],
				'appIdList'=>['70W51gn5nFzzw8GQTDLh36rs52ZxhFYb','70oMsaa3PHiQ5xW6wL48zR2fjBpTvewq','70vkDQOF8WbaYGi0jYpcAYhHAJtJYvdv'],//config,customer,employee,calendar
				'moduleIdList'=>[],
				'employeeList'=>[],
				'appointmentTemplateList'=>[],
			'additionalData'=>[],
			'settings'=>[
				'timeZone'=>['value'=>'Europe/Berlin'],
				'currency'=>['value'=>'EUR'],
				'taxRate'=>['value'=>19],
				'showPrice'=>['value'=>TRUE],
				'availability'=>[
					['31.12.2019 09:00','31.12.2022 18:00'],
				],
				'emailReply'=>['value'=>'hamburg@acme-gmbh.de'],
				'smsSender'=>['value'=>'ACMEMutter'],
				'locale'=>['value'=>'de_DE'],
				'availability'=>['value'=>'CUSTOM'],
				'timeGrid'=>['value'=>'CUSTOM'],
				'moduleBookingDayEarliest'=>['value'=>0],
				'moduleBookingDayLatest'=>['value'=>14],
				'moduleBookingLeadTime'=>['value'=>120],
				'externalCalendarContentCustomer'=>['value'=>'[ORGANIZATION]','inheritance'=>'OFF'],
				'externalCalendarContentCustomerI18nList'=>['value'=>[['key'=>'en','value'=>'[ORGANIZATION]']],'inheritance'=>'OFF'],
				'moduleMultiFactorProtection'=>['value'=>'EMAIL'],
				'customerAddressRequired'=>['value'=>FALSE],
				'customerEmailRequired'=>['value'=>FALSE],
				'customerMobileRequired'=>['value'=>FALSE],
			],
		];
		$organization=$sdk->organization_add([],$data);
		$this->assertEquals($organization['mock-content'],1);
		$data=[
			'name'=>'CB Test Orga New Route',
			'customId'=>'123',
			'appConfig'=>TRUE,
			'moduleConfig'=>TRUE,
			'file'=>TRUE,
			'emailTemplate'=>TRUE,
			'smsTemplate'=>TRUE,
			'employee'=>TRUE,
			'employeeGroup'=>TRUE,
			'resource'=>TRUE,
			'appointmentTemplate'=>TRUE,
		];
		$organization=$sdk->organization_copy(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($organization['mock-content'],1);
		$organization=$sdk->organization_show(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($organization['class'],'ORGANIZATION');
		$data=['name'=>'CB Test Orga edited',];
		$organization=$sdk->organization_edit(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($organization['mock-content'],1);
		$data=['organizationId'=>'f6BRgjIDurHnDNaWDMEHRHWmABZ8ne5p',];
		$organization=$sdk->organization_move(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($organization['mock-content'],1);
		$organization=$sdk->organization_app_index(['appId'=>'70xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($organization['mock-content'],1);
		$organization=$sdk->organization_app_filter(['appId'=>'70xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($organization['mock-content'],1);
		$organization=$sdk->organization_app_list(['appId'=>'70xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($organization['class'],'LIST');
		$organization=$sdk->organization_app_tree(['appId'=>'70xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($organization['mock-content'],1);
		$organization=$sdk->organization_availability_listDay(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','year'=>'2021','month'=>'1','day'=>'30']);
		$this->assertEquals($organization['mock-content'],1);
		$organization=$sdk->organization_availability_listWeek(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','year'=>'2021','week'=>'41']);
		$this->assertEquals($organization['mock-content'],1);
		$organization=$sdk->organization_availability_listMonth(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','year'=>'2021','month'=>'1']);
		$this->assertEquals($organization['mock-content'],1);
		$data=['rangeStart'=>'2021-11-11T12:00:00+02:00','rangeEnd'=>'2021-11-19T19:00:00+02:00','availability'=>[['start'=>'2021-11-11T12:00:00+02:00','end'=>'2021-11-11T12:30:00+02:00']]];
		$organization=$sdk->organization_availability_edit(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($organization['mock-content'],1);
		$organization=$sdk->organization_emailTemplate_link(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','emailTemplateId'=>'46xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($organization['mock-content'],1);
		$organization=$sdk->organization_emailTemplate_unlink(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','emailTemplateId'=>'46xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($organization['mock-content'],1);
		$organization=$sdk->organization_smsTemplate_link(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','smsTemplateId'=>'6Gxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($organization['mock-content'],1);
		$organization=$sdk->organization_smsTemplate_unlink(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','smsTemplateId'=>'6Gxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($organization['mock-content'],1);
		$data=[
			'name'=>'CB Test Orga New Route',
			'customId'=>'123',
			'address'=>[
				'value'=>[
					'name'=>'CB Test Orga',
					'street'=>'Teststraße 1',
					'zip'=>'12345',
					'city'=>'Hamburg',
					'country'=>'DE',
				],
			],
			'email'=>['value'=>'max@mustermann.de'],
			'contactPerson'=>[
				'value'=>[
					'firstName'=>'Cathrin',
					'lastName'=>'B',
					'email'=>'max@mustermann.de',
				],
			],
			'settings'=>[
				'timeZone'=>['value'=>'Europe/Berlin'],
				'emailReply'=>['value'=>'noreply@bookingtime.com'],
				'locale'=>['value'=>'de_DE'],
				'moduleMultiFactorProtection'=>[
					'value'=>'OFF',
					'inheritance'=>'OFF',
				],
				'customerAddressRequired'=>[
					'value'=>FALSE,
					'inheritance'=>'OFF',
				],
				'customerEmailRequired'=>[
					'value'=>FALSE,
					'inheritance'=>'OFF',
				],
				'customerMobileRequired'=>[
					'value'=>FALSE,
					'inheritance'=>'OFF',
				],
			],
			'admin'=>[
				'firstName'=>'Cathrin',
				'lastName'=>'B',
				'email'=>'max@mustermann.de',
			],
			'sector'=>['value'=>'01ab'],
			'appIdList'=>[],
			'moduleIdList'=>[],
			'employeeList'=>[],
			'appointmentTemplateList'=>[],
		];
		$organization=$sdk->organization_subOrganization_addRoot(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($organization['mock-content'],1);
		$data=[
			'name'=>'CB Test Orga',
			'customId'=>'12345',
			'address'=>[
				'value'=>[
					'name'=>'CB Test Orga',
					'street'=>'Teststraße 1',
					'zip'=>'12345',
					'city'=>'Hamburg',
					'country'=>'DE',
				],
			],
			'email'=>['value'=>'max@mustermann.de'],
			'contactPerson'=>[
				'value'=>[
					'firstName'=>'Cathrin',
					'lastName'=>'B',
					'email'=>'max@mustermann.de',
				],
			],
			'settings'=>[
				'timeZone'=>['value'=>'Europe/Berlin'],
				'emailReply'=>['value'=>'noreply@bookingtime.com'],
				'locale'=>['value'=>'de_DE'],
			],
			'sector'=>['value'=>'01ab'],
		];
		$organization=$sdk->organization_subOrganization_addSub(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($organization['mock-content'],1);
		$organization=$sdk->organization_subOrganization_identify(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customId'=>'12345']);
		$this->assertEquals($organization['mock-content'],1);
		$organization=$sdk->organization_subOrganization_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($organization['mock-content'],1);
		$organization=$sdk->organization_subOrganization_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($organization['mock-content'],1);
		$organization=$sdk->organization_subOrganization_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($organization['class'],'LIST');
		$organization=$sdk->organization_subOrganization_tree(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($organization['mock-content'],1);
		$organization=$sdk->organization_timeGrid_listWeek(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','year'=>'2021','week'=>'41']);
		$this->assertEquals($organization['mock-content'],1);
		$data=['rangeStart'=>'2021-11-11T12:00:00+02:00','rangeEnd'=>'2021-11-19T19:00:00+02:00','timeGrid'=>['2021-11-11T12:00:00+02:00','2021-11-11T12:30:00+02:00']];
		$organization=$sdk->organization_timeGrid_edit(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($organization['mock-content'],1);
		$organization=$sdk->organization_delete(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($organization['mock-content'],1);

		#PACKET
		$packet=$sdk->packet_show(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','packetId'=>'aPxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($packet['mock-content'],1);
		$packetArray=$sdk->packet_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($packetArray['mock-content'],1);
		$packetArray=$sdk->packet_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($packetArray['mock-content'],1);
		$packetArray=$sdk->packet_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($packetArray['mock-content'],1);
		$packet=$sdk->packet_purchase(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','packetId'=>'aPxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($packet['mock-content'],1);

		#RESOURCE
		$data=[
			'name'=>'Resource Test',
			'nameI18nList'=>[['key'=>'en','value'=>'This is a resource']],
			'type'=>'LOCATION',
			'description'=>'Das ist die Resource Test',
			'descriptionI18nList'=>[['key'=>'en','value'=>'This is a resource']],
		];
		$resource=$sdk->resource_add(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($resource['mock-content'],1);
		$resource=$sdk->resource_show(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','resourceId'=>'73xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($resource['mock-content'],1);
		$resource=$sdk->resource_identify(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customId'=>'696']);
		$this->assertEquals($resource['mock-content'],1);
		$resourceArray=$sdk->resource_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($resourceArray['mock-content'],1);
		$resourceArray=$sdk->resource_indexAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($resourceArray['mock-content'],1);
		$resourceArray=$sdk->resource_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($resourceArray['mock-content'],1);
		$resourceArray=$sdk->resource_filterAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($resourceArray['mock-content'],1);
		$resourceArray=$sdk->resource_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($resourceArray['mock-content'],1);
		$resourceArray=$sdk->resource_listAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($resourceArray['mock-content'],1);
		$data=['name'=>'Resource Testedited'];
		$resource=$sdk->resource_edit(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','resourceId'=>'73xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($resourceArray['mock-content'],1);
		$resource=$sdk->resource_availability_listDay(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','resourceId'=>'73xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','year'=>'2021','month'=>'1','day'=>'30']);
		$this->assertEquals($resourceArray['mock-content'],1);
		$resource=$sdk->resource_availability_listWeek(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','resourceId'=>'73xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','year'=>'2021','week'=>'41']);
		$this->assertEquals($resourceArray['mock-content'],1);
		$resource=$sdk->resource_availability_listMonth(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','resourceId'=>'73xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','year'=>'2021','month'=>'1']);
		$this->assertEquals($resourceArray['mock-content'],1);
		$data=['rangeStart'=>'2021-11-11T12:00:00+02:00','rangeEnd'=>'2021-11-19T19:00:00+02:00','availability'=>[['start'=>'2021-11-11T12:00:00+02:00','end'=>'2021-11-11T12:30:00+02:00']]];
		$resource=$sdk->resource_availability_edit(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','resourceId'=>'73xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($resource['mock-content'],1);
		$resourceArray=$sdk->resource_customEntity_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','page'=>'1']);
		$this->assertEquals($resourceArray['mock-content'],1);
		$resourceArray=$sdk->resource_customEntity_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar','searchQuery'=>'test','page'=>'2']);
		$this->assertEquals($resourceArray['mock-content'],1);
		$resourceArray=$sdk->resource_customEntity_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityId'=>'6Txxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customEntityType'=>'rentalCar']);
		$this->assertEquals($resourceArray['mock-content'],1);
		$resource=$sdk->resource_delete(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','resourceId'=>'73xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($resource['mock-content'],1);

		#REPORTINGJOB
		$data=[
			'name'=>'ReportingJob Test',
			'customId'=>'test',
			'category'=>'APPOINTMENT_LIST',
			'sendingInterval'=>'WEEKLY',
			'recipientEmailList'=>['support@bookingtime.com'],
		];
		$reportingJob=$sdk->reportingJob_add(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($reportingJob['mock-content'],1);
		$reportingJob=$sdk->reportingJob_show(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','reportingJobId'=>'73xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($reportingJob['mock-content'],1);
		$reportingJob=$sdk->reportingJob_identify(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customId'=>'696']);
		$this->assertEquals($reportingJob['mock-content'],1);
		$reportingJobArray=$sdk->reportingJob_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($reportingJobArray['mock-content'],1);
		$reportingJobArray=$sdk->reportingJob_indexAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($reportingJobArray['mock-content'],1);
		$reportingJobArray=$sdk->reportingJob_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($reportingJobArray['mock-content'],1);
		$reportingJobArray=$sdk->reportingJob_filterAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($reportingJobArray['mock-content'],1);
		$reportingJobArray=$sdk->reportingJob_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($reportingJobArray['mock-content'],1);
		$reportingJobArray=$sdk->reportingJob_listAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($reportingJobArray['mock-content'],1);
		$data=['name'=>'reportingJob Testedited'];
		$reportingJob=$sdk->reportingJob_edit(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','reportingJobId'=>'73xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($reportingJobArray['mock-content'],1);
		$reportingJob=$sdk->reportingJob_delete(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','reportingJobId'=>'73xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($reportingJob['mock-content'],1);

		#SMS
		$sms=$sdk->sms_show(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','smsId'=>'e0xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($sms['mock-content'],1);
		$smsArray=$sdk->sms_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($smsArray['mock-content'],1);
		$smsArray=$sdk->sms_indexAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($smsArray['mock-content'],1);
		$smsArray=$sdk->sms_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($smsArray['mock-content'],1);
		$smsArray=$sdk->sms_filterAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($smsArray['mock-content'],1);
		$smsArray=$sdk->sms_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($smsArray['mock-content'],1);
		$smsArray=$sdk->sms_listAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($smsArray['mock-content'],1);
		$sms=$sdk->sms_resend(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','smsId'=>'e0xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($sms['mock-content'],1);
		$smsArray=$sdk->sms_customer_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customerId'=>'d3xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($smsArray['mock-content'],1);
		$smsArray=$sdk->sms_customer_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customerId'=>'d3xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($smsArray['mock-content'],1);
		$smsArray=$sdk->sms_customer_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customerId'=>'d3xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($smsArray['mock-content'],1);

		#SMSTEMPLATE
		$data=[
			'name'=>'SMS Template Test',
			'active'=>true,
			'event'=>'APPOINTMENT_ADD',
			'text'=>'Juten Tach',
			'textI18nList'=>[['key'=>'en','value'=>'good day']],
		];
		$smsTemplate=$sdk->smsTemplate_add(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($smsTemplate['mock-content'],1);
		$smsTemplate=$sdk->smsTemplate_show(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','smsTemplateId'=>'6Gxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($smsTemplate['mock-content'],1);
		$smsTemplate=$sdk->smsTemplate_identify(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customId'=>'1234']);
		$this->assertEquals($smsTemplate['mock-content'],1);
		$smsTemplateArray=$sdk->smsTemplate_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($smsTemplateArray['mock-content'],1);
		$smsTemplateArray=$sdk->smsTemplate_indexAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($smsTemplateArray['mock-content'],1);
		$smsTemplateArray=$sdk->smsTemplate_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($smsTemplateArray['mock-content'],1);
		$smsTemplateArray=$sdk->smsTemplate_filterAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($smsTemplateArray['mock-content'],1);
		$smsTemplateArray=$sdk->smsTemplate_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($smsTemplateArray['mock-content'],1);
		$smsTemplateArray=$sdk->smsTemplate_listAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($smsTemplateArray['mock-content'],1);
		$data=['name'=>'smsTemplate Test edited'];
		$smsTemplate=$sdk->smsTemplate_edit(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','smsTemplateId'=>'6Gxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($smsTemplate['mock-content'],1);
		$smsTemplate=$sdk->smsTemplate_delete(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','smsTemplateId'=>'6Gxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],[]);
		$this->assertEquals($smsTemplate['mock-content'],1);

		#STATIC
		$countryList=$sdk->static_country_list([]);
		$this->assertEquals($countryList['mock-content'],1);
		$currencyList=$sdk->static_currency_list([]);
		$this->assertEquals($currencyList['mock-content'],1);
		$error400=$sdk->static_error_show(['errorCode'=>400]);
		$this->assertEquals($error400['mock-content'],1);
		$error401=$sdk->static_error_show(['errorCode'=>401]);
		$this->assertEquals($error401['mock-content'],1);
		$error403=$sdk->static_error_show(['errorCode'=>403]);
		$this->assertEquals($error403['mock-content'],1);
		$error404=$sdk->static_error_show(['errorCode'=>404]);
		$this->assertEquals($error404['mock-content'],1);
		$error405=$sdk->static_error_show(['errorCode'=>405]);
		$this->assertEquals($error405['mock-content'],1);
		$error500=$sdk->static_error_show(['errorCode'=>500]);
		$this->assertEquals($error500['mock-content'],1);
		$languageList=$sdk->static_language_list([]);
		$this->assertEquals($languageList['mock-content'],1);
		$logCategoryList=$sdk->static_logCategory_list([]);
		$this->assertEquals($logCategoryList['mock-content'],1);
		$permissionList=$sdk->static_permission_list([]);
		$this->assertEquals($permissionList['mock-content'],1);
		$sectorList=$sdk->static_sector_list([]);
		$this->assertEquals($sectorList['mock-content'],1);
		$timeZoneList=$sdk->static_timeZone_list([]);
		$this->assertEquals($timeZoneList['mock-content'],1);
		$organizationTemplateDataList=$sdk->static_organizationTemplateData_list([]);
		$this->assertEquals($organizationTemplateDataList['mock-content'],1);

		#SYNCHRONIZATION
		$data=[
			'bookingResourceId'=>'brxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
			'type'=>'GRAPH',
			'customId'=>'888',
			'email'=>'support@bookingtime.com',
			'externalCalendarContentStaff'=>[
				'value'=>'',
				'inheritance'=>'ORGANIZATION',
			],
			'notes'=>'',
			'synchronizationServer'=>[
				'value'=>[],
				'inheritance'=>'ORGANIZATION',
			],
			'syncInterval'=>'MINUTES_15',
		];
		$synchronization=$sdk->synchronization_add(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($synchronization['mock-content'],1);
		$synchronization=$sdk->synchronization_show(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','synchronizationId'=>'A7xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($synchronization['mock-content'],1);
		$synchronization=$sdk->synchronization_identify(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','customId'=>'666']);
		$this->assertEquals($synchronization['mock-content'],1);
		$synchronizationArray=$sdk->synchronization_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($synchronizationArray['mock-content'],1);
		$synchronizationArray=$sdk->synchronization_indexAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($synchronizationArray['mock-content'],1);
		$synchronizationArray=$sdk->synchronization_filter(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($synchronizationArray['mock-content'],1);
		$synchronizationArray=$sdk->synchronization_filterAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','searchQuery'=>'test','page'=>'1']);#page optional
		$this->assertEquals($synchronizationArray['mock-content'],1);
		$synchronizationArray=$sdk->synchronization_list(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($synchronizationArray['mock-content'],1);
		$synchronizationArray=$sdk->synchronization_listAll(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($synchronizationArray['mock-content'],1);
		$data=['notes'=>'test edit'];
		$synchronization=$sdk->synchronization_edit(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','synchronizationId'=>'Ehxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'],$data);
		$this->assertEquals($synchronization['mock-content'],1);
		$synchronization=$sdk->synchronization_delete(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','synchronizationId'=>'A7xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($synchronization['mock-content'],1);
		$synchronization=$sdk->synchronization_reset(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','synchronizationId'=>'A7xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($synchronization['mock-content'],1);

		#SYNCHRONIZATION_LOG
		$synchronizationLog=$sdk->synchronizationLog_show(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','synchronizationId'=>'A7xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','synchronizationLogId'=>'7qxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx']);
		$this->assertEquals($synchronizationLog['mock-content'],1);
		$synchronizationLogArray=$sdk->synchronizationLog_index(['organizationId'=>'f6xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','synchronizationId'=>'A7xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','page'=>'1']);#page optional
		$this->assertEquals($synchronizationLogArray['mock-content'],1);
	}
}
