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

namespace Google\Cloud\Spanner;

use Google\Cloud\ArrayTrait;
use Google\Cloud\Int64;
use google\spanner\v1\TypeCode;

class ValueMapper
{
    use ArrayTrait;

    const NANO_REGEX = '/\.(\d{1,9})Z/';

    const TYPE_BOOL = TypeCode::TYPE_BOOL;
    const TYPE_INT64 = TypeCode::TYPE_INT64;
    const TYPE_FLOAT64 = TypeCode::TYPE_FLOAT64;
    const TYPE_TIMESTAMP = TypeCode::TYPE_TIMESTAMP;
    const TYPE_DATE = TypeCode::TYPE_DATE;
    const TYPE_STRING = TypeCode::TYPE_STRING;
    const TYPE_BYTES = TypeCode::TYPE_BYTES;
    const TYPE_ARRAY = TypeCode::TYPE_ARRAY;
    const TYPE_STRUCT = TypeCode::TYPE_STRUCT;
    const TYPE_NULL = 'null';

    /**
     * @var bool
     */
    private $returnInt64AsObject;

    public function __construct($returnInt64AsObject)
    {
        $this->returnInt64AsObject = $returnInt64AsObject;
    }

    /**
     * Accepts an array of key/value pairs, where the key is a SQL parameter
     * name and the value is the value interpolated by the server, and returns
     * an array of parameters and inferred parameter types.
     *
     * @param array $parameters The key/value parameters.
     * @return array An associative array containing params and paramTypes.
     */
    public function formatParamsForExecuteSql(array $parameters)
    {
        $paramTypes = [];

        foreach ($parameters as $key => $value) {
            list ($parameters[$key], $paramTypes[$key]) = $this->paramType($value);
        }

        return [
            'params' => $parameters,
            'paramTypes' => $paramTypes
        ];
    }

    /**
     * Accepts a list of values and encodes the value into a format accepted by
     * the Spanner API.
     *
     * @param array $values The list of values
     * @return array The encoded values
     */
    public function encodeValuesAsSimpleType(array $values)
    {
        $res = [];

        foreach ($values as $value) {
            if ($value instanceof ValueInterface) {
                $value = $value->formatAsString();
            }

            if (gettype($value) === 'integer') {
                $value = (string) $value;
            }

            if ($value instanceof Int64) {
                $value = $value->get();
            }

            $res[] = $value;
        }

        return $res;
    }

    /**
     * Accepts a list of columns (with name and type) and a row from read or
     * executeSql and decodes each value to its corresponding PHP type.
     *
     * @param array $columns The list of columns
     * @param array $row The row data.
     * @return array The decoded row data.
     */
    public function decodeValues(array $columns, array $row)
    {
        $cols = [];
        $types = [];
        foreach (array_keys($row) as $colIndex) {
            $cols[] = $columns[$colIndex]['name'];
            $types[] = $columns[$colIndex]['type']['code'];
        }

        $res = [];
        foreach ($row as $index => $value) {
            $res[$cols[$index]] = $this->decodeValue($value, $types[$index]);
        }

        return $res;
    }

    private function decodeValue($value, $type)
    {
        switch ($type) {
            case self::TYPE_INT64:
                $value = $this->returnInt64AsObject
                    ? new Int64($value)
                    : (int) $value;
                break;

            case self::TYPE_TIMESTAMP:
                $matches = [];
                preg_match(self::NANO_REGEX, $value, $matches);
                $value = preg_replace(self::NANO_REGEX, '.0Z', $value);

                $dt = \DateTimeImmutable::createFromFormat(Timestamp::FORMAT, $value);
                $value = new Timestamp($dt, (isset($matches[1])) ? $matches[1] : 0);
                break;

            case self::TYPE_DATE:
                $value = new Date(new \DateTimeImmutable($value));
                break;

            case self::TYPE_BYTES:
                $value = new Bytes(base64_decode($value));
                break;

            case self::TYPE_ARRAY:
                $value = '';
                break;

            case self::TYPE_STRUCT:
                $value = '';
                break;
        }

        return $value;
    }

    private function paramType($value)
    {
        $phpType = gettype($value);
        switch ($phpType) {
            case 'boolean':
                $type = $this->typeObject(self::TYPE_BOOL);
                break;

            case 'integer':
                $value = (string) $value;
                $type = $this->typeObject(self::TYPE_INT64);
                break;

            case 'double':
                $type = $this->typeObject(self::TYPE_FLOAT64);
                break;

            case 'string':
                $type = $this->typeObject(self::TYPE_STRING);
                break;

            case 'resource':
                $type = $this->typeObject(self::TYPE_BYTES);
                $value = base64_encode(stream_get_contents($value));
                break;

            case 'object':
                list ($type, $value) = $this->objectParam($value);
                break;

            case 'array':
                list ($type, $value) = $this->arrayOrStructObject($value);
                break;

            case 'NULL':
                $type = null;
                break;

            default:
                throw new \InvalidArgumentException(sprintf(
                    'Unrecognized value type %s. Please ensure you are using the latest version of google/cloud.',
                    $phpType
                ));
                break;
        }

        return [$value, $type];
    }

    private function objectParam($value)
    {
        if ($value instanceof \stdClass) {
            return $this->arrayOrStructObject($value);
        }

        if ($value instanceof ValueInterface) {
            return [
                $this->typeObject($value->type()),
                $value->formatAsString()
            ];
        }

        throw new \InvalidArgumentException(sprintf(
            'Unrecognized value type %s. Please ensure you are using the latest version of google/cloud.',
            get_class($value)
        ));
    }

    private function arrayOrStructObject(array $arrayOrStruct)
    {
        $type = null;
        $nestedTypeKey = 'fake';
        $nestedTypeData = [];

        if ($arrayOrStruct instanceof \stdClass) {
            $type = self::TYPE_STRUCT;
            $nestedTypeKey = 'structType';
            $nestedTypeData = [];
        } elseif ($this->isAssoc($arrayOrStruct)) {
            $type = self::TYPE_STRUCT;
            $nestedTypeKey = 'structType';
            $nestedTypeData = [];
        } else {
            $type = self::TYPE_ARRAY;
            $nestedTypeKey = 'arrayElementType';

            foreach ($arrayOrStruct as $element) {
                $nestedTypeData[] = $this->paramType($element)[1];
            }
        }

        return [
            $this->typeObject($type) + [
                $nestedTypeKey = $nestedTypeData
            ],
            $nestedTypeData
        ];
    }

    private function typeObject($type)
    {
        return [
            'code' => $type
        ];
    }
}
