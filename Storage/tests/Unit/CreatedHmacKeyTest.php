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

namespace Google\Cloud\Storage\Tests\Unit;

use Google\Cloud\Storage\CreatedHmacKey;
use Google\Cloud\Storage\HmacKey;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group storage
 * @group storage-hmackey
 */
class CreatedHmacKeyTest extends TestCase
{
    const ACCESS_ID = 'aid';
    const SECRET = 'secrettttt';

    private $createdKey;

    public function set_up()
    {
        $this->createdKey = new CreatedHmacKey(
            $this->prophesize(HmacKey::class)->reveal(),
            self::SECRET
        );
    }

    public function testHmacKey()
    {
        $this->assertInstanceOf(HmacKey::class, $this->createdKey->hmacKey());
    }

    public function testSecret()
    {
        $this->assertEquals(self::SECRET, $this->createdKey->secret());
    }
}
