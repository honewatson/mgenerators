<?php

class Generators_Generator_Class extends Generators_Generator_Core_Abstract {

	public function run()
	{
		//print_r($this->load('helper'));
		//print_r($this->template->build('Generator.html'));

		/** @var H2o */
		$template = $this->template->build('Generator.html');

		//print_r($this->args);
		$result = $template->render($this->getData());
		/** @var $helper Generators_Generator_Core_Helper */
		$helper = $this->load('helper');
		$helper->mkdir($this->args->name);
		$helper->mkdir($this->args->name);
		print_r($helper);
		print_r($this->args);
		//$helper->mkdir($this->args['']);

		//echo $result;
		// TODO: Implement run() method.
	}
}