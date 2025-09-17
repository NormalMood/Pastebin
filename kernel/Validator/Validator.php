<?php

namespace Pastebin\Kernel\Validator;

class Validator implements ValidatorInterface
{
    private array $data = [];

    private array $errors = [];

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
                if (empty($value)) {
                    return $ruleName;
                }
                break;
            case 'min':
                if (strlen($value ?? '') < $ruleValue) {
                    return "$ruleName:$ruleValue";
                }
                break;
            case 'max':
                if (strlen($value ?? '') > $ruleValue) {
                    return "$ruleName:$ruleValue";
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
        }
        return false;
    }
}
