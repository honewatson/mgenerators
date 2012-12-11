<?php

class Generators_Generator_Core_Factory {

	/**
	 * @var string
	 */
	public $class;

	/**
	 * @var $object
	 */
	public $args;

	/**
	 * @var Generators_Generator_Ini
	 */
	public $Generators_Generator_Ini;

	/**
	 * @param $class
	 * @param $args
	 * @param $dependencies
	 */
	public function __construct($class, $args, $namespace, $Generators_Generator_Ini, $base_path) {
		$this->class = $class;
		$this->args = $args;
		$this->namespace = $namespace;
		$this->Generators_Generator_Ini = $Generators_Generator_Ini;
		$this->base_path = $base_path;
	}

	public function build(){
		$module_dependencies = $this->Generators_Generator_Ini->parse();
		$class_dependencies = $module_dependencies[$this->class];

		$template = new $class_dependencies['template_factory']($class_dependencies['template_engine'],
			$this->namespace, $this->base_path);
		$class = new $this->class($this->args, $class_dependencies, $template);
		return $class;
	}
}