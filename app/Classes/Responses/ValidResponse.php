<?php

namespace App\Classes\Responses;

class ValidResponse
{
    public $result;

    function __construct($_result)
    {
        $this->success = true;
        $this->result = $_result;
    }
}
