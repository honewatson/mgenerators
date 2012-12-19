<?php

class Generators_Magento_Installer extends Generators_Generator_Core_Abstract {

	public function run()
	{
		/** @var $helper Generators_Generator_Core_Helper */
		$helper = $this->load('helper');

		$data = $this->getData();

		/**
		*
		* Maybe do some data manipulation here
		*/

		$template =  "Installer.html";

		/** @var H2o */
		$template = $this->template->build($template);

		$result = $template->render($data);

		file_put_contents( $helper->getClassFile($this->args->name), $result);

		$helper->addTemplate($data);
	}

}