<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;


class GiantPaginateHelper extends Helper
{
    var $paginator;
    var $count;
    var $limit;
    var $page;
    var $pageCount;


    public function create($paginator){
        $this->paginator = $paginator;
        $this->page = (int)$paginator['page'];
        $this->limit = (int)$paginator['limit'];
        $this->count = (int)$paginator['count'];
        $this->pageCount = (int)((int)$paginator['count'] / (int)$paginator['limit']) +1;
    }
    public function numbers() {
        $paginator = $this->paginator;
        $result = "";
        for ($i = 1; $i<=$this->pageCount; $i++) {
            $active = "";
            if($i==$this->page) $active = "active";
            $result .= "<li  class='".$active."'><a href='?page=".$i."'>".$i.'</a></li>';
        }

        $result .="";
        return $result;
    }

    public function prev($text){
        $paginator = $this->paginator;
        $result = "";
        if($this->page == 1) {
            $result .= "<li class='disabled'>".$text."</li>";
        } else {
            $result .= "<li><a href='?page=".($this->page-1)."'>".$text."</a></li>";
        }
        return $result;
    }

    public function next($text){
        $paginator = $this->paginator;

        $result = "";
        if($this->page == $this->pageCount) {
            $result .= "<li class='disabled'>".$text."</li>";
        } else {
            $result .= "<li><a href='?page=".($this->page+1)."'>".$text."</a></li>";
        }
        return $result;
    }

    public function counter(){
        if($this->page < $this->pageCount){
            $result = (($this->page-1)*$this->limit+1)." - ".($this->page*$this->limit).__(" of")." ".$this->count ;
        } else {
            $result = (($this->page-1)*$this->limit+1)." - ".$this->count.__(" of")." ".$this->count ;
        }
        
        return $result;
    }
}