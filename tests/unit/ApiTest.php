<?php

use MediaAdgo\Api;
use Curl\Curl;

class ApiTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

	/**
	 * @var PHPUnit_Framework_MockObject_MockBuilder
	 */
	public $mock;

	/**
	 * @var Api
	 */
	public $api;

	/**
	 * @var \Curl\Curl
	 */
	public $curl;

	protected function _before()
	{
		$this->api = new Api(new Curl());
		$this->mock = $this->getMockBuilder(Api::class);
	}

	protected function _after()
	{
		$this->mock = null;
	}

	public function apiProvider()
	{
		return [
			[new ReflectionClass(Api::class)]
		];
	}

	/**
	 * @test
	 */
    public function existClassApi()
    {
    	$check = $this->tester->existClass(Api::class);
    	$this->assertTrue($check);
    }

	/**
	 * @test
	 * @param $class ReflectionClass
	 * @dataProvider apiProvider
	 */
    public function existClassExtendOfApiAbstract($class)
    {
    	$this->assertTrue($class->isSubclassOf(\MediaAdgo\ApiAbstract::class));
    }

	/**
	 * @test
	 * @param $class ReflectionClass
	 * @dataProvider apiProvider
	 */
	public function hasMethodSetHeaders($class)
	{
		$this->assertEquals('setHeaders', $class->getMethod('setHeaders')->name);
	}

	/**
	 * @test
	 * @param $class ReflectionClass
	 * @dataProvider apiProvider
	 */
	public function hasMethodSetSettings($class)
	{
		$this->assertEquals('setSettings', $class->getMethod('setSettings')->name);
	}

	/**
	 * @test
	 * @param $class ReflectionClass
	 * @dataProvider apiProvider
	 */
	public function hasMethodIsOrderEmpty($class)
	{
		$this->assertEquals('isOrderEmpty', $class->getMethod('isOrderEmpty')->name);
	}

	/**
	 * @test
	 * @param $class ReflectionClass
	 * @dataProvider apiProvider
	 */
	public function methodBuildQueryReturnStringEncoded($class)
	{
		$post = array(
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

		$strExpect = 'order%5Bcustomer_name%5D=Name+Surname&order%5Bcustomer_address%5D=Street+API+123';
		$strExpect .= '&order%5Bcustomer_postcode%5D=20-576&order%5Bcustomer_city%5D=Rome';
		$strExpect .= '&order%5Bcustomer_country_iso%5D=IT&order%5Bcustomer_phone%5D=1234567';
		$strExpect .= '&order%5Bcustomer_email%5D=test%40mail.com&order%5Bcash_on_delivery%5D=0';
		$strExpect .= '&order%5Badref%5D=test&order%5Bproducts%5D%5B0%5D%5Bproduct_code%5D=PPF';
		$strExpect .= '&order%5Bproducts%5D%5B0%5D%5Bpackage_name%5D=Intense&order%5Bproducts%5D%5B0%5D%5Bqty%5D=3';


		$method = $class->getMethod('buildQuery');
		$method->setAccessible(true);

		$result = $method->invokeArgs($this->api, $post);

//		$this->assertSame($strExpect, $result);
    }

	/**
	 * @test
	 * @param $class ReflectionClass
	 * @dataProvider apiProvider
	 */
	public function mathodSendOrderReturnOk($class)
	{


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


		$mock = $this->mock->setMethods(array('sendOrder','setSettings'))->getMock();

		$mock->expects($this->once())
			->method('setSettings')
			->with($apiUrl, $apiKey, $apiVersion, $apiClient);

		$mock->expects($this->once())
			->method('sendOrder')
			->with($order);
//			->will($this->stringContains('ok'));

		$this->expectOutputString('OK');

		$mock->sendOrder($order);


//		echo '<pre>';print_r([__LINE__,__CLASS__, __METHOD__,$this->mock]);die();
//		$param = $class->getMethod('buildQuery')->getParameters()[0];
//		$this->assertTrue($param->isArray());
	}
}