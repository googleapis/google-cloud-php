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
use Google\Cloud\Core\ValueMapperTrait;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Protobuf\NullValue;

class ValueMapper
{
    use ArrayTrait;
    use DebugInfoTrait;
    use ValueMapperTrait;

    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @var bool
     */
    private $returnInt64AsObject;

    /**
     * @param bool $returnInt64AsObject
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
     * @param array $fields
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
     * @param array $fields
     * @return array
     */
    public function encodeValues(array $fields)
    {
        $output = [];

        foreach ($fields as $key => $val) {
            if ($val === Document::DELETE_FIELD) {
                continue;
            }

            $output[$key] = $this->encodeValue($val);
        }

        return $output;
    }

    /**
     * Create a list of fields paths from field data.
     *
     * @param array $fields
     * @param string $parentPath
     * @return array
     */
    public function encodeFieldPaths(array $fields, $parentPath = '')
    {
        $output = [];

        foreach ($fields as $key => $val) {
            if (is_array($val)) {
                $nestedParentPath = $parentPath
                    ? $parentPath . '.' . $key
                    : $key;

                $output = array_merge($output, $this->encodeFieldPaths($val, $nestedParentPath));
            } else {
                $output[] = $parentPath
                    ? $parentPath . '.' . $key
                    : $key;
            }
        }

        return $output;
    }

    /**
     * Accepts a list of [string,mixed], where the key is a field path and the
     * value is a document field value, and returns a nested array.
     *
     * @param array $fieldPaths
     * @return array
     */
    public function decodeFieldPaths(array $fieldPaths)
    {
        $output = [];

        $mapper = function (&$arr, $path, $value) {
            $keys = explode('.', $path);

            foreach ($keys as $key) {
                $arr = &$arr[$key];
            }

            $arr = $value;
        };

        foreach ($fieldPaths as $fieldPath => $fieldValue) {
            $mapper($output, $fieldPath, $fieldValue);
        }

        return $output;
    }

    private function decodeValue($type, $value)
    {
        switch ($type) {
            case 'booleanValue':
            case 'nullValue':
            case 'stringValue':
            case 'doubleValue':
                return $value;
                break;

            case 'bytesValue':
                return new Blob($value);

            case 'integerValue':
                return $this->returnInt64AsObject
                    ? new Int64($value)
                    : $value;

            case 'timestampValue':
                return $this->createTimestampWithNanos($value);
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
                return new Document($this->connection, $this, $value);

            default:
                throw new \RuntimeException(sprintf(
                    'unexpected value type %s!',
                    $type
                ));

                break;
        }
    }

    private function encodeValue($value)
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
                return ['bytesValue' => base64_encode(stream_get_contents($value))];
                break;

            case 'object':
                return $this->encodeObjectValue($value);
                break;

            case 'array':
                if ($this->isAssoc($value)) {
                    return $this->encodeAssociativeArrayValue($value);
                }

                return $this->encodeArrayValue($value);
                break;

            case 'NULL':
                // @todo encode this in a way such that is compatible with a potential future REST transport.
                return ['nullValue' => NullValue::NULL_VALUE];
                break;

            default:
                throw new \RuntimeException(sprintf(
                    'Invalid value type %s',
                    $type
                ));
                break;
        }
    }

    private function encodeObjectValue($value)
    {
        $class = get_class($value);

        switch ($class) {
            case 'stdClass':
                return $this->encodeAssociativeArrayValue((array) $value);

            case Blob::class:
                return ['bytesValue' => (string) $value];

            case Timestamp::class:
                return ['timestampValue' => [
                    'seconds' => $value->get()->format('U'),
                    'nanos' => $value->nanoSeconds()
                ]];

            case GeoPoint::class:
                return ['geoPointValue' => $value->point()];

            case Document::class:
                return ['referenceValue' => $value->name()];

            default:
                throw new \BadMethodCallException(sprintf(
                    'Object of type %s cannot be encoded to a Firestore value type.',
                    $class
                ));
        }
    }

    private function encodeAssociativeArrayValue(array $value)
    {
        $out = [];
        foreach ($value as $key => $item) {
            $out[$key] = $this->encodeValue($item);
        }

        return ['mapValue' => ['fields' => $out]];
    }

    private function encodeArrayValue(array $value)
    {
        $out = [];
        foreach ($value as $item) {
            if (is_array($item)) {
                throw new \BadMethodCallException('Nested array values are not permitted.');
            }

            $out[] = $this->encodeValue($item);
        }

        return ['arrayValue' => ['values' => $out]];
    }
}
