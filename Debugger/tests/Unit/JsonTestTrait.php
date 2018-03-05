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

namespace Google\Cloud\Debugger\Tests\Unit;

trait JsonTestTrait
{
    private function assertProducesEquivalentJson($array1, $array2)
    {
        if (!is_array($array2)) {
            $array2 = json_decode(json_encode($array2), true);
        }
        foreach ($array1 as $key => $value) {
            $this->assertArrayHasKey($key, $array2);
            if (is_array($value)) {
                $this->assertProducesEquivalentJson($value, $array2[$key]);
            } else {
                $this->assertEquals($value, $array2[$key]);
            }
        }
    }
}
