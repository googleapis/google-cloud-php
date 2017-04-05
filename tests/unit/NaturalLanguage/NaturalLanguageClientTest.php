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

namespace Google\Cloud\Tests\Unit\NaturalLanguage;

use Google\Cloud\NaturalLanguage\Annotation;
use Google\Cloud\NaturalLanguage\Connection\ConnectionInterface;
use Google\Cloud\NaturalLanguage\NaturalLanguageClient;
use Google\Cloud\Storage\StorageObject;
use Prophecy\Argument;

/**
 * @group naturallanguage
 */
class NaturalLanguageClientTest extends \PHPUnit_Framework_TestCase
{
    private $client;
    private $connection;

    public function setUp()
    {
        $this->client = new NaturalLanguageTestClient();
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
        $this->client->setConnection($this->connection->reveal());
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
        $this->client->setConnection($this->connection->reveal());
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
        $this->client->setConnection($this->connection->reveal());
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
        $this->client->setConnection($this->connection->reveal());
        $annotation = $this->client->analyzeSyntax($content, $options);

        $this->assertInstanceOf(Annotation::class, $annotation);
    }

    /**
     * @dataProvider analyzeDataProvider
     */
    public function testAnnotateText($options, $expectedOptions)
    {
        $content = $options['content'];
        unset($options['content']);
        $options['features'] = ['syntax', 'entities', 'sentiment'];
        $expectedOptions['features'] = [
            'extractSyntax' => true,
            'extractEntities' => true,
            'extractDocumentSentiment' => true
        ];
        $this->connection
            ->annotateText($expectedOptions)
            ->willReturn([])
            ->shouldBeCalledTimes(1);
        $this->client->setConnection($this->connection->reveal());
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

class NaturalLanguageTestClient extends NaturalLanguageClient
{
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }
}
