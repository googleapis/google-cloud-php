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

namespace Google\Cloud\Spanner\Tests\Unit;

use Google\Cloud\Spanner\CommitTimestamp;
use Google\Cloud\Spanner\Database;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group spanner
 */
class CommitTimestampTest extends TestCase
{
    private $t;

    public function set_up()
    {
        $this->t = new CommitTimestamp;
    }

    public function testType()
    {
        $this->assertEquals(Database::TYPE_TIMESTAMP, $this->t->type());
    }

    /**
     * @dataProvider methodProvider
     */
    public function testValues($method)
    {
        $this->assertEquals(CommitTimestamp::SPECIAL_VALUE, $this->t->$method());
    }

    public function methodProvider()
    {
        return [
            ['get'],
            ['formatAsString'],
            ['__toString'],
        ];
    }
}
