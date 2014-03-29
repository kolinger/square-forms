Square Forms
============

Some useful extensions for Nette Forms

Requirements:
- Nette 2.1

Instalation:
```
composer require kolinger/square-forms:@dev
```

DepedentSelextBox
-----------------

Additional requirements:
- jQuery
- http://addons.nette.org/cs/jquery-ajax
- http://addons.nette.org/cs/ajax-form

Example presenter:
```php
namespace App;

use Square\Forms\Form;

class SelectsPresenter extends BasePresenter
{

    private static $items = array(
		array('dependent on first item #1', 'dependent on first item #2'),
		array('dependent on second item')
	);


	public function renderDefault()
	{
		if ($this->isAjax()) {
			$this->redrawControl('form');
		}
	}


	protected function createComponentForm()
	{
		$form = new Form();

		$items = array('first item', 'second item', 'empty item');
		$form->addSelect('main', 'Main', $items);

		$form->addDependentSelect('second', 'Dependent', $form['main'], callback($this, 'loadItems'))
			->controlPrototype->data('dependent-select', 'true');

		$form->addText('text', 'Some input')
			->setRequired();

		$form->addSubmit('send', 'Send');

		$form->addSubmit('load', 'Load')
			->setValidationScope(FALSE)
			->controlPrototype->data('dependent-select-loader', 'true');

		$form->onSuccess[] = callback($this, 'formSubmitted');
		return $form;
	}


	public function loadItems($parent)
	{
		if (!$parent->getValue()) {
			return reset(static::$items);
		}
		return isset(static::$items[$parent->getValue()]) ? static::$items[$parent->getValue()] : array();
	}


	public function formSubmitted(Form $form)
	{
		if (!$form['send']->isSubmittedBy()) {
			return;
		}

		$values = $form->getValues();
		dump($values);
	}
}

```

Example template:
```html
<html>
    <head>
		<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
		<script src="{$basePath}/jquery.nette-ajax.js"></script>
		<script>
			$(document).ready(function () {
				$('[data-dependent-select-loader]').hide();

				$(document).on('change', '[data-dependent-select]', function () {
					$(this).closest('form').find('[data-dependent-select-loader]').ajaxSubmit(function (payload) {
						jQuery.nette.success(payload);
						$('[data-dependent-select-loader]').hide();
					});
				});
			});
		</script>
	</head>
	<body>
		{snippet form}
			{control form}
		{/snippet}
	</body>
</html>
```

DateInput/DateTimeInput/TimeInput
---------------------------------

Additional requirements:
- jQuery
- jQuery UI
- http://trentrichardson.com/examples/timepicker/jquery-ui-timepicker-addon.js

Example presenter:
```
namespace App;

use Square\Forms\Form;

class DateTimePresenter extends BasePresenter
{

    protected function createComponentForm()
	{
		$form = new Form();

		$form->addDate('date', 'Date');

		$form->addDateTime('datetime', 'DateTime');

		$form->addTime('time', 'Time');

		$form->addSubmit('send', 'Send');

		$form->onSuccess[] = callback($this, 'formSubmitted');
		return $form;
	}


	public function formSubmitted(Form $form)
	{
		$values = $form->getValues();
		dump($values);
	}
}
```

Example template:
```html
<html>
    <head>
		<link href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css" rel="stylesheet">

		<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
		<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
		<script src="{$basePath}/jquery-ui-timepicker-addon.js"></script>

		<script>
			$(document).ready(function () {
				$('[data-date-input]').datepicker();
				$('[data-datetime-input]').datetimepicker();
				$('[data-time-input]').timepicker();
			});
		</script>
	</head>
	<body>
		{control form}
	</body>
</html>
```
