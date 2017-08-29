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

use Google\Cloud\Core\DebugInfoTrait;
use Google\Cloud\Core\GeoPoint;
use Google\Cloud\Core\Int64;
use Google\Cloud\Core\ValueMapperTrait;
use Google\Cloud\Firestore\Connection\ConnectionInterface;

class ValueMapper
{
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

    public function encodeValues()
    {}

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
}
