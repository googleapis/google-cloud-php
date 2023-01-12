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

namespace Google\Cloud\Language\Tests\Unit;

use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Language\Annotation;
use Google\Cloud\Language\Connection\ConnectionInterface;
use Google\Cloud\Language\LanguageClient;
use Google\Cloud\Storage\StorageObject;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Prophecy\Argument;

/**
 * @group language
 */
class LanguageClientTest extends TestCase
{
    private $client;
    private $connection;

    public function set_up()
    {
        $this->client = TestHelpers::stub(LanguageClient::class);
        $this->connection = $this->prophesize(ConnectionInterface::class);
    }

    /**
     * @dataProvider analyzeDataProvider
     */
    public function testAnalyzeEntities($options, $expectedOptions)
    {
        $content = $options['content'];
        unset($options['content']);
        $this->connection
            ->analyzeEntities($expectedOptions)
            ->willReturn([])
            ->shouldBeCalledTimes(1);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $annotation = $this->client->analyzeEntities($content, $options);

        $this->assertInstanceOf(Annotation::class, $annotation);
    }

    /**
     * @dataProvider analyzeDataProvider
     */
    public function testAnalyzeSentiment($options, $expectedOptions)
    {
        $content = $options['content'];
        unset($options['content']);
        $this->connection
            ->analyzeSentiment($expectedOptions)
            ->willReturn([])
            ->shouldBeCalledTimes(1);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $annotation = $this->client->analyzeSentiment($content, $options);

        $this->assertInstanceOf(Annotation::class, $annotation);
    }

    /**
     * @dataProvider analyzeDataProvider
     */
    public function testAnalyzeEntitySentiment($options, $expectedOptions)
    {
        $content = $options['content'];
        unset($options['content']);
        $this->connection
            ->analyzeEntitySentiment($expectedOptions)
            ->willReturn([])
            ->shouldBeCalledTimes(1);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $annotation = $this->client->analyzeEntitySentiment($content, $options);
        $this->assertInstanceOf(Annotation::class, $annotation);
    }

    /**
     * @dataProvider analyzeDataProvider
     */
    public function testAnalyzeSyntax($options, $expectedOptions)
    {
        $content = $options['content'];
        unset($options['content']);

        $this->connection
            ->analyzeSyntax($expectedOptions)
            ->willReturn([])
            ->shouldBeCalledTimes(1);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $annotation = $this->client->analyzeSyntax($content, $options);

        $this->assertInstanceOf(Annotation::class, $annotation);
    }

    /**
     * @dataProvider analyzeDataProvider
     */
    public function testClassifyText($options, $expectedOptions)
    {
        $content = $options['content'];
        unset($options['content']);
        $categories = [
            [
                'name' => 'category1',
                'confidence' => .99
            ]
        ];

        $this->connection
            ->classifyText($expectedOptions)
            ->willReturn([
                'categories' => $categories
            ])
            ->shouldBeCalledTimes(1);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $annotation = $this->client->classifyText($content, $options);

        $this->assertInstanceOf(Annotation::class, $annotation);
        $this->assertEquals($categories, $annotation->categories());
    }

    /**
     * @dataProvider analyzeDataProvider
     */
    public function testAnnotateText($options, $expectedOptions)
    {
        $content = $options['content'];
        unset($options['content']);
        $options['features'] = ['syntax', 'entities', 'sentiment', 'entitySentiment'];
        $expectedOptions['features'] = [
            'extractSyntax' => true,
            'extractEntities' => true,
            'extractDocumentSentiment' => true,
            'extractEntitySentiment' => true,
        ];
        $this->connection
            ->annotateText($expectedOptions)
            ->willReturn([])
            ->shouldBeCalledTimes(1);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $annotation = $this->client->annotateText($content, $options);

        $this->assertInstanceOf(Annotation::class, $annotation);
    }

    public function analyzeDataProvider()
    {
        $objectMock = $this->prophesize(StorageObject::class);
        $gcsUri = 'gs://bucket/object';
        $objectMock->gcsUri(Argument::any())->willReturn($gcsUri);

        return [
            [
                [
                    'content' => $gcsUri,
                    'encodingType' => 'UTF16'
                ],
                [
                    'document' => [
                        'gcsContentUri' => $gcsUri,
                        'type' => 'PLAIN_TEXT'
                    ],
                    'encodingType' => 'UTF16'
                ]
            ],
            [
                [
                    'content' => 'My content.',
                    'type' => 'HTML',
                    'language' => 'es',
                    'encodingType' => 'UTF16'
                ],
                [
                    'document' => [
                        'content' => 'My content.',
                        'type' => 'HTML',
                        'language' => 'es',
                    ],
                    'encodingType' => 'UTF16'
                ]
            ],
            [
                [
                    'content' => $objectMock->reveal()
                ],
                [
                    'document' => [
                        'gcsContentUri' => 'gs://bucket/object',
                        'type' => 'PLAIN_TEXT',
                    ],
                    'encodingType' => 'UTF8'
                ]
            ]
        ];
    }
}
