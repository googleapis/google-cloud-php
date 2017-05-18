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

namespace Google\Cloud\Tests\Snippets\Core\LongRunning;

use Google\Cloud\Core\LongRunning\LongRunningConnectionInterface;
use Google\Cloud\Core\LongRunning\LongRunningOperation;
use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Prophecy\Argument;

/**
 * @group core
 * @group longrunning
 */
class LongRunningOperationTest extends SnippetTestCase
{
    private $connection;
    private $operation;
    private $callables;

    const NAME = 'operations/foo';
    const TYPE = 'test-type';

    public function setUp()
    {
        $this->connection = $this->prophesize(LongRunningConnectionInterface::class);
        $this->callables = [
            ['typeUrl' => self::TYPE, 'callable' => function($res) { return $res; }]
        ];
        $this->operation = \Google\Cloud\Dev\stub(LongRunningOperation::class, [
            $this->connection->reveal(),
            self::NAME,
            $this->callables
        ]);
    }

    public function testName()
    {
        $snippet = $this->snippetFromMethod(LongRunningOperation::class, 'name');
        $snippet->addLocal('operation', $this->operation);

        $res = $snippet->invoke('name');
        $this->assertEquals(self::NAME, $res->returnVal());
    }

    public function testDone()
    {
        $this->connection->get(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'done' => true,
                'response' => [],
                'metadata' => [
                    'typeUrl' => self::TYPE
                ]
            ]);

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(LongRunningOperation::class, 'done');
        $snippet->addLocal('operation', $this->operation);

        $res = $snippet->invoke();
        $this->assertEquals('The operation is done!', $res->output());
    }

    public function testStateInProgress()
    {
        $this->connection->get(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'done' => false
            ]);

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(LongRunningOperation::class, 'state');
        $snippet->addLocal('operation', $this->operation);
        $snippet->addUse(LongRunningOperation::class);

        $res = $snippet->invoke();
        $this->assertEquals('Operation is in progress', $res->output());
    }

    public function testStateDone()
    {
        $this->connection->get(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'done' => true,
                'response' => [
                    'foo' => 'bar'
                ],
                'metadata' => [
                    'typeUrl' => self::TYPE
                ]
            ]);

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(LongRunningOperation::class, 'state');
        $snippet->addUse(LongRunningOperation::class);
        $snippet->addLocal('operation', $this->operation);

        $res = $snippet->invoke();
        $this->assertEquals('Operation succeeded', $res->output());
    }

    public function testStateFailed()
    {
        $this->connection->get(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'done' => true,
                'response' => [],
                'error' => [],
                'metadata' => [
                    'typeUrl' => self::TYPE
                ]
            ]);

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(LongRunningOperation::class, 'state');
        $snippet->addLocal('operation', $this->operation);
        $snippet->addUse(LongRunningOperation::class);

        $res = $snippet->invoke();
        $this->assertEquals('Operation failed', $res->output());
    }

    public function testResult()
    {
        $result = [
            'foo' => 'bar'
        ];
        $this->connection->get(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'done' => true,
                'response' => $result,
                'metadata' => [
                    'typeUrl' => self::TYPE
                ]
            ]);

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(LongRunningOperation::class, 'result');
        $snippet->addLocal('operation', $this->operation);

        $res = $snippet->invoke('result');
        $this->assertEquals($result, $res->returnVal());
    }

    public function testError()
    {
        $result = [
            'foo' => 'bar'
        ];
        $this->connection->get(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'done' => true,
                'response' => [],
                'error' => $result,
                'metadata' => [
                    'typeUrl' => self::TYPE
                ]
            ]);

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(LongRunningOperation::class, 'error');
        $snippet->addLocal('operation', $this->operation);

        $res = $snippet->invoke('error');
        $this->assertEquals($result, $res->returnVal());
    }

    public function testInfo()
    {
        $result = [
            'done' => true,
            'response' => [
                'foo' => 'bar'
            ],
            'metadata' => [
                'typeUrl' => self::TYPE
            ]
        ];
        $this->connection->get(Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn($result);

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(LongRunningOperation::class, 'info');
        $snippet->addLocal('operation', $this->operation);

        $res = $snippet->invoke('info');
        $this->assertEquals($result, $res->returnVal());

        $snippet->invoke();
    }

    public function testReload()
    {
        $result = [
            'done' => true,
            'response' => [
                'foo' => 'bar'
            ],
            'metadata' => [
                'typeUrl' => self::TYPE
            ]
        ];
        $this->connection->get(Argument::any())
            ->shouldBeCalledTimes(2)
            ->willReturn($result);

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(LongRunningOperation::class, 'reload');
        $snippet->addLocal('operation', $this->operation);

        $res = $snippet->invoke('result');
        $this->assertEquals($result, $res->returnVal());

        $snippet->invoke();
    }

    public function testPollUntilComplete()
    {
        $result1 = [
            'done' => false,
        ];

        $result2 = [
            'done' => true,
            'response' => [
                'foo' => 'bar'
            ],
            'metadata' => [
                'typeUrl' => self::TYPE
            ]
        ];

        $this->connection->get(Argument::any())
            ->shouldBeCalledTimes(2)
            ->willReturn($result1, $result2);

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(LongRunningOperation::class, 'pollUntilComplete');
        $snippet->addLocal('operation', $this->operation);

        $res = $snippet->invoke('result');
        $this->assertEquals($result2['response'], $res->returnVal());
    }

    public function testCancel()
    {
        $this->connection->cancel(Argument::any())
            ->shouldBeCalled();

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(LongRunningOperation::class, 'cancel');
        $snippet->addLocal('operation', $this->operation);

        $res = $snippet->invoke();
    }

    public function testDelete()
    {
        $this->connection->delete(Argument::any())
            ->shouldBeCalled();

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(LongRunningOperation::class, 'delete');
        $snippet->addLocal('operation', $this->operation);

        $res = $snippet->invoke();
    }
}
