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
use Google\Protobuf\ListValue;
use Google\Protobuf\Struct;
use Google\Protobuf\Value;
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

    public function testProperlyHandlesMessage()
    {
        $value = 'test';

        // Using this class because it contains maps, oneofs and structs
        $message = new \Google\Api\Servicecontrol\V1\LogEntry();

        $labels = [
            strtoupper($value) => strtoupper($value),
            $value => $value,
        ];

        $innerValue1 = new Value();
        $innerValue1->setStringValue($value);
        $innerValue2 = new Value();
        $innerValue2->setBoolValue(true);
        $innerValues = [$innerValue1, $innerValue2];
        $listValue = new ListValue();
        $listValue->setValues($innerValues);
        $fieldValue = new Value();
        $fieldValue->setListValue($listValue);
        $structValue = new Struct();
        $fields = [
            'listField' => $fieldValue,
        ];
        $structValue->setFields($fields);

        $message->setName($value);
        $message->setLabels($labels);
        $message->setStructPayload($structValue);

        $this->backAndForth($message, [
            'name' => $value,
            'labels' => [
                strtoupper($value) => strtoupper($value),
                $value => $value,
            ],
            'severity' => 0,
            'insertId' => '',
            'structPayload' => [
                'fields' => [
                    'listField' => [
                        'listValue' => [
                            'values' => [
                                [
                                    'stringValue' => $value,
                                ],
                                [
                                    'boolValue' => true,
                                ]
                            ]
                        ]
                    ]
                ],
            ],
        ]);
    }
}
