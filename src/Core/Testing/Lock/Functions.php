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

namespace Google\Cloud\Core\Testing\Lock;

class Functions
{
    public static function flock($handle, $type)
    {
        return MockValues::$flockReturnValue;
    }

    public static function fopen($file, $mode)
    {
        $val = MockValues::$fopenReturnValue;

        if (is_callable($val)) {
            return $val($file, $mode);
        }

        return $val;
    }

    public static function sem_acquire($id)
    {
        return MockValues::$sem_acquireReturnValue;
    }

    public static function sem_release($id)
    {
        return MockValues::$sem_releaseReturnValue;
    }

    public static function sem_get($key)
    {
        $val = MockValues::$sem_getReturnValue;

        if (is_callable($val)) {
            return $val($key);
        }

        return $val;
    }
}
