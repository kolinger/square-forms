<?php

namespace Square\Forms;

use Nette\Forms\Controls\BaseControl;
use Nette\Forms\Controls\SelectBox;

/**
 * @author Tomáš Kolinger <tomas@kolinger.name>
 */
class DependentSelectBox extends SelectBox
{

	/**
	 * @var callable
	 */
	private $callback;

	/**
	 * @var BaseControl
	 */
	private $parent;


	/**
	 * @param string $label
	 * @param BaseControl|array $parent
	 * @param callable $callback
	 */
	public function __construct($label, $parent, callable $callback)
	{
		$this->callback = $callback;
		$this->parent = $parent;
		parent::__construct($label, $callback($parent));
	}


	/**
	 * @param string $value
	 * @return \Nette\Forms\Controls\ChoiceControl
	 */
	public function setValue($value)
	{
		$this->setItems($this->callback->__invoke($this->parent));
		parent::setValue($value);
		return $this;
	}


	public function loadHttpData()
	{
		parent::loadHttpData();
		$this->setItems($this->callback->__invoke($this->parent));
	}
}