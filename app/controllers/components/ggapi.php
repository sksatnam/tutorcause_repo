<?php
class GgapiComponent extends Object {

	public function initialize($controller, $settings = array()) {
		$this->controller = $controller;
		Configure::load('Ggapi.settings');
	}

	/**
	* Prepares, converts, posts, and receives a response from the  GG API.
	*
	* @param array $data required The order data, such as cardnumber, name, address, etc.
	* @param boolean $testing optional Set to true to use testing config
	* @return array Response data or false if connection fails
	* @author chronon
	*/
	public function ggProcess($data, $testing = false) {
		$configType = 'live';
		if ($testing) {
			$configType = 'testing';
		}

		// get required settings and config from config/settings.php
		$settings = Configure::read('Ggapi.settings');
		$config = Configure::read('Ggapi.'.$configType);

		// field mapping
		$request = $this->__ggPrep($data);
		
		
		print_r($request);
		

		// combine the non-variable settings from config file with order data
		$request['configfile'] = $config['configfile'];
	 	$request = array_merge($request, $settings);

		// converts the array into the GG API formatted XML file
		$request = $this->__ggBuildXML($request);

		// post the XML file, hopefully get a response
		$response = $this->__ggPostXML(
			$config['url'],
			$config['port'],
			$config['key'],
			$request,
			$testing
		);

		// check the response, convert to array if it's valid
		if ($response) {
			$response = $this->__ggDecodeXML($response);
			if (is_array($response)) {
				return $response;
			}
		}
		return false;
	}

	/**
	* Matches local fields to GG API fields (field map in config/settings.php).
	*
	* @param array $data required
	* @return array Array key is per GG API specs with order values as val.
	* @author chronon
	*/
	private function __ggPrep($data) {
		$resData = array();
		$fields = Configure::read('Ggapi.fields');
		
		
		print_r($fields);
		
		
		
		foreach ($data as $k => $v) {
			if (isset($fields[$k])) {
				if (!is_array($fields[$k])) {
					$resData[$fields[$k]] = $v;
				} else {
					foreach ($fields[$k] as $ik => $iv) {
						if (isset($fields[$k][$ik])) {
							$resData[$iv] = $v[$ik];
						}
					}
				}
			}
		}
		return $resData;
	}

	/**
	* Format the array of data into an XML string for GG API.
	* An alternative function to do this is in GG API php sample code lphp.php,
	* but this one is faster/better.
	*
	* @param array $data required
	* @return string An XML string ready for submission
	* @author chronon
	*/
	private function __ggBuildXML($data) {
		$fields = Configure::read('Ggapi.apiFields');

		$dom = new DomDocument;
		$order = $dom->appendChild($dom->createElement('order'));
		foreach ($fields as $key => $val) {
			$$key = $order->appendChild($dom->createElement($key));
			foreach ($val as $k => $v) {
				$kk = $$key->appendChild($dom->createElement($v));
				$kk->appendChild($dom->createTextNode($data[$v]));
			}
		}

		$dom->formatOutput = false;
		$xml = $dom->saveXML();
		$xml = str_replace('<?xml version="1.0"?>', '', $xml);	
		
		print_r($xml);
		
		
			
	
		
		return $xml;
	}

	/**
	* Posts the XML string to GG API
	*
	* @param string $url
	* @param string $port
	* @param string $key
	* @param string $xml
	* @param boolean $testing optional Set to true to use testing config
	* @return string XML response or false
	* @author chronon
	*/
	private function __ggPostXML($url, $port, $key, $xml, $testing = false) {
		$defaults = array(
			CURLOPT_POST => 1,
			CURLOPT_HEADER => 0,
			CURLOPT_URL => $url,
			CURLOPT_PORT => $port,
			CURLOPT_FRESH_CONNECT => 1,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_FORBID_REUSE => 1,
			CURLOPT_TIMEOUT => 15,
			CURLOPT_POSTFIELDS => $xml,
			CURLOPT_SSLCERT => $key
		);

		// if using testing config, the SSL cert if invalid so these must be set to connect.
		if ($testing) {
			$testParams = array(
				CURLOPT_SSL_VERIFYHOST => 0,
				CURLOPT_SSL_VERIFYPEER => 0
			);
			$defaults = $defaults + $testParams;
		}

		$ch = curl_init();
		curl_setopt_array($ch, $defaults);
		if (!$result = curl_exec($ch)) {
			return false;
		}

		curl_close($ch);
		
		print_r($result);
		
		return $result;
	}

	/**
	* Converts the response XML into an array
	*
	* @param string $xml
	* @return array The response from the gateway
	* @author chronon
	*/
	private function __ggDecodeXML($xml) {
		preg_match_all ("/<(.*?)>(.*?)\</", $xml, $out, PREG_SET_ORDER);
		$n = 0;
		$result = array();
		while (isset($out[$n])) {
			$result[$out[$n][1]] = strip_tags($out[$n][0]);
			$n++;
		}
		return $result;
	}

}