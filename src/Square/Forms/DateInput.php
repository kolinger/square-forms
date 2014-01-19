<?php

namespace Square\Forms;

use Nette\DateTime;
use Nette\Forms\Controls\BaseControl;

/**
 * @author Tomáš Kolinger <tomas@kolinger.name>
 */
class DateInput extends BaseControl
{

	/**
	 * @var string
	 */
	private $format;


	/**
	 * @param string $label
	 * @param string $format
	 */
	public function __construct($label = NULL, $format = 'j.n.Y')
	{
		parent::__construct($label);
		$this->format = $format;
		$this->addRule(__CLASS__ . '::validateDate', 'Date is invalid.');
	}


	/**
	 * @param string $value
	 * @return BaseControl
	 */
	public function setValue($value)
	{
		if ($value instanceof \DateTime || $value == NULL) {
			$this->value = $value;
		} else {
			$time = strtotime($value);
			$this->value = $time ? DateTime::from($time) : FALSE;
		}
		return $this;
	}


	/**
	 * @return string
	 */
	public function getControl()
	{
		return $this->generateControl();
	}


	/**
	 * @param string $id
	 * @return string
	 */
	protected function generateControl($id = 'date-input')
	{
		$value = $this->value ? $this->value->format($this->format) : NULL;
		return parent::getControl()
			->value($value)
			->data($id, 'true');
	}


	/**
	 * @param DateInput $control
	 * @return bool
	 */
	public static function validateDate(DateInput $control)
	{
		if (!$control->required && $control->value == NULL) {
			return TRUE;
		}
		return (bool) $control->value;
	}
}