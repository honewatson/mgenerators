<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hone
 * Date: 11/12/12
 * Time: 12:27 PM
 * To change this template use File | Settings | File Templates.
 */


require_once 'Abstract.php';

class Generators_Generator extends Generators_Abstract
{

	public function run(){
		$this->getClass()->run();

	}
	public function usageHelp(){
        return <<<USAGE
Usage:  php -f generator.php -- [options]

  --class <Class>                 Run Class
  --name <Relative Name of new class>
  php Generator.php --class Generators_Generator_Class --name Magento_Block
  help                          This help

  <indexer>     Comma separated indexer codes or value "all" for all indexers

USAGE;
	}
}
/*
$page = 'blah';
echo $h2o->render(compact('page'));
*/

$shell = new Generators_Generator();
$shell->run();
