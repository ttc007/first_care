<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;


class FormErrorHelper extends Helper
{
    public function create($errors) {
        if(!$errors)return "";
        $result = "<script>";
        foreach ($errors as $key => $error) {
            $result .= 'var x = document.getElementById("'.$key.'"); x.classList.add("error");'.
                        'var txt = document.createTextNode("'.$error.'");'.
                        'var paragraph = document.createElement("p");paragraph.classList.add("msg-error");paragraph.classList.add("mt-2");'.
                        'paragraph.appendChild(txt);'.
                        'x.parentNode.appendChild(paragraph);';
        }
        $result .= "</script>";
        return $result;
    }
}