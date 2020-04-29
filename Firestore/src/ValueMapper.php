<?php
/**
 * Copyright 2017 Google Inc.
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

namespace Google\Cloud\Firestore;

use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\Blob;
use Google\Cloud\Core\DebugInfoTrait;
use Google\Cloud\Core\GeoPoint;
use Google\Cloud\Core\Int64;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Core\TimeTrait;
use Google\Cloud\Core\ValidateTrait;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Protobuf\NullValue;

/**
 * Normalizes values between Google Cloud PHP and Cloud Firestore.
 *
 * @internal
 */
class ValueMapper
{
    use ArrayTrait;
    use DebugInfoTrait;
    use PathTrait;
    use TimeTrait;
    use ValidateTrait;

    const VALID_FIELD_PATH = '/^[^*~\/[\]]+$/';
    const UNESCAPED_FIELD_NAME = '/^[_a-zA-Z][_a-zA-Z0-9]*$/';

    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @var bool
     */
    private $returnInt64AsObject;

    /**
     * @param ConnectionInterface $connection A connection to Cloud Firestore
     * @param bool $returnInt64AsObject Whether to wrap int types in a wrapper
     *        (to preserve values in 32-bit environments).
     */
    public function __construct(ConnectionInterface $connection, $returnInt64AsObject)
    {
        $this->connection = $connection;
        $this->returnInt64AsObject = $returnInt64AsObject;
    }

    /**
     * Convert a list of fields from the API to corresponding PHP values in a
     * nested key/value array.
     *
     * @param array $fields A list of fields to decode.
     * @return array
     */
    public function decodeValues(array $fields)
    {
        $output = [];

        foreach ($fields as $key => $val) {
            $type = array_keys($val)[0];
            $value = current($val);

            $output[$key] = $this->decodeValue($type, $value);
        }

        return $output;
    }

    /**
     * Convert a PHP array containing google-cloud-php and simple types to an
     * array ready to be sent to Firestore.
     *
     * @param array $fields A list of fields to encode.
     * @return array
     */
    public function encodeValues(array $fields)
    {
        $output = [];

        foreach ($fields as $key => $val) {
            $output[$key] = $this->encodeValue($val);
        }

        return $output;
    }

    /**
     * Convert a Firestore value to a Google Cloud PHP value.
     *
     * @see https://firebase.google.com/docs/firestore/reference/rpc/google.firestore.v1beta1#value Value
     * @param string $type The Firestore value type.
     * @param mixed $value The firestore value.
     * @return mixed
     * @throws \RuntimeException if an unknown value is encountered.
     */
    private function decodeValue($type, $value)
    {
        switch ($type) {
            case 'booleanValue':
            case 'stringValue':
            case 'doubleValue':
                return $value;
                break;

            case 'nullValue':
                return null;

            case 'bytesValue':
                return new Blob($value);

            case 'integerValue':
                return $this->returnInt64AsObject
                    ? new Int64($value)
                    : (int) $value;

            case 'timestampValue':
                $time = $this->parseTimeString($value);
                return new Timestamp($time[0], $time[1]);
                break;

            case 'geoPointValue':
                $value += [
                    'latitude' => null,
                    'longitude' => null
                ];

                return new GeoPoint($value['latitude'], $value['longitude']);
                break;

            case 'arrayValue':
                $res = [];

                foreach ($value['values'] as $val) {
                    $type = array_keys($val)[0];

                    $res[] = $this->decodeValue($type, current($val));
                }

                return $res;
                break;

            case 'mapValue':
                $res = [];

                foreach ($value['fields'] as $key => $val) {
                    $type = array_keys($val)[0];

                    $res[$key] = $this->decodeValue($type, current($val));
                }

                return $res;
                break;

            case 'referenceValue':
                $parent = new CollectionReference($this->connection, $this, $this->parentPath($value));
                return new DocumentReference($this->connection, $this, $parent, $value);

            default:
                throw new \RuntimeException(sprintf(
                    'unexpected value type %s!',
                    $type
                ));

                break;
        }
    }

    /**
     * Encode a Google Cloud PHP value as a Firestore value.
     *
     * @param mixed $value
     * @return array [Value](https://firebase.google.com/docs/firestore/reference/rpc/google.firestore.v1beta1#value)
     * @throws \RuntimeException If an unknown type is encountered.
     */
    public function encodeValue($value)
    {
        $type = gettype($value);

        switch ($type) {
            case 'boolean':
                return ['booleanValue' => $value];
                break;

            case 'integer':
                return ['integerValue' => $value];
                break;

            case 'double':
                return ['doubleValue' => $value];
                break;

            case 'string':
                return ['stringValue' => $value];
                break;

            case 'resource':
                return ['bytesValue' => stream_get_contents($value)];
                break;

            case 'object':
                return $this->encodeObjectValue($value);
                break;

            case 'array':
                if (!empty($value) && $this->isAssoc($value)) {
                    return $this->encodeAssociativeArrayValue($value);
                }

                return ['arrayValue' => $this->encodeArrayValue($value)];
                break;

            case 'NULL':
                // @todo encode this in a way such that is compatible with a potential future REST transport.
                return ['nullValue' => NullValue::NULL_VALUE];
                break;

            // @codeCoverageIgnoreStart
            default:
                throw new \RuntimeException(sprintf(
                    'Invalid value type %s',
                    $type
                ));
                break;
            // @codeCoverageIgnoreEnd
        }
    }

    /**
     * Encode a simple array as a Firestore array value.
     *
     * @codingStandardsIgnoreStart
     * @param array $value
     * @return array [ArrayValue](https://firebase.google.com/docs/firestore/reference/rpc/google.firestore.v1beta1#google.firestore.v1beta1.ArrayValue)
     * @throws \RuntimeException If the array contains a nested array.
     * @codingStandardsIgnoreEnd
     */
    public function encodeArrayValue(array $value)
    {
        $out = [];
        foreach ($value as $item) {
            if (is_array($item) && !$this->isAssoc($item)) {
                throw new \RuntimeException('Nested array values are not permitted.');
            }

            $out[] = $this->encodeValue($item);
        }

        return ['values' => $out];
    }

    /**
     * Encode a value of type `object` as a Firestore value.
     *
     * @param object $value
     * @return array
     * @throws \RuntimeException If an invalid object type is provided.
     */
    private function encodeObjectValue($value)
    {
        if ($value instanceof \stdClass) {
            return $this->encodeAssociativeArrayValue((array) $value);
        }

        if ($value instanceof Blob) {
            return ['bytesValue' => (string) $value];
        }

        if ($value instanceof \DateTimeInterface) {
            return [
                'timestampValue' => [
                    'seconds' => $value->format('U'),
                    'nanos' => (int)($value->format('u') * 1000)
                ]
            ];
        }

        if ($value instanceof Timestamp) {
            return [
                'timestampValue' => [
                    'seconds' => $value->get()->format('U'),
                    'nanos' => $value->nanoSeconds()
                ]
            ];
        }

        if ($value instanceof GeoPoint) {
            return ['geoPointValue' => $value->point()];
        }

        if ($value instanceof DocumentReference || $value instanceof DocumentSnapshot) {
            return ['referenceValue' => $value->name()];
        }

        throw new \RuntimeException(sprintf(
            'Object of type %s cannot be encoded to a Firestore value type.',
            get_class($value)
        ));
    }

    /**
     * Encode an associative array as a Firestore Map value.
     *
     * @codingStandardsIgnoreStart
     * @param array $value
     * @return array [MapValue](https://firebase.google.com/docs/firestore/reference/rpc/google.firestore.v1beta1#google.firestore.v1beta1.MapValue)
     * @codingStandardsIgnoreEnd
     */
    private function encodeAssociativeArrayValue(array $value)
    {
        $out = [];
        foreach ($value as $key => $item) {
            $out[$key] = $this->encodeValue($item);
        }

        return ['mapValue' => ['fields' => $out]];
    }

    /**
     * Encode a list of Google Cloud PHP values as a Firestore value.
     *
     * The list is treated as an ArrayValue with one exception: indexed arrays are allowed as top level items.
     * This is needed to properly encode values for "in" query filters.
     *
     * @param array $values
     * @return array [Value](https://firebase.google.com/docs/firestore/reference/rpc/google.firestore.v1beta1#value)
     */
    public function encodeMultiValue(array $values)
    {
        return [
            'arrayValue' => [
                'values' => array_map([$this, 'encodeValue'], $values),
            ],
        ];
    }
}
