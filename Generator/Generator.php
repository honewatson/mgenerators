<?php

class Generators_Generator_Generator extends Generators_Generator_Abstract {

	public function run()
	{
		//print_r($this->load('helper'));
		//print_r($this->template->build('Generator.html'));

		/** @var H2o */
		$template = $this->template->build('Generator.html');

		//print_r($this->args);
		$result = $template->render($this->getData());
		echo $result;
		// TODO: Implement run() method.
	}
}