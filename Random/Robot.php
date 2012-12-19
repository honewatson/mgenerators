<?php

class Random_Robot  {


	/**
	 *
	 * @var Head
	 */
	public $Head;

	/**
	 *
	 * @var Arms
	 */
	public $Arms;

	/**
	 *
	 * @var Legs
	 */
	public $Legs;

	public function __construct( $Head, $Arms, $Legs) {

			$this->Head = $Head;
			$this->Arms = $Arms;
			$this->Legs = $Legs;
	
	}

}