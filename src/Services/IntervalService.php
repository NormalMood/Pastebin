<?php

namespace Pastebin\Services;

use Pastebin\Kernel\Database\DatabaseInterface;
use Pastebin\Models\Interval;

class IntervalService
{
    public function __construct(
        private DatabaseInterface $database
    ) {
    }

    /**
     * Summary of all
     * @return array<Interval>
     */
    public function all(): array
    {
        $intervals = $this->database->get(table: 'intervals');
        return array_map(
            callback: fn ($interval): Interval =>
                new Interval(
                    id: $interval['interval_id'],
                    name: $interval['name']
                ),
            array: $intervals
        );
    }
}
