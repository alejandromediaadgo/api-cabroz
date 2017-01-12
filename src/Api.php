<?php
/**
 * Creado para Sites.
 * Desarrollador: Alejandro Sosa <alesjohnson@hotmail.com>
 * Fecha: 12/1/17 - 3:22
 */

namespace MediaAdgo;


use Curl\Curl;

class Api extends ApiAbstract
{
	/**
	 * Api constructor.
	 *
	 * @param Curl|null $curl
	 */
	public function __construct(Curl $curl = null)
	{
		parent::__construct($curl);
	}

	/**
	 * Set settings of api
	 *
	 * @param $apiUrl
	 * @param $apiKey
	 * @param $apiVersion
	 * @param $apiClient
	 */
	public function setSettings($apiUrl, $apiKey, $apiVersion, $apiClient = self::CLIENT)
	{
		$this->apiUrl = $apiUrl;
		$this->apiKey = $apiKey;
		$this->apiVersion = $apiVersion;
		$this->apiClient = $apiClient;
	}

	/**
	 * Send order data to web service
	 *
	 * @param array $order
	 * @return mixed
	 */
	public function sendOrder(array $order = [])
	{
		$this->isOrderEmpty($order);

		$token = $this->generateToken();
		$header = array(
			"Api-Version" => $this->apiVersion,
			"Authorization" => $this->apiClient.' '.$token,
		);

		$this->setHeaders($header);

		$this->_curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
		$this->_curl->setOpt(CURLOPT_RETURNTRANSFER, true);
		$response = $this->_curl->post($this->apiUrl, $order);

		return $response;
	}

	/**
	 * Check if order is empty
	 * @param $order
	 * @throws \Exception
	 */
	private function isOrderEmpty($order)
	{
		if(empty($order)){
			throw new \Exception('Order can not be empty');
		}
	}

	/**
	 * Create a token
	 *
	 * @return string
	 */
	protected function generateToken()
	{
		return hash_hmac('sha1', $this->apiKey.'~'.$this->apiVersion, $this->apiClient, false);
	}
}