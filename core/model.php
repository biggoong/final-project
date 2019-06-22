<?php
class Model
{
    protected $db = false;

    public function __construct()
    {
     self::$db = sql::getInstance();   
    }
}