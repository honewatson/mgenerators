<?php

class Generators_Generator_Core_Helper {

	/**
	 * @var Generators_Autoload
	 */
	public $Generators_Autoload;

	public function __construct($Generators_Autoload = 'Generators_Autoload') {

		  $this->Generators_Autoload = $Generators_Autoload;

	}

	public function mkdir($class_name) {
		$dir = $this->getBasePath($class_name)."Generators/".$this->getFilePath($class_name);
		echo "\n\n\n";
		echo $dir;
		echo "\n\n\n";
		try {
			mkdir($dir, 0755, true);
		}
		catch(Exception $e){
			echo "\n\n\n";
			echo $e->getMessage();
			echo "\n\n\n";
			echo $dir;
			echo "\n\n\n";
			die();
		}
	}

	public function getFilePath($class_name){
		$Generators_Autoload = $this->Generators_Autoload;
		return $Generators_Autoload::getFilePath($class_name);
	}

	public function getBasePath($class_name){
		$Generators_Autoload = $this->Generators_Autoload;
		return $Generators_Autoload::getBasePath();
	}

}