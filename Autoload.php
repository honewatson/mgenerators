<?php
class Generators_Autoload {

    protected static $base_path;

	public function __construct($base_path){
		static::$base_path = $base_path;
	}


    public function autoloader($class_name)
    {
        $path = static::getFilePath($class_name) . '.php';
        include static::$base_path.$path;
    }

    public function autoload()
    {
        spl_autoload_register(array($this, 'autoloader'));
        return $this;
    }

	public static function getFilePath($class_name) {
		return str_replace('_', '/', $class_name);
	}

	public static function getBasePath(){
		return static::$base_path;
	}

}