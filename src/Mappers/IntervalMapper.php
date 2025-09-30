<?php

namespace Pastebin\Mappers;

use Pastebin\Models\Interval;

class IntervalMapper
{
    private static array $intervals = [
        'INFINITY' => 'Не удалять',
        '10 MINUTES' => '10 минут',
        '1 HOUR' => '1 час',
        '1 DAY' => '1 день',
        '1 WEEK' => '1 неделя',
        '2 WEEKS' => '2 недели',
        '1 MONTH' => '1 месяц',
        '6 MONTHS' => '6 месяцев',
        '1 YEAR' => '1 год'
    ];

    private static array $expirations = [
        'INFINITY' => 'Никогда',
        '10 MINUTES' => '10 минут',
        '1 HOUR' => '1 час',
        '1 DAY' => '1 день',
        '1 WEEK' => '1 неделя',
        '2 WEEKS' => '2 недели',
        '1 MONTH' => '1 месяц',
        '6 MONTHS' => '6 месяцев',
        '1 YEAR' => '1 год'
    ];

    public static function getExpiration(string $key): string
    {
        return self::$expirations[$key];
    }

    /**
     * Summary of getValue
     * @param array<Interval> $intervals
     * @return array<Interval>
     */
    public static function getMapped(array $intervals): array
    {
        $result = [];
        foreach ($intervals as $interval) {
            $result[] = new Interval(id: $interval->id(), name: self::$intervals[$interval->name()]);
        }
        return $result;
    }
}
