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

namespace Google\Cloud\Tests\Snippets\Iam;

use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Iam\Iam;
use Google\Cloud\Iam\IamConnectionInterface;
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
        $this->iam = new \IamStub($this->connection->reveal(), $this->resource);
        $this->iam->setConnection($this->connection->reveal());
    }

    public function testPolicy()
    {
        $snippet = $this->method(Iam::class, 'policy');
        $snippet->addLocal('iam', $this->iam);

        $this->connection->getPolicy(Argument::any())
            ->shouldBeCalled()
            ->willReturn('foo');

        $this->iam->setConnection($this->connection->reveal());

        $res = $snippet->invoke('policy');

        // The actual value returned doesn't matter. in the real world
        // it's an array. Here it can be anything, so long as we are getting
        // the value of $policy.
        $this->assertEquals('foo', $res->return());
    }

    public function setPolicy()
    {
        $snippet = $this->method(Iam::class, 'setPolicy');
        $snippet->addLocal('iam', $this->iam);

        $this->connection->getPolicy(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'bindings' => [
                    ['members' => ['users:admin@domain.com']]
                ]
            ]);

        $this->connection->setPolicy([
            'bindings' => [
                ['members' => ['user:test@example.com']]
            ]
        ])->shouldBeCalled()->willReturn('foo');

        $this->iam->setConnection($this->connection->reveal());

        $res = $snippet->invoke('policy');

        $this->assertEquals('foo', $res->return());
    }

    public function testTestPermissions()
    {
        $permissions = [
            'pubsub.topics.publish',
            'pubsub.topics.attachSubscription'
        ];

        $snippet = $this->method(Iam::class, 'testPermissions');
        $snippet->addLocal('iam', $this->iam);

        $this->connection->testPermissions([
            'permissions' => $permissions,
            'resource' => $this->resource
        ])
            ->shouldBeCalled()
            ->willReturn($permissions);

        $this->iam->setConnection($this->connection->reveal());

        $res = $snippet->invoke('allowedPermissions');
        $this->assertEquals($permissions, $res->return());
    }

    public function testReload()
    {
        $snippet = $this->method(Iam::class, 'reload');
        $snippet->addLocal('iam', $this->iam);

        $this->connection->getPolicy(Argument::any())
            ->shouldBeCalled()
            ->willReturn('foo');

        $this->iam->setConnection($this->connection->reveal());

        $res = $snippet->invoke('policy');
        $this->assertEquals('foo', $res->return());
    }
}
