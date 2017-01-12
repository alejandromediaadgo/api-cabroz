<?php
/**
 * Creado para Sites.
 * Desarrollador: Alejandro Sosa <alesjohnson@hotmail.com>
 * Fecha: 11/1/17 - 23:44
 */

namespace MediaAdgo;


use Curl\Curl;

abstract class ApiAbstract
{
	const METHOD_POST 	= 'POST';
	const METHOD_GET 	= 'GET';
	const CLIENT		= 'Client';

	/**
	 * @var int
	 */
	protected $apiVersion;

	/**
	 * @var string
	 */
	protected $apiKey;

	/**
	 * @var string
	 */
	protected $apiMethod;

	/**
	 * @var string
	 */
	protected $apiUrl;

	/**
	 * @var string
	 */
	protected $apiAutorization;

	/**
	 * @var string
	 */
	protected $apiClient;

	/**
	 * @var Curl
	 */
	protected $_curl;

	/**
	 * ApiAbstract constructor.
	 *
	 * @param \Curl\Curl|null $curl
	 */
	public function __construct(Curl $curl = null)
	{
		$this->_curl = $curl;
	}

	/**
	 * Set settings of api
	 * @param $apiUrl
	 * @param $apiKey
	 * @param $apiVersion
	 * @param $apiClient
	 */
	abstract protected function setSettings($apiUrl, $apiKey, $apiVersion, $apiClient = self::CLIENT);

	/**
	 * Set headers
	 * @param array $headers
	 * @return mixed
	 */
	protected function setHeaders(array $headers = [])
	{
		foreach ($headers as $key => $header) {
			$this->_curl->setHeader($key, $header);
		}
	}

	/**
	 * Send order data to web service
	 * @param array $order
	 * @return mixed
	 */
	abstract protected function sendOrderData(array $order = array());

	/**
	 * Create a token
	 * @return string
	 */
	abstract protected function generateToken();

	/**
	 * Generate URL-encoded query string
	 * @param array $post
	 * @return string
	 */
	public function buildQuery(array $post = array())
	{
		if(empty($post)){
			return '';
		}

		return http_build_query($post);
	}
}