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

namespace Google\Cloud\Tests;

use DrSlump\Protobuf\Message;
use Google\Cloud\PhpArray;
use Prophecy\Argument;

/**
 * @group root
 */
class PhpArrayTest extends \PHPUnit_Framework_TestCase
{
    private function getCodec($customFilters = [])
    {
        return new PhpArray(['customFilters' => $customFilters]);
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function testThrowsExceptionWithoutRequiredField()
    {
        $message = new TestMessage();
        $serializedMessage = $message->serialize($this->getCodec());
    }

    public function testProperlyHandlesMessage()
    {
        $value = 'test';
        $message = new TestMessage();
        $message = $message->deserialize([
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
        ], $this->getCodec());
        $serializedMessage = $message->serialize($this->getCodec());

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
}

class TestMessage extends Message
{
    public $test_struct = null;
    public $test_labels = [];
    public $test_stings = [];

    protected static $__extensions = array();

    public static function descriptor()
    {
        $descriptor = new \DrSlump\Protobuf\Descriptor(__CLASS__, 'Google.Cloud.Tests.TestMessage');

        $f = new \DrSlump\Protobuf\Field();
        $f->number    = 1;
        $f->name      = "test_struct";
        $f->type      = \DrSlump\Protobuf::TYPE_MESSAGE;
        $f->rule      = \DrSlump\Protobuf::RULE_REQUIRED;
        $f->reference = '\google\protobuf\Struct';
        $descriptor->addField($f);

        $f = new \DrSlump\Protobuf\Field();
        $f->number    = 2;
        $f->name      = "test_labels";
        $f->type      = \DrSlump\Protobuf::TYPE_MESSAGE;
        $f->rule      = \DrSlump\Protobuf::RULE_REPEATED;
        $f->reference = '\Google\Cloud\Tests\TestLabelsEntry';
        $descriptor->addField($f);

        $f = new \DrSlump\Protobuf\Field();
        $f->number    = 3;
        $f->name      = "test_strings";
        $f->type      = \DrSlump\Protobuf::TYPE_STRING;
        $f->rule      = \DrSlump\Protobuf::RULE_REPEATED;
        $descriptor->addField($f);

        return $descriptor;
    }
}

class TestLabelsEntry extends Message
{
    public $key = null;
    public $value = null;

    protected static $__extensions = array();

    public static function descriptor()
    {
        $descriptor = new \DrSlump\Protobuf\Descriptor(__CLASS__, 'Google.Cloud.Tests.TestLabelsEntry');

        $f = new \DrSlump\Protobuf\Field();
        $f->number    = 1;
        $f->name      = "key";
        $f->type      = \DrSlump\Protobuf::TYPE_STRING;
        $f->rule      = \DrSlump\Protobuf::RULE_OPTIONAL;
        $descriptor->addField($f);

        $f = new \DrSlump\Protobuf\Field();
        $f->number    = 2;
        $f->name      = "value";
        $f->type      = \DrSlump\Protobuf::TYPE_STRING;
        $f->rule      = \DrSlump\Protobuf::RULE_OPTIONAL;
        $descriptor->addField($f);

        return $descriptor;
    }

    public function getKey(){
        return $this->_get(1);
    }

    public function getValue(){
        return $this->_get(2);
    }
}
