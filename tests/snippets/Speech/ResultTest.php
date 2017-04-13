<?php
/**
 * Copyright 2017 Google Inc.
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
use Google\Cloud\Speech\Result;
use Prophecy\Argument;

/**
 * @group speech
 */
class ResultTest extends SnippetTestCase
{
    private $transcript;
    private $resultData;
    private $result;

    public function setUp()
    {
        $this->transcript = 'hello world';
        $this->resultData = [
            'alternatives' => [
                [
                    'transcript' => $this->transcript,
                    'confidence' => 1.0
                ]
            ]
        ];

        $this->result = new Result($this->resultData);
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Result::class);
        $connectionStub = $this->prophesize(ConnectionInterface::class);
        $connectionStub->recognize(Argument::any())
            ->willReturn(['name' => 'foo']);
        $snippet->addLocal('connectionStub', $connectionStub->reveal());
        $snippet->insertAfterLine(4, '$reflection = new \ReflectionClass($speech);
            $property = $reflection->getProperty(\'connection\');
            $property->setAccessible(true);
            $property->setValue($speech, $connectionStub);
            $property->setAccessible(false);'
        );

        $snippet->replace("__DIR__  . '/audio.flac'", '"php://temp"');

        $res = $snippet->invoke('result');
    }

    public function testAlternatives()
    {
        $snippet = $this->snippetFromMethod(Result::class, 'alternatives');
        $snippet->addLocal('result', $this->result);

        $res = $snippet->invoke();
        $this->assertEquals($this->transcript . PHP_EOL, $res->output());
    }

    public function testTopAlternative()
    {
        $snippet = $this->snippetFromMethod(Result::class, 'topAlternative');
        $snippet->addLocal('result', $this->result);

        $res = $snippet->invoke();
        $this->assertEquals($this->transcript, $res->output());
    }

    public function testInfo()
    {
        $snippet = $this->snippetFromMethod(Result::class, 'info');
        $snippet->addLocal('result', $this->result);

        $res = $snippet->invoke();
        $this->assertEquals($this->transcript, $res->output());
    }
}
