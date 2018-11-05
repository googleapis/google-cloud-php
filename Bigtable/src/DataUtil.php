<?php
/**
 * Copyright 2018, Google LLC All rights reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Bigtable;

/**
 * This class contains utility to convert integer to byte string and backward.
 * This utility class is only supported on 64 bit machine with PHP version > 5.5.
 */
class DataUtil
{
    private static $isLittleEndian;
    private static $isSupported;

    /**
     * Check if system is little-endian.
     *
     * @return bool
     */
    public static function isSystemLittleEndian()
    {
        if (self::$isLittleEndian === null) {
            self::$isLittleEndian = (pack("P", 2) === pack("Q", 2));
        }
        return self::$isLittleEndian;
    }

    /**
     * Check if {@see Google\Cloud\Bigtable\DataUtil::intToByteString()} and
     * {@see Google\Cloud\Bigtable\DataUtil::byteStringToInt()} supported on
     * the current platform.
     *
     * @return bool
     */
    public static function isSupported()
    {
        if (self::$isSupported === null) {
            self::$isSupported = PHP_VERSION_ID >= 50600 && PHP_INT_SIZE > 4;
        }
        return self::$isSupported;
    }

    /**
     * Utility method to convert an integer to a 64-bit big-endian signed integer byte string.
     *
     * @param int $intValue Integer value to convert to.
     * @return string Returns a string of bytes representing a 64-bit big-endian signed integer.
     * @throws \InvalidArgumentException If value is not an integer.
     * @throws \RuntimeException If called on PHP version <= 5.5.
     */
    public static function intToByteString($intValue)
    {
        if (!self::isSupported()) {
            throw new \RuntimeException('This utility is only supported on 64 bit machines with PHP version > 5.5.');
        }
        if (!is_int($intValue)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Expected argument to be of type int, instead got \'%s\'.',
                    gettype($intValue)
                )
            );
        }
        $bytes = pack("J", $intValue);
        return $bytes;
    }

    /**
     * Converts a 64-bit big-endian signed integer represented as a byte string to an integer.
     *
     * @param string $bytes String of bytes to convert.
     * @return int Integer value of the string bytes.
     * @throws \RuntimeException If called on PHP version <= 5.5.
     */
    public static function byteStringToInt($bytes)
    {
        if (!self::isSupported()) {
            throw new \RuntimeException('This utility is only supported on 64 bit machines with PHP version > 5.5.');
        }
        if (self::isSystemLittleEndian()) {
            $bytes = strrev($bytes);
        }
        return unpack("q", $bytes)[1];
    }
}
