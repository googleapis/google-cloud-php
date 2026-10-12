<?php
/**
 * Copyright 2025 Google LLC
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

namespace Google\Cloud\Spanner\Tests\Unit;

use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Uuid;
use PHPUnit\Framework\TestCase;

/**
 * @group spanner
 */
class UuidTest extends TestCase
{
    public function testUuid()
    {
        $val = 'f47ac10b-58cc-4372-a567-0e02b2c3d479';
        $uuid = new Uuid($val);

        $this->assertEquals($val, $uuid->get());
        $this->assertEquals($val, (string) $uuid);
        $this->assertEquals($val, $uuid->formatAsString());
        $this->assertEquals(Database::TYPE_UUID, $uuid->type());
    }

    public function testUuidLowercase()
    {
        $val = 'F47AC10B-58CC-4372-A567-0E02B2C3D479';
        $uuid = new Uuid($val);

        $this->assertEquals(strtolower($val), $uuid->get());
    }

    public function testInvalidUuid()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid UUID format');

        new Uuid('invalid-uuid');
    }
}
