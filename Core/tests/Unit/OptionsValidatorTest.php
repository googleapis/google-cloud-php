<?php
/**
 * Copyright 2025 Google Inc.
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

namespace Google\Cloud\Core\Tests\Unit;

use Google\ApiCore\Options\CallOptions;
use Google\Cloud\Core\OptionsValidator;
use PHPUnit\Framework\TestCase;

/**
 * @group core
 */
class OptionsValidatorTest extends TestCase
{
    private $validator;

    public function setUp(): void
    {
        $this->validator = new OptionsValidator();
    }

    public function testStripUnknownOptions()
    {
        $options = [
            'parameters' => ['a' => 1],
            'queryOptions' => ['optimizerVersion' => '1'],
            'requestOptions' => ['priority' => 1],
            'timeoutMillis' => 100,
            'unknown' => 'strip me'
        ];

        $stripped = $this->validator->stripUnknownOptions(
            $options,
            ['parameters'],
            CallOptions::class,
            DummyMessage::class
        );

        $this->assertArrayHasKey('parameters', $stripped);
        $this->assertArrayHasKey('queryOptions', $stripped); // From DummyMessage
        $this->assertArrayHasKey('requestOptions', $stripped); // From DummyMessage
        $this->assertArrayHasKey('timeoutMillis', $stripped); // From CallOptions
        $this->assertArrayNotHasKey('unknown', $stripped);
    }
}
