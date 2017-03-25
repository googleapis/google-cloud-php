<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Core\Batch;

/**
 * A utility class related to System V IPC.
 */
class SysvUtils
{
    const TYPE_DIRECT = 1;
    const TYPE_FILE = 2;

    /**
     * Create a SystemV IPC key for the given id number.
     *
     * @param int $idNum An id number of the job
     *
     * @return int
     */
    public static function getSysvKey($idNum)
    {
        $base = ftok(__FILE__, 'S');
        if ($base == PHP_INT_MAX) {
            $base = 1;
        }
        return $base + $idNum;
    }
}
