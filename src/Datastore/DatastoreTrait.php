<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Datastore;

use InvalidArgumentException;
use Psr\Http\Message\StreamInterface;

/**
 * Utility methods mostly for translating data from user input to API format.
 */
trait DatastoreTrait
{
    /**
     * Format the partitionId
     *
     * @param string $projectId
     * @param string $namespaceId
     * @return array
     */
    private function partitionId($projectId, $namespaceId)
    {
        return array_filter([
            'projectId' => $projectId,
            'namespaceId' => $namespaceId
        ]);
    }

    /**
     * Format values for the API
     *
     * @param mixed $value
     * @param bool $encode Set to true to base64_encode certain values.
     * @param bool $exclude If true, value will be excluded from datastore indexes.
     * @return array
     */
    private function valueObject($value, $encode = false, $exclude = false)
    {
        switch (gettype($value)) {
            case 'boolean':
                $propertyValue = [
                    'booleanValue' => $value
                ];

                break;

            case 'integer':
                $propertyValue = [
                    'integerValue' => $value
                ];

                break;

            case 'double':
                $propertyValue = [
                    'doubleValue' => $value
                ];

                break;

            case 'string':
                $propertyValue = [
                    'stringValue' => $value
                ];

                break;

            case 'array':
                if (!empty($value) && $this->isAssoc($value)) {
                    print_R($value);exit;
                    throw new \InvalidArgumentException('Associative Arrays cannot be stored in datastore');
                }

                $values = [];
                foreach ($value as $val) {
                    $values[] = $this->valueObject($val, $encode);
                }

                $propertyValue = [
                    'arrayValue' => [
                        'values' => $values
                    ]
                ];
                break;

            case 'object':
                $propertyValue = $this->objectProperty($value);
                break;

            case 'resource':
                $content = stream_get_contents($value);

                $propertyValue = [
                    'blobValue' => ($encode)
                        ? base64_encode($content)
                        : $content
                ];
                break;

            case 'NULL':
                $propertyValue = [
                    'nullValue' => null
                ];
                break;

            //@codeCoverageIgnoreStart
            case 'unknown type':
                throw new InvalidArgumentException(sprintf(
                    'Unknown type for `%s',
                    $content
                ));
                break;

            default:
                throw new InvalidArgumentException(sprintf(
                    'Invalid type for `%s',
                    $content
                ));
                break;
            //@codeCoverageIgnoreEnd
        }

        if ($exclude) {
            $propertyValue['excludeFromIndexes'] = true;
        }

        return $propertyValue;
    }

    /**
     * Convert different object types to API values
     *
     * @todo add middleware
     *
     * @param mixed $value
     * @param bool $encode
     * @return array
     */
    private function objectProperty($value, $encode = false)
    {
        switch (true) {
            case $value instanceof \DateTimeInterface:
                return [
                    'timestampValue' => $value->format(\DateTime::RFC3339)
                ];

                break;

            case $value instanceof Key:
                return [
                    'keyValue' => $value->keyObject()
                ];

                break;

            case $value instanceof GeoPoint:
                return [
                    'geoPointValue' => $value->point()
                ];

                break;

            default:
                throw new InvalidArgumentException(
                    sprintf('Value of type `%s` could not be serialized', get_class($value))
                );

                break;
        }
    }

    /**
     * Determine whether given array is associative
     *
     * @param array $value
     * @return bool
     */
    private function isAssoc(array $value)
    {
        return array_keys($value) !== range(0, count($value) - 1);
    }
}
