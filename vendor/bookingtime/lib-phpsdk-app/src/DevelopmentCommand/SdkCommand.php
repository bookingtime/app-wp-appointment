<?php

namespace bookingtime\phpsdkapp\DevelopmentCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use bookingtime\phpsdkapp\Sdk;
use bookingtime\phpsdkapp\Lib\BasicLib;


/**
 * command, see desciption for more infos
 *
 * @author <bookingtime GmbH>
 */
class SdkCommand extends Command {



	/**
	 * {@inheritDoc}
	 */
	protected function configure():void {
		//define command meta data
		$this->setName('development:sdk');
		$this->setDescription('Use the php SDK with this command for development');
		$this->setHelp('...');
	}



	/**
	 * {@inheritDoc}
	 */
	protected function execute(InputInterface $input,OutputInterface $output):int {
		if(!file_exists(__DIR__.'/secret.json')) {throw new \RuntimeException(__METHOD__.'() #'.__LINE__.': Abort command, no secret.json found!');}
		$secret=json_decode(file_get_contents(__DIR__.'/secret.json'),TRUE);
		$sdk=new Sdk($secret['client_id'],$secret['client_secret'],[
			'appApiUrl'=>'http://host.docker.internal:4102/app/v3/',
			'oauthUrl'=>'http://host.docker.internal:4101/oauth/token',
			'locale'=>'de',
			'timeout'=>15,
			'mock'=>FALSE,
		]);

		#APPCONFIG
		// $data=[
		// 	'appId'=>'70EIHwXpJekFi2FEgCx00wXgFcTXHkbB',
		// 	'developerAccountId'=>'dA2n8tV5XPnvxT7m7usPWCa8wjlhTgFF',
		// 	'settingList'=>[
		// 		['key'=>'appSetting1_checkbox','value'=>'true'],
		// 		['key'=>'appSetting2_input','value'=>'hallo'],
		// 		['key'=>'appSetting3_textArea','value'=>'test'],
		// 		['key'=>'appSetting4_date','value'=>'2021-09-28'],
		// 		['key'=>'appSetting5_time','value'=>'09:33:00'],
		// 		['key'=>'appSetting6_dateTime','value'=>'2021-09-29T12:00:00+01:00'],
		// 		['key'=>'appSetting7_color','value'=>'#ffcc00'],
		// 		['key'=>'appSetting9_email','value'=>'devtest@bookingtime.com'],
		// 		['key'=>'appSetting10_mobile','value'=>'+491701234567'],
		// 		['key'=>'appSetting11_url','value'=>'http://wwwmusterfirma.de'],
		// 		['key'=>'appSetting12_number','value'=>'123456'],
		// 		['key'=>'appSetting13_alpha','value'=>'abcdefghijkm'],
		// 		['key'=>'appSetting14_alphaNum','value'=>'abcdefghijkm123456'],
		// 		['key'=>'appSetting15_digit','value'=>'123456'],
		// 		['key'=>'appSetting16_hex','value'=>'abc123456789123456'],
		// 	],
		// ];
		// $appConfig=$sdk->appConfig_add(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs'],$data);
		// $appConfig=$sdk->appConfig_show(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','appConfigId'=>'c3DfkPErdv7zgyb0nWn2iwJCPgF4kKMD']);
		// $appConfig=$sdk->appConfig_identify(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','customId'=>'666']);
		// $appConfigArray=$sdk->appConfig_index(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','page'=>'2']);#page optional
		// $appConfigArray=$sdk->appConfig_indexAll(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','page'=>'1']);#page optional
		// $appConfigArray=$sdk->appConfig_filter(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','searchQuery'=>'test','page'=>'2']);#page optional
		// $appConfigArray=$sdk->appConfig_filterAll(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','searchQuery'=>'test','page'=>'1']);#page optional
		// $appConfigArray=$sdk->appConfig_list(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs']);
		// $appConfigArray=$sdk->appConfig_listAll(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs']);
		// $data=['name'=>'Test App edited2'];
		// $sdk->appConfig_edit(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','appConfigId'=>'c3DfkPErdv7zgyb0nWn2iwJCPgF4kKMD'],$data);
		// $sdk->appConfig_app_show(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','appId'=>'70B9EOUxfSN0p866nCa2zGVKma3K3wEy']);
		// $sdk->appConfig_delete(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','appConfigId'=>'c3DfkPErdv7zgyb0nWn2iwJCPgF4kKMD']);

		#APP
		// $app=$sdk->app_show(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','appId'=>'70B9EOUxfSN0p866nCa2zGVKma3K3wEy']);
		// $appArray=$sdk->app_index(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','page'=>'1']);#page optional
		// $appArray=$sdk->app_filter(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','searchQuery'=>'test','page'=>'1']);#page optional
		// $appArray=$sdk->app_list(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs',]);

		#APPOINTMENT
		// $data=['bookingSlotId'=>'4f6gl70xpd6oeqis236e1f80ac7acd54','customerId'=>'d3k1qW5uf3pInMnanVLzRABG1H6XOGHC'];
		// $appointment=$sdk->appointment_add(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO'],$data);
		// $appointment=$sdk->appointment_show(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentId'=>'eddXX23behodfOJck69hZW1y8dJYbDkX']);
		// $appointment=$sdk->appointment_identify(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customId'=>'123']);
		// $appointmentArray=$sdk->appointment_listDay(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','year'=>'2021','month'=>'9','day'=>'28']);
		// $appointmentArray=$sdk->appointment_listWeek(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','year'=>'2021','week'=>'39']);
		// $appointmentArray=$sdk->appointment_listMonth(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','year'=>'2021','month'=>'9']);
		//$appointmentArray=$sdk->appointment_bookingResourceReplaceList(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentId'=>'eddXX23behodfOJck69hZW1y8dJYbDkX']);
		// $data=['notes'=>'Test Appointment edited'];
		// $data=['bookingSlotId'=>'4f6gl70xpd6oeqis236e1f80ac7acd54'];
		// $appointment=$sdk->appointment_move(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentId'=>'eddXX23behodfOJck69hZW1y8dJYbDkX'],$data);
		// $this->assertEquals($appointment['mock-content'],1);
		// $sdk->appointment_edit(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentId'=>'eddXX23behodfOJck69hZW1y8dJYbDkX'],$data);
		// $sdk->appointment_cancel(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentId'=>'eddXX23behodfOJck69hZW1y8dJYbDkX']);
		// $appointmentArray=$sdk->appointment_customer_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customerId'=>'d3k1qW5uf3pInMnanVLzRABG1H6XOGHC','page'=>'1']);
		// $appointmentArray=$sdk->appointment_customer_filter(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customerId'=>'d3k1qW5uf3pInMnanVLzRABG1H6XOGHC','searchQuery'=>'test','page'=>'2']);
		// $appointmentArray=$sdk->appointment_customer_list(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customerId'=>'d3k1qW5uf3pInMnanVLzRABG1H6XOGHC']);
		// $appointment=$sdk->appointment_customer_link(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentId'=>'eddXX23behodfOJck69hZW1y8dJYbDkX','customerId'=>'d3cTwmaQHY6vAZTZFwjcAsrLhuFNiKN8']);
		// $appointment=$sdk->appointment_customer_unlink(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentId'=>'eddXX23behodfOJck69hZW1y8dJYbDkX','customerId'=>'d3cTwmaQHY6vAZTZFwjcAsrLhuFNiKN8']);

		#APPOINTMENTTEMPLATE
		//$appointmentTemplateArray=$sdk->appointmentTemplate_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','page'=>'2']);#page optional
		// $appointmentTemplateArray=$sdk->appointmentTemplate_indexAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','page'=>'1']);#page optional
		// $appointmentTemplateArray=$sdk->appointmentTemplate_filter(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','searchQuery'=>'test','page'=>'2']);#page optional
		// $appointmentTemplateArray=$sdk->appointmentTemplate_filterAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','searchQuery'=>'test','page'=>'1']);#page optional
		// $appointmentTemplateArray=$sdk->appointmentTemplate_list(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO']);
		// $appointmentTemplateArray=$sdk->appointmentTemplate_listAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO']);
		#die(BasicLib::debug($appointmentTemplateArray));

		#APPOINTMENTTEMPLATESIMPLE
		// $data=[
		// 	'type'=>'SIMPLE',
		// 	'name'=>'Terminvorlage simple',
		// 	'publicName'=>'Terminvorlage simple',
		// 	'publicNameI18nList'=>[['key'=>'en','value'=>'AppointmentTemplate simple']],
		// 	'description'=>'Terminvorlage simple',
		// 	'descriptionI18nList'=>[],
		// 	'duration'=>60,
		// 	'externalCalendarContentCustomer'=>['value'=>'[ORGANIZATION]','inheritance'=>'OFF'],
		// 	'externalCalendarContentCustomerI18nList'=>['value'=>[['key'=>'en','value'=>'[ORGANIZATION]']],'inheritance'=>'OFF'],
		// 	'moduleMultiFactorProtection'=>[
		// 		'value'=>'OFF',
		// 		'inheritance'=>'OFF',
		// 	],
		// 	'customerAddressRequired'=>[
		// 		'value'=>FALSE,
		// 		'inheritance'=>'OFF',
		// 	],
		// 	'customerEmailRequired'=>[
		// 		'value'=>FALSE,
		// 		'inheritance'=>'OFF',
		// 	],
		// 	'customerMobileRequired'=>[
		// 		'value'=>FALSE,
		// 		'inheritance'=>'OFF',
		// 	],
		// ];
		// $appointmentTemplateSimple=$sdk->appointmentTemplate_add(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO'],$data);
		// $appointmentTemplateSimple=$sdk->appointmentTemplate_show(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'ea5viEwqzcz55RGwF6vR8U9UywkW6m2X']);
		// $appointmentTemplateSimple=$sdk->appointmentTemplate_identify(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'ea5viEwqzcz55RGwF6vR8U9UywkW6m2X','customId'=>'666']);
		// $data=['name'=>'Terminvorlage simple edited'];
		// $sdk->appointmentTemplate_edit(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'ea5viEwqzcz55RGwF6vR8U9UywkW6m2X'],$data);
		// $sdk->appointmentTemplate_bookingResource_link(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'ea5viEwqzcz55RGwF6vR8U9UywkW6m2X','bookingResourceId'=>'browuBQJWSylERkRQIHHrlXHVpCeyfqN']);
		// $sdk->appointmentTemplate_bookingResource_unlink(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'ea5viEwqzcz55RGwF6vR8U9UywkW6m2X','bookingResourceId'=>'browuBQJWSylERkRQIHHrlXHVpCeyfqN']);
		// $sdk->appointmentTemplate_emailTemplate_link(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'ea5viEwqzcz55RGwF6vR8U9UywkW6m2X','emailTemplateId'=>'46a6NWcBgly2Wyl2e5sTXF0joar3KOdV']);
		// $sdk->appointmentTemplate_emailTemplate_unlink(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'ea5viEwqzcz55RGwF6vR8U9UywkW6m2X','emailTemplateId'=>'46a6NWcBgly2Wyl2e5sTXF0joar3KOdV']);
		// $sdk->appointmentTemplate_smsTemplate_link(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'ea5viEwqzcz55RGwF6vR8U9UywkW6m2X','smsTemplateId'=>'6G4qU5lcT3AyZwkRfZtm4eRegr1ma9yl']);
		// $sdk->appointmentTemplate_smsTemplate_unlink(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'ea5viEwqzcz55RGwF6vR8U9UywkW6m2X','smsTemplateId'=>'6G4qU5lcT3AyZwkRfZtm4eRegr1ma9yl']);
		// $sdk->appointmentTemplate_timeGrid_listWeek(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'ea5viEwqzcz55RGwF6vR8U9UywkW6m2X','year'=>'2021','week'=>'41']);
		// $data=['rangeStart'=>'2021-11-11T12:00:00+02:00','rangeEnd'=>'2021-11-19T19:00:00+02:00','timeGrid'=>['2021-11-11T12:00:00+02:00','2021-11-11T12:30:00+02:00']];
		// $sdk->appointmentTemplate_timeGrid_edit(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'ea5viEwqzcz55RGwF6vR8U9UywkW6m2X'],$data);
		// $sdk->appointmentTemplate_delete(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'ea5viEwqzcz55RGwF6vR8U9UywkW6m2X']);

		#APPOINTMENTTEMPLATECOMPLEX
		// $data=[
		// 	'type'=>'COMPLEX',
		// 	'name'=>'Terminvorlage COMPLEX',
		// 	'duration'=>90,
		// ];
		// $appointmentTemplateComplex=$sdk->appointmentTemplate_add(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO'],$data);
		// $appointmentTemplateComplex=$sdk->appointmentTemplate_show(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'eaURedwhApwgw5YAe3kNBPiDsUKJxS3P']);
		// $appointmentTemplateComplex=$sdk->appointmentTemplate_identify(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'eaURedwhApwgw5YAe3kNBPiDsUKJxS3P','customId'=>'1234']);
		// $data=['name'=>'Terminvorlage complex edited'];
		// $sdk->appointmentTemplate_edit(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'eaURedwhApwgw5YAe3kNBPiDsUKJxS3P'],$data);
		// $sdk->appointmentTemplate_emailTemplate_link(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'eaURedwhApwgw5YAe3kNBPiDsUKJxS3P','emailTemplateId'=>'46a6NWcBgly2Wyl2e5sTXF0joar3KOdV']);
		// $sdk->appointmentTemplate_emailTemplate_unlink(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'eaURedwhApwgw5YAe3kNBPiDsUKJxS3P','emailTemplateId'=>'46a6NWcBgly2Wyl2e5sTXF0joar3KOdV']);
		// $sdk->appointmentTemplate_smsTemplate_link(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'eaURedwhApwgw5YAe3kNBPiDsUKJxS3P','smsTemplateId'=>'6G4qU5lcT3AyZwkRfZtm4eRegr1ma9yl']);
		// $sdk->appointmentTemplate_smsTemplate_unlink(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'eaURedwhApwgw5YAe3kNBPiDsUKJxS3P','smsTemplateId'=>'6G4qU5lcT3AyZwkRfZtm4eRegr1ma9yl']);
		// $sdk->appointmentTemplate_timeGrid_listWeek(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'eaURedwhApwgw5YAe3kNBPiDsUKJxS3P','year'=>'2021','week'=>'41']);
		// $data=['rangeStart'=>'2021-10-11T12:00:00+02:00','rangeEnd'=>'2021-10-19T19:00:00+02:00','timeGrid'=>['2021-10-11T12:00:00+02:00','2021-10-11T12:30:00+02:00']];
		// $sdk->appointmentTemplate_timeGrid_edit(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'eaURedwhApwgw5YAe3kNBPiDsUKJxS3P'],$data);
		// $sdk->appointmentTemplate_delete(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'eaURedwhApwgw5YAe3kNBPiDsUKJxS3P']);

		#APPOINTMENTTEMPLATESTEP
		// $data=[
		// 	'name'=>'Buchungsschritt',
		// 	'nameI18nList'=>[['key'=>'en','value'=>'appointmentTemplateStep']],
		// 	'description'=>'Buchungsschritt',
		// 	'descriptionI18nList'=>[['key'=>'en','value'=>'This is an appointmentTemplateStep']],
		// ];
		// $appointmentTemplateStep=$sdk->appointmentTemplateStep_add(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'eaURedwhApwgw5YAe3kNBPiDsUKJxS3P'],$data);
		// $data=['name'=>'Buchungsschritt edited'];
		// $sdk->appointmentTemplateStep_edit(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'eaURedwhApwgw5YAe3kNBPiDsUKJxS3P','appointmentTemplateStepId'=>'b8liy4o7AItwRPoct0akZBHG6UPX52j8'],$data);
		// $sdk->appointmentTemplateStep_delete(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'eaURedwhApwgw5YAe3kNBPiDsUKJxS3P','appointmentTemplateStepId'=>'b8liy4o7AItwRPoct0akZBHG6UPX52j8']);
		// $sdk->appointmentTemplateStep_bookingResource_link(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'eaURedwhApwgw5YAe3kNBPiDsUKJxS3P','appointmentTemplateStepId'=>'b8liy4o7AItwRPoct0akZBHG6UPX52j8','bookingResourceId'=>'browuBQJWSylERkRQIHHrlXHVpCeyfqN']);
		// $sdk->appointmentTemplateStep_bookingResource_unlink(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'eaURedwhApwgw5YAe3kNBPiDsUKJxS3P','appointmentTemplateStepId'=>'b8liy4o7AItwRPoct0akZBHG6UPX52j8','bookingResourceId'=>'browuBQJWSylERkRQIHHrlXHVpCeyfqN']);

		#APPOINTMENTTEMPLATE_EVENT_DATE_TIME
		// $data=[
		// 	'customId'=>'sdk1',
		// 	'start'=>'2024-10-29T12:00:00+01:00',
		// 	'bookingResourceIdList'=>['brDqyrfum3JUiBUni0o70wyeoMiIpRLG'],
		// 	'appointmentEventAttendanceCountMax'=>10,
		// ];
		// $appointmentTemplateEventDateTime=$sdk->appointmentTemplateEventDateTime_add(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'6tAlWWMmOS7u75bKhvdZiaAGMLlYZdVb'],$data);
		// $data=['customId'=>'sdk1edited'];
		// $appointmentTemplateEventDateTime=$sdk->appointmentTemplateEventDateTime_edit(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'6tAlWWMmOS7u75bKhvdZiaAGMLlYZdVb','appointmentTemplateEventDateTimeId'=>'psCBIC5nrBNvBNk7uapuqbUuUkuNCmdo'],$data);
		// $appointmentTemplateEventDateTime=$sdk->appointmentTemplateEventDateTime_bookingResource_unlink(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'6tAlWWMmOS7u75bKhvdZiaAGMLlYZdVb','appointmentTemplateEventDateTimeId'=>'psCBIC5nrBNvBNk7uapuqbUuUkuNCmdo','bookingResourceId'=>'browuBQJWSylERkRQIHHrlXHVpCeyfqN']);
		// $appointmentTemplateEventDateTime=$sdk->appointmentTemplateEventDateTime_bookingResource_link(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'6tAlWWMmOS7u75bKhvdZiaAGMLlYZdVb','appointmentTemplateEventDateTimeId'=>'psCBIC5nrBNvBNk7uapuqbUuUkuNCmdo','bookingResourceId'=>'browuBQJWSylERkRQIHHrlXHVpCeyfqN']);
		// $appointmentTemplateEventDateTime=$sdk->appointmentTemplateEventDateTime_delete(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'6tAlWWMmOS7u75bKhvdZiaAGMLlYZdVb','appointmentTemplateEventDateTimeId'=>'psCBIC5nrBNvBNk7uapuqbUuUkuNCmdo']);
		#die(BasicLib::debug($appointmentTemplateEventDateTime));

		#AVAILABILITYEXCEPTION
		// $data=[
		// 	'name'=>'Ausnahme Test',
		// 	'type'=>'FREE',
		// 	'appointmentTemplateId'=>'ea5viEwqzcz55RGwF6vR8U9UywkW6m2X',
		// 	'bookingResourceId'=>'brDqyrfum3JUiBUni0o70wyeoMiIpRLG',
		// 	'start'=>'2021-10-29T12:00:00+01:00',
		// 	'end'=>'2021-10-29T19:00:00+01:00',
		// ];
		// $availabilityException=$sdk->availabilityException_add(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO'],$data);
		// $availabilityException=$sdk->availabilityException_show(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','availabilityExceptionId'=>'acmi17HCCrpJ5krwIKMtdlMLauIMUcdR']);
		// $availabilityException=$sdk->availabilityException_identify(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customId'=>'4446611']);
		// $availabilityExceptionArray=$sdk->availabilityException_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','page'=>'1']);#page optional
		// $availabilityExceptionArray=$sdk->availabilityException_indexAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','page'=>'1']);#page optional
		// $availabilityExceptionArray=$sdk->availabilityException_filter(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','searchQuery'=>'test','page'=>'1']);#page optional
		// $availabilityExceptionArray=$sdk->availabilityException_filterAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','searchQuery'=>'test','page'=>'1']);#page optional
		// $availabilityExceptionArray=$sdk->availabilityException_list(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO']);
		// $availabilityExceptionArray=$sdk->availabilityException_listAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO']);
		// $data=['name'=>'Ausnahme Test edited'];
		// $sdk->availabilityException_edit(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','availabilityExceptionId'=>'acmi17HCCrpJ5krwIKMtdlMLauIMUcdR'],$data);
		// $availabilityExceptionArray=$sdk->availabilityException_appointmentTemplate_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'ea5viEwqzcz55RGwF6vR8U9UywkW6m2X','page'=>'1']);
		// $availabilityExceptionArray=$sdk->availabilityException_appointmentTemplate_filter(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'ea5viEwqzcz55RGwF6vR8U9UywkW6m25','searchQuery'=>'test','page'=>'1']);
		// $availabilityExceptionArray=$sdk->availabilityException_appointmentTemplate_list(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'ea5viEwqzcz55RGwF6vR8U9UywkW6m2X']);
		// $availabilityExceptionArray=$sdk->availabilityException_bookingResource_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','bookingResourceId'=>'brDqyrfum3JUiBUni0o70wyeoMiIpRLG','page'=>'1']);
		// $availabilityExceptionArray=$sdk->availabilityException_bookingResource_filter(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','bookingResourceId'=>'brDqyrfum3JUiBUni0o70wyeoMiIpRLG','searchQuery'=>'test','page'=>'1']);
		// $availabilityExceptionArray=$sdk->availabilityException_bookingResource_list(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','bookingResourceId'=>'brDqyrfum3JUiBUni0o70wyeoMiIpRLG']);
		// $sdk->availabilityException_delete(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','availabilityExceptionId'=>'acSyLAlLl4yrfnpJ2xWp9bFnr3w8dF5r'],[]);

		#BOOKINGRESOURCE
		// $bookingResource=$sdk->bookingResource_show(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','bookingResourceId'=>'brOayV9d7lcj5vjeG0Pl1qFuK92v4Uaf']);
		// $bookingResource=$sdk->bookingResource_identify(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customId'=>'dk']);
		// $bookingResourceArray=$sdk->bookingResource_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','page'=>'1']);#page optional
		// $bookingResourceArray=$sdk->bookingResource_indexAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','page'=>'1']);#page optional
		// $bookingResourceArray=$sdk->bookingResource_filter(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','searchQuery'=>'test','page'=>'1']);#page optional
		// $bookingResourceArray=$sdk->bookingResource_filterAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','searchQuery'=>'test','page'=>'1']);#page optional
		// $bookingResourceArray=$sdk->bookingResource_list(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO']);
		// $bookingResourceArray=$sdk->bookingResource_listAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO']);
		//$bookingResourceArray=$sdk->bookingResource_availability_listDay(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','bookingResourceId'=>'brOayV9d7lcj5vjeG0Pl1qFuK92v4Uaf','year'=>'2021','month'=>'9','day'=>'28']);
		//$bookingResourceArray=$sdk->bookingResource_availability_listWeek(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','bookingResourceId'=>'brOayV9d7lcj5vjeG0Pl1qFuK92v4Uaf','year'=>'2021','week'=>'39']);
		//$bookingResourceArray=$sdk->bookingResource_availability_listMonth(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','bookingResourceId'=>'brOayV9d7lcj5vjeG0Pl1qFuK92v4Uaf','year'=>'2021','month'=>'9']);
		#die(BasicLib::debug($bookingResourceArray));


		#BOOKINGSLOT
		// $bookingSlotArray=$sdk->bookingSlot_earliest(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','bookingTemplateId'=>'fcrVx2aWQzDnd1MZkEeVbVDt6wuFCJIL']);
		// $bookingSlotArray=$sdk->bookingSlot_listDay(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','bookingTemplateId'=>'fcrVx2aWQzDnd1MZkEeVbVDt6wuFCJIL','year'=>'2021','month'=>'9','day'=>'30']);
		// $bookingSlotArray=$sdk->bookingSlot_listWeek(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','bookingTemplateId'=>'fcrVx2aWQzDnd1MZkEeVbVDt6wuFCJIL','year'=>'2021','week'=>'39']);
		// $bookingSlotArray=$sdk->bookingSlot_listMonth(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','bookingTemplateId'=>'fcrVx2aWQzDnd1MZkEeVbVDt6wuFCJIL','year'=>'2021','month'=>'9']);

		#BOOKINGTEMPLATE
		// $bookingTemplate=$sdk->bookingTemplate_show(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','bookingTemplateId'=>'fcrVx2aWQzDnd1MZkEeVbVDt6wuFCJIL']);
		// $bookingTemplate=$sdk->bookingTemplate_identify(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customId'=>'666']);
		// $bookingTemplateArray=$sdk->bookingTemplate_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','page'=>'1']);#page optional
		// $bookingTemplateArray=$sdk->bookingTemplate_indexAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','page'=>'1']);#page optional
		// $bookingTemplateArray=$sdk->bookingTemplate_filter(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','searchQuery'=>'test','page'=>'1']);#page optional
		// $bookingTemplateArray=$sdk->bookingTemplate_filterAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','searchQuery'=>'test','page'=>'1']);#page optional
		// $bookingTemplateArray=$sdk->bookingTemplate_list(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO']);
		// $bookingTemplateArray=$sdk->bookingTemplate_listAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO']);
		// $bookingTemplateArray=$sdk->bookingTemplate_bookingResource_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','bookingResourceId'=>'brOayV9d7lcj5vjeG0Pl1qFuK92v4Uaf','page'=>'1']);
		// $bookingTemplateArray=$sdk->bookingTemplate_bookingResource_filter(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','bookingResourceId'=>'brOayV9d7lcj5vjeG0Pl1qFuK92v4Uaf','searchQuery'=>'test','page'=>'1']);
		// $bookingTemplateArray=$sdk->bookingTemplate_bookingResource_list(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','bookingResourceId'=>'brOayV9d7lcj5vjeG0Pl1qFuK92v4Uaf']);

		#CONRACTACCOUNT
		// $data=[
		// 	'tariffId'=>'tFb41cqMdgahwFep4nIlwXSfc1ZuT89B',//Super-Master-Tarif
		// 	'customId'=>'acmeSDK',
		// 	'name'=>'ACME ContractAccountSDK',

		// 	'locale'=>'en',
		// 	'timeZone'=>'Europe/Berlin',

		// 	'admin'=>[
		// 		'gender'=>'MALE',
		// 		'firstName'=>'Max',
		// 		'lastName'=>'Mustermann',
		// 		'email'=>'dk@acme-gmbh.de',
		// 		'mobile'=>'+491701234567',
		// 	],

		// 	'contactPerson'=>[
		// 		'gender'=>'MALE',
		// 		'title'=>'Dr.',
		// 		'firstName'=>'Max',
		// 		'lastName'=>'Mustermann',
		// 		'telephone'=>'040/12345678',
		// 		'email'=>'dk@acme-gmbh.de',
		// 		'mobile'=>'+491701234567',
		// 	],

		// 	'address'=>[
		// 		'name'=>'ACME ContractAccountSDK',
		// 		'street'=>'Masterstreet',
		// 		'extra'=>'',
		// 		'zip'=>'12345',
		// 		'city'=>'Mastertown',
		// 		'country'=>'DE',
		// 	],
		// 	'invoiceEmail'=>'dk@acme-gmbh.de',
		// 	'memberList'=>[],
		// ];
		// $contractAccount=$sdk->contractAccount_add([],$data);

		#CUSTOMENTITY
		// $data=['customId'=>'667','name'=>'CB Testentity'];
		// $customEntity=$sdk->customEntity_add(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customEntityType'=>'rentalCar'],$data);
		// $customEntity=$sdk->customEntity_show(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customEntityType'=>'rentalCar','customEntityId'=>'6TocDgVSBO87tLcxmLCWeuaB8eV8JtY2']);
		// $customEntity=$sdk->customEntity_identify(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customEntityType'=>'rentalCar','customId'=>'666']);
		// $customEntityArray=$sdk->customEntity_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customEntityType'=>'rentalCar','page'=>'2']);#page optional
		// $customEntityArray=$sdk->customEntity_indexAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customEntityType'=>'rentalCar','page'=>'1']);#page optional
		// $customEntityArray=$sdk->customEntity_filter(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customEntityType'=>'rentalCar','searchQuery'=>'test','page'=>'2']);#page optional
		// $customEntityArray=$sdk->customEntity_filterAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customEntityType'=>'rentalCar','searchQuery'=>'test','page'=>'1']);#page optional
		// $customEntityArray=$sdk->customEntity_list(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customEntityType'=>'rentalCar']);
		// $customEntityArray=$sdk->customEntity_listAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customEntityType'=>'rentalCar']);
		// $data=['notes'=>'Test customEntity edited'];
		// $sdk->customEntity_edit(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customEntityId'=>'6TocDgVSBO87tLcxmLCWeuaB8eV8JtY2','customEntityType'=>'rentalCar'],$data);
		// $customEntityArray=$sdk->customEntity_appointment_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentId'=>'eddXX23behodfOJck69hZW1y8dJYbDkX','customEntityType'=>'rentalCar','page'=>'1']);
		// $customEntityArray=$sdk->customEntity_appointment_filter(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentId'=>'eddXX23behodfOJck69hZW1y8dJYbDkX','customEntityType'=>'rentalCar','searchQuery'=>'Testentity','page'=>'1']);
		// $customEntityArray=$sdk->customEntity_appointment_list(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentId'=>'eddXX23behodfOJck69hZW1y8dJYbDkX','customEntityType'=>'rentalCar']);
		// $customEntityArray=$sdk->customEntity_appointment_link(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentId'=>'eddXX23behodfOJck69hZW1y8dJYbDkX','customEntityType'=>'rentalCar','customEntityId'=>'6TW0kOIdHlZh0EzwtWODyMatn7fU3Aox']);
		// $customEntityArray=$sdk->customEntity_appointment_unlink(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentId'=>'eddXX23behodfOJck69hZW1y8dJYbDkX','customEntityType'=>'rentalCar','customEntityId'=>'6TW0kOIdHlZh0EzwtWODyMatn7fU3Aox']);
		// $customEntityArray=$sdk->customEntity_appointmentTemplate_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'ea5viEwqzcz55RGwF6vR8U9UywkW6m2X','customEntityType'=>'rentalCar','page'=>'1']);
		// $customEntityArray=$sdk->customEntity_appointmentTemplate_filter(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'ea5viEwqzcz55RGwF6vR8U9UywkW6m2X','customEntityType'=>'rentalCar','searchQuery'=>'test','page'=>'2']);
		// $customEntityArray=$sdk->customEntity_appointmentTemplate_list(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'ea5viEwqzcz55RGwF6vR8U9UywkW6m2X','customEntityType'=>'rentalCar']);
		// $customEntityArray=$sdk->customEntity_appointmentTemplate_link(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'ea5viEwqzcz55RGwF6vR8U9UywkW6m2X','customEntityType'=>'rentalCar','customEntityId'=>'6TW0kOIdHlZh0EzwtWODyMatn7fU3Aox']);
		// $customEntityArray=$sdk->customEntity_appointmentTemplate_unlink(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','appointmentTemplateId'=>'ea5viEwqzcz55RGwF6vR8U9UywkW6m2X','customEntityType'=>'rentalCar','customEntityId'=>'6TW0kOIdHlZh0EzwtWODyMatn7fU3Aox']);
		// $customEntityArray=$sdk->customEntity_bookingResource_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','bookingResourceId'=>'brDqyrfum3JUiBUni0o70wyeoMiIpRLG','customEntityType'=>'rentalCar','page'=>'1']);
		// $customEntityArray=$sdk->customEntity_bookingResource_filter(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','bookingResourceId'=>'brDqyrfum3JUiBUni0o70wyeoMiIpRLG','customEntityType'=>'rentalCar','searchQuery'=>'test','page'=>'2']);
		// $customEntityArray=$sdk->customEntity_bookingResource_list(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','bookingResourceId'=>'brDqyrfum3JUiBUni0o70wyeoMiIpRLG','customEntityType'=>'rentalCar']);
		// $customEntityArray=$sdk->customEntity_bookingResource_link(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','bookingResourceId'=>'brDqyrfum3JUiBUni0o70wyeoMiIpRLG','customEntityType'=>'rentalCar','customEntityId'=>'6TW0kOIdHlZh0EzwtWODyMatn7fU3Aox']);
		// $customEntityArray=$sdk->customEntity_bookingResource_unlink(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','bookingResourceId'=>'brDqyrfum3JUiBUni0o70wyeoMiIpRLG','customEntityType'=>'rentalCar','customEntityId'=>'6TW0kOIdHlZh0EzwtWODyMatn7fU3Aox']);
		// $customEntityArray=$sdk->customEntity_bookingTemplate_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','bookingTemplateId'=>'fcrVx2aWQzDnd1MZkEeVbVDt6wuFCJIL','customEntityType'=>'rentalCar','page'=>'1']);
		// $customEntityArray=$sdk->customEntity_bookingTemplate_filter(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','bookingTemplateId'=>'fcrVx2aWQzDnd1MZkEeVbVDt6wuFCJIL','customEntityType'=>'rentalCar','searchQuery'=>'test','page'=>'2']);
		// $customEntityArray=$sdk->customEntity_bookingTemplate_list(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','bookingTemplateId'=>'fcrVx2aWQzDnd1MZkEeVbVDt6wuFCJIL','customEntityType'=>'rentalCar']);
		// $customEntityArray=$sdk->customEntity_bookingTemplate_link(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','bookingTemplateId'=>'fcrVx2aWQzDnd1MZkEeVbVDt6wuFCJIL','customEntityType'=>'rentalCar','customEntityId'=>'6TW0kOIdHlZh0EzwtWODyMatn7fU3Aox']);
		// $customEntityArray=$sdk->customEntity_bookingTemplate_unlink(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','bookingTemplateId'=>'fcrVx2aWQzDnd1MZkEeVbVDt6wuFCJIL','customEntityType'=>'rentalCar','customEntityId'=>'6TW0kOIdHlZh0EzwtWODyMatn7fU3Aox']);
		// $customEntityArray=$sdk->customEntity_customEntity_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customEntityId'=>'6TW0kOIdHlZh0EzwtWODyMatn7fU3Aox','customEntityType'=>'rentalCar','page'=>'1']);
		// $customEntityArray=$sdk->customEntity_customEntity_filter(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customEntityId'=>'6TW0kOIdHlZh0EzwtWODyMatn7fU3Aox','customEntityType'=>'rentalCar','searchQuery'=>'test','page'=>'2']);
		// $customEntityArray=$sdk->customEntity_customEntity_list(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customEntityId'=>'6TW0kOIdHlZh0EzwtWODyMatn7fU3Aox','customEntityType'=>'rentalCar']);
		// $customEntityArray=$sdk->customEntity_customEntity_link(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customEntityId'=>'6TW0kOIdHlZh0EzwtWODyMatn7fU3Aox','customEntityType'=>'rentalCar','customEntityRelatedId'=>'6TW0kOIdHlZh0EzwtWODyMatn7fU3Aox']);
		// $customEntityArray=$sdk->customEntity_customEntity_unlink(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customEntityId'=>'6TW0kOIdHlZh0EzwtWODyMatn7fU3Aox','customEntityType'=>'rentalCar','customEntityRelatedId'=>'6TW0kOIdHlZh0EzwtWODyMatn7fU3Aox']);
		// $customEntityArray=$sdk->customEntity_customer_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customerId'=>'d3k1qW5uf3pInMnanVLzRABG1H6XOGHC','customEntityType'=>'rentalCar','page'=>'1']);
		// $customEntityArray=$sdk->customEntity_customer_filter(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customerId'=>'d3k1qW5uf3pInMnanVLzRABG1H6XOGHC','customEntityType'=>'rentalCar','searchQuery'=>'test','page'=>'2']);
		// $customEntityArray=$sdk->customEntity_customer_list(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customerId'=>'d3k1qW5uf3pInMnanVLzRABG1H6XOGHC','customEntityType'=>'rentalCar']);
		// $customEntityArray=$sdk->customEntity_customer_link(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customerId'=>'d3k1qW5uf3pInMnanVLzRABG1H6XOGHC','customEntityType'=>'rentalCar','customEntityId'=>'6TW0kOIdHlZh0EzwtWODyMatn7fU3Aox']);
		// $customEntityArray=$sdk->customEntity_customer_unlink(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customerId'=>'d3k1qW5uf3pInMnanVLzRABG1H6XOGHC','customEntityType'=>'rentalCar','customEntityId'=>'6TW0kOIdHlZh0EzwtWODyMatn7fU3Aox']);
		// $customEntityArray=$sdk->customEntity_employee_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','employeeId'=>'EhJrjoTXZwwvZ4VI7vUKFvZoWpV0OYr3','customEntityType'=>'rentalCar','page'=>'1']);
		// $customEntityArray=$sdk->customEntity_employee_filter(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','employeeId'=>'EhJrjoTXZwwvZ4VI7vUKFvZoWpV0OYr3','customEntityType'=>'rentalCar','searchQuery'=>'test','page'=>'2']);
		// $customEntityArray=$sdk->customEntity_employee_list(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','employeeId'=>'EhJrjoTXZwwvZ4VI7vUKFvZoWpV0OYr3','customEntityType'=>'rentalCar']);
		// $customEntityArray=$sdk->customEntity_employee_link(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','employeeId'=>'EhJrjoTXZwwvZ4VI7vUKFvZoWpV0OYr3','customEntityType'=>'rentalCar','customEntityId'=>'6TW0kOIdHlZh0EzwtWODyMatn7fU3Aox']);
		// $customEntityArray=$sdk->customEntity_employee_unlink(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','employeeId'=>'EhJrjoTXZwwvZ4VI7vUKFvZoWpV0OYr3','customEntityType'=>'rentalCar','customEntityId'=>'6TW0kOIdHlZh0EzwtWODyMatn7fU3Aox']);
		// $customEntityArray=$sdk->customEntity_resource_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','resourceId'=>'73VXNMJ2LbvoHagLfAgXrwbyGODh8Txt','customEntityType'=>'rentalCar','page'=>'1']);
		// $customEntityArray=$sdk->customEntity_resource_filter(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','resourceId'=>'73VXNMJ2LbvoHagLfAgXrwbyGODh8Txt','customEntityType'=>'rentalCar','searchQuery'=>'test','page'=>'2']);
		// $customEntityArray=$sdk->customEntity_resource_list(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','resourceId'=>'73VXNMJ2LbvoHagLfAgXrwbyGODh8Txt','customEntityType'=>'rentalCar']);
		// $customEntityArray=$sdk->customEntity_resource_link(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','resourceId'=>'73VXNMJ2LbvoHagLfAgXrwbyGODh8Txt','customEntityType'=>'rentalCar','customEntityId'=>'6TW0kOIdHlZh0EzwtWODyMatn7fU3Aox']);
		// $customEntityArray=$sdk->customEntity_resource_unlink(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','resourceId'=>'73VXNMJ2LbvoHagLfAgXrwbyGODh8Txt','customEntityType'=>'rentalCar','customEntityId'=>'6TW0kOIdHlZh0EzwtWODyMatn7fU3Aox']);
		// $sdk->customEntity_delete(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customEntityId'=>'6TTpMLUAUyTXKXQiETIMnY9PiuOMuVQo','customEntityType'=>'rentalCar']);

		#CUSTOMER
		// $data=[
		// 	'firstName'=>'Kunde',
		// 	'lastName'=>'van Test',
		// 	'gender'=>'FEMALE',
		// 	'email'=>'support@bookingtime.com',
		// 	'locale'=>'de',
		// ];
		// $customer=$sdk->customer_add(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO'],$data);
		// $customer=$sdk->customer_show(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customerId'=>'d3k1qW5uf3pInMnanVLzRABG1H6XOGHC']);
		// $customer=$sdk->customer_identify(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customId'=>'666']);
		// $customer=$sdk->customer_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','page'=>'1']);#page optional
		// $customer=$sdk->customer_indexAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','page'=>'1']);#page optional
		// $customer=$sdk->customer_filter(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','searchQuery'=>'test','page'=>'1']);#page optional
		// $customer=$sdk->customer_filterAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','searchQuery'=>'test','page'=>'1']);#page optional
		// $customer=$sdk->customer_list(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO']);
		// $customer=$sdk->customer_listAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO']);
		// $data=['notes'=>'test edit'];
		// $sdk->customer_edit(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customerId'=>'EhJrjoTXZwwvZ4VI7vUKFvZoWpV0OYr3'],$data);
		// $sdk->customer_customerGroup_link(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customerId'=>'d3k1qW5uf3pInMnanVLzRABG1H6XOGHC','customerGroupId'=>'7bKBQIlSbTR2JjETXRcVa3GSe02c7pyT']);
		// $sdk->customer_customerGroup_unlink(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customerId'=>'d3k1qW5uf3pInMnanVLzRABG1H6XOGHC','customerGroupId'=>'7bKBQIlSbTR2JjETXRcVa3GSe02c7pyT']);
		// $sdk->customer_delete(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customerId'=>'d3k1qW5uf3pInMnanVLzRABG1H6XOGHC']);

		#CUSTOMERGROUP
		// $data=[
		// 	'name'=>'Kundengruppe Test',
		// 	'customId'=>'1563',
		// ];
		// $customerGroup=$sdk->customerGroup_add(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO'],$data);
		// $customerGroup=$sdk->customerGroup_show(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customerGroupId'=>'7bz0gEKEarkwI4QbJFMwHNP1GUf1JAJE']);
		// $customerGroup=$sdk->customerGroup_identify(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customId'=>'1563']);
		// $customerGroupArray=$sdk->customerGroup_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','page'=>'1']);#page optional
		// $customerGroupArray=$sdk->customerGroup_indexAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','page'=>'1']);#page optional
		// $customerGroupArray=$sdk->customerGroup_filter(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','searchQuery'=>'test','page'=>'1']);#page optional
		// $customerGroupArray=$sdk->customerGroup_filterAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','searchQuery'=>'test','page'=>'1']);#page optional
		// $customerGroupArray=$sdk->customerGroup_list(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO']);
		// $customerGroupArray=$sdk->customerGroup_listAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO']);
		// $data=['name'=>'Kundengruppe Test edited'];
		// $sdk->customerGroup_edit(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customerGroupId'=>'7bz0gEKEarkwI4QbJFMwHNP1GUf1JAJE'],$data);
		// $sdk->customerGroup_delete(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customerGroupId'=>'7bz0gEKEarkwI4QbJFMwHNP1GUf1JAJE'],[]);

		#EMAIL
		// $email=$sdk->email_show(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','emailId'=>'5drDGqAlPUnpEhagDLsELmIPueATDyrJ']);
		// $emailArray=$sdk->email_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','page'=>'1']);#page optional
		// $emailArray=$sdk->email_indexAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','page'=>'1']);#page optional
		// $emailArray=$sdk->email_filter(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','searchQuery'=>'test','page'=>'1']);#page optional
		// $emailArray=$sdk->email_filterAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','searchQuery'=>'test','page'=>'1']);#page optional
		// $emailArray=$sdk->email_list(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO']);
		// $emailArray=$sdk->email_listAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO']);
		// $email=$sdk->email_resend(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','emailId'=>'5dk7SaAbJA2QUmkIKtjR0Dpa5J98D2dG']);
		// $emailArray=$sdk->email_customer_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customerId'=>'d3k1qW5uf3pInMnanVLzRABG1H6XOGHC','page'=>'1']);#page optional
		// $emailArray=$sdk->email_customer_filter(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customerId'=>'d3k1qW5uf3pInMnanVLzRABG1H6XOGHC','searchQuery'=>'test','page'=>'1']);#page optional
		// $emailArray=$sdk->email_customer_list(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customerId'=>'d3k1qW5uf3pInMnanVLzRABG1H6XOGHC']);

		#EMAILTEMPLATE
		// $data=[
		// 	'name'=>'EmailTemplate Test',
		// 	'active'=>true,
		// 	'event'=>'APPOINTMENT_ADD',
		// 	'subject'=>'Hello hello',
		// 	'subjectI18nList'=>[],
		// 	'bodyPlain'=>'Juten Tach',
		// 	'bodyPlainI18nList'=>[['key'=>'en','value'=>'good day']],
		// 	'bodyHtml'=>'Juten Tach',
		// 	'bodyHtmlI18nList'=>[['key'=>'en','value'=>'good day']],
		// 	'externalCalendarContentCustomer'=>['value'=>'[ORGANIZATION]','inheritance'=>'OFF'],
		// 	'externalCalendarContentCustomerI18nList'=>['value'=>[['key'=>'en','value'=>'[ORGANIZATION]']],'inheritance'=>'OFF'],
		// ];
		// $emailTemplate=$sdk->emailTemplate_add(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO'],$data);
		// $emailTemplate=$sdk->emailTemplate_show(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','emailTemplateId'=>'46qZYdCmXu4uxuY1e8g7csIO74EnJr05']);
		// $emailTemplate=$sdk->emailTemplate_identify(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customId'=>'1234']);
		// $emailTemplateArray=$sdk->emailTemplate_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','page'=>'1']);#page optional
		// $emailTemplateArray=$sdk->emailTemplate_indexAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','page'=>'1']);#page optional
		// $emailTemplateArray=$sdk->emailTemplate_filter(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','searchQuery'=>'test','page'=>'1']);#page optional
		// $emailTemplateArray=$sdk->emailTemplate_filterAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','searchQuery'=>'test','page'=>'1']);#page optional
		// $emailTemplateArray=$sdk->emailTemplate_list(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO']);
		// $emailTemplateArray=$sdk->emailTemplate_listAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO']);
		// $data=['name'=>'EmailTemplate Test edited'];
		// $sdk->emailTemplate_edit(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','emailTemplateId'=>'46qZYdCmXu4uxuY1e8g7csIO74EnJr05'],$data);
		// $sdk->emailTemplate_delete(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','emailTemplateId'=>'46qZYdCmXu4uxuY1e8g7csIO74EnJr05'],[]);

		#EMPLOYEE
		// $data=[
		// 	'firstName'=>'CB',
		// 	'lastName'=>'van Test',
		// 	'gender'=>'MALE',
		// 	'email'=>'support@bookingtime.com',
		// 	'description'=>['value'=>'Das ist ein Mitarbeiter','inheritance'=>'OFF'],
		// 	'descriptionI18nList'=>['value'=>[['key'=>'en','value'=>'This is an employee']],'inheritance'=>'OFF'],
		// ];
		// $employee=$sdk->employee_add(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO'],$data);
		// $employee=$sdk->employee_show(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','employeeId'=>'EhbLpHdJczWhtVPC9QMzoQZZd66VBsSq']);
		// $employee=$sdk->employee_identify(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customId'=>'dk']);
		// $employeeArrayemployee=$sdk->employee_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','page'=>'1']);#page optional
		// $employeeArrayemployee=$sdk->employee_indexAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','page'=>'1']);#page optional
		// $employeeArrayemployee=$sdk->employee_filter(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','searchQuery'=>'test','page'=>'1']);#page optional
		// $employeeArrayemployee=$sdk->employee_filterAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','searchQuery'=>'test','page'=>'1']);#page optional
		// $employeeArrayemployee=$sdk->employee_list(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO']);
		// $employeeArrayemployee=$sdk->employee_listAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO']);
		// $employeeArrayemployee=$sdk->employee_permission(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','employeeId'=>'EhbLpHdJczWhtVPC9QMzoQZZd66VBsSq']);
		// $data=['notes'=>'test edit'];
		// $employee=$sdk->employee_edit(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','employeeId'=>'EhJrjoTXZwwvZ4VI7vUKFvZoWpV0OYr3'],$data);
		// $employee=$sdk->employee_employeeGroup_link(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','employeeId'=>'EhbLpHdJczWhtVPC9QMzoQZZd66VBsSq','employeeGroupId'=>'jsOejOwIwUmT59SGrKC770A9GmTs0ej7']);
		// $employee=$sdk->employee_employeeGroup_unlink(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','employeeId'=>'EhbLpHdJczWhtVPC9QMzoQZZd66VBsSq','employeeGroupId'=>'jsOejOwIwUmT59SGrKC770A9GmTs0ej7']);
		#$employee=$sdk->employee_availability_listDay(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','employeeId'=>'EhJrjoTXZwwvZ4VI7vUKFvZoWpV0OYr3','year'=>'2021','month'=>'1','day'=>'30']);
		// $employee=$sdk->employee_availability_listWeek(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','employeeId'=>'EhbLpHdJczWhtVPC9QMzoQZZd66VBsSq','year'=>'2021','week'=>'41']);
		#$employee=$sdk->employee_availability_listMonth(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','employeeId'=>'EhJrjoTXZwwvZ4VI7vUKFvZoWpV0OYr3','year'=>'2021','month'=>'1']);
		// $data=['rangeStart'=>'2021-11-11T12:00:00+02:00','rangeEnd'=>'2021-11-19T19:00:00+02:00','availability'=>[['start'=>'2021-11-11T12:00:00+02:00','end'=>'2021-11-11T12:30:00+02:00']]];
		// $employee=$sdk->employee_availability_edit(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','employeeId'=>'EhbLpHdJczWhtVPC9QMzoQZZd66VBsSq'],$data);
		// $sdk->employee_delete(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','employeeId'=>'EhbLpHdJczWhtVPC9QMzoQZZd66VBsSq']);
		#die(BasicLib::debug($employee));

		#EMPLOYEEGROUP
		// $data=[
		// 	'name'=>'CB Mitarbeitergruppe Test',
		// 	'customId'=>'Test123',
		// ];
		// $employeeGroup=$sdk->employeeGroup_add(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO'],$data);
		// $employeeGroup=$sdk->employeeGroup_show(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','employeeGroupId'=>'js96DZ0coJaHPN5OPOs9LExDhwUsAGrH']);
		// $employeeGroup=$sdk->employeeGroup_identify(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customId'=>'Test123']);
		// $employeeGroup=$sdk->employeeGroup_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','page'=>'1']);#page optional
		// $employeeGroup=$sdk->employeeGroup_indexAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','page'=>'1']);#page optional
		// $employeeGroup=$sdk->employeeGroup_filter(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','searchQuery'=>'test','page'=>'1']);#page optional
		// $employeeGroup=$sdk->employeeGroup_filterAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','searchQuery'=>'test','page'=>'1']);#page optional
		// $employeeGroup=$sdk->employeeGroup_list(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO']);
		// $employeeGroup=$sdk->employeeGroup_listAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO']);
		// $data=['name'=>'CB Mitarbeitergruppe Test edited'];
		// $sdk->employeeGroup_edit(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','employeeGroupId'=>'js96DZ0coJaHPN5OPOs9LExDhwUsAGrH'],$data);
		// $sdk->employeeGroup_appConfig_link(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','employeeGroupId'=>'jsJoeXxMm8Vdez6xmjifrGM1eYwmumTV','appConfigId'=>'c3DfkPErdv7zgyb0nWn2iwJCPgF4kKMD']);
		// $sdk->employeeGroup_appConfig_unlink(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','employeeGroupId'=>'jsJoeXxMm8Vdez6xmjifrGM1eYwmumTV','appConfigId'=>'c3DfkPErdv7zgyb0nWn2iwJCPgF4kKMD']);
		// $sdk->employeeGroup_delete(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','employeeGroupId'=>'js96DZ0coJaHPN5OPOs9LExDhwUsAGrH']);

		#FILE
		// $fileData=file_get_contents(__DIR__.'/fileTest.txt');
		// $data=[
		// 	'name'=>'testDatei2',
		// 	'fileName'=>'testDatei2',
		// 	'fileContent'=>base64_encode($fileData),
		// 	'customId'=>'1234',
		// ];
		// $file=$sdk->file_add(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO'],$data);
		// $file=$sdk->file_show(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','fileId'=>'w1yIp9h4JNkd65zb2ElWg4w7ZZh7Zhz5']);
		// $file=$sdk->file_download(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','fileId'=>'w1yIp9h4JNkd65zb2ElWg4w7ZZh7Zhz5']);
		// $file=$sdk->file_identify(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customId'=>'123']);
		// $fileArray=$sdk->file_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','page'=>'2']);#page optional
		// $fileArray=$sdk->file_indexAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','page'=>'1']);#page optional
		// $fileArray=$sdk->file_filter(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','searchQuery'=>'test','page'=>'2']);#page optional
		// $fileArray=$sdk->file_filterAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','searchQuery'=>'test','page'=>'1']);#page optional
		// $fileArray=$sdk->file_list(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO']);
		// $fileArray=$sdk->file_listAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO']);
		// $data=['name'=>'Test file edited'];
		// $sdk->file_edit(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','fileId'=>'w1yIp9h4JNkd65zb2ElWg4w7ZZh7Zhz5'],$data);
		// $sdk->file_delete(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','fileId'=>'w1yIp9h4JNkd65zb2ElWg4w7ZZh7Zhz5']);
		// $fileArray=$sdk->file_customEntity_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customEntityId'=>'6TW0kOIdHlZh0EzwtWODyMatn7fU3Aox','customEntityType'=>'rentalCar','page'=>'1']);
		// $fileArray=$sdk->file_customEntity_filter(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customEntityId'=>'6TW0kOIdHlZh0EzwtWODyMatn7fU3Aox','customEntityType'=>'rentalCar','searchQuery'=>'test','page'=>'2']);
		// $fileArray=$sdk->file_customEntity_list(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customEntityId'=>'6TW0kOIdHlZh0EzwtWODyMatn7fU3Aox','customEntityType'=>'rentalCar']);
		// $fileArray=$sdk->file_customer_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customerId'=>'d3k1qW5uf3pInMnanVLzRABG1H6XOGHC','page'=>'1']);
		// $fileArray=$sdk->file_customer_filter(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customerId'=>'d3k1qW5uf3pInMnanVLzRABG1H6XOGHC','searchQuery'=>'test','page'=>'2']);
		// $fileArray=$sdk->file_customer_list(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customerId'=>'d3k1qW5uf3pInMnanVLzRABG1H6XOGHC']);

		#IMAGE
		// $imageData=file_get_contents(__DIR__.'/pelican.jpg');
		// $data=[
		// 	'fileName'=>'testImage',
		// 	'fileContent'=>base64_encode($imageData),
		// ];
		// $image=$sdk->image_add(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO'],$data);

		#LICENSECONFIG
		// $data=[
		// 	'licenseId'=>'1la298iUsMQ3duvnVuUJvwJ15gSS7qY9',
		// 	'validationPeriodRenew'=>TRUE,
		// ];
		// $licenseConfig=$sdk->licenseConfig_add(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs'],$data);
		// $licenseConfig=$sdk->licenseConfig_show(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','licenseConfigId'=>'lCBqRTpruviK7l8X9w1vuVCjJx6puwST']);
		// $licenseConfig=$sdk->licenseConfig_identify(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','customId'=>'test']);
		// $licenseConfigArray=$sdk->licenseConfig_index(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','page'=>'2']);#page optional
		// $licenseConfigArray=$sdk->licenseConfig_indexAll(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','page'=>'1']);#page optional
		// $licenseConfigArray=$sdk->licenseConfig_filter(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','searchQuery'=>'test','page'=>'2']);#page optional
		// $licenseConfigArray=$sdk->licenseConfig_filterAll(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','searchQuery'=>'test','page'=>'1']);#page optional
		// $licenseConfigArray=$sdk->licenseConfig_list(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs']);
		// $licenseConfigArray=$sdk->licenseConfig_listAll(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs']);
		// $data=[
		//  	'licenseId'=>'1la298iUsMQ3duvnVuUJvwJ15gSS7qY9',
		// 	'validationPeriodRenew'=>FALSE,
		// ];
		// $licenseConfig=$sdk->licenseConfig_edit(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','licenseConfigId'=>'lCBqRTpruviK7l8X9w1vuVCjJx6puwST'],$data);
		// $licenseConfig=$sdk->licenseConfig_delete(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','licenseConfigId'=>'lCBqRTpruviK7l8X9w1vuVCjJx6puwST']);


		#LICENSE
		// $license=$sdk->license_show(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','licenseId'=>'1la298iUsMQ3duvnVuUJvwJ15gSS7qY9']);
		// $licenseArray=$sdk->license_index(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','page'=>'1']);#page optional
		// $licenseArray=$sdk->license_filter(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','searchQuery'=>'test','page'=>'1']);#page optional
		// $licenseArray=$sdk->license_list(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs',]);

		#LOG
		// $log=$sdk->log_show(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','logId'=>'348u6JCa8vfYhdqAIh7zxJdGk4O9UwrI']);
		// $log=$sdk->log_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','page'=>'1']);#page optional
		// $log=$sdk->log_filter(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','searchQuery'=>'test','page'=>'1']);#page optional

		#MODULECONFIG
		// $data=[
		// 	'moduleId'=>'23wJv4LyFBK5eGGiyIkDFb9uaVPdr5Vm',
		// 	'developerAccountId'=>'dA2n8tV5XPnvxT7m7usPWCa8wjlhTgFF',
		// 	'settingList'=>[
		// 		['key'=>'moduleSetting1_checkbox','value'=>'true'],
		// 		['key'=>'moduleSetting2_input','value'=>'hallo'],
		// 		['key'=>'moduleSetting3_textArea','value'=>'test'],
		// 		['key'=>'moduleSetting4_date','value'=>'2021-09-28'],
		// 		['key'=>'moduleSetting5_time','value'=>'09:33:00'],
		// 		['key'=>'moduleSetting6_dateTime','value'=>'2021-09-29T12:00:00+01:00'],
		// 		['key'=>'moduleSetting7_color','value'=>'#ffcc00'],
		// 		['key'=>'moduleSetting9_email','value'=>'testtest@bookingtime.com'],
		// 		['key'=>'moduleSetting10_mobile','value'=>'+4917012345678'],
		// 		['key'=>'moduleSetting11_url','value'=>'http://wwwmusterfirma.de'],
		// 		['key'=>'moduleSetting12_number','value'=>'123456'],
		// 		['key'=>'moduleSetting13_alpha','value'=>'abcdefghijkm'],
		// 		['key'=>'moduleSetting14_alphaNum','value'=>'abcdefghijkm123456'],
		// 		['key'=>'moduleSetting15_digit','value'=>'123456'],
		// 		['key'=>'moduleSetting16_hex','value'=>'abc123456789123456'],
		// 	],
		// ];
		// $moduleConfig=$sdk->moduleConfig_add(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs'],$data);
		// $moduleConfig=$sdk->moduleConfig_show(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','moduleConfigId'=>'5fc5FGM96G1UncqO2HBsZxeoDvSC8jKH']);
		// $moduleConfig=$sdk->moduleConfig_identify(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customId'=>'666']);
		// $moduleConfigArray=$sdk->moduleConfig_index(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','page'=>'2']);#page optional
		// $moduleConfigArray=$sdk->moduleConfig_indexAll(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','page'=>'1']);#page optional
		// $moduleConfigArray=$sdk->moduleConfig_filter(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','searchQuery'=>'test','page'=>'2']);#page optional
		// $moduleConfigArray=$sdk->moduleConfig_filterAll(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','searchQuery'=>'test','page'=>'1']);#page optional
		// $moduleConfigArray=$sdk->moduleConfig_list(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs']);
		// $moduleConfigArray=$sdk->moduleConfig_listAll(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs']);
		// $data=['name'=>'Test Module edited2'];
		// $sdk->moduleConfig_edit(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','moduleConfigId'=>'5fc5FGM96G1UncqO2HBsZxeoDvSC8jKH'],$data);
		// $sdk->moduleConfig_appointmentTemplate_link(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','moduleConfigId'=>'5f5ueoQSsb1P2liAVtuRuIpJn1lHSz6R','appointmentTemplateId'=>'eaURedwhApwgw5YAe3kNBPiDsUKJxS3P']);
		// $sdk->moduleConfig_appointmentTemplate_unlink(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','moduleConfigId'=>'5f5ueoQSsb1P2liAVtuRuIpJn1lHSz6R','appointmentTemplateId'=>'eaURedwhApwgw5YAe3kNBPiDsUKJxS3P']);
		// $sdk->moduleConfig_delete(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','moduleConfigId'=>'5fc5FGM96G1UncqO2HBsZxeoDvSC8jKH']);

		#MODULESTORE
		// $module=$sdk->module_show(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','moduleId'=>'23wJv4LyFBK5eGGiyIkDFb9uaVPdr5Vm']);
		// $moduleArray=$sdk->module_index(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','page'=>'1']);#page optional
		// $moduleArray=$sdk->module_filter(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','searchQuery'=>'test','page'=>'1']);#page optional
		// $moduleArray=$sdk->module_list(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs',]);

		#ONLINEMEETINGCONNECTION
		#$data=[
		#	'type'=>'TEAMS',
		#	'email'=>'c.scheerer@bookingtime.com',
		#	'bookingResourceId'=>'broOMpalIzPaMjHdDC5qh6p2uhHnZmyR',
		#	'customId'=>'777',
		#];
		#$onlineMeetingConnection=$sdk->onlineMeetingConnection_add(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO'],$data);
		#$onlineMeetingConnection=$sdk->onlineMeetingConnection_show(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','onlineMeetingConnectionId'=>'bKyZyFkGSfP17brc8PloH4bxTMz3cxdq']);
		#$onlineMeetingConnection=$sdk->onlineMeetingConnection_identify(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customId'=>'777']);
		#$onlineMeetingConnectionArray=$sdk->onlineMeetingConnection_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','page'=>'1']);#page optional
		#$onlineMeetingConnectionArray=$sdk->onlineMeetingConnection_indexAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','page'=>'1']);#page optional
		#$onlineMeetingConnectionArray=$sdk->onlineMeetingConnection_filter(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','searchQuery'=>'test','page'=>'1']);#page optional
		#$onlineMeetingConnectionArray=$sdk->onlineMeetingConnection_filterAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','searchQuery'=>'test','page'=>'1']);#page optional
		#$onlineMeetingConnectionArray=$sdk->onlineMeetingConnection_list(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO']);
		#$onlineMeetingConnectionArray=$sdk->onlineMeetingConnection_listAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO']);
		#$data=['email'=>'c.scheerer3@bookingtime.com'];
		#$onlineMeetingConnection=$sdk->onlineMeetingConnection_edit(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','onlineMeetingConnectionId'=>'bKyZyFkGSfP17brc8PloH4bxTMz3cxdq'],$data);
		#$sdk->onlineMeetingConnection_delete(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','onlineMeetingConnectionId'=>'bKyZyFkGSfP17brc8PloH4bxTMz3cxdq']);

		#ONLINEMEETINGCONNECTIONLOG
		#$onlineMeetingConnectionLog=$sdk->onlineMeetingConnectionLog_show(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','onlineMeetingConnectionId'=>'bKyZyFkGSfP17brc8PloH4bxTMz3cxdq','onlineMeetingConnectionLogId'=>'v6mK11ChX4iw9l47nihdumFW7uIZcUH3']);
		#$onlineMeetingConnectionLogArray=$sdk->onlineMeetingConnectionLog_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','onlineMeetingConnectionId'=>'bKyZyFkGSfP17brc8PloH4bxTMz3cxdq','page'=>'1']);#page optional
		#die(BasicLib::debug($onlineMeetingConnectionLogArray));

		#ORGANIZATION
		// $data=[
		// 	'customId'=>'sdkTest',
		// 	'contractAccountId'=>'c4UkxIuuVYSaE3KBrAh1YpCS26zXa5Xj',
		// 	'name'=>'SDK GmbH - Mutterkonzern',
		// 	'notes'=>'Die grosse SDK Konzernmutter',
		// 	'address'=>[
		// 		'name'=>'Firma ACME GmbH Zentrale',
		// 		'extra'=>'',
		// 		'street'=>'Musterstraße 1',
		// 		'zip'=>'12345',
		// 		'city'=>'Bonn',
		// 		'country'=>'DE',
		// 	],
		// 	'email'=>'max@mustermann.de',
		// 	'description'=>'Die erste Firma aus dem SDK...',
		// 	'descriptionI18nList'=>[['key'=>'en','value'=>'First organization from sdk...']],
		// 	'contactPerson'=>[
		// 		'firstName'=>'Cathrin',
		// 		'lastName'=>'B',
		// 		'email'=>'max@mustermann.de',
		// 	],
		// 	'admin'=>[
		// 		'firstName'=>'Cathrin',
		// 		'lastName'=>'B',
		// 		'email'=>'max@mustermann.de',
		// 	],
		// 	'sector'=>'01ab',
		// 	'appIdList'=>['70W51gn5nFzzw8GQTDLh36rs52ZxhFYb','70oMsaa3PHiQ5xW6wL48zR2fjBpTvewq','70vkDQOF8WbaYGi0jYpcAYhHAJtJYvdv'],//config,customer,employee,calendar
		// 	'moduleIdList'=>[],
		// 	'employeeList'=>[],
		// 	'appointmentTemplateList'=>[],
		// 	'additionalData'=>[],
		// 	'settings'=>[
		// 		'timeZone'=>'Europe/Berlin',
		// 		'currency'=>'EUR',
		// 		'taxRate'=>19,
		// 		'showPrice'=>TRUE,
		// 		'availability'=>[
		// 			['31.12.2019 09:00','31.12.2022 18:00'],
		// 		],
		// 		'emailReply'=>'hamburg@acme-gmbh.de',
		// 		'smsSender'=>'ACMEMutter',
		// 		'locale'=>'de_DE',
		// 		'availability'=>'CUSTOM',
		// 		'timeGrid'=>'CUSTOM',
		// 		'moduleBookingDayEarliest'=>0,
		// 		'moduleBookingDayLatest'=>14,
		// 		'moduleBookingLeadTime'=>120,
		// 		'externalCalendarContentCustomer'=>'[ORGANIZATION]',
		// 		'externalCalendarContentCustomerI18nList'=>['value'=>[['key'=>'en','value'=>'[ORGANIZATION]']],'inheritance'=>'OFF'],
		// 		'moduleMultiFactorProtection'=>'EMAIL',
		// 		'customerAddressRequired'=>FALSE,
		// 		'customerEmailRequired'=>FALSE,
		// 		'customerMobileRequired'=>FALSE,
		// 	],
		// ];
		// $organization=$sdk->organization_add([],$data);

		// $data=[
		// 	'name'=>'CB Test Orga New Route',
		// 	'customId'=>'123',
		// 	'appConfig'=>TRUE,
		// 	'moduleConfig'=>TRUE,
		// 	'file'=>TRUE,
		// 	'emailTemplate'=>TRUE,
		// 	'smsTemplate'=>TRUE,
		// 	'employee'=>TRUE,
		// 	'employeeGroup'=>TRUE,
		// 	'resource'=>TRUE,
		// 	'appointmentTemplate'=>TRUE,
		// ];
		// $organization=$sdk->organization_copy(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO'],$data);
		// $organization=$sdk->organization_show(['organizationId'=>'f64byemP9Rip4p3OwQGMSmw9sU11o8Jm']);
		// $data=['name'=>'CB Test Orga edited',];
		// $sdk->organization_edit(['organizationId'=>'f64byemP9Rip4p3OwQGMSmw9sU11o8Jm'],$data);
		// $data=['organizationId'=>'f6BRgjIDurHnDNaWDMEHRHWmABZ8ne5p',];
		// $sdk->organization_move(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO'],$data);
		// $organization=$sdk->organization_app_index(['appId'=>'70B9EOUxfSN0p866nCa2zGVKma3K3wEy','page'=>'1']);#page optional
		// $organization=$sdk->organization_app_filter(['appId'=>'70B9EOUxfSN0p866nCa2zGVKma3K3wEy','searchQuery'=>'test','page'=>'1']);#page optional
		// $organization=$sdk->organization_app_list(['appId'=>'70B9EOUxfSN0p866nCa2zGVKma3K3wEy']);
		// $organization=$sdk->organization_app_tree(['appId'=>'70B9EOUxfSN0p866nCa2zGVKma3K3wEy']);
		#$organization=$sdk->organization_availability_listDay(['organizationId'=>'f6BRgjIDurHnDNaWDMEHRHWmABZ8ne5p','year'=>'2021','month'=>'1','day'=>'30']);
		// $sdk->organization_availability_listWeek(['organizationId'=>'f6BRgjIDurHnDNaWDMEHRHWmABZ8ne5p','year'=>'2021','week'=>'41']);
		#$organization=$sdk->organization_availability_listMonth(['organizationId'=>'f6BRgjIDurHnDNaWDMEHRHWmABZ8ne5p','year'=>'2021','month'=>'1']);
		// $data=['rangeStart'=>'2021-11-11T12:00:00+02:00','rangeEnd'=>'2021-11-19T19:00:00+02:00','availability'=>[['start'=>'2021-11-11T12:00:00+02:00','end'=>'2021-11-11T12:30:00+02:00']]];
		// $sdk->organization_availability_edit(['organizationId'=>'f64byemP9Rip4p3OwQGMSmw9sU11o8Jm'],$data);
		// $sdk->organization_emailTemplate_link(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','emailTemplateId'=>'46a6NWcBgly2Wyl2e5sTXF0joar3KOdV']);
		// $sdk->organization_emailTemplate_unlink(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','emailTemplateId'=>'46a6NWcBgly2Wyl2e5sTXF0joar3KOdV']);
		// $sdk->organization_smsTemplate_link(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','smsTemplateId'=>'6G4qU5lcT3AyZwkRfZtm4eRegr1ma9yl']);
		// $sdk->organization_smsTemplate_unlink(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','smsTemplateId'=>'6G4qU5lcT3AyZwkRfZtm4eRegr1ma9yl']);
		#die(BasicLib::debug($organization));

		// $data=[
		// 	'name'=>'CB Test Orga New Route',
		// 	'customId'=>'123',
		// 	'address'=>[
		// 		'value'=>[
		// 			'name'=>'CB Test Orga',
		// 			'street'=>'Teststraße 1',
		// 			'zip'=>'12345',
		// 			'city'=>'Hamburg',
		// 			'country'=>'DE',
		// 		],
		// 	],
		// 	'email'=>['value'=>'max@mustermann.de'],
		// 	'description'=>['value'=>'Die erste Firma aus dem SDK...'],
		// 	'descriptionI18nList'=>['value'=>[['key'=>'en','value'=>'First organization from sdk...']],'inheritance'=>'OFF'],
		// 	'contactPerson'=>[
		// 		'value'=>[
		// 			'firstName'=>'Cathrin',
		// 			'lastName'=>'B',
		// 			'email'=>'max@mustermann.de',
		// 		],
		// 	],
		// 	'settings'=>[
		// 		'timeZone'=>['value'=>'Europe/Berlin'],
		// 		'emailReply'=>['value'=>'noreply@bookingtime.com'],
		// 		'locale'=>['value'=>'de_DE'],
		// 		'moduleMultiFactorProtection'=>[
		// 			'value'=>'OFF',
		// 			'inheritance'=>'OFF',
		// 		],
		// 		'customerAddressRequired'=>[
		// 			'value'=>FALSE,
		// 			'inheritance'=>'OFF',
		// 		],
		// 		'customerEmailRequired'=>[
		// 			'value'=>FALSE,
		// 			'inheritance'=>'OFF',
		// 		],
		// 		'customerMobileRequired'=>[
		// 			'value'=>FALSE,
		// 			'inheritance'=>'OFF',
		// 		],
		// 	],
		// 	'admin'=>[
		// 		'firstName'=>'Cathrin',
		// 		'lastName'=>'B',
		// 		'email'=>'max@mustermann.de',
		// 	],
		// 	'sector'=>['value'=>'01ab'],
		// 		'appIdList'=>['70W51gn5nFzzw8GQTDLh36rs52ZxhFYb','70oMsaa3PHiQ5xW6wL48zR2fjBpTvewq','70vkDQOF8WbaYGi0jYpcAYhHAJtJYvdv','70r1ysjQ1OBbmgFghr4NQUJqmJuL6sYD'],//config,customer,employee,calendar
		// 		'moduleIdList'=>[],
		// 		'employeeList'=>[],
		// 		'appointmentTemplateList'=>[],
		// ];
		// $organization=$sdk->organization_subOrganization_addRoot(['organizationId'=>'f64byemP9Rip4p3OwQGMSmw9sU11o8Jm'],$data);
		// $data=[
		// 	'name'=>'CB Test Orga',
		// 	'customId'=>'12345',
		// 	'address'=>[
		// 		'value'=>[
		// 			'name'=>'CB Test Orga',
		// 			'street'=>'Teststraße 1',
		// 			'zip'=>'12345',
		// 			'city'=>'Hamburg',
		// 			'country'=>'DE',
		// 		],
		// 	],
		// 	'email'=>['value'=>'max@mustermann.de'],
		// 	'contactPerson'=>[
		// 		'value'=>[
		// 			'firstName'=>'Cathrin',
		// 			'lastName'=>'B',
		// 			'email'=>'max@mustermann.de',
		// 		],
		// 	],
		// 	'settings'=>[
		// 			'timeZone'=>['value'=>'Europe/Berlin'],
		// 			'emailReply'=>['value'=>'noreply@bookingtime.com'],
		// 			'locale'=>['value'=>'de_DE'],
		// 	],
		// 	'sector'=>['value'=>'01ab'],
		// ];
		// $organization=$sdk->organization_subOrganization_addSub(['organizationId'=>'f64byemP9Rip4p3OwQGMSmw9sU11o8Jm'],$data);
		// $organization=$sdk->organization_subOrganization_identify(['organizationId'=>'f64byemP9Rip4p3OwQGMSmw9sU11o8Jm','customId'=>'12345']);
		// $organization=$sdk->organization_subOrganization_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','page'=>'1']);#page optional
		// $organization=$sdk->organization_subOrganization_filter(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','searchQuery'=>'test','page'=>'1']);#page optional
		//$organization=$sdk->organization_subOrganization_list(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO']);
		// $organization=$sdk->organization_subOrganization_tree(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO']);
		// $sdk->organization_timeGrid_listWeek(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','year'=>'2021','week'=>'41']);
		// $data=['rangeStart'=>'2021-11-11T12:00:00+02:00','rangeEnd'=>'2021-11-19T19:00:00+02:00','timeGrid'=>['2021-11-11T12:00:00+02:00','2021-11-11T12:30:00+02:00']];
		// $sdk->organization_timeGrid_edit(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO'],$data);
		// $sdk->organization_delete(['organizationId'=>'f64byemP9Rip4p3OwQGMSmw9sU11o8Jm','organizationId'=>'EhbLpHdJczWhtVPC9QMzoQZZd66VBsSq']);

		#PACKET
		// $packet=$sdk->packet_show(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','packetId'=>'aPqxPQhPwM7nSqJQjLuBXRnidyBn0ccA']);
		// $packetArray=$sdk->packet_index(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','page'=>'1']);#page optional
		// $packetArray=$sdk->packet_filter(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs','searchQuery'=>'test','page'=>'1']);#page optional
		// $packetArray=$sdk->packet_list(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs',]);
		// $packet=$sdk->packet_purchase(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','packetId'=>'aPqxPQhPwM7nSqJQjLuBXRnidyBn0ccA'],$data);

		#RESOURCE
		// $data=[
		// 	'name'=>'Resource Test',
		// 	'nameI18nList'=>[['key'=>'en','value'=>'This is a resource']],
		// 	'type'=>'LOCATION',
		// 	'description'=>'Das ist die Resource Test',
		// 	'descriptionI18nList'=>[['key'=>'en','value'=>'This is a resource']],
		// ];
		// $resource=$sdk->resource_add(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO'],$data);
		// $resource=$sdk->resource_show(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','resourceId'=>'73OwAp1QDyuEYydT197riP0AGhhV6noL']);
		// $resource=$sdk->resource_identify(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customId'=>'696']);
		// $resourceArray=$sdk->resource_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','page'=>'1']);#page optional
		// $resourceArray=$sdk->resource_indexAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','page'=>'1']);#page optional
		// $resourceArray=$sdk->resource_filter(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','searchQuery'=>'test','page'=>'1']);#page optional
		// $resourceArray=$sdk->resource_filterAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','searchQuery'=>'test','page'=>'1']);#page optional
		// $resourceArray=$sdk->resource_list(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO']);
		// $resourceArray=$sdk->resource_listAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO']);
		// $data=['name'=>'Resource Testedited'];
		// $sdk->resource_edit(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','resourceId'=>'73OwAp1QDyuEYydT197riP0AGhhV6noL'],$data);
		#$resource=$sdk->resource_availability_listDay(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','resourceId'=>'73OwAp1QDyuEYydT197riP0AGhhV6noL','year'=>'2021','month'=>'1','day'=>'31']);
		// $sdk->resource_availability_listWeek(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','resourceId'=>'73OwAp1QDyuEYydT197riP0AGhhV6noL','year'=>'2021','week'=>'41']);
		#$resource=$sdk->resource_availability_listMonth(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','resourceId'=>'73OwAp1QDyuEYydT197riP0AGhhV6noL','year'=>'2021','month'=>'1']);
		// $data=['rangeStart'=>'2021-11-11T12:00:00+02:00','rangeEnd'=>'2021-11-19T19:00:00+02:00','availability'=>[['start'=>'2021-11-11T12:00:00+02:00','end'=>'2021-11-11T12:30:00+02:00']]];
		// $sdk->resource_availability_edit(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','resourceId'=>'73OwAp1QDyuEYydT197riP0AGhhV6noL'],$data);
		// $sdk->resource_delete(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','resourceId'=>'73OwAp1QDyuEYydT197riP0AGhhV6noL']);
		#die(BasicLib::debug($resource));

		// #REPORTINGJOB
		// $data=[
		// 	'name'=>'ReportingJob Test',
		// 	'customId'=>'test',
		// 	'category'=>'APPOINTMENT_LIST',
		// 	'sendingInterval'=>'WEEKLY',
		// 	'recipientEmailList'=>['testtest@bookingtime.com'],
		// ];
		// $reportingJob=$sdk->reportingJob_add(['organizationId'=>'f6OB6HtSBX1fgo46p4SigKtsiQwZz4Vs'],$data);
		// $reportingJob=$sdk->reportingJob_show(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','reportingJobId'=>'aYYWUQ7S4u76Fujd8Jr6NylVzqoc0fvo']);
		// $reportingJob=$sdk->reportingJob_identify(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customId'=>'reporting1']);
		// $reportingJobArray=$sdk->reportingJob_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','page'=>'1']);#page optional
		// $reportingJobArray=$sdk->reportingJob_indexAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','page'=>'1']);#page optional
		// $reportingJobArray=$sdk->reportingJob_filter(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','searchQuery'=>'test','page'=>'1']);#page optional
		// $reportingJobArray=$sdk->reportingJob_filterAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','searchQuery'=>'test','page'=>'1']);#page optional
		// $reportingJobArray=$sdk->reportingJob_list(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO']);
		// $reportingJobArray=$sdk->reportingJob_listAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO']);
		// $data=['name'=>'reportingJob Testedited'];
		// $sdk->reportingJob_edit(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','reportingJobId'=>'aYYWUQ7S4u76Fujd8Jr6NylVzqoc0fvo'],$data);
		// $sdk->reportingJob_delete(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','reportingJobId'=>'aYYWUQ7S4u76Fujd8Jr6NylVzqoc0fvo']);

		#SMS
		// $sms=$sdk->sms_show(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','smsId'=>'e02wqh6KXgt1lDpilLkmfO4oORLMD840']);
		// $smsArray=$sdk->sms_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','page'=>'1']);#page optional
		// $smsArray=$sdk->sms_indexAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','page'=>'1']);#page optional
		// $smsArray=$sdk->sms_filter(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','searchQuery'=>'test','page'=>'1']);#page optional
		// $smsArray=$sdk->sms_filterAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','searchQuery'=>'test','page'=>'1']);#page optional
		// $smsArray=$sdk->sms_list(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO']);
		// $smsArray=$sdk->sms_listAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO']);
		// $sms=$sdk->sms_show(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','smsId'=>'e0vk66gRzE7kp0Jxm5PXDCJvOOhE5l7b']);
		// $smsArray=$sdk->sms_customer_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customerId'=>'d3k1qW5uf3pInMnanVLzRABG1H6XOGHC','page'=>'1']);#page optional
		// $smsArray=$sdk->sms_customer_filter(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customerId'=>'d3k1qW5uf3pInMnanVLzRABG1H6XOGHC','searchQuery'=>'test','page'=>'1']);#page optional
		// $smsArray=$sdk->sms_customer_list(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customerId'=>'d3k1qW5uf3pInMnanVLzRABG1H6XOGHC']);

		#SMSTEMPLATE
		// $data=[
		// 	'name'=>'SMS Template Test',
		// 	'active'=>true,
		// 	'event'=>'APPOINTMENT_ADD',
		// 	'text'=>'Juten Tach',
		// 	'textI18nList'=>[['key'=>'en','value'=>'good day']],
		// ];
		// $smsTemplate=$sdk->smsTemplate_add(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO'],$data);
		// $smsTemplate=$sdk->smsTemplate_show(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','smsTemplateId'=>'6Gzf6HJYpNKtcpIiTkAyJq3NOtrJWdHi']);
		// $smsTemplate=$sdk->smsTemplate_identify(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customId'=>'1234']);
		// $smsTemplateArray=$sdk->smsTemplate_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','page'=>'1']);#page optional
		// $smsTemplateArray=$sdk->smsTemplate_indexAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','page'=>'1']);#page optional
		// $smsTemplateArray=$sdk->smsTemplate_filter(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','searchQuery'=>'test','page'=>'1']);#page optional
		// $smsTemplateArray=$sdk->smsTemplate_filterAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','searchQuery'=>'test','page'=>'1']);#page optional
		// $smsTemplateArray=$sdk->smsTemplate_list(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO']);
		// $smsTemplateArray=$sdk->smsTemplate_listAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO']);
		// $data=['name'=>'smsTemplate Test edited'];
		// $sdk->smsTemplate_edit(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','smsTemplateId'=>'6Gzf6HJYpNKtcpIiTkAyJq3NOtrJWdHi'],$data);
		// $sdk->smsTemplate_delete(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','smsTemplateId'=>'6Gzf6HJYpNKtcpIiTkAyJq3NOtrJWdHi'],[]);

		#STATIC
		// $countryList=$sdk->static_country_list([]);
		// $currencyList=$sdk->static_currency_list([]);
		// $languageList=$sdk->static_language_list([]);
		// $logCategoryList=$sdk->static_logCategory_list([]);
		// $permissionList=$sdk->static_permission_list([]);
		// $sectorList=$sdk->static_sector_list([]);
		// $timeZoneList=$sdk->static_timeZone_list([]);
			#$organizationTemplateDataList=$sdk->static_organizationTemplateData_list([]);
		// $error=$sdk->static_error_show(['errorCode'=>400]);
		// $error=$sdk->static_error_show(['errorCode'=>401]);
		// $error=$sdk->static_error_show(['errorCode'=>403]);
		// $error=$sdk->static_error_show(['errorCode'=>404]);
		// $error=$sdk->static_error_show(['errorCode'=>405]);
		// $error=$sdk->static_error_show(['errorCode'=>500]);
		#die(BasicLib::debug($organizationTemplateDataList));

		#SYNCHRONIZATION
		// $data=[
		// 	'bookingResourceId'=>'brOayV9d7lcj5vjeG0Pl1qFuK92v4Uaf',
		// 	'type'=>'GRAPH',
		// 	'customId'=>'888',
		// 	'email'=>'support@bookingtime.com',
		// 	'externalCalendarContentStaff'=>[
		// 		'value'=>'',
		// 		'inheritance'=>'ORGANIZATION',
		// 	],
		// 	'notes'=>'',
		// 	'synchronizationServer'=>[
		// 		'value'=>[],
		// 		'inheritance'=>'ORGANIZATION',
		// 	],
		// 	'syncInterval'=>'MINUTES_15',
		// ];
		#$synchronization=$sdk->synchronization_add(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO'],$data);
		#$synchronization=$sdk->synchronization_show(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','synchronizationId'=>'A7CQ0ZOgj6gKnouvjVLRCr3GWizkiD5B']);
		#$synchronization=$sdk->synchronization_identify(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','customId'=>'666']);
		#$synchronization=$sdk->synchronization_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','page'=>'1']);#page optional
		#$synchronization=$sdk->synchronization_indexAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','page'=>'1']);#page optional
		#$synchronization=$sdk->synchronization_filter(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','searchQuery'=>'test','page'=>'1']);#page optional
		#$synchronization=$sdk->synchronization_filterAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','searchQuery'=>'test','page'=>'1']);#page optional
		#$synchronization=$sdk->synchronization_list(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO']);
		#$synchronization=$sdk->synchronization_listAll(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO']);
		#$data=['notes'=>'test edit'];
		#$synchronization=$sdk->synchronization_edit(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','synchronizationId'=>'A7CQ0ZOgj6gKnouvjVLRCr3GWizkiD5B'],$data);
		#$synchronization=$sdk->synchronization_delete(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','synchronizationId'=>'A7CQ0ZOgj6gKnouvjVLRCr3GWizkiD5B']);
		#$synchronization=$sdk->synchronization_reset(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','synchronizationId'=>'A7CQ0ZOgj6gKnouvjVLRCr3GWizkiD5B']);
		#die(BasicLib::debug($synchronization));

		#SYNCHRONIZATION_LOG
		#$synchronizationLog=$sdk->synchronizationLog_show(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','synchronizationId'=>'A7CQ0ZOgj6gKnouvjVLRCr3GWizkiD5B','synchronizationLogId'=>'7qydl51FdZjQD5dwXdPrl74FIopumLMV']);
		#$synchronizationLog=$sdk->synchronizationLog_index(['organizationId'=>'f6dS3eSezWO4ohcznIzoTb5JzzMB9nsO','synchronizationId'=>'A7CQ0ZOgj6gKnouvjVLRCr3GWizkiD5B','page'=>'1']);#page optional
		#die(BasicLib::debug($synchronizationLog));

		$output->writeln('last message: '."\n".$sdk->getMessageArrayAsString());
		$output->writeln('last request: '."\n".print_r($sdk->getLastRequestInfo(),TRUE));

		//finish command
		return 0;
	}
}
