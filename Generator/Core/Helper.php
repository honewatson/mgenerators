<?php

class Generators_Generator_Core_Helper {

	/**
	 * @var Generators_Autoload
	 */
	public $Generators_Autoload;

	public function __construct($Generators_Autoload = 'Generators_Autoload') {

		  $this->Generators_Autoload = $Generators_Autoload;

	}

	public function mkdir($dir) {


		if(file_exists($dir))
			return;
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

	public function getBasePath(){
		$Generators_Autoload = $this->Generators_Autoload;
		return $Generators_Autoload::getBasePath();
	}

	public function getClassName($class_name){
		$class_name = explode("_", $class_name);
		return $class_name[sizeof($class_name) - 1];
	}

	public function getFullDirPath($class_name){
		return str_replace($this->getClassName($class_name), "", $this->getBasePath()."Generators/".$this->getFilePath($class_name));
	}

	public function getFullFileName($class_name){
		return $this->getFullDirPath($class_name).$this->getClassName($class_name).".php";
	}
	public function getClassFile($class_name){
		$dir = $this->getFullDirPath($class_name);
		$this->mkdir($dir);
		$this->show('Created Class:', $this->getFullFileName($class_name));
		return $this->getFullFileName($class_name);
	}

    public function show($message, $string){
	        echo "\n\n$message: $string\n\n";
	}
	public function getFullTemplatePath($class_name){
		return "{$this->getFullTemplateDirPath($class_name)}{$this->getClassName($class_name)}.html" ;
	}

	public function getFullTemplateDirPath($class_name){
		return "{$this->getTemplateBaseDir($class_name)}/{$this->getClassName($class_name)}/";
	}

	public function getTemplateBaseDir($class_name) {
		return $this->getFullDirPath($class_name)."templates";
	}
	public function addTemplate($data){
		$data = $data['data'];
		$this->mkdir($this->getFullTemplateDirPath($data['name']));
		$path = $this->getFullTemplateDirPath($data['name']).$data['template'];
		$this->show('Created Template:', $path);
		file_put_contents($path, "");
	}

}