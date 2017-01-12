<?php

use MediaAdgo\ApiAbstract;

class ApiAbstractTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

	public function apiAbtractProvider()
	{
		return [
			[new ReflectionClass(ApiAbstract::class)]
		];
    }

	/**
	 * @test
	 */
    public function existClassApiAbstract()
    {
    	$check = $this->tester->existClass(ApiAbstract::class);
    	$this->assertTrue($check);
    }

	/**
	 * @test
	 * @param $class ReflectionClass
	 * @dataProvider apiAbtractProvider
	 */
	public function methodConstructorReceiveFirstParameterInstanceOfCurl($class)
	{
		$classExpect = new \ReflectionClass(\Curl\Curl::class);

		$result = $this->tester->checkInstanceParameterOfMethod($class, null, 0, $classExpect, true);
		$this->assertTrue($result);
	}

	/**
	 * @test
	 * @param $class ReflectionClass
	 * @dataProvider apiAbtractProvider
	 */
    public function isAbstractClassApiAbstract($class)
    {
    	$this->assertTrue($class->isAbstract());
    }

	/**
	 * @test
	 * @param $class ReflectionClass
	 * @dataProvider apiAbtractProvider
	 */
    public function hasMethodSendData($class)
    {
    	$this->assertEquals('sendOrderData', $class->getMethod('sendOrderData')->name);
    }

	/**
	 * @test
	 * @param $class ReflectionClass
	 * @dataProvider apiAbtractProvider
	 */
    public function hasMethodSetSettings($class)
    {
    	$this->assertEquals('setSettings', $class->getMethod('setSettings')->name);
    }

	/**
	 * @test
	 * @param $class ReflectionClass
	 * @dataProvider apiAbtractProvider
	 */
    public function hasMethodBuildQuery($class)
    {
    	$this->assertEquals('buildQuery', $class->getMethod('buildQuery')->name);
    }

	/**
	 * @test
	 * @param $class ReflectionClass
	 * @dataProvider apiAbtractProvider
	 */
    public function hasMethodBuildSetHeaders($class)
    {
    	$this->assertEquals('setHeaders', $class->getMethod('setHeaders')->name);
    }

	/**
	 * @test
	 * @param $class ReflectionClass
	 * @dataProvider apiAbtractProvider
	 */
    public function hasMethodAbstractGenerateToken($class)
    {
    	$this->assertTrue($class->getMethod('generateToken')->isAbstract());
    }

	/**
	 * @test
	 * @param $class ReflectionClass
	 * @dataProvider apiAbtractProvider
	 */
    public function hasConstanPost($class)
    {
    	$this->assertTrue($class->hasConstant('METHOD_POST'));
    }

	/**
	 * @test
	 * @param $class ReflectionClass
	 * @dataProvider apiAbtractProvider
	 */
    public function hasConstanGet($class)
    {
    	$this->assertTrue($class->hasConstant('METHOD_GET'));
    }

	/**
	 * @test
	 * @param $class ReflectionClass
	 * @dataProvider apiAbtractProvider
	 */
    public function hasProperties($class)
    {
		$properties = $propertiesExpects = [];
		foreach ($class->getProperties() as $property) {
			$properties[] = $property->getName();
		}

		$propertiesExpects = [
			'apiVersion',
			'apiKey',
			'apiMethod',
			'apiUrl',
			'apiAutorization',
			'apiClient',
			'_curl',
		];

    	$this->assertEquals($properties, $propertiesExpects);
    }

	/**
	 * @test
	 * @param $class ReflectionClass
	 * @dataProvider apiAbtractProvider
	 */
	public function mathodBuildQueryReturnStringWithParameter($class)
	{
		$this->assertTrue($class->hasConstant('METHOD_GET'));
	}

	/**
	 * @test
	 * @param $class ReflectionClass
	 * @dataProvider apiAbtractProvider
	 */
	public function mathodBuildQueryReceiveParameter($class)
	{
		$this->assertEquals(1, $class->getMethod('buildQuery')->getNumberOfParameters());
	}

	/**
	 * @test
	 * @param $class ReflectionClass
	 * @dataProvider apiAbtractProvider
	 */
	public function mathodBuildQueryReceiveParameterIsTypeArray($class)
	{
		$param = $class->getMethod('buildQuery')->getParameters()[0];
		$this->assertTrue($param->isArray());
	}

	/**
	 * @test
	 * @param $class ReflectionClass
	 * @dataProvider apiAbtractProvider
	 */
	public function mathodSetSettingHasFourParameters($class)
	{
		$result = $this->tester->countParametersOfMethod($class, 'setSettings', 4);
		$this->assertTrue($result);
	}

	/**
	 * @test
	 * @param $class ReflectionClass
	 * @dataProvider apiAbtractProvider
	 */
	public function mathodSetHeadersHasOneParameters($class)
	{
		$result = $this->tester->countParametersOfMethod($class, 'setHeaders', 1);
		$this->assertTrue($result);
	}
}