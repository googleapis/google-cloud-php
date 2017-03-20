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

namespace Google\Cloud\Tests\Snippets\Storage;

use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Storage\Acl;
use Google\Cloud\Storage\Connection\ConnectionInterface;
use Prophecy\Argument;

/**
 * @group storage
 */
class AclTest extends SnippetTestCase
{
    private $connection;
    private $acl;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->acl = \Google\Cloud\Dev\stub(Acl::class, [
            $this->connection->reveal(),
            'bucketAccessControls',
            []
        ]);
    }
    public function testClass()
    {
        $snippet = $this->snippetFromClass(Acl::class);

        $res = $snippet->invoke('acl');
        $this->assertInstanceOf(Acl::class, $res->returnVal());
    }

    public function testDelete()
    {
        $snippet = $this->snippetFromMethod(Acl::class, 'delete');
        $snippet->addLocal('acl', $this->acl);

        $this->connection->deleteAcl(Argument::any())
            ->shouldBeCalled();

        $this->acl->___setProperty('connection', $this->connection->reveal());

        $snippet->invoke();
    }

    public function testGet()
    {
        $snippet = $this->snippetFromMethod(Acl::class, 'get');
        $snippet->addLocal('acl', $this->acl);

        $this->connection->getAcl(Argument::any())
            ->shouldBeCalled()
            ->willReturn('foo');

        $this->acl->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('res');
        $this->assertEquals('foo', $res->returnVal());
    }

    public function testAdd()
    {
        $snippet = $this->snippetFromMethod(Acl::class, 'add');
        $snippet->addLocal('acl', $this->acl);

        $this->connection->insertAcl(Argument::any())
            ->shouldBecalled();

        $this->acl->___setProperty('connection', $this->connection->reveal());

        $snippet->invoke();
    }

    public function testUpdate()
    {
        $snippet = $this->snippetFromMethod(Acl::class, 'update');
        $snippet->addlocal('acl', $this->acl);

        $this->connection->patchAcl(Argument::any())
            ->shouldBeCalled();

        $this->acl->___setProperty('connection', $this->connection->reveal());
        $snippet->invoke();
    }
}
