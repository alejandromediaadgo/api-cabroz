<?php
/**
 * Creado para Sites.
 * Desarrollador: Alejandro Sosa <alesjohnson@hotmail.com>
 * Fecha: 11/1/17 - 23:58
 */

require 'vendor/autoload.php';

use MediaAdgo\Api;
use Curl\Curl;

$apiUrl = 'http://fordeals24.com/api/orders/add';
$apiKey = '7x.pPGb4nh!bP#?h,SCc.yh.x:e4FBUx';
$apiVersion = 1;
$apiClient = 'Client';

$order = array(
	'order' => array(
		'customer_name' => 'Name Surname',
		'customer_address' => 'Street API 123',
		'customer_postcode' => '20-576',
		'customer_city' => 'Rome',
		'customer_country_iso' => 'IT',
		'customer_phone' => '1234567',
		'customer_email' => 'test@mail.com',
		'cash_on_delivery' => 0,
		'adref' => 'test',
		'products' => array(
			array(
				'product_code' => 'PPF',
				'package_name' => 'Intense',
				'qty' => 3,
			)
		),
	),
);



$api = new Api(new Curl());
$api->setSettings($apiUrl, $apiKey, $apiVersion, $apiClient);
$response = $api->sendOrder($order);
echo '<pre>';print_r([__LINE__,__CLASS__, __METHOD__,$response]);die();