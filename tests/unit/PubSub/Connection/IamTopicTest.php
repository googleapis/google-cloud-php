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

namespace Google\Cloud\Tests\Unit\PubSub\Connection;

use Google\Cloud\PubSub\Connection\ConnectionInterface;
use Google\Cloud\PubSub\Connection\IamTopic;
use Prophecy\Argument;

/**
 * @group pubsub
 */
class IamTopicTest extends \PHPUnit_Framework_TestCase
{
    public function testProxies()
    {
        $connection = $this->prophesize(ConnectionInterface::class);
        $connection->getTopicIamPolicy(Argument::withEntry('foo', 'bar'))
            ->willReturn('test')
            ->shouldBeCalledTimes(1);

        $connection->setTopicIamPolicy(Argument::withEntry('foo', 'bar'))
            ->willReturn('test')
            ->shouldBeCalledTimes(1);

        $connection->testTopicIamPermissions(Argument::withEntry('foo', 'bar'))
            ->willReturn('test')
            ->shouldBeCalledTimes(1);

        $iamTopic = new IamTopic($connection->reveal());

        $this->assertEquals('test', $iamTopic->getPolicy(['foo' => 'bar']));
        $this->assertEquals('test', $iamTopic->setPolicy(['foo' => 'bar']));
        $this->assertEquals('test', $iamTopic->testPermissions(['foo' => 'bar']));
    }
}
