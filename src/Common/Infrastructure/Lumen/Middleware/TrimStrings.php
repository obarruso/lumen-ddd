<?php

namespace App\Common\Infrastructure\Lumen\Middleware;

class TrimStrings extends TransformsRequest
{
    /**
     * The attributes that should not be trimmed.
     *
     * @var array
     */
    protected $except = [
      'current_password',
      'password',
      'password_confirmation',
    ];

    /**
     * Transform the given value.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    protected function transform($key, $value)
    {
        if (in_array($key, $this->except)) {
            return $value;
        }

        return is_string($value) ? trim($value) : $value;
    }
}