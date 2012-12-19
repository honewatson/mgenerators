<?php

class Generators_Generator_File extends Generators_Generator_Core_Abstract {

	public function run()
	{
		/** @var $helper Generators_Generator_Core_Helper */
		$helper = $this->load('helper');

		$data = $this->getData();
		$data['vars'] = explode(',', $data['data']['vars']);
		/**
		*
		* Maybe do some data manipulation here
		*/
		//php Generator.php --class Generators_Generator_File --name Random_Robot --vars Head,Arms,Legs

		$template =  "File/File.html";

		/** @var H2o */
		$template = $this->template->build($template);

		$result = $template->render($data);

		file_put_contents( $helper->getClassFile($this->args->name), $result);

		//$helper->addTemplate($data);
	}

}