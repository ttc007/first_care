<?php
namespace App\Entity;

/**
 * 
 */
class Entity
{
	function __construct($dTO)
	{
		foreach ($dTO as $key => $value) {
			if($key=='id') $this->id = $value;
			elseif(in_array($key, $this->fillable)) $this->$key = $value;
		}
	}

}