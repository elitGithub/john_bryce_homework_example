<?php


namespace Elit1\ObjectOriented\Forms;


use Elit1\ObjectOriented\Model;

class Form
{
	public static function begin(string $action, string $method): Form
	{
		echo sprintf('<form action="%s" method="%s">', $action, $method);
		return new Form();
	}

	public static function end()
	{
		echo '</form>';
	}

	public function field(Model $model, $attribute): InputField
	{
		return new InputField($model, $attribute);
	}
}