<?php


namespace App\Core;


use Prettus\Validator\LaravelValidator;

class TaskValidator
{
    protected static $rules = [
        'username' => ['required',],
        'description'  => ['required',],
        'email'=> ['required', 'email',],
    ];

    protected static $errors = [];

    public static function validate(array $params)
    {
        foreach ($params as $key => $value)
        {
            if (array_key_exists($key, self::$rules))
            {
                foreach (self::$rules[$key] as $rule)
                {
                    if (!self::validateByRule($key, $value, $rule))
                        break;
                }
            }
        }

        return self::$errors;
    }

    public static function validateByRule($key, $value, $rule)
    {
        switch ($rule)
        {
            case 'required':
                if (empty($value)) {
                    self::$errors[] = "Field {$key} is required";
                    return false;
                }
                break;
            case 'email':
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    self::$errors[] = "Field {$key} is not valid";
                    return false;
                }
                break;
        }

        return true;
    }
}