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

namespace Google\Cloud\Tests\Snippets\Language;

use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Language\Connection\ConnectionInterface;
use Google\Cloud\Language\LanguageClient;
use Prophecy\Argument;

/**
 * @group language
 */
class LanguageClientTest extends SnippetTestCase
{
    private $client;
    private $connection;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->client = \Google\Cloud\Dev\stub(LanguageClient::class);
        $this->client->___setProperty('connection', $this->connection->reveal());
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(LanguageClient::class);
        $res = $snippet->invoke('language');
        $this->assertInstanceOf(LanguageClient::class, $res->returnVal());
    }

    public function testAnalyzeEntities()
    {
        $this->connection->analyzeEntities(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'entities' => [
                    [
                        'type' => 'PERSON'
                    ]
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(LanguageClient::class, 'analyzeEntities');
        $snippet->addLocal('language', $this->client);

        $res = $snippet->invoke();
        $this->assertEquals('PERSON', $res->output());
    }

    public function testAnalyzeSentiment()
    {
        $this->connection->analyzeSentiment(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'documentSentiment' => [
                    'score' => 1.0
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(LanguageClient::class, 'analyzeSentiment');
        $snippet->addLocal('language', $this->client);

        $res = $snippet->invoke();
        $this->assertEquals("This is a positive message.", $res->output());
    }

    public function testAnalyzeSyntax()
    {
        $this->connection->analyzeSyntax(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'sentences' => [
                    [
                        'text' => [
                            'beginOffset' => 1.0
                        ]
                    ]
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(LanguageClient::class, 'analyzeSyntax');
        $snippet->addLocal('language', $this->client);

        $res = $snippet->invoke();
        $this->assertEquals('1.0', $res->output());
    }

    public function testAnnotateTextAllFeatures()
    {
        $this->connection->annotateText(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'documentSentiment' => [
                    'magnitude' => 999
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(LanguageClient::class, 'annotateText');
        $snippet->addLocal('language', $this->client);

        $this->assertEquals('999', $snippet->invoke()->output());
    }

    public function testAnnotateTextSomeFeatures()
    {
        $this->connection->annotateText(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'tokens' => [
                    [
                        'text' => [
                            'beginOffset' => '2.0'
                        ]
                    ]
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $snippet = $this->snippetFromMethod(LanguageClient::class, 'annotateText', 1);
        $snippet->addLocal('language', $this->client);

        $this->assertEquals('2.0', $snippet->invoke()->output());
    }
}
