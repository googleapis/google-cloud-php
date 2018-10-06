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
 */
class DataUtil
{
    private static $isLittleEndian = false;

    public static function init()
    {
        self::$isLittleEndian = (pack("Q", 2) === pack("P", 2));
    }

    public static function isSystemLittleEndian()
    {
        return self::$isLittleEndian;
    }

    /**
     * Utility method to convert integer value in to 64 bit signed BigEndian
     * representation.
     *
     * @param string|int $intValue Integer value to convert to.
     * @return string Returns string of bytes representing 64 bit big signed BigEndian.
     * @throws \InvalidArgumentException If value is not numberic.
     */
    public static function intToByteString($intValue)
    {
        if (!is_numeric($intValue)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Expected argument to be of type int, instead got \'%s\'.',
                    gettype($intValue)
                )
            );
        }
        $bytes = implode(unpack("C*", pack("q", $intValue)));
        if (self::isSystemLittleEndian()) {
            return strrev($bytes);
        }
        return $bytes;
    }

    /**
     * Convertes string bytes of 64 bit signed BigEndian to int.
     *
     * @param string|array $bytes String of bytes to convert.
     * @return int Integer value of the string bytes.
     */
    public static function byteStringToInt($bytes)
    {
        return intval($bytes);
    }
}

DataUtil::init();
