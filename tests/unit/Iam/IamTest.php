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

namespace Google\Cloud\Tests\Iam;

use Google\Cloud\Iam\Iam;
use Google\Cloud\Iam\IamConnectionInterface;
use Prophecy\Argument;

/**
 * @group iam
 */
class IamTest extends \PHPUnit_Framework_TestCase
{
    const RESOURCE = 'projects/my-project/topics/my-topic';

    private $connection;

    public function setUp()
    {
        $this->connection = $this->prophesize(IamConnectionInterface::class);
    }

    public function testPolicy()
    {
        $policies = $this->policies();

        $this->connection->getPolicy(Argument::withEntry('foo', 'bar'))
            ->willReturn($policies[0])
            ->shouldBeCalledTimes(1);

        $iam = new Iam($this->connection->reveal(), self::RESOURCE);
        $res = $iam->policy(['foo' => 'bar']);

        $this->assertEquals($res, $policies[0]);
    }

    public function testReload()
    {
        $policies = $this->policies();

        $this->connection->getPolicy(Argument::withEntry('foo', 'bar'))
            ->willReturn($policies[0])
            ->shouldBeCalledTimes(1);

        $iam = new Iam($this->connection->reveal(), self::RESOURCE);
        $iam->reload(['foo' => 'bar']);

        $this->assertEquals($iam->policy(), $policies[0]);
    }

    public function testSetPolicy()
    {
        $policies = $this->policies();

        $this->connection->getPolicy(Argument::any())
            ->willReturn($policies[0]);

        $this->connection->setPolicy(Argument::withEntry('policy', $policies[1]))
            ->willReturn($policies[1]);

        $iam = new Iam($this->connection->reveal(), self::RESOURCE);
        $oldPolicy = $iam->policy();

        $oldPolicy['bindings'][0]['members'][] = 'user:foo@bar.com';

        $iam->setPolicy($oldPolicy);
        $this->assertEquals($iam->policy(), $policies[1]);
    }

    public function testTestPermissions()
    {
        $permissions = [
            'foo', 'bar'
        ];

        $this->connection->testPermissions(Argument::withEntry('permissions', $permissions))
            ->willReturn($permissions);

        $iam = new Iam($this->connection->reveal(), self::RESOURCE);
        $this->assertEquals($permissions, $iam->testPermissions($permissions));
    }

    public function policies()
    {
        return [
            [
                'bindings' => [
                    [
                        'role' => 'roles/role-a',
                        'members' => [
                            'user:test@test.com'
                        ]
                    ], [
                        'role' => 'roles/role-b',
                        'members' => [
                            'group:group@test.com'
                        ]
                    ], [
                        'role' => 'roles/role-c',
                        'members' => [
                            'allUsers'
                        ]
                    ]
                ],
                'etag' => 'foo',
                'version' => 2
            ], [
                'bindings' => [
                    [
                        'role' => 'roles/role-a',
                        'members' => [
                            'user:test@test.com',
                            'user:foo@bar.com'
                        ]
                    ], [
                        'role' => 'roles/role-b',
                        'members' => [
                            'group:group@test.com'
                        ]
                    ], [
                        'role' => 'roles/role-c',
                        'members' => [
                            'allUsers'
                        ]
                    ]
                ],
                'etag' => 'foo',
                'version' => 2
            ]
        ];
    }
}
