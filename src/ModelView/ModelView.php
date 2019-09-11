<?php
namespace App\ModelView;

/**
 * 
 */
class ModelView implements ModelViewInterface
{
	function __construct($data)
	{
		foreach ($data as $key => $value) {
			$this->$key = $value;
		}
	}

	public function validate(){}
}