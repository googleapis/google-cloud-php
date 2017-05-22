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

namespace Google\Cloud\Core;

use Google\Protobuf\Internal\Descriptor;
use Google\Protobuf\Internal\DescriptorPool;
use Google\Protobuf\Internal\FieldDescriptor;
use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\MapField;
use Google\Protobuf\Internal\Message;
use RuntimeException;

class Serializer
{
    private $fieldTransformers;

    public function __construct($fieldTransformers = [])
    {
        $this->fieldTransformers = $fieldTransformers;
    }

    private function encodeElement(FieldDescriptor $field, $data)
    {
        switch ($field->getType()) {
            case GPBType::MESSAGE:
                if (is_array($data)) {
                    return $data;
                }
                if (!($data instanceof Message)) {
                    throw new RuntimeException("Expected message, instead got " . get_class($data));
                }
                $result = $this->encodeMessageImpl($data, $field->getMessageType());
                break;
            default:
                $result = $data;
                break;
        }

        if (isset($this->fieldTransformers[$field->getName()])) {
            $result = $this->fieldTransformers[$field->getName()]($result);
        }
        return $result;
    }

    private function encodeMessageImpl(Message $message, Descriptor $messageType)
    {
        $data = [];

        foreach ($messageType->getField() as $field) {
            /** @var FieldDescriptor $field */
            $key = $field->getName();
            $getter = $field->getGetter();
            $v = $message->$getter();

            if (is_null($v)) {
                continue;
            }

            if ($field->getOneofIndex() !== -1) {
                $oneof = $messageType->getOneofDecl()[$field->getOneofIndex()];
                $oneofName = $oneof->getName();
                $oneofGetter = 'get' . ucfirst(self::toCamelCase($oneofName));
                if ($message->$oneofGetter() !== $field->getName()) {
                    continue;
                }
            }

            if ($field->isMap()) {
                //throw new RuntimeException("Map field not supported: $key");
                $keyField = $field->getMessageType()->getFieldByNumber(1);
                $valueField = $field->getMessageType()->getFieldByNumber(2);
                $arr = [];
                foreach ($v as $k => $vv) {
                    $arr[$this->encodeElement($keyField, $k)] = $this->encodeElement($valueField, $vv);
                }
                $v = $arr;
            } elseif ($field->isRepeated()) {
                $arr = [];
                foreach ($v as $k => $vv) {
                    $arr[$k] = $this->encodeElement($field, $vv);
                }
                $v = $arr;
            } else {
                $v = $this->encodeElement($field, $v);
            }

            $key = self::toCamelCase($key);
            $data[$key] = $v;
        }

        return $data;
    }

    public function encodeMessage(Message $message)
    {
        // Get message descriptor
        $pool = DescriptorPool::getGeneratedPool();
        $messageType = $pool->getDescriptorByClassName(get_class($message));
        return $this->encodeMessageImpl($message, $messageType);
    }


    private function decodeElement(FieldDescriptor $field, $data)
    {
        switch ($field->getType()) {
            case GPBType::MESSAGE:
                if ($data instanceof Message) {
                    return $data;
                }
                /** @var Descriptor $messageType */
                $messageType = $field->getMessageType();
                $klass = $messageType->getClass();
                $msg = new $klass();

                return $this->decodeMessageImpl($msg, $messageType, $data);
            default:
                return $data;
        }
    }

    private function decodeMessageImpl(Message $message, Descriptor $messageType, $data)
    {
        $fieldsByName = [];
        foreach ($messageType->getField() as $field) {
            /** @var FieldDescriptor $field */
            $fieldsByName[$field->getName()] = $field;
        }
        foreach ($data as $key => $v) {
            // Get the field by tag number or name
            $fieldName = self::toSnakeCase($key);
            $field = $fieldsByName[$fieldName];

            // Unknown field found
            if (!$field) {
                throw new RuntimeException("cannot handle unknown field: $fieldName");
            }

            if ($field->isMap()) {
                $keyField = $field->getMessageType()->getFieldByNumber(1);
                $valueField = $field->getMessageType()->getFieldByNumber(2);
                $klass = $valueField->getType() === GPBType::MESSAGE
                    ? $valueField->getMessageType()->getClass()
                    : null;
                $arr = new MapField($keyField->getType(), $valueField->getType(), $klass);
                //$arr = [];
                //$field->getMessageType()->
                foreach ($v as $k => $vv) {
                    $arr[$this->decodeElement($keyField, $k)] = $this->decodeElement($valueField, $vv);
                }
                $v = $arr;
            } elseif ($field->isRepeated()) {
                // Make sure the value is an array of values
                //$v = is_array($v) && is_int(key($v)) ? $v : array($v);

                $arr = [];
                foreach ($v as $k => $vv) {
                    $arr[$k] = $this->decodeElement($field, $vv);
                }
                $v = $arr;
            } else {
                $v = $this->decodeElement($field, $v);
            }

            $setter = $field->getSetter();
            $message->$setter($v);
        }
        return $message;
    }

    public function decodeMessage(Message $message, $data)
    {
        // Get message descriptor
        $pool = DescriptorPool::getGeneratedPool();
        $messageType = $pool->getDescriptorByClassName(get_class($message));
        return $this->decodeMessageImpl($message, $messageType, $data);
    }

    private static function toSnakeCase($key)
    {
        return strtolower(preg_replace(['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', $key));
    }

    private static function toCamelCase($key)
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $key))));
    }
}
