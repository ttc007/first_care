<?php 

namespace App\ModelView;
use Cake\Log\Log;

class BlogModelView extends ModelView{
	var $id;
	var $title;
	var $content;

	public function validate(){
		$errors = [];
		if(strlen($this->title) < 20){
			$errors['title'] = 'The title length must be greater than 20 character!!';
		}

		if(strlen($this->content) < 120){
			$errors['content'] = 'The content length must be greater than 120 character!!';
		}

		return $errors;
	}
}