<?php

namespace Pastebin\Kernel\Utils;

use DateTime;
use DateTimeZone;

class TimestampTZ
{
    public static function convert(int $timestamp): string
    {
        $timestampTZ = new DateTime();
        $timestampTZ->setTimestamp($timestamp);
        $timestampTZ->setTimezone(new DateTimeZone('UTC'));
        return $timestampTZ->format('Y-m-d H:i:sP');
    }
}
