<?php
/*
 * Copyright 2017, Google Inc.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are
 * met:
 *
 *     * Redistributions of source code must retain the above copyright
 * notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above
 * copyright notice, this list of conditions and the following disclaimer
 * in the documentation and/or other materials provided with the
 * distribution.
 *     * Neither the name of Google Inc. nor the names of its
 * contributors may be used to endorse or promote products derived from
 * this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */
namespace Google\GAX;

use Google\Protobuf\Internal\Descriptor;
use Google\Protobuf\Internal\DescriptorPool;
use Google\Protobuf\Internal\FieldDescriptor;
use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\MapField;
use Google\Protobuf\Internal\Message;
use RuntimeException;

/**
 * Collection of methods to help with serialization of protobuf objects
 */
class Serializer
{
    private static $phpArraySerializer;

    private static $metadataKnownTypes = [
        'google.rpc.retryinfo-bin' => \Google\Rpc\RetryInfo::class,
        'google.rpc.debuginfo-bin' => \Google\Rpc\DebugInfo::class,
        'google.rpc.quotafailure-bin' => \Google\Rpc\QuotaFailure::class,
        'google.rpc.badrequest-bin' => \Google\Rpc\BadRequest::class,
        'google.rpc.requestinfo-bin' => \Google\Rpc\RequestInfo::class,
        'google.rpc.resourceinfo-bin' => \Google\Rpc\ResourceInfo::class,
        'google.rpc.help-bin' => \Google\Rpc\Help::class,
        'google.rpc.localizedmessage-bin' => \Google\Rpc\LocalizedMessage::class,
    ];

    private $fieldTransformers;
    private $messageTypeTransformers;

    public function __construct($fieldTransformers = [], $messageTypeTransformers = [])
    {
        $this->fieldTransformers = $fieldTransformers;
        $this->messageTypeTransformers = $messageTypeTransformers;
    }

    public function encodeMessage(Message $message)
    {
        // Get message descriptor
        $pool = DescriptorPool::getGeneratedPool();
        $messageType = $pool->getDescriptorByClassName(get_class($message));
        return $this->encodeMessageImpl($message, $messageType);
    }

    public function decodeMessage(Message $message, $data)
    {
        // Get message descriptor
        $pool = DescriptorPool::getGeneratedPool();
        $messageType = $pool->getDescriptorByClassName(get_class($message));
        return $this->decodeMessageImpl($message, $messageType, $data);
    }

    /**
     * @param \Google\Protobuf\Internal\Message $message
     * @return string
     */
    public static function serializeToJson($message)
    {
        return json_encode(self::serializeToPhpArray($message), JSON_PRETTY_PRINT);
    }

    /**
     * @param \Google\Protobuf\Internal\Message $message
     * @return string
     */
    public static function serializeToPhpArray($message)
    {
        return self::getPhpArraySerializer()->encodeMessage($message);
    }

    /**
     * Decode metadata received from gRPC status object
     * @param $metadata
     * @return array
     */
    public static function decodeMetadata($metadata)
    {
        if (is_null($metadata) || count($metadata) == 0) {
            return [];
        }
        $result = [];
        foreach ($metadata as $key => $values) {
            $decodedValues = [];
            foreach ($values as $value) {
                if (self::hasBinaryHeaderSuffix($key)) {
                    if (isset(self::$metadataKnownTypes[$key])) {
                        $class = self::$metadataKnownTypes[$key];
                        $message = new $class();
                        $message->mergeFromString($value);
                        $decodedValue = self::serializeToPhpArray($message);
                    } else {
                        // The metadata contains an unexpected binary type
                        $decodedValue = "<Binary Data>";
                    }
                } else {
                    $decodedValue = $value;
                }
                $decodedValues[] = $decodedValue;
            }
            $result[$key] = $decodedValues;
        }
        return $result;
    }

    private function encodeElement(FieldDescriptor $field, $data)
    {
        switch ($field->getType()) {
            case GPBType::MESSAGE:
                if (is_array($data)) {
                    $result = $data;
                } else {
                    if (!($data instanceof Message)) {
                        throw new RuntimeException("Expected message, instead got " . get_class($data));
                    }
                    $result = $this->encodeMessageImpl($data, $field->getMessageType());
                }
                $messageType = $field->getMessageType()->getFullName();
                if (isset($this->messageTypeTransformers[$messageType])) {
                    $result = $this->messageTypeTransformers[$messageType]($result);
                }
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
                foreach ($v as $k => $vv) {
                    $arr[$this->decodeElement($keyField, $k)] = $this->decodeElement($valueField, $vv);
                }
                $v = $arr;
            } elseif ($field->isRepeated()) {
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

    public static function toSnakeCase($key)
    {
        return strtolower(preg_replace(['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', $key));
    }

    public static function toCamelCase($key)
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $key))));
    }

    private static function hasBinaryHeaderSuffix($key)
    {
        return substr_compare($key, "-bin", strlen($key) - 4) === 0;
    }

    private static function getPhpArraySerializer()
    {
        if (is_null(self::$phpArraySerializer)) {
            self::$phpArraySerializer = new Serializer();
        }
        return self::$phpArraySerializer;
    }
}
