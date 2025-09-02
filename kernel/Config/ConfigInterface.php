<?php

namespace Pastebin\Kernel\Config;

interface ConfigInterface
{
    public function get(string $key, $default = null);
}
