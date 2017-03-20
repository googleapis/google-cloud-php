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

namespace Google\Cloud\Tests\Spanner;

use Google\Cloud\Core\Int64;
use Google\Cloud\Spanner\Bytes;
use Google\Cloud\Spanner\Connection\ConnectionInterface;
use Google\Cloud\Spanner\Database;
use Google\Cloud\Spanner\Date;
use Google\Cloud\Spanner\Duration;
use Google\Cloud\Spanner\KeyRange;
use Google\Cloud\Spanner\KeySet;
use Google\Cloud\Spanner\Session\SessionClient;
use Google\Cloud\Spanner\SpannerClient;
use Google\Cloud\Spanner\Timestamp;

/**
 * @group spanner
 */
class SpannerClientTest extends \PHPUnit_Framework_TestCase
{
    const PROJECT = 'my-awesome-project';
    const INSTANCE = 'inst';
    const DATABASE = 'db';

    private $client;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->client = \Google\Cloud\Dev\stub(SpannerClient::class);
    }

    public function testConnect()
    {
        $database = $this->client->connect(self::INSTANCE, self::DATABASE);
        $this->assertInstanceOf(Database::class, $database);
        $this->assertEquals(self::DATABASE, $database->name());
    }

    public function testConnectWithInstance()
    {
        $inst = $this->client->instance(self::INSTANCE);
        $database = $this->client->connect($inst, self::DATABASE);
        $this->assertInstanceOf(Database::class, $database);
        $this->assertEquals(self::DATABASE, $database->name());
    }

    public function testKeyset()
    {
        $ks = $this->client->keySet();
        $this->assertInstanceOf(KeySet::class, $ks);
    }

    public function testKeyRange()
    {
        $kr = $this->client->keyRange();
        $this->assertInstanceOf(KeyRange::class, $kr);
    }

    public function testBytes()
    {
        $b = $this->client->bytes('foo');
        $this->assertInstanceOf(Bytes::class, $b);
        $this->assertEquals(base64_encode('foo'), (string)$b);
    }

    public function testDate()
    {
        $d = $this->client->date(new \DateTime);
        $this->assertInstanceOf(Date::class, $d);
    }

    public function testTimestamp()
    {
        $ts = $this->client->timestamp(new \DateTime);
        $this->assertInstanceOf(Timestamp::class, $ts);
    }

    public function testInt64()
    {
        $i64 = $this->client->int64('123');
        $this->assertInstanceOf(Int64::class, $i64);
    }

    public function testDuration()
    {
        $d = $this->client->duration(10, 1);
        $this->assertInstanceOf(Duration::class, $d);
    }

    public function testSessionClient()
    {
        $sc = $this->client->sessionClient();
        $this->assertInstanceOf(SessionClient::class, $sc);
    }
}
