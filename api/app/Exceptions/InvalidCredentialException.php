<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Traits\ApiResponse;

class InvalidCredentialException extends Exception
{
    use ApiResponse;

    public function render(): JsonResponse
    {
        return $this->responseUnauthorized('wrong email or password');
    }
}
