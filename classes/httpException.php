<?php
class httpException extends Exception
{
    public function __construct($code, $message)
    {
        die($code.' '.$message);
    }
}