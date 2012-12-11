<?php

abstract class Generators_Generator_Core_Abstract {

	/**
	 * @var Generators_Generator_Templateh20
	 */
	public $template;

	/**
	 * @var array
	 */
	public $inject;

	/**
	 * @var array
	 */
	public $args;

	/**
	 * @param $args args parsed from command line
	 * @param $inject an ini file with a list of classes to inject
	 * @param $template a template factory for loading templates of a template engine
	 */

	public function __construct($args, $inject, $template){
		$this->args = $args;
		$this->inject = $inject;
		$this->template = $template;
	}
	public function load($class, $args=array()){
		$class = $this->inject[$class];
		return new $class($args);
	}

	public function getData(){
		return array('data'=>$this->args);
	}

	abstract public function run();

}