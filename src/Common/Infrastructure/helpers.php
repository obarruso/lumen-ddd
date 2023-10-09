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
            // Verifica si el campo está presente en los datos
            if (!array_key_exists($field, $data)) {
                if (strpos($rule, 'required') !== false) {
                    $errors[$field] = "El campo '$field' es requerido.";
                }
                continue; // Pasa al siguiente campo si no está presente
            }

            // Divide las reglas por coma y verifica cada una
            $fieldRules = explode('|', $rule);
            foreach ($fieldRules as $fieldRule) {
                $parts = explode(':', $fieldRule);
                $ruleName = $parts[0];

                // Valida según la regla
                switch ($ruleName) {
                    case 'required':
                        if (empty($data[$field])) {
                            $errors[$field] = "El campo '$field' es requerido.";
                        }
                        break;
                    case 'string':
                        if (!is_string($data[$field])) {
                            $errors[$field] = "El campo '$field' debe ser una cadena de texto.";
                        }
                        break;
                    case 'numeric':
                        if (!is_numeric($data[$field])) {
                            $errors[$field] = "El campo '$field' debe ser un valor numérico.";
                        }
                        break;
                    case 'email':
                        if (!filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
                            $errors[$field] = "El campo '$field' no es una dirección de correo electrónico válida.";
                        }
                        break;
                    default:
                        break;
                }
            }
        }
        if (!empty($errors)) {
            throw \Illuminate\Validation\ValidationException::withMessages($errors);
        }
    }
}
