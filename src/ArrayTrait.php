<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud;

/**
 * Provides basic array helper methods.
 */
trait ArrayTrait
{
    /**
     * Pluck a value out of an array.
     *
     * @param string $key
     * @param array $arr
     * @return string
     * @throws \InvalidArgumentException
     */
    private function pluck($key, array &$arr)
    {
        if (!isset($arr[$key])) {
            throw new \InvalidArgumentException(
                "Key $key does not exist in the provided array."
            );
        }

        $value = $arr[$key];
        unset($arr[$key]);
        return $value;
    }

    /**
     * Pluck a subset of an array.
     *
     * @param string $keys
     * @param array $arr
     * @return string
     * @throws \InvalidArgumentException
     */
    private function pluckArray(array $keys, &$arr)
    {
        $values = [];

        foreach ($keys as $key) {
            $values[$key] = $this->pluck($key, $arr);
        }

        return $values;
    }

    /**
     * Determine whether given array is associative.
     *
     * @param array $arr
     * @return bool
     */
    private function isAssoc(array $arr)
    {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}
