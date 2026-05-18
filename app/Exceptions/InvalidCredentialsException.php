<?php

namespace App\Exceptions;

use Exception;

class InvalidCredentialsException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'success' => false,
            'message' => $this->message,
        ], 401);
    }
}
