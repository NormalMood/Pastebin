<?php

namespace Pastebin\Kernel\Validator;

interface ValidatorInterface
{
    public function validate(array $data, array $validationRules): bool;

    public function errors(): array;

    public function errorValues(): array;
}
