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

namespace Google\Cloud\Spanner\Tests\Unit;

use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Proto;
use PHPUnit\Framework\TestCase;
use Testing\Data\User;

/**
 * @group spanner
 */
class ProtoTest extends TestCase
{
    private User $testUser;
    private Proto $proto;
    private string $testUserData;

    public function setUp(): void
    {
        $this->testUser = new User(['name' => 'John']);
        $this->testUserData = base64_encode($this->testUser->serializeToString());
        $this->proto = new Proto($this->testUserData, 'testing.data.User');
    }

    public function testGet()
    {
        $this->assertEquals($this->testUser, $this->proto->get());
    }

    public function testGetValue()
    {
        $this->assertEquals($this->testUserData, $this->proto->getValue());
    }

    public function testGetProtoTypeFqn()
    {
        $this->assertEquals('testing.data.User', $this->proto->getProtoTypeFqn());
    }

    public function testFormatAsString()
    {
        $this->assertEquals($this->testUserData, $this->proto->formatAsString());
    }

    public function testCast()
    {
        $this->assertEquals($this->testUserData, (string) $this->proto);
    }

    public function testType()
    {
        $this->assertEquals(
            Database::TYPE_PROTO,
            $this->proto->type()
        );
    }

    public function testGetWithUnknownMappingThrowsException()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Unable to decode proto value. Descriptor not found for testing.data.Unknown.');

        $value = 'this-data-doesnt-matter';
        $proto = new Proto($value, 'testing.data.Unknown');

        // With unknown types, users can still get the data
        $this->assertEquals($value, $proto->getValue());
        $this->assertEquals('testing.data.Unknown', $proto->getProtoTypeFqn());

        // getting the message will throw an exception as the mapping doesn't exist
        $proto->get();
    }
}
