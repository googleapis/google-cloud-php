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

namespace Google\Cloud\Tests\Speech;

use Google\Cloud\Speech\Connection\ConnectionInterface;
use Google\Cloud\Speech\Operation;
use Google\Cloud\Speech\SpeechClient;
use Google\Cloud\Storage\StorageObject;
use Prophecy\Argument;

/**
 * @group speech
 */
class SpeechClientTest extends \PHPUnit_Framework_TestCase
{
    private $client;
    private $connection;

    public function setUp()
    {
        $this->client = new SpeechTestClient([
            'languageCode' => 'en-US'
        ]);
        $this->connection = $this->prophesize(ConnectionInterface::class);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testClientInstantiationThrowsExceptionWithoutLanguageCode()
    {
        $client = new SpeechTestClient();
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
        $this->client->setConnection($this->connection->reveal());
        $results = $this->client->recognize($audio, $options);

        $this->assertEquals($transcript, $results[0]['transcript']);
        $this->assertEquals($confidence, $results[0]['confidence']);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testRecognizeThrowsExceptionWhenCannotDetectEncoding()
    {
        $this->client->recognize('abcd', [
            'sampleRate' => 16000
        ]);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testRecognizeThrowsExceptionWhenCannotDetectSampleRate()
    {
        $this->client->recognize('abcd', [
            'encoding' => 'MULAW'
        ]);
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
        $this->client->setConnection($this->connection->reveal());
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
        $amrMock->identity(Argument::any())->willReturn(['bucket' => 'bucket', 'object' => 'object.amr']);
        $awbMock = $this->prophesize(StorageObject::class);
        $awbMock->identity(Argument::any())->willReturn(['bucket' => 'bucket', 'object' => 'object.awb']);
        $audioPath = __DIR__ . '/../data/brooklyn.flac';

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
                    ]
                ],
                [
                    'audio' => [
                        'content' => base64_encode(file_get_contents($audioPath))
                    ],
                    'config' => [
                        'encoding' => 'FLAC',
                        'maxAlternatives' => 1,
                        'languageCode' => 'en-GB',
                        'profanityFilter' => false,
                        'speechContexts' => [
                            [
                                'phrases' => ['Test']
                            ]
                        ]
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
                        'encoding' => 'AMR',
                        'sampleRateHertz' => 8000,
                        'languageCode' => 'en-US',
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
                        'encoding' => 'AMR_WB',
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
                        'encoding' => 'FLAC',
                        'sampleRateHertz' => 16000,
                        'languageCode' => 'en-US',
                    ]
                ]
            ]
        ];
    }
}

class SpeechTestClient extends SpeechClient
{
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }
}

class HttpStreamWrapper {
    public $position = 0;
    public $bodyData = 'abcd';

    public function stream_open($path, $mode, $options, &$opened_path) {
        return true;
    }

    public function stream_read($count) {
        $this->position += strlen($this->bodyData);
        if ($this->position > strlen($this->bodyData)) {
            return false;
        }

        return $this->bodyData;
    }

    public function stream_eof() {
        return $this->position >= strlen($this->bodyData);
    }

    public function stream_stat() {
        return [
            'wrapper_data' => ['test']
        ];
    }

    public function stream_tell() {
        return $this->position;
    }
}
