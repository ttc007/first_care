<?php 
namespace App\Service;

interface ServiceInterface{
	public function save($dTO);
	public function get($id);
}