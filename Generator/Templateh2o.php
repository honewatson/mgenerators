<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hone
 * Date: 11/12/12
 * Time: 4:40 PM
 * To change this template use File | Settings | File Templates.
 */
class Generators_Generator_Templateh2o
{
	public $H2o;
	public $namespace;
	public $base_path;

	public function __construct($H2o, $namespace, $base_path){
	    $this->H2o = $H2o;
		$this->namespace = $namespace;
		$this->base_path = $base_path;
	}

	/**
	 * @param $template_name
	 * @return H2o
	 */
	public function build($template_name, $use_default=true){
		if($use_default)
			$template_name ="{$this->base_path}Generators/$this->namespace/templates/$template_name";
		else {
			$template_name ="{$this->base_path}$template_name";
		}
		return new $this->H2o($template_name);
	}
}
