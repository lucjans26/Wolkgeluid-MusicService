<?php

namespace App\Classes\Responses;

class InvalidResponse extends Response
{
    public $error;

    public function __construct(string $error)
    {
        $this->success = false;
        $this->error = $error;
    }
}
