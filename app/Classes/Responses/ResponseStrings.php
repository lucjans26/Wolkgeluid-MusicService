<?php

namespace App\Classes\Responses;

abstract class ResponseStrings
{
    const SUCCESS = 'success';
    const NOT_FOUND = 'not found';
    const DELETED = 'entity deleted';
    const UPDATED = 'entity updated';
    const UNAUTHORIZED = 'unauthorized';
    const INVALID = 'invalid request';
    const INTERNAL_ERROR = 'internal server error';
}
