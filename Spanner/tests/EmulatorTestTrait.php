<?php
/**
 * Copyright 2020 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Spanner\Tests;

/**
 * Provides checks for whether to skip tests when the emulator is being used
 *
 * @experimental
 * @internal
 */
trait EmulatorTestTrait
{
    /**
     * Checks if the test should be skip, and if it should, marks the test as skipped
     *
     * @experimental
     * @internal
     */
    public function checkAndSkipEmulatorTests()
    {
        if ($this->shouldSkipEmulatorTests()) {
            $this->markTestSkipped('This test is not supported by the emulator.');
        }
    }

    /**
     * @return bool True if emulator is enabled, otherwise false
     *
     * @experimental
     * @internal
     */
    public function shouldSkipEmulatorTests()
    {
        return (bool) getenv("SPANNER_EMULATOR_HOST");
    }
}
