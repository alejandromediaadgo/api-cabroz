<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Unit extends \Codeception\Module
{
	/**
	 * Check if exist class
	 * @param $class
	 * @return bool
	 */
	public function existClass($class)
	{
		if(empty($class)){
			return false;
		}

		return class_exists($class);
	}

	/**
	 * Check if exist method
	 * @param $class \ReflectionClass
	 * @param $method string
	 */
	public function existsMethod($class, $method)
	{
		if(empty($class) || empty($method)){
			return false;
		}

		return $class->hasMethod($method);
	}

	/**
	 * Check instance parameter of method
	 * @param \ReflectionClass $class
	 * @param string           $method
	 * @param string           $positionParameter
	 * @param \ReflectionClass $classExpect
	 * @param bool             $constructor
	 * @return bool
	 */
	public function checkInstanceParameterOfMethod(
		\ReflectionClass $class,
		$method, $positionParameter,
		\ReflectionClass $classExpect,
		$constructor = false
	)
	{
		$firstParameter = !$constructor ?
			$class->getMethod($method)->getParameters() : $class->getConstructor()->getParameters();

		if(empty($firstParameter[$positionParameter])){
			return false;
		}

		$obj = $firstParameter[$positionParameter]->getClass();

		return $classExpect->getName() === $obj->getName() ? true : false;
	}

	/**
	 * Count parameter of method
	 * @param \ReflectionClass $class
	 * @param string           $method
	 * @param int              $totalExpect
	 * @param bool             $constructor
	 * @return bool
	 */
	public function countParametersOfMethod(\ReflectionClass $class, $method, $totalExpect, $constructor = false)
	{
		$parametros = !$constructor ? $class->getMethod($method)->getParameters() : $class->getConstructor()->getParameters();

		return $totalExpect == count($parametros) ? true : false;
	}
}
