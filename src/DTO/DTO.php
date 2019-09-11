<?php 
namespace App\DTO;

class DTO{
	function __construct($modelView) {
        foreach ($modelView as $key => $value) {
        	$this->$key = $value;
        }
    }
}