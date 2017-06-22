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

namespace Google\Cloud\Tests\Snippets\Speech;

use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Speech\Connection\ConnectionInterface;
use Google\Cloud\Speech\Operation;
use Google\Cloud\Speech\Result;
use Google\Cloud\Speech\SpeechClient;
use Prophecy\Argument;

/**
 * @group speech
 */
class OperationTest extends SnippetTestCase
{
    private $opData;
    private $connection;
    private $operation;

    public function setUp()
    {
        $this->opData = [
            'done' => true,
            'name' => 'operation',
            'response' => [
                'results' => [
                    [
                        'alternatives' => 'foo'
                    ]
                ]
            ]
        ];

        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->operation = \Google\Cloud\Dev\stub(Operation::class, [
            $this->connection->reveal(),
            $this->opData['name'],
            $this->opData
        ]);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Operation::class);

        $connectionStub = $this->prophesize(ConnectionInterface::class);

        $connectionStub->longRunningRecognize(Argument::any())
            ->willReturn(['name' => 'foo']);

        $snippet->addLocal('connectionStub', $connectionStub->reveal());
        $snippet->insertAfterLine(4, '$reflection = new \ReflectionClass($speech);
            $property = $reflection->getProperty(\'connection\');
            $property->setAccessible(true);
            $property->setValue($speech, $connectionStub);
            $property->setAccessible(false);'
        );

        $snippet->replace("__DIR__  . '/audio.flac'", '"php://temp"');

        $res = $snippet->invoke('operation');
    }

    public function testIsComplete()
    {
        $snippet = $this->snippetFromMethod(Operation::class, 'isComplete');
        $snippet->addLocal('operation', $this->operation);

        $res = $snippet->invoke();
        $this->assertEquals('The operation is complete!', $res->output());
    }

    public function testResults()
    {
        $snippet = $this->snippetFromMethod(Operation::class, 'results');
        $snippet->addLocal('operation', $this->operation);

        $res = $snippet->invoke('results');
        $this->assertContainsOnlyInstancesOf(Result::class, $res->returnVal());
    }

    public function testExists()
    {
        $snippet = $this->snippetFromMethod(Operation::class, 'exists');
        $snippet->addLocal('operation', $this->operation);

        $res = $snippet->invoke();
        $this->assertEquals('The operation exists.', $res->output());
    }

    public function testInfo()
    {
        $snippet = $this->snippetFromMethod(Operation::class, 'info');
        $snippet->addLocal('operation', $this->operation);

        $res = $snippet->invoke();
        $this->assertEquals(print_r($this->opData['response'], true), $res->output());
    }

    public function testReload()
    {
        $snippet = $this->snippetFromMethod(Operation::class, 'reload');
        $snippet->addLocal('operation', $this->operation);

        $this->connection->getOperation(Argument::any())
            ->shouldBeCalled()
            ->willReturn($this->opData);

        $this->operation->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals(print_r($this->opData['response'], true), $res->output());
    }

    public function testName()
    {
        $snippet = $this->snippetFromMethod(Operation::class, 'name');
        $snippet->addLocal('operation', $this->operation);

        $res = $snippet->invoke();
        $this->assertEquals($this->opData['name'], $res->output());
    }
}
