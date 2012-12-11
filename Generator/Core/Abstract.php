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
	 * @var array
	 */
	public $class_cache = array();

	/**
	 * @param $args args parsed from command line
	 * @param $inject an ini file with a list of classes to inject
	 * @param $template a template factory for loading templates of a template engine
	 */

	public function __construct($args, $inject, $template, $namespace){
		$this->args = $args;
		$this->inject = $inject;
		$this->template = $template;
		$this->namespace = $namespace;
	}
	public function load($class, $args=array()){
		$class = $this->inject[$class];
		if(sizeof($args))
			return new $class($args);
		else
			return new $class;
	}

	public function fromCache($class, $args=array()){
		if(!isset($this->class_cache[$class]))
			$this->class_cache[$class] = $this->load($class, $args=array());
		return $this->class_cache[$class];
	}

	public function getData(){
		$helper = $this->load('helper');
		$data['abstract'] = 'Generators_Generator_Core_Abstract';
		$data['classname'] = $helper->getClassName($this->args->name);
		$data['namespace'] = $this->namespace;
		$data['template'] =  "{$data['classname']}.html";
		$final = array_merge($data, (array)$this->args);
		return array('data'=>$final);
	}

	abstract public function run();

}