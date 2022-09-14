<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Vision\Tests\System;

use Google\Cloud\Vision\VisionClient;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group vision
 */
class VisionTestCase extends TestCase
{
    protected static $vision;
    private static $hasSetUp = false;

    public static function set_up_before_class()
    {
        if (self::$hasSetUp) {
            return;
        }

        $keyFilePath = getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH');
        self::$vision = new VisionClient([
            'keyFilePath' => $keyFilePath
        ]);
        self::$hasSetUp = true;
    }

    protected function getFixtureFilePath($file)
    {
        return __DIR__ .'/fixtures/'. $file;
    }
}
