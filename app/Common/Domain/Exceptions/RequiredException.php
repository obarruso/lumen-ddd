<?php

namespace App\Common\Domain\Exceptions;

final class RequiredException extends \DomainException
{
    public function __construct($fieldName)
    {
        parent::__construct(trans('validation.required', ['attribute' => $fieldName]));
    }
}