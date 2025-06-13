<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Traits\ApiResponse;

class InvalidCredentialException extends Exception
{
    use ApiResponse;

    public function render(): JsonResponse
    {
        return $this->unauthorized('wrong email or password');
    }
}
