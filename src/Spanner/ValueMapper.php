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

use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\Int64;
use Google\Spanner\V1\TypeCode;

/**
 * Manage value mappings between Google Cloud PHP and Cloud Spanner
 */
class ValueMapper
{
    use ArrayTrait;

    const NANO_REGEX = '/(?:\.(\d{1,9})Z)|(?:Z)/';

    const TYPE_BOOL = TypeCode::BOOL;
    const TYPE_INT64 = TypeCode::INT64;
    const TYPE_FLOAT64 = TypeCode::FLOAT64;
    const TYPE_TIMESTAMP = TypeCode::TIMESTAMP;
    const TYPE_DATE = TypeCode::DATE;
    const TYPE_STRING = TypeCode::STRING;
    const TYPE_BYTES = TypeCode::BYTES;
    const TYPE_ARRAY = TypeCode::PBARRAY;
    const TYPE_STRUCT = TypeCode::STRUCT;

    /**
     * @var array
     */
    private $allowedTypes = [
        self::TYPE_BOOL,
        self::TYPE_INT64,
        self::TYPE_FLOAT64,
        self::TYPE_TIMESTAMP,
        self::TYPE_DATE,
        self::TYPE_STRING,
        self::TYPE_BYTES,
        self::TYPE_ARRAY,
        self::TYPE_STRUCT,
    ];

    /**
     * @var bool
     */
    private $returnInt64AsObject;

    /**
     * @param bool $returnInt64AsObject
     */
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
     * @param array $types The types of values.
     * @return array An associative array containing params and paramTypes.
     */
    public function formatParamsForExecuteSql(array $parameters, array $types = [])
    {
        $paramTypes = [];

        foreach ($parameters as $key => $value) {
            if (is_null($value) && !isset($types[$key])) {
                throw new \BadMethodCallException(sprintf(
                    'Null value for parameter @%s must supply a parameter type.',
                    $key
                ));
            }

            $type = isset($types[$key]) ? $types[$key] : null;
            $arrayType = null;
            if (is_array($type)) {
                $arrayType = $type[1];
                $type = $type[0];
            }

            if ($type !== null && !in_array($type, $this->allowedTypes)) {
                throw new \BadMethodCallException(sprintf(
                    'Type %s given for parameter @%s is not valid.',
                    $type,
                    $key
                ));
            }

            if ($arrayType !== null && !in_array($arrayType, $this->allowedTypes)) {
                throw new \BadMethodCallException(sprintf(
                    'Type %s given for parameter @%s is not valid.',
                    $type,
                    $key
                ));
            }

            list ($parameters[$key], $paramTypes[$key]) = $this->paramType($value, $type, $arrayType);
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
            $res[] = $this->paramType($value)[0];
        }

        return $res;
    }

    /**
     * Accepts a list of columns (with name and type) and a row from read or
     * executeSql and decodes each value to its corresponding PHP type.
     *
     * @param array $columns The list of columns.
     * @param array $row The row data.
     * @param string $format The format in which to return the rows.
     * @return array The decoded row data.
     * @throws \InvalidArgumentException
     */
    public function decodeValues(array $columns, array $row, $format)
    {
        switch ($format) {
            case Result::RETURN_NAME_VALUE_PAIR:
                foreach ($row as $index => $value) {
                    $row[$index] = [
                        'name' => $this->getColumnName($columns, $index),
                        'value' => $this->decodeValue($value, $columns[$index]['type'])
                    ];
                }

                return $row;

            case Result::RETURN_ASSOCIATIVE:
                foreach ($row as $index => $value) {
                    unset($row[$index]);
                    $row[$this->getColumnName($columns, $index)] = $this->decodeValue(
                        $value,
                        $columns[$index]['type']
                    );
                }

                return $row;

            case Result::RETURN_ZERO_INDEXED:
                foreach ($row as $index => $value) {
                    $row[$index] = $this->decodeValue($value, $columns[$index]['type']);
                }

                return $row;
            default:
                throw new \InvalidArgumentException('Invalid format provided.');
        }
    }

    /**
     * Convert a timestamp string to a Timestamp class with nanosecond support.
     *
     * @param string $timestamp The timestamp string
     * @return Timestamp
     */
    public function createTimestampWithNanos($timestamp)
    {
        $matches = [];
        preg_match(self::NANO_REGEX, $timestamp, $matches);
        $timestamp = preg_replace(self::NANO_REGEX, '.000000Z', $timestamp);

        $dt = \DateTimeImmutable::createFromFormat(Timestamp::FORMAT, str_replace('..', '.', $timestamp));

        return new Timestamp($dt, (isset($matches[1])) ? $matches[1] : 0);
    }

    /**
     * Convert a single value to its corresponding PHP type.
     *
     * @param mixed $value The value to decode
     * @param array $type The value type
     * @return mixed
     */
    private function decodeValue($value, array $type)
    {
        if ($value === null || $value === '') {
            return $value;
        }

        switch ($type['code']) {
            case self::TYPE_INT64:
                $value = $this->returnInt64AsObject
                    ? new Int64($value)
                    : (int) $value;
                break;

            case self::TYPE_TIMESTAMP:
                $value = $this->createTimestampWithNanos($value);
                break;

            case self::TYPE_DATE:
                $value = new Date(new \DateTimeImmutable($value));
                break;

            case self::TYPE_BYTES:
                $value = new Bytes(base64_decode($value));
                break;

            case self::TYPE_ARRAY:
                $res = [];
                foreach ($value as $item) {
                    $res[] = $this->decodeValue($item, $type['arrayElementType']);
                }

                $value = $res;
                break;

            case self::TYPE_STRUCT:
                $fields = isset($type['structType']['fields'])
                    ? $type['structType']['fields']
                    : [];

                $value = $this->decodeValues($fields, $value, Result::RETURN_ASSOCIATIVE);
                break;

            case self::TYPE_FLOAT64:
                // NaN, Infinite and -Infinite are possible FLOAT64 values,
                // but when the gRPC response is decoded, they are represented
                // as strings. This conditional checks for a string, converts to
                // an equivalent double value, or dies if something really weird
                // happens.
                if (is_string($value)) {
                    switch ($value) {
                        case 'NaN':
                            $value = NAN;
                            break;

                        case 'Infinity':
                            $value = INF;
                            break;

                        case '-Infinity':
                            $value = -INF;
                            break;

                        default:
                            throw new \RuntimeException(sprintf(
                                'Unexpected string value %s encountered in FLOAT64 field.',
                                $value
                            ));
                    }
                }

                break;
        }

        return $value;
    }

    /**
     * Create a spanner parameter type value object from a PHP value type.
     *
     * @param mixed $value The PHP value
     * @param int $givenType
     * @param int $arrayType
     * @return array The Value type
     */
    private function paramType($value, $givenType = null, $arrayType = null)
    {
        $phpType = gettype($value);
        switch ($phpType) {
            case 'boolean':
                $type = $this->typeObject($givenType ?: self::TYPE_BOOL);
                break;

            case 'integer':
                $value = (string) $value;
                $type = $this->typeObject($givenType ?: self::TYPE_INT64);
                break;

            case 'double':
                $type = $this->typeObject($givenType ?: self::TYPE_FLOAT64);
                switch ($value) {
                    case INF:
                        $value = 'Infinity';
                        break;

                    case -INF:
                        $value = '-Infinity';
                        break;
                }

                if (!is_string($value) && is_nan($value)) {
                    $value = 'NaN';
                }

                break;

            case 'string':
                $type = $this->typeObject($givenType ?: self::TYPE_STRING);
                break;

            case 'resource':
                $type = $this->typeObject($givenType ?: self::TYPE_BYTES);
                $value = base64_encode(stream_get_contents($value));
                break;

            case 'object':
                list ($type, $value) = $this->objectParam($value);
                break;

            case 'array':
                if (!empty($value) && $this->isAssoc($value)) {
                    throw new \BadMethodCallException(
                        'Associative arrays are not supported. Did you mean to call a batch method?'
                    );
                }

                $res = [];
                $types = [];
                foreach ($value as $element) {
                    $type = $this->paramType($element);
                    $res[] = $type[0];
                    if (isset($type[1]['code'])) {
                        $types[] = $type[1]['code'];
                    }
                }

                if (count(array_unique($types)) > 1) {
                    throw new \BadMethodCallException('Array values may not be of mixed type');
                }

                $type = $this->typeObject(
                    self::TYPE_ARRAY,
                    $this->typeObject((isset($types[0])) ? $types[0] : $arrayType),
                    'arrayElementType'
                );

                $value = $res;
                break;

            case 'NULL':
                if ($givenType === self::TYPE_ARRAY) {
                    $type = $this->typeObject(
                        $givenType,
                        $this->typeObject($arrayType),
                        'arrayElementType'
                    );
                } else {
                    $type = $this->typeObject($givenType);
                }
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
        if ($value instanceof ValueInterface) {
            return [
                $this->typeObject($value->type()),
                $value->formatAsString()
            ];
        }

        if ($value instanceof Int64) {
            return [
                $this->typeObject(self::TYPE_INT64),
                $value->get()
            ];
        }

        throw new \InvalidArgumentException(sprintf(
            'Unrecognized value type %s. Please ensure you are using the latest version of google/cloud.',
            get_class($value)
        ));
    }

    private function typeObject($type, array $nestedDefinition = [], $nestedDefinitionType = null)
    {
        return array_filter([
            'code' => $type,
            $nestedDefinitionType => $nestedDefinition
        ]);
    }

    private function getColumnName($columns, $index)
    {
        return (isset($columns[$index]['name']) && $columns[$index]['name'])
            ? $columns[$index]['name']
            : $index;
    }
}
