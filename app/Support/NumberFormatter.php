<?php

namespace App\Support;

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;

class NumberFormatter
{
    public static function formatNumber($value, int $scale = 2, string $decimal = ',', string $thousands = '.') : string
    {
        if ($value === null || $value === '') {
            return $scale === 0 ? '0' : ('0' . $decimal . str_repeat('0', $scale));
        }

        $stringValue = is_string($value) ? trim($value) : (string) $value;

        try {
            $decimalValue = BigDecimal::of($stringValue)->toScale($scale, RoundingMode::HALF_UP);
        } catch (\Throwable $exception) {
            return number_format((float) $value, $scale, $decimal, $thousands);
        }

        $plain = $decimalValue->__toString();
        $sign = '';

        if (str_starts_with($plain, '-')) {
            $sign = '-';
            $plain = substr($plain, 1);
        }

        $parts = explode('.', $plain, 2);
        $integer = $parts[0] ?? '0';
        $fraction = $parts[1] ?? '';

        $integer = preg_replace('/\B(?=(\d{3})+(?!\d))/', $thousands, $integer);

        if ($scale === 0) {
            return $sign . $integer;
        }

        $fraction = str_pad($fraction, $scale, '0');

        return $sign . $integer . $decimal . $fraction;
    }
}
