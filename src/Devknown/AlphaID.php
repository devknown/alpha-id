<?php

namespace Devknown;

/**
 * AlphaID class
 */
class AlphaID
{
    private static $baseChars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    private static $globalKey = '';

    /**
     * Set the global key
     *
     * @param  string $key
     */
    public static function config($key)
    {
        if (!is_string($key)) {
            throw new InvalidArgumentException('Invalid input. The key must be a string.');
        }

        self::$globalKey = $key;
    }

    /**
     * Encode a number
     *
     * @param  int $number
     * @param  string $key
     * @return string
     */
    public static function convertNumber($number, $key = '')
    {
        if (!is_numeric($number)) {
            throw new InvalidArgumentException('Invalid input. The number must be numeric.');
        }

        if (empty($key)) {
            $key = self::$globalKey;
        }

        // Perform a simple encryption or hashing operation on the number using the key
        $encryptedNumber = $number ^ crc32($key);

        $baseLength = strlen(self::$baseChars);
        $convertedString = '';
        $lookup = str_split(self::$baseChars);

        while ($encryptedNumber > 0) {
            $convertedString = $lookup[$encryptedNumber % $baseLength] . $convertedString;
            $encryptedNumber = (int)($encryptedNumber / $baseLength);
        }

        return $convertedString;
    }

    /**
     * Decode a string
     *
     * @param  string $convertedString
     * @param  string $key
     * @return int
     */
    public static function recoverNumber($convertedString, $key = '')
    {
        if (!is_string($convertedString)) {
            throw new InvalidArgumentException('Invalid input. The encoded string must be a string.');
        }

        if (empty($key)) {
            $key = self::$globalKey;
        }

        $baseLength = strlen(self::$baseChars);
        $recoveredNumber = 0;
        $stringLength = strlen($convertedString);
        $lookup = array_flip(str_split(self::$baseChars));

        for ($i = 0; $i < $stringLength; $i++) {
            $recoveredNumber = $recoveredNumber * $baseLength + $lookup[$convertedString[$i]];
        }

        // Reverse the encryption or hashing operation using the key
        $originalNumber = $recoveredNumber ^ crc32($key);

        return $originalNumber;
    }

    /**
     * Short name function redirects to convertNumber
     */
    public static function convert($numberToBeConverted, $key = '')
    {
        return self::convertNumber($numberToBeConverted, $key);
    }

    /**
     * Short name function redirects to recoverNumber
     */
    public static function recover($stringToBeRecovered, $key = '')
    {
        return self::recoverNumber($stringToBeRecovered, $key);
    }
}
