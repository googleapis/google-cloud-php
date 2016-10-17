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
    private $phpArray;

    public function setUp()
    {
        $this->phpArray = new PhpArray();
    }

    public function testProperlyTransformsKeys()
    {
        $value = 'testing123';
        $message = new TestMessage();
        $message->setTestField($value);
        $serializedMessage = $message->serialize(new PhpArray());

        $this->assertEquals(['testField' => $value], $serializedMessage);
    }
}

class TestMessage extends Message
{
    public $test_field = null;

    protected static $__extensions = array();

    public static function descriptor()
    {
      $descriptor = new \DrSlump\Protobuf\Descriptor(__CLASS__, 'Google.Cloud.Tests.TestMessage');

      $f = new \DrSlump\Protobuf\Field();
      $f->number    = 1;
      $f->name      = "test_field";
      $f->type      = \DrSlump\Protobuf::TYPE_STRING;
      $f->rule      = \DrSlump\Protobuf::RULE_OPTIONAL;
      $descriptor->addField($f);


      foreach (self::$__extensions as $cb) {
        $descriptor->addField($cb(), true);
      }

      return $descriptor;
    }

    public function hasTestField(){
      return $this->_has(1);
    }

    public function clearTestField(){
      return $this->_clear(1);
    }

    public function getTestField(){
      return $this->_get(1);
    }

    public function setTestField( $value){
      return $this->_set(1, $value);
    }
}
