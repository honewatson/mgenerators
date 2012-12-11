<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hone
 * Date: 11/12/12
 * Time: 2:38 PM
 * To change this template use File | Settings | File Templates.
 */
class Generators_Generator_Core_Ini
{
	/**
	 * @var string
	 */
	public $class;

	/**
	 * @var string
	 */
	public $base_path;

	/**
	 * @var Generators_Autoload
	 */
	public $Generators_Autoload;


	public function __construct($class, $base_path, $Generators_Autoload) {
		$this->class = $class;
		$this->base_path = $base_path;
		$this->Generators_Autoload = $Generators_Autoload;
	}

	public function parse() {
		/**
		 * var $autoload Generators_Autoload
		 */
		$autoload = $this->Generators_Autoload;
		$file = $autoload::getFilePath($this->class).".ini";
		return parse_ini_file($this->base_path."/".$file,true);
	}

}
