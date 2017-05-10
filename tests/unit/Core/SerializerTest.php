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

namespace Google\Cloud\Tests\Unit\Core;

use Google\Cloud\Core\Serializer;
use Google\Logging\V2\LogEntry;
use Google\Protobuf\Any;
use Google\Protobuf\Field;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * @group core
 */
class SerializerTest extends \PHPUnit_Framework_TestCase
{
    private function backAndForth($message, $arrayStructure)
    {
        $serializer = new Serializer();
        $klass = get_class($message);

        $serializedMessage = $serializer->encodeMessage($message);
        $deserializedMessage = $serializer->decodeMessage(new $klass(), $serializedMessage);
        $this->assertEquals($arrayStructure, $serializedMessage);
        $this->assertEquals($message, $deserializedMessage);

        $deserializedStructure = $serializer->decodeMessage(new $klass(), $arrayStructure);
        $reserializedStructure = $serializer->encodeMessage($deserializedStructure);
        $this->assertEquals($message, $deserializedStructure);
        $this->assertEquals($arrayStructure, $reserializedStructure);
    }

    public function testStatusMessage()
    {
        $details = [new Any()];
        $message = new Status();
        $message->setMessage("message");
        $message->setCode(0);
        $message->setDetails($details);
        $this->backAndForth($message, [
            'message' => 'message',
            'code' => 0,
            'details' => [
                [
                    'typeUrl' => '',
                    'value' => '',
                ],
            ]
        ]);
    }

    public function testLogEntry()
    {
        $message = new LogEntry();
        $this->backAndForth($message, [
            'logName' => '',
            'severity' => 0,
            'insertId' => '',
            'labels' => [],
            'trace' => '',
        ]);
    }

    public function testLogEntrySetOneof()
    {
        $message = new LogEntry();
        $message->setTextPayload('');
        $this->backAndForth($message, [
            'logName' => '',
            'textPayload' => '',
            'severity' => 0,
            'insertId' => '',
            'labels' => [],
            'trace' => '',
        ]);
    }

    public function testLogEntrySetOneofToValue()
    {
        $message = new LogEntry();
        $message->setTextPayload('test');
        $this->backAndForth($message, [
            'logName' => '',
            'textPayload' => 'test',
            'severity' => 0,
            'insertId' => '',
            'labels' => [],
            'trace' => '',
        ]);
    }

    public function testFieldMask()
    {
        $message = new FieldMask();
        $this->backAndForth($message, [
            'paths' => []
        ]);
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    /*
    public function testThrowsExceptionWithoutRequiredField()
    {
        $message = new TestMessage();
        $serializedMessage = $message->serialize($this->getCodec());
    }

    public function testProperlyHandlesMessage()
    {
        $value = 'test';
        $message = new TestMessage();
        $message = $message->mergeFromString([
            'testStruct' => [
                'fields' => [
                    'key' => $value,
                    'value' => [
                        'list_value' => [
                            'values' => [
                                'string_value' => $value
                            ]
                        ]
                    ]
                ]
            ],
            'testLabels' => [
                [
                    'key' => strtoupper($value),
                    'value' => strtoupper($value)
                ],
                [
                    'key' => $value,
                    'value' => $value
                ]
            ],
            'testStrings' => [
                $value,
                $value
            ]
        ]);
        $serializedMessage = $message->serializeToString();

        $expected = [
            'testStruct' => [
                $value => [
                    $value
                ]
            ],
            'testLabels' => [
                strtoupper($value) => strtoupper($value),
                $value => $value
            ],
            'testStrings' => [
                $value,
                $value
            ]
        ];

        $this->assertEquals($expected, $serializedMessage);
    }
    */
}
