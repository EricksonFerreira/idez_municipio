<?php

namespace App\Exceptions;

use Exception;

class ExternalApiException extends Exception
{
    public function __construct($message = "Erro na API externa", $code = 500, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
