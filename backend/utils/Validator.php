<?php
declare(strict_types=1);

require_once __DIR__ . '/exceptions.php';

class Validator
{
    public static function required(array $data, array $fields): void
    {
        foreach ($fields as $field) {
            if (!isset($data[$field]) || trim((string) $data[$field]) === '') {
                throw new ValidationException("Field '$field' is required.");
            }
        }
    }

    public static function length(
        string $value,
        string $field,
        int $min,
        int $max
    ): void {
        $length = strlen($value);

        if ($length < $min || $length > $max) {
            throw new ValidationException(
                "Field '$field' must be between $min and $max characters long."
            );
        }
    }

    public static function integer(
        mixed $value,
        string $field,
        int $min = 0,
        ?int $max = null
    ): void {
        if (filter_var($value, FILTER_VALIDATE_INT) === false) {
            throw new ValidationException(
                "Field '$field' must be a whole number."
            );
        }

        $number = (int) $value;

        if ($number < $min) {
            throw new ValidationException(
                "Field '$field' must be at least $min."
            );
        }

        if ($max !== null && $number > $max) {
            throw new ValidationException(
                "Field '$field' must be at most $max."
            );
        }
    }

    public static function one_of(
        mixed $value,
        string $field,
        array $allowedValues
    ): void {
        if (!in_array($value, $allowedValues, true)) {
            throw new ValidationException(
                "Field '$field' has an invalid value."
            );
        }
    }

    public static function in_future(mixed $value, string $field): void
    {
        if ($value <= date('Y-m-d H:i:s')) {
            throw new ValidationException(
                "Field '$field' must be in the future."
            );
        }
    }

    public static function no_html(mixed $value, string $field): void
    {
        if (preg_match('/[<>]/', (string) $value)) {
            throw new ValidationException(
                "Field '$field' must not contain HTML."
            );
        }
    }
}
