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
use Google\Cloud\Storage\CreatedHmacKey;
use Google\Cloud\Storage\HmacKey;
use Google\Cloud\Storage\StorageClient;
use Prophecy\Argument;

/**
 * @group storage
 * @group storage-hmackey
 */
class CreatedHmacKeyTest extends SnippetTestCase
{
    const ACCESS_ID = 'aid';
    const SECRET = 'secrettttt';

    private $connection;
    private $createdKey;

    public function set_up()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);

        $this->createdKey = new CreatedHmacKey(
            $this->prophesize(HmacKey::class)->reveal(),
            self::SECRET
        );
    }

    public function testClass()
    {
        $this->connection->createHmacKey(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'metadata' => [
                    'foo' => 'bar',
                    'accessId' => self::ACCESS_ID
                ],
                'secret' => self::SECRET
            ]);

        $client = TestHelpers::stub(StorageClient::class);
        $client->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromClass(CreatedHmacKey::class);
        $snippet->addLocal('serviceAccountEmail', 'foo@bar.com');
        $snippet->replace('$storage = new StorageClient();', '');
        $snippet->addLocal('storage', $client);

        $res = $snippet->invoke('response');
        $this->assertInstanceOf(CreatedHmacKey::class, $res->returnVal());
    }

    public function testHmacKey()
    {
        $snippet = $this->snippetFromMethod(CreatedHmacKey::class, 'hmacKey');
        $snippet->addLocal('response', $this->createdKey);

        $this->assertInstanceOf(
            HmacKey::class,
            $snippet->invoke('key')->returnVal()
        );
    }

    public function testSecret()
    {
        $snippet = $this->snippetFromMethod(CreatedHmacKey::class, 'secret');
        $snippet->addLocal('response', $this->createdKey);

        $this->assertEquals(
            self::SECRET,
            $snippet->invoke('secret')->returnVal()
        );
    }
}
