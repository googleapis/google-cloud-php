<?php
/**
 * Copyright 2019 Google LLC
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

namespace Google\Cloud\Core\Testing;

use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestListener;
use PHPUnit\Framework\TestSuite;
use PHPUnit\Framework\Warning;
use PHPUnit\Framework\AssertionFailedError;
use Throwable;

/**
 * Garbage collector for tests
 * @internal
 */
class GcTestListener implements TestListener
{
    public function endTestSuite(TestSuite $suite): void
    {
        gc_collect_cycles();
    }

    public function addError(Test $test, Throwable $t, float $time): void {}

    public function addWarning(Test $test, Warning $e, float $time): void {}

    public function addFailure(Test $test, AssertionFailedError $e, float $time): void {}

    public function addIncompleteTest(Test $test, Throwable $t, float $time): void {}

    public function addRiskyTest(Test $test, Throwable $t, float $time): void {}

    public function addSkippedTest(Test $test, Throwable $t, float $time): void {}

    public function startTestSuite(TestSuite $suite): void {}

    public function startTest(Test $test): void {}

    public function endTest(Test $test, float $time): void {}
}
