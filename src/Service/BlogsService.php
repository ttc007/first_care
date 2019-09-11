<?php 
namespace App\Service;

use App\Repository\BlogsRepository;
use App\Entity\BlogEntity;
use App\Service\ServiceInterface;
use App\ModelView\BlogModelView;

class BlogsService implements ServiceInterface{
	var $blogRepository;

	function __construct() {
    	$this->blogsRepository = new BlogsRepository();
    }

    public function save($blogDTO){
    	$blogEntity = new BlogEntity($blogDTO);
    	$this->blogsRepository->save($blogEntity);
    }

    public function get($id){
    	$blogEntity = $this->blogsRepository->get($id);
    	$blogModelView = new BlogModelView((array)$blogEntity);
    	return $blogModelView;
    }

    public function find($conditions){
    	return $this->blogsRepository->find($conditions);
    }

    public function delete($id){
        $this->blogsRepository->delete($id);
    }
}