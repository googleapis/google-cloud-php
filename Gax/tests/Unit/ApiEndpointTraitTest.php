<?php
/**
 * Copyright 2018 Google Inc.
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

namespace Google\ApiCore\Tests\Unit;

use Google\ApiCore\ApiEndpointTrait;
use Google\ApiCore\ValidationException;
use PHPUnit\Framework\TestCase;

class ApiEndpointTraitTest extends TestCase
{
    use ApiEndpointTrait;

    /**
     * @dataProvider normalizeApiEndpointData
     */
    public function testNormalizeApiEndpoint($ApiEndpointString, $expectedAddress, $expectedPort)
    {
        list($actualAddress, $actualPort) = self::normalizeApiEndpoint($ApiEndpointString);
        $this->assertSame($expectedAddress, $actualAddress);
        $this->assertSame($expectedPort, $actualPort);
    }

    public function normalizeApiEndpointData()
    {
        return [
            ['simple.com:123', 'simple.com', '123'],
            ['really.long.and.dotted:456', 'really.long.and.dotted', '456'],
            ['noport.com', 'noport.com', self::$defaultPort],
        ];
    }

    /**
     * @dataProvider normalizeApiEndpointInvalidData
     */
    public function testNormalizeApiEndpointInvalid($ApiEndpointString)
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Invalid apiEndpoint');

        self::normalizeApiEndpoint($ApiEndpointString);
    }

    public function normalizeApiEndpointInvalidData()
    {
        return [
            ['too.many:colons:123'],
            ['too:many:colons'],
        ];
    }
}
