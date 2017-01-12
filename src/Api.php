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
	protected function setSettings($apiUrl, $apiKey, $apiVersion, $apiClient = self::CLIENT)
	{
		$this->apiUrl = $apiUrl;
		$this->apiKey = $apiKey;
		$this->apiVersion = $apiVersion;
		$this->apiClient = $apiClient;
	}

	/**
	 * Create a token
	 *
	 * @return string
	 */
	protected function generateToken()
	{
		return hash_hmac('sha1', $this->apiKey.'~'.$this->apiVersion, $this->apiClient, FALSE);
	}

	/**
	 * Send order data to web service
	 *
	 * @param array $order
	 * @return mixed
	 */
	protected function sendOrderData(array $order = [])
	{
		$token = $this->generateToken();
		$header = array(
			"Api-Version" => $this->apiVersion,
			"Authorization" => $this->apiClient.' '.$token,
		);

		$this->setHeaders($header);
	}
}