<?php

namespace Pastebin\Services;

use Pastebin\Kernel\Database\DatabaseInterface;
use Pastebin\Models\Syntax;

class SyntaxService
{
    public function __construct(
        private DatabaseInterface $database
    ) {
    }

    /**
     * Summary of all
     * @return array<Syntax>
     */
    public function all(): array
    {
        $syntaxes = $this->database->get(table: 'syntaxes');
        return array_map(
            callback: fn ($syntax): Syntax =>
                new Syntax(
                    id: $syntax['syntax_id'],
                    name: $syntax['name'],
                    codemirror5Mode: $syntax['codemirror5_mode']
                ),
            array: $syntaxes
        );
    }
}
