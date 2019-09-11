<?php
namespace App\Repository;

interface RepositoryInterface{
	public function save($entity);
	public function get($id);
	public function getList($conditions);

	public function find($conditions);
}