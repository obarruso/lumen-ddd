<?php

namespace App\Common\Domain\Exceptions;

use Exception;

final class ValidationException extends Exception
{
    protected $errors;

    public function __construct($message = 'Validation failed', $errors = [])
    {
        parent::__construct($message);
        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
