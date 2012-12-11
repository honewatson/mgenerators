<?php

class Generators_Generator_Class extends Generators_Generator_Core_Abstract {

	public function run()
	{
		//print_r($this->load('helper'));
		//print_r($this->template->build('Generator.html'));

		/** @var $helper Generators_Generator_Core_Helper */
		$helper = $this->load('helper');

		$data = $this->getData();
		//print_r($data); exit;
		/** @var H2o */
		$template = $this->template->build('Class/Class.html');

		// print_r($this);

		//print_r($helper->getFullFileName($this->args->name));
		$result = $template->render($data);
		//print_r($this->getData());
		//echo $result;

		file_put_contents( $helper->getClassFile($this->args->name), $result);

		$helper->addTemplate($data);
		//$helper->

		//echo $result;
		// TODO: Implement run() method.
	}
}