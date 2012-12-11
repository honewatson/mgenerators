<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Shell
 * @copyright   Copyright (c) 2009 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Shell scripts abstract class
 *
 * @category    Mage
 * @package     Mage_Shell
 * @author      Magento Core Team <core@magentocommerce.com>
 */
date_default_timezone_set('Australia/Melbourne');
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);
require_once 'Autoload.php';

abstract class Generators_Abstract
{
    /**
     * Is include Mage and initialize application
     *
     * @var bool
     */
    protected $_includeMage = true;

    /**
     * Magento Root path
     *
     * @var string
     */
    protected $_rootPath;

    /**
     * Initialize application with code (store, website code)
     *
     * @var string
     */
    protected $_appCode     = 'admin';

    /**
     * Initialize application code type (store, website, store_group)
     *
     * @var string
     */
    protected $_appType     = 'store';

    /**
     * Input arguments
     *
     * @var array
     */
    protected $_args        = array();

	protected $_color;

    /**
     * Initialize application and parse input parameters
     *
     */
    public function __construct()
    {

        if ($this->_includeMage) {
            require_once $this->_getRootPath() . 'app' . DIRECTORY_SEPARATOR . 'Mage.php';
            Mage::app($this->_appCode, $this->_appType);
        }
	    $this->_autoload();
	    $this->_loadH2o();
        $this->_applyPhpVariables();
        $this->_parseArgs();
        $this->_construct();
        $this->_validate();
        $this->_showHelp();
    }

	protected function _loadH2o(){
		include "./h2o-php/h2o.php";
		//$h2o = new h2o('h2o-php/templates/generator/magento.php');

	}

	protected function _autoload(){
		$autoload = new Generators_Autoload($this->_getRootPath());
		$autoload->autoload();
	}

    /**
     * Get Magento Root path (with last directory separator)
     *
     * @return string
     */
    protected function _getRootPath()
    {
        if (is_null($this->_rootPath)) {
            $this->_rootPath = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR;
        }
        return $this->_rootPath;
    }

    /**
     * Parse .htaccess file and apply php settings to shell script
     *
     */
    protected function _applyPhpVariables()
    {
        $htaccess = $this->_getRootPath() . '.htaccess';
        if (file_exists($htaccess)) {
            // parse htaccess file
            $data = file_get_contents($htaccess);
            $matches = array();
            preg_match_all('#^\s+?php_value\s+([a-z_]+)\s+(.+)$#siUm', $data, $matches, PREG_SET_ORDER);
            if ($matches) {
                foreach ($matches as $match) {
                    @ini_set($match[1], $match[2]);
                }
            }
            preg_match_all('#^\s+?php_flag\s+([a-z_]+)\s+(.+)$#siUm', $data, $matches, PREG_SET_ORDER);
            if ($matches) {
                foreach ($matches as $match) {
                    @ini_set($match[1], $match[2]);
                }
            }
        }
    }

    /**
     * Parse input arguments
     *
     * @return Mage_Shell_Abstract
     */
    protected function _parseArgs()
    {
        $current = null;
        foreach ($_SERVER['argv'] as $arg) {
            $match = array();
            if (preg_match('#^--([\w\d_-]{1,})$#', $arg, $match) || preg_match('#^-([\w\d_]{1,})$#', $arg, $match)) {
                $current = $match[1];
                $this->_args[$current] = true;
            } else {
                if ($current) {
                    $this->_args[$current] = $arg;
                } else if (preg_match('#^([\w\d_]{1,})$#', $arg, $match)) {
                    $this->_args[$match[1]] = true;
                }
            }
        }
        return $this;
    }

    /**
     * Additional initialize instruction
     *
     * @return Mage_Shell_Abstract
     */
    protected function _construct()
    {
        return $this;
    }

    /**
     * Validate arguments
     *
     */
    protected function _validate()
    {
        if (isset($_SERVER['REQUEST_METHOD'])) {
            die('This script cannot be run from Browser. This is the shell script.');
        }
    }

	public  $_namespace = null;
	public function getNamespace() {
		if($this->_namespace === null)     {
			$name = explode("_",$this->getArg('name'));
			array_pop($name);
			$this->_namespace = implode("_", $name);
		}
		return $this->_namespace;
	}
	public $_generator_namespace = null;
	public function getGeneratorNamespace() {
		if($this->_generator_namespace === null)
			$this->_generator_namespace  = str_replace('Generators_', '', get_called_class());
		return $this->_generator_namespace;
	}
	public function getClass($Generators_Generator_Factory ='Generators_Generator_Core_Factory',
	                         $Generators_Generator_Ini
	= 'Generators_Generator_Core_Ini',
	                         $Generators_Autoload = 'Generators_Autoload'){
			//$this->_namespace  = str_replace('Generators_', '', get_called_class());

			/**
			 *  @var $class Generators_Generator_Abstract
	         */
			$class = $this->getArg('class');

			$Class = new $Generators_Generator_Factory(
				$class,
				(object)$this->_args,
				$this->getNamespace(),
				$this->getGeneratorNamespace(),
				new $Generators_Generator_Ini($this->getGeneratorNamespace(),
					$this->_getRootPath(),
					$Generators_Autoload
				),
				$this->_getRootPath()
			);

			return $Class->build();
	}
    /**
     * Run script
     *
     */
    abstract public function run();

    /**
     * Check is show usage help
     *
     */
    protected function _showHelp()
    {
        if (isset($this->_args['h']) || isset($this->_args['help'])) {
            die($this->usageHelp());
        }
    }

    /**
     * Retrieve Usage Help Message
     *
     */
    public function usageHelp()
    {
        return <<<USAGE
Usage:  php -f script.php -- [options]

  -h            Short alias for help
  help          This help
USAGE;
    }

    /**
     * Retrieve argument value by name or false
     *
     * @param string $name the argument name
     * @return mixed
     */
    public function getArg($name)
    {
        if (isset($this->_args[$name])) {
            return $this->_args[$name];
        }
        return false;
    }
}
