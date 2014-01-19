<?php

namespace Square\Forms;

/**
 * @author Tomáš Kolinger <tomas@kolinger.name>
 */
class TimeInput extends DateInput
{

	/**
	 * @param string $label
	 * @param string $format
	 */
	public function __construct($label = NULL, $format = 'H:i')
	{
		parent::__construct($label, $format);
	}


	/**
	 * @return string
	 */
	public function getControl()
	{
		return $this->generateControl('time-input');
	}
}