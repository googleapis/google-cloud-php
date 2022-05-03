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

use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Storage\Connection\ConnectionInterface;
use Google\Cloud\Storage\HmacKey;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Prophecy\Argument;

/**
 * @group storage
 * @group storage-hmackey
 */
class HmacKeyTest extends TestCase
{
    const PROJECT = 'project';

    private $connection;

    private $key;

    private $metadata = [
        'accessId' => 'foo'
    ];

    public function set_up()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->key = TestHelpers::stub(HmacKey::class, [
            $this->connection->reveal(),
            self::PROJECT,
            $this->metadata['accessId'],
            $this->metadata
        ], ['connection', 'info']);
    }

    public function testAccessId()
    {
        $this->assertEquals($this->metadata['accessId'], $this->key->accessId());
    }

    public function testReload()
    {
        $this->connection->getHmacKey([
            'projectId' => self::PROJECT,
            'accessId' => $this->metadata['accessId']
        ])->shouldBeCalledTimes(2)->willReturn($this->metadata);

        $this->key->___setProperty('connection', $this->connection->reveal());

        $this->assertEquals($this->metadata, $this->key->reload());

        // Make sure reload() always runs a service call.
        $this->key->reload();
    }

    public function testInfo()
    {
        $this->connection->getHmacKey([
            'projectId' => self::PROJECT,
            'accessId' => $this->metadata['accessId']
        ])->shouldBeCalledTimes(1)->willReturn($this->metadata);

        $this->key->___setProperty('connection', $this->connection->reveal());
        $this->key->___setProperty('info', []);

        $this->assertEquals($this->metadata, $this->key->info());

        // Test that the 2nd call uses cached result.
        $this->assertEquals($this->metadata, $this->key->info());
    }

    public function testInfoCached()
    {
        $this->connection->getHmacKey(Argument::any())
            ->shouldNotBeCalled();

        $this->key->___setProperty('connection', $this->connection->reveal());
        $this->assertEquals($this->metadata, $this->key->info());
    }

    public function testUpdate()
    {
        $state = 'INACTIVE';
        $newMetadata = array_merge($this->metadata, ['state' => $state]);
        $this->connection->updateHmacKey([
            'accessId' => $this->metadata['accessId'],
            'projectId' => self::PROJECT,
            'state' => $state
        ])->shouldBeCalled()->willReturn($newMetadata);

        $this->key->___setProperty('connection', $this->connection->reveal());

        $res = $this->key->update($state);
        $this->assertEquals($newMetadata, $res);
        $this->assertEquals($newMetadata, $this->key->info());
    }

    public function testDelete()
    {
        $this->connection->deleteHmacKey([
            'accessId' => $this->metadata['accessId'],
            'projectId' => self::PROJECT
        ])->shouldBeCalled();

        $this->key->___setProperty('connection', $this->connection->reveal());

        $this->key->delete();
    }
}
