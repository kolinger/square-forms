<?php

namespace Square\Forms;

use Nette\Forms\Controls\BaseControl;

class Form extends \Nette\Application\UI\Form
{

	/**
	 * @param string $name
	 * @param string $label
	 * @param BaseControl|array $parent
	 * @param callable $callback
	 * @return DependentSelectBox
	 */
	public function addDependentSelect($name, $label = NULL, $parent, callable $callback)
	{
		return $this[$name] = new DependentSelectBox($label, $parent, $callback);
	}


	/**
	 * @param string $name
	 * @param string $label
	 * @param string $format
	 * @return DateInput
	 */
	public function addDate($name, $label = NULL, $format = 'm/d/Y')
	{
		return $this[$name] = new DateInput($label, $format);
	}


	/**
	 * @param string $name
	 * @param string $label
	 * @param string $format
	 * @return DateInput
	 */
	public function addDateTime($name, $label = NULL, $format = 'm/d/Y H:i')
	{
		return $this[$name] = new DateTimeInput($label, $format);
	}


	/**
	 * @param string $name
	 * @param string $label
	 * @param string $format
	 * @return DateInput
	 */
	public function addTime($name, $label = NULL, $format = 'H:i')
	{
		return $this[$name] = new TimeInput($label, $format);
	}
}