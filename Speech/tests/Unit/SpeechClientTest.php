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

namespace Google\Cloud\Speech\Tests\Unit;

use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Speech\Connection\ConnectionInterface;
use Google\Cloud\Speech\Operation;
use Google\Cloud\Speech\Result;
use Google\Cloud\Speech\SpeechClient;
use Google\Cloud\Storage\StorageObject;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group speech
 */
class SpeechClientTest extends TestCase
{
    use ProphecyTrait;

    const GCS_URI = 'gs://bucket/object';

    private $client;
    private $connection;

    public function setUp(): void
    {
        $this->client = TestHelpers::stub(SpeechClient::class, [
            ['languageCode' => 'en-US', 'suppressKeyFileNotice' => true]
        ]);
        $this->connection = $this->prophesize(ConnectionInterface::class);
    }

    public function testThrowsExceptionWithoutLanguageCode()
    {
        $this->expectException(InvalidArgumentException::class);

        $client = TestHelpers::stub(SpeechClient::class, [['suppressKeyFileNotice' => true]]);
        $client->recognize(self::GCS_URI);
    }

    /**
     * @dataProvider audioProvider
     */
    public function testRecognize($audio, array $options, array $expectedOptions)
    {
        $transcript = 'testing';
        $confidence = 1.0;
        $this->connection
            ->recognize($expectedOptions)
            ->willReturn([
                'results' => [
                    [
                        'alternatives' => [
                            [
                                'transcript' => $transcript,
                                'confidence' => $confidence
                            ]
                        ]
                    ]
                ]
            ])
            ->shouldBeCalledTimes(1);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $results = $this->client->recognize($audio, $options);

        $this->assertContainsOnlyInstancesOf(Result::class, $results);
    }


    /**
     * @dataProvider audioProvider
     */
    public function testBeginRecognizeOperation($audio, array $options, array $expectedOptions)
    {
        $this->connection
            ->longRunningRecognize($expectedOptions)
            ->willReturn(['name' => '1234abc'])
            ->shouldBeCalledTimes(1);
        $this->client->___setProperty('connection', $this->connection->reveal());
        $operation = $this->client->beginRecognizeOperation($audio, $options);

        $this->assertInstanceOf(Operation::class, $operation);
    }

    public function testGetsOperation()
    {
        $operationName = 'test';
        $operation = $this->client->operation($operationName);

        $this->assertInstanceOf(Operation::class, $operation);
        $this->assertEquals($operationName, $operation->name());
    }

    public function audioProvider()
    {
        stream_wrapper_unregister('http');
        stream_wrapper_register('http', HttpStreamWrapper::class);
        $amrMock = $this->prophesize(StorageObject::class);
        $amrMock->gcsUri(Argument::any())->willReturn(self::GCS_URI . '.amr');
        $awbMock = $this->prophesize(StorageObject::class);
        $awbMock->gcsUri(Argument::any())->willReturn(self::GCS_URI . '.awb');
        $audioPath = __DIR__ . '/data/brooklyn.flac';

        return [
            [
                fopen($audioPath, 'r'),
                [
                    'maxAlternatives' => 1,
                    'languageCode' => 'en-GB',
                    'profanityFilter' => false,
                    'speechContexts' => [
                        [
                            'phrases' => ['Test']
                        ]
                    ],
                    'enableWordTimeOffsets' => false
                ],
                [
                    'audio' => [
                        'content' => base64_encode(file_get_contents($audioPath))
                    ],
                    'config' => [
                        'maxAlternatives' => 1,
                        'languageCode' => 'en-GB',
                        'profanityFilter' => false,
                        'speechContexts' => [
                            [
                                'phrases' => ['Test']
                            ]
                        ],
                        'enableWordTimeOffsets' => false
                    ]
                ]
            ],
            [
                file_get_contents($audioPath),
                [
                    'encoding' => 'FLAC',
                    'sampleRateHertz' => 16000
                ],
                [
                    'audio' => [
                        'content' => base64_encode(file_get_contents($audioPath))
                    ],
                    'config' => [
                        'encoding' => 'FLAC',
                        'sampleRateHertz' => 16000,
                        'languageCode' => 'en-US',
                    ]
                ]
            ],
            [
                file_get_contents($audioPath),
                [
                    'encoding' => 'FLAC'
                ],
                [
                    'audio' => [
                        'content' => base64_encode(file_get_contents($audioPath)),
                    ],
                    'config' => [
                        'encoding' => 'FLAC',
                        'languageCode' => 'en-US',
                    ]
                ]
            ],
            [
                $amrMock->reveal(),
                [],
                [
                    'audio' => [
                        'uri' => 'gs://bucket/object.amr'
                    ],
                    'config' => [
                        'languageCode' => 'en-US'
                    ]
                ]
            ],
            [
                $awbMock->reveal(),
                [],
                [
                    'audio' => [
                        'uri' => 'gs://bucket/object.awb'
                    ],
                    'config' => [
                        'languageCode' => 'en-US'
                    ]
                ]
            ],
            [
                self::GCS_URI,
                [
                    'encoding' => 'FLAC',
                    'sampleRateHertz' => 16000
                ],
                [
                    'audio' => [
                        'uri' => self::GCS_URI
                    ],
                    'config' => [
                        'encoding' => 'FLAC',
                        'sampleRateHertz' => 16000,
                        'languageCode' => 'en-US',
                    ]
                ]
            ],
            [
                fopen('http://www.example.com/file.flac', 'r'),
                [
                    'sampleRateHertz' => 16000
                ],
                [
                    'audio' => [
                        'content' => base64_encode('abcd')
                    ],
                    'config' => [
                        'sampleRateHertz' => 16000,
                        'languageCode' => 'en-US'
                    ]
                ]
            ]
        ];
    }
}
