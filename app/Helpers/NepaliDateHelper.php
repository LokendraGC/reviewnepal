<?php

namespace App\Helpers;

use Carbon\Carbon;
use Anuzpandey\LaravelNepaliDate\LaravelNepaliDate;

class NepaliDateHelper
{
    public static function toNepaliDate($date)
    {
        if (!$date) {
            return null;
        }

        $carbon = $date instanceof Carbon
            ? $date
            : Carbon::parse($date);

        return LaravelNepaliDate::from(
            $carbon,
        
        )->toNepaliDate(format: 'j F Y');
    }
}