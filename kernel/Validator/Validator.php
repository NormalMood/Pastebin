<?php

namespace Pastebin\Kernel\Validator;

use Pastebin\Kernel\Database\DatabaseInterface;

class Validator implements ValidatorInterface
{
    private array $data = [];

    private array $errors = [];

    public function __construct(
        private DatabaseInterface $database
    ) {
    }

    public function validate(array $data, array $validationRules): bool
    {
        $this->data = $data;
        $this->errors = [];
        foreach ($validationRules as $field => $rules) {
            $rules = explode(separator: '|', string: $rules);
            foreach ($rules as $rule) {
                $parts = explode(separator: ':', string: $rule);
                $ruleName = $parts[0];
                $ruleValue = $parts[1] ?? null;
                $error = $this->validateRule($field, $ruleName, $ruleValue);
                if ($error) {
                    $this->errors[$field][] = $error;
                }
            }
        }
        return empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    private function validateRule(string $field, string $ruleName, ?string $ruleValue = null): string|false
    {
        $value = $this->data[$field];
        switch ($ruleName) {
            case 'required':
                if (!isset($value) || $value === '') {
                    return $ruleName;
                }
                break;
            case 'min':
                if (mb_strlen($value ?? '') < $ruleValue) {
                    return $ruleName;
                }
                break;
            case 'max':
                if (mb_strlen($value ?? '') > $ruleValue) {
                    return $ruleName;
                }
                break;
            case 'email':
                if (!filter_var(value: $value, filter: FILTER_VALIDATE_EMAIL)) {
                    return $ruleName;
                }
                break;
            case 'confirmed':
                if (!hash_equals(known_string: $value, user_string: $this->data["{$field}_confirmation"])) {
                    return $ruleName;
                }
                break;
            case 'name':
                if (!preg_match(pattern: '/^[a-zA-Z0-9-_]+$/', subject: $value)) {
                    return $ruleName;
                }
                break;
            case 'unique':
                $parts = explode(separator: ',', string: $ruleValue);
                $table = $parts[0];
                $column = $parts[1];
                $entity = $this->database->first($table, [$column => $value]);
                if (!empty($entity)) {
                    return $ruleName;
                }
                break;
            case 'exists':
                $parts = explode(separator: ',', string: $ruleValue);
                $table = $parts[0];
                $column = $parts[1];
                $entity = $this->database->first($table, [$column => $value]);
                if (empty($entity)) {
                    return $ruleName;
                }
                break;
            case 'max_bytes':
                if (strlen($value) > $ruleValue) {
                    return $ruleName;
                }
                break;
        }
        return false;
    }
}
