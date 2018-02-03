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

namespace Google\Cloud\Tests\Unit\Debugger;

use Google\Cloud\Debugger\FormatMessage;
use Google\Cloud\Debugger\Reference;
use Google\Cloud\Debugger\StatusMessage;
use PHPUnit\Framework\TestCase;

/**
 * @group debugger
 */
class StatusMessageTest extends TestCase
{
    use JsonTestTrait;

    public function testSerializes()
    {
        $message = new StatusMessage(false, StatusMessage::REFERENCE_VARIABLE_NAME, new FormatMessage('format', ['param1', 'param2']));
        $expected = [
            'isError' => false,
            'refersTo' => 'VARIABLE_NAME',
            'description' => [
                'format' => 'format',
                'parameters' => ['param1', 'param2']
            ]
        ];
        $this->assertProducesEquivalentJson($expected, $message);
    }
}
