<?php

class FacebookParser
{
    public $page_id = '';

    public function __construct($id = null){
        if ($id != null){
            $this->$page_id = $id;
        }
    }

    
}