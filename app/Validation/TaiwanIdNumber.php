<?php

namespace App\Validation;

class TaiwanIdNumber
{
    public function taiwan_id(
        string $str,
        string $fields = null,
        array $data = []
    ): bool {
        // 先確認基本格式
        if (! preg_match('/^[A-Z][12][0-9]{8}$/', $str)) {
            return false;
        }

        // 英文字母對應的數值
        $letters = [
            'A' => 10,
            'B' => 11,
            'C' => 12,
            'D' => 13,
            'E' => 14,
            'F' => 15,
            'G' => 16,
            'H' => 17,
            'I' => 34,
            'J' => 18,
            'K' => 19,
            'L' => 20,
            'M' => 21,
            'N' => 22,
            'O' => 35,
            'P' => 23,
            'Q' => 24,
            'R' => 25,
            'S' => 26,
            'T' => 27,
            'U' => 28,
            'V' => 29,
            'W' => 32,
            'X' => 30,
            'Y' => 31,
            'Z' => 33,
        ];

        $letterValue = $letters[$str[0]];

        $n1 = intdiv($letterValue, 10);
        $n2 = $letterValue % 10;

        $sum =
            $n1 +
            $n2 * 9 +
            ((int) $str[1]) * 8 +
            ((int) $str[2]) * 7 +
            ((int) $str[3]) * 6 +
            ((int) $str[4]) * 5 +
            ((int) $str[5]) * 4 +
            ((int) $str[6]) * 3 +
            ((int) $str[7]) * 2 +
            ((int) $str[8]);

        $checkDigit = (int) $str[9];

        return (($sum + $checkDigit) % 10) === 0;
    }
}