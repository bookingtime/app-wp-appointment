<?php

namespace bookingtime\phpsdkapp\Sdk;
use bookingtime\phpsdkapp\Sdk\HttpClient;
use bookingtime\phpsdkapp\Lib\BasicLib;



/**
 * handle specific API requests
 *
 * @author DKone <bookingtime GmbH>
 */
abstract class Route {
	//class properties
	protected $httpClient;



	/**
	 * set some class properties
	 *
	 * @param	object	$httpClient: bookingtime\phpsdkapp\Sdk\HttpClient
	 * @return	void
	 */
	public function __construct(HttpClient $httpClient) {
		$this->httpClient=$httpClient;
	}



	/**
	 * check if submitted url parameter are complete
	 * INFO: throw exception if inclomplete parameters submitted
	 *
	 * @param	array		$checkUrlParameter: check if this parameters are exiting in submitted data like "[organizationId,customerId]"
	 * @param	array		$submittedUrlParameter: submitted parameters
	 * @return	void
	 */
	protected function checkUrlParameters(array $checkUrlParameter, array $submittedUrlParameter) {
		foreach($checkUrlParameter as $item) {
			if(!array_key_exists($item,$submittedUrlParameter)) {
				throw new \InvalidArgumentException('Expected url parameter "'.$item.'" missing!');
			}
		}
	}
}
