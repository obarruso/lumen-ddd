<?php

use App\Common\Domain\Exceptions\UnauthorizedUserException;

if (!function_exists('authorize')) {
    /* @throws UnauthorizedUserException */
    function authorize($ability, $policy, $arguments = []): bool
    {
        // Check if the code is running in a shell environment (e.g., command line)
        if (app()->runningInConsole()) {
            return true;
        }

        if ($policy::{$ability}(...$arguments)) {
            return true;
        }
        throw new UnauthorizedUserException();
    }
}

if (!function_exists('fake') && class_exists(\Faker\Factory::class)) {
    /**
     * Get a faker instance.
     *
     * @param  string|null  $locale
     * @return \Faker\Generator
     */
    function fake($locale = null)
    {
        if (app()->bound('config')) {
            $locale ??= app('config')->get('app.faker_locale');
        }

        $locale ??= 'en_US';

        $abstract = \Faker\Generator::class . ':' . $locale;

        if (!app()->bound($abstract)) {
            app()->singleton($abstract, fn () => \Faker\Factory::create($locale));
        }

        return app()->make($abstract);
    }
}

if (!function_exists('bcrypt')) {
    /**
     * Hash the given value against the bcrypt algorithm.
     *
     * @param  string  $value
     * @param  array  $options
     * @return string
     */
    function bcrypt($value, $options = [])
    {
        return app('hash')->driver('bcrypt')->make($value, $options);
    }
}

if (!function_exists('validateParameters')) {

    /**
     * Validate an array of parameters based on specified rules.
     *
     * @param array $data   The data to validate as an associative array.
     * @param array $rules  The validation rules for each parameter.
     *
     * If validation fails, a ValidationException is thrown with error messages.
     * @throws \Illuminate\Validation\ValidationException  
     *
     * @return void
     */
    function validateParameters(array $data, array $rules)
    {
        $errors = [];

        foreach ($rules as $field => $rule) {
            if (!array_key_exists($field, $data)) {
                if (strpos($rule, 'required') !== false) {
                    $errors[$field] = "The field '$field' ir required";
                }
                continue; 
            }

            $fieldRules = explode('|', $rule);
            foreach ($fieldRules as $fieldRule) {
                $parts = explode(':', $fieldRule);
                $ruleName = $parts[0];

                switch ($ruleName) {
                    case 'required':
                        if (empty($data[$field])) {
                            $errors[$field] = "The field '$field' ir required";
                        }
                        break;
                    case 'string':
                        if (!is_string($data[$field])) {
                            $errors[$field] = "The field '$field' have to by of type string";
                        }
                        break;
                    case 'numeric':
                        if (!is_numeric($data[$field])) {
                            $errors[$field] = "The field '$field' have to by of type number";
                        }
                        break;
                    case 'email':
                        if (!filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
                            $errors[$field] = "The field '$field' is not valid email";
                        }
                        break;
                    default:
                        break;
                }
            }
        }
        if (!empty($errors)) {
            throw new \App\Common\Domain\Exceptions\ValidationException(null, $errors);
        }
    }
}
