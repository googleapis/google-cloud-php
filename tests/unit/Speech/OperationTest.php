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

namespace Google\Cloud\Tests\Unit\Speech;

use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Speech\Connection\ConnectionInterface;
use Google\Cloud\Speech\Operation;
use Google\Cloud\Speech\Result;
use Prophecy\Argument;

/**
 * @group speech
 */
class OperationTest extends \PHPUnit_Framework_TestCase
{
    public $connection;
    public $operationName = 'myOperation';
    public $operationData = [
        'name' => 'abcdefg'
    ];

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
    }

    public function getOperation($connection, array $data = [])
    {
        return new Operation($connection->reveal(), $this->operationName, $data);
    }

    public function testIsCompleteTrue()
    {
        $operation = $this->getOperation($this->connection, $this->operationData + [
            'done' => true
        ]);

        $this->assertTrue($operation->isComplete());
    }

    public function testIsCompleteFalse()
    {
        $operation = $this->getOperation($this->connection, $this->operationData);

        $this->assertFalse($operation->isComplete());
    }

    public function testGetsResults()
    {
        $operation = $this->getOperation($this->connection, $this->operationData + [
            'response' => [
                'results' => [
                    [
                        'alternatives' => []
                    ]
                ]
            ]
        ]);
        $results = $operation->results();

        $this->assertContainsOnlyInstancesOf(Result::class, $results);
    }

    public function testDoesExistTrue()
    {
        $this->connection->getOperation([
                'name' => $this->operationName,
            ])
            ->willReturn($this->operationData)
            ->shouldBeCalledTimes(1);
        $operation = $this->getOperation($this->connection);

        $this->assertTrue($operation->exists());
    }

    public function testDoesExistFalse()
    {
        $this->connection->getOperation([
                'name' => $this->operationName,
            ])
            ->willThrow(new NotFoundException(null))
            ->shouldBeCalledTimes(1);
        $operation = $this->getOperation($this->connection);

        $this->assertFalse($operation->exists());
    }

    public function testGetsInfo()
    {
        $this->connection->getOperation(Argument::any())->shouldNotBeCalled();
        $operation = $this->getOperation($this->connection, $this->operationData);

        $this->assertEquals($this->operationData, $operation->info());
    }

    public function testGetsInfoWithReload()
    {
        $this->connection->getOperation([
                'name' => $this->operationName
            ])
            ->willReturn($this->operationData)
            ->shouldBeCalledTimes(1);
        $operation = $this->getOperation($this->connection);

        $this->assertEquals($this->operationData, $operation->info());
    }

    public function testGetsName()
    {
        $operation = $this->getOperation($this->connection);

        $this->assertEquals($this->operationName, $operation->name());
    }
}
