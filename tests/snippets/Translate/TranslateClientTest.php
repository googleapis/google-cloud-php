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

namespace Google\Cloud\Tests\Snippets\Translate;

use Google\Cloud\Dev\Snippet\SnippetTestCase;
use Google\Cloud\Translate\Connection\ConnectionInterface;
use Google\Cloud\Translate\TranslateClient;
use Prophecy\Argument;

/**
 * @group translate
 */
class TranslateClientTest extends SnippetTestCase
{
    private $connection;
    private $client;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->client = \Google\Cloud\Dev\stub(TranslateClient::class);
        $this->client->___setProperty('connection', $this->connection->reveal());
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(TranslateClient::class);
        $res = $snippet->invoke('translate');

        $this->assertInstanceOf(TranslateClient::class, $res->returnVal());
    }

    public function testTranslate()
    {
        $snippet = $this->snippetFromMethod(TranslateClient::class, 'translate');
        $snippet->addLocal('translate', $this->client);

        $this->connection->listTranslations(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'data' => [
                    'translations' => [
                        [
                            'detectedSourceLanguage' => 'en',
                            'translatedText' => 'foobar',
                        ]
                    ]
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('foobar', $res->output());
    }

    public function testTranslateBatch()
    {
        $snippet = $this->snippetFromMethod(TranslateClient::class, 'translateBatch');
        $snippet->addLocal('translate', $this->client);

        $this->connection->listTranslations(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'data' => [
                    'translations' => [
                        [
                            'detectedSourceLanguage' => 'en',
                            'translatedText' => 'foobar',
                        ]
                    ]
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('foobar', $res->output());
    }

    public function testDetectLanguage()
    {
        $snippet = $this->snippetFromMethod(TranslateClient::class, 'detectLanguage');
        $snippet->addLocal('translate', $this->client);

        $this->connection->listDetections(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'data' => [
                    'detections' => [
                        [
                            [
                                'language' => 'en',
                                'confidence' => 1
                            ]
                        ]
                    ]
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('en', $res->output());
    }

    public function testDetectLanguageBatch()
    {
        $snippet = $this->snippetFromMethod(TranslateClient::class, 'detectLanguageBatch');
        $snippet->addLocal('translate', $this->client);

        $this->connection->listDetections(Argument::any())
            ->shouldBeCalled()
            ->willReturn([
                'data' => [
                    'detections' => [
                        [
                            [
                                'language' => 'en',
                                'confidence' => 1
                            ]
                        ]
                    ]
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('en', $res->output());
    }

    public function testLanguages()
    {
        $snippet = $this->snippetFromMethod(TranslateClient::class, 'languages');
        $snippet->addLocal('translate', $this->client);

        $this->connection->listLanguages(Argument::any())
            ->shouldbeCalled()
            ->willReturn([
                'data' => [
                    'languages' => [
                        [
                            'language' => 'en',
                            'name' => 'English'
                        ]
                    ]
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('en', $res->output());
    }

    public function testLocalizedLanguages()
    {
        $snippet = $this->snippetFromMethod(TranslateClient::class, 'localizedLanguages');
        $snippet->addLocal('translate', $this->client);

        $this->connection->listLanguages(Argument::any())
            ->shouldbeCalled()
            ->willReturn([
                'data' => [
                    'languages' => [
                        [
                            'language' => 'en',
                            'name' => 'English'
                        ]
                    ]
                ]
            ]);

        $this->client->___setProperty('connection', $this->connection->reveal());

        $res = $snippet->invoke();
        $this->assertEquals('en', $res->output());
    }
}
