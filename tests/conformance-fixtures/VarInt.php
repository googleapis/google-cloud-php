<?php
/**
 * Copyright 2017 Google Inc.
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

class VarInt
{
    public static function encode($number)
    {
        $buf = '';
        while (true) {
            $toWrite = $number & 0x7f;
            $number = $number >> 7;
            if ($number) {
                $buf .= pack('c', $toWrite | 0x80);
            } else {
                $buf .= pack('c', $toWrite);
                break;
            }
        }
        return $buf;
    }

    public static function decode($bytes, $index)
    {
        $shift = 0;
        $result = 0;
        while (true) {
            $i = unpack('C', substr($bytes, $index, 1))[1];
            $index += 1;
            $result = $result | (($i & 0x7f) << $shift);
            $shift += 7;
            if (!($i & 0x80)) {
                break;
            }
        }
        return [$result, $index];
    }
}
