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

namespace Google\Cloud\Storage\Tests\Snippet;

use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Storage\Connection\ConnectionInterface;
use Google\Cloud\Storage\HmacKey;
use Prophecy\Argument;

/**
 * @group storage
 * @group storage-hmackey
 */
class HmacKeyTest extends SnippetTestCase
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
        ]);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(HmacKey::class);
        $snippet->addLocal('accessId', 'foo');
        $res = $snippet->invoke('hmacKey');
        $this->assertInstanceOf(HmacKey::class, $res->returnVal());
    }

    public function testAccessId()
    {
        $snippet = $this->snippetFromMethod(HmacKey::class, 'accessId');
        $snippet->addLocal('hmacKey', $this->key);

        $res = $snippet->invoke('accessId');
        $this->assertEquals($this->metadata['accessId'], $res->returnVal());
    }

    public function testReload()
    {
        $newMetadata = array_merge($this->metadata, ['foo' => 'bar']);
        $this->connection->getHmacKey(Argument::any())->willReturn($newMetadata);
        $this->key->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(HmacKey::class, 'reload');
        $snippet->addLocal('hmacKey', $this->key);
        $res = $snippet->invoke('keyMetadata');
        $this->assertEquals($newMetadata, $res->returnVal());
    }

    public function testInfo()
    {
        $snippet = $this->snippetFromMethod(HmacKey::class, 'info');
        $snippet->addLocal('hmacKey', $this->key);

        $this->assertEquals($this->metadata, $snippet->invoke('keyMetadata')->returnVal());
    }

    public function testUpdate()
    {
        $this->connection->updateHmacKey(Argument::withEntry('state', 'INACTIVE'))
            ->willReturn($this->metadata);

        $this->key->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(HmacKey::class, 'update');
        $snippet->addLocal('hmacKey', $this->key);

        $snippet->invoke();
    }

    public function testDelete()
    {
        $this->connection->deleteHmacKey(Argument::any())
            ->willReturn(null);

        $this->key->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(HmacKey::class, 'delete');
        $snippet->addLocal('hmacKey', $this->key);

        $snippet->invoke();
    }
}
