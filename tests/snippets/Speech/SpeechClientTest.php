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
use Google\Cloud\Speech\SpeechClient;
use Prophecy\Argument;

/**
 * @group speech
 */
class SpeechClientTest extends SnippetTestCase
{
    private $testFile;
    private $connection;
    private $client;

    public function setUp()
    {
        $this->testFile = "'" . __DIR__ . '/../fixtures/Speech/demo.flac' . "'";
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->client = \Google\Cloud\Dev\stub(SpeechClient::class, [
            ['languageCode' => 'en-US']
        ]);
        $this->client->___setProperty('connection', $this->connection->reveal());
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(SpeechClient::class);

        $res = $snippet->invoke('speech');
        $this->assertInstanceOf(SpeechClient::class, $res->returnVal());
    }

    public function testRecognize()
    {
        $snippet = $this->snippetFromMethod(SpeechClient::class, 'recognize', 0);
        $snippet->addLocal('speech', $this->client);
        $snippet->replace('__DIR__  . \'/audio.flac\'', $this->testFile);

        $transcript = 'hello world';
        $this->connection->recognize(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'results' => [
                    [
                        'alternatives' => [
                            [
                                'transcript' => $transcript
                            ]
                        ]
                    ]
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals($transcript . PHP_EOL, $res->output());
    }

    public function testRecognizeWithOptions()
    {
        $snippet = $this->snippetFromMethod(SpeechClient::class, 'recognize', 1);
        $snippet->addLocal('speech', $this->client);
        $snippet->replace('__DIR__  . \'/audio.flac\'', $this->testFile);

        $transcript = 'hello world';
        $this->connection->recognize(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'results' => [
                    [
                        'alternatives' => [
                            [
                                'transcript' => $transcript
                            ]
                        ]
                    ]
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals($transcript . PHP_EOL, $res->output());
    }

    public function testBeginRecognizeOperation()
    {
        $snippet = $this->snippetFromMethod(SpeechClient::class, 'beginRecognizeOperation');
        $snippet->addLocal('speech', $this->client);
        $snippet->replace('__DIR__  . \'/audio.flac\'', $this->testFile);

        $this->connection->longRunningRecognize(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['done' => false, 'name' => 'foo']);

        $results = [
            [
                'alternatives' => 'foo'
            ]
        ];

        $this->connection->getOperation(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'done' => true, 'name' => 'foo',
                'response' => [
                    'results' => $results
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals(print_r($results[0]['alternatives'][0], true), $res->output());
    }

    public function testBeginRecognizeOperationWithOptions()
    {
        $snippet = $this->snippetFromMethod(SpeechClient::class, 'beginRecognizeOperation', 1);
        $snippet->addLocal('speech', $this->client);
        $snippet->replace('__DIR__  . \'/audio.flac\'', $this->testFile);

        $this->connection->longRunningRecognize(Argument::any())
            ->shouldBeCalled()
            ->willReturn(['done' => false, 'name' => 'foo']);

        $results = [
            [
                'alternatives' => 'foo'
            ]
        ];

        $this->connection->getOperation(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'done' => true, 'name' => 'foo',
                'response' => [
                    'results' => $results
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals(print_r($results[0]['alternatives'][0], true), $res->output());
    }

    public function testOperation()
    {
        $opName = 'testOperation';

        $snippet = $this->snippetFromMethod(SpeechClient::class, 'operation');
        $snippet->addLocal('speech', $this->client);
        $snippet->addLocal('operationName', $opName);

        $res = $snippet->invoke('operation');
        $this->assertInstanceOf(Operation::class, $res->returnVal());
        $this->assertEquals($opName, $res->returnVal()->name());
    }
}
