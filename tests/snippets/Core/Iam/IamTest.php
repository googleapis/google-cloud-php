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

namespace Google\Cloud\Tests\Snippets\Core\Iam;

use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Core\Iam\Iam;
use Google\Cloud\Core\Iam\IamConnectionInterface;
use Prophecy\Argument;

/**
 * @group iam
 */
class IamTest extends SnippetTestCase
{
    private $policyData;
    private $resource;

    private $connection;
    private $policy;

    public function setUp()
    {
        $this->policyData = [];
        $this->resource = 'testObject';

        $this->connection = $this->prophesize(IamConnectionInterface::class);
        $this->iam = \Google\Cloud\Dev\stub(Iam::class, [$this->connection->reveal(), $this->resource]);
        $this->iam->___setProperty('connection', $this->connection->reveal());
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Iam::class);
        $res = $snippet->invoke('iam');

        $this->assertInstanceOf(Iam::class, $res->returnVal());
    }

    public function testPolicy()
    {
        $snippet = $this->snippetFromMethod(Iam::class, 'policy');
        $snippet->addLocal('iam', $this->iam);

        $this->connection->getPolicy(Argument::any())
            ->shouldBeCalled()
            ->willReturn('foo');

        $this->iam->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('policy');

        // The actual value returned doesn't matter. in the real world
        // it's an array. Here it can be anything, so long as we are getting
        // the value of $policy.
        $this->assertEquals('foo', $res->returnVal());
    }

    public function testSetPolicy()
    {
        $snippet = $this->snippetFromMethod(Iam::class, 'setPolicy');
        $snippet->addLocal('iam', $this->iam);

        $this->connection->getPolicy(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'bindings' => [
                    ['members' => ['users:admin@domain.com']]
                ]
            ]);

        $this->connection->setPolicy([
            'policy' => [
                'bindings' => [
                    ['members' => 'user:test@example.com']
                ]
            ],
            'resource' => $this->resource
        ])->shouldBeCalled()->willReturn('foo');

        $this->iam->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('policy');

        $this->assertEquals('foo', $res->returnVal());
    }

    public function testTestPermissions()
    {
        $permissions = [
            'pubsub.topics.publish',
            'pubsub.topics.attachSubscription'
        ];

        $snippet = $this->snippetFromMethod(Iam::class, 'testPermissions');
        $snippet->addLocal('iam', $this->iam);

        $this->connection->testPermissions([
            'permissions' => $permissions,
            'resource' => $this->resource
        ])
            ->shouldBeCalled()
            ->willReturn(['permissions' => $permissions]);

        $this->iam->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('allowedPermissions');
        $this->assertEquals($permissions, $res->returnVal());
    }

    public function testReload()
    {
        $snippet = $this->snippetFromMethod(Iam::class, 'reload');
        $snippet->addLocal('iam', $this->iam);

        $this->connection->getPolicy(Argument::any())
            ->shouldBeCalled()
            ->willReturn('foo');

        $this->iam->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke('policy');
        $this->assertEquals('foo', $res->returnVal());
    }
}
