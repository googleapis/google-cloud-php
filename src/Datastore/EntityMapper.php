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

namespace Google\Cloud\Datastore;

use Google\Cloud\Datastore\Entity;
use Google\Cloud\Datastore\GeoPoint;
use Google\Cloud\Datastore\Key;
use InvalidArgumentException;
use RuntimeException;

/**
 * Utility methods for mapping between datastore and {@see Google\Cloud\Datastore\Entity}.
 */
class EntityMapper
{
    use DatastoreTrait;

    /**
     * @var string
     */
    private $projectId;

    /**
     * @var bool
     */
    private $encode;

    /**
     * Create an Entity Mapper
     *
     * @param string $projectId The datastore project ID
     * @param bool $encode Whether to encode blobs as base64.
     */
    public function __construct($projectId, $encode)
    {
        $this->projectId = $projectId;
        $this->encode = $encode;
    }

    /**
     * Map a lookup or query result to a set of properties
     *
     * @param array $entityData The incoming entity data
     * @return array
     */
    public function responseToProperties(array $entityData)
    {
        $props = [];

        foreach ($entityData as $key => $property) {
            $props[$key] = $this->getPropertyValue($property);
        }

        return $props;
    }

    /**
     * Get a list of properties excluded from datastore indexes
     *
     * @param array $entityData The incoming entity data
     * @return array
     */
    public function responseToExcludeFromIndexes(array $entityData)
    {
        $excludes = [];

        foreach ($entityData as $key => $property) {
            if (isset($property['excludeFromIndexes']) && $property['excludeFromIndexes']) {
                $excludes[] = $key;
            }
        }

        return $excludes;
    }

    /**
     * Translate an Entity to a datastore representation.
     *
     * @param Entity $entity The input entity.
     * @return array A Datastore [Entity](https://cloud.google.com/datastore/reference/rest/v1/Entity)
     */
    public function objectToRequest(Entity $entity)
    {
        $data = $entity->get();

        $properties = [];
        foreach ($data as $key => $value) {
            $exclude = in_array($key, $entity->excludedProperties());

            $properties[$key] = $this->valueObject(
                $value,
                $exclude
            );
        }

        return array_filter([
            'key' => $entity->key(),
            'properties' => $properties
        ]);
    }

    /**
     * Convert a Datastore value object to a simple value
     *
     * @param string $type The value type
     * @param mixed $value The value
     * @return mixed
     */
    public function convertValue($type, $value)
    {
        $result = null;

        switch ($type) {
            case 'timestampValue':
                $result = new \DateTimeImmutable($value);

                break;

            case 'keyValue':
                $namespaceId = (isset($value['partitionId']['namespaceId']))
                    ? $value['partitionId']['namespaceId']
                    : null;

                $result = new Key($this->projectId, [
                    'path' => $value['path'],
                    'namespaceId' => $namespaceId
                ]);

                break;

            case 'geoPointValue':
                $value += [
                    'latitude' => null,
                    'longitude' => null
                ];

                $result = new GeoPoint($value['latitude'], $value['longitude']);

                break;

            case 'entityValue':
                $props = $this->responseToProperties($value['properties']);

                if (isset($value['key'])) {
                    $namespaceId = (isset($value['key']['partitionId']['namespaceId']))
                        ? $value['key']['partitionId']['namespaceId']
                        : null;

                    $key = new Key($this->projectId, [
                        'path' => $value['key']['path'],
                        'namespaceId' => $namespaceId
                    ]);

                    $result = new Entity($key, $props, [
                        'populatedByService' => true
                    ]);
                } else {
                    $result = [];

                    foreach ($value['properties'] as $key => $property) {
                        $result[$key] = $this->getPropertyValue($property);
                    }
                }

                break;

            case 'doubleValue':
                $result = (float) $value;

                break;

            case 'integerValue':
                $result = (int) $value;

                break;

            case 'arrayValue':
                $result = [];

                foreach ($value['values'] as $val) {
                    $result[] = $this->getPropertyValue($val);
                }

                break;

            case 'blobValue':
                if ($this->isEncoded($value)) {
                    $value = base64_decode($value);
                }

                $result = new Blob($value);

                break;

            default:
                $result = $value;
                break;
        }


        return $result;
    }

    /**
     * Format values for the API
     *
     * @param mixed $value
     * @param bool $exclude [optional] If true, value will be excluded from datastore indexes.
     * @return array
     */
    public function valueObject($value, $exclude = false)
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
                    $propertyValue = $this->convertArrayToEntityValue($value);
                } else {
                    $propertyValue = $this->convertArrayToArrayValue($value);
                }

                break;

            case 'object':
                $propertyValue = $this->objectProperty($value);
                break;

            case 'resource':
                $content = stream_get_contents($value);

                $propertyValue = [
                    'blobValue' => ($this->encode)
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
     * @param mixed $value The value object
     * @return array
     */
    public function objectProperty($value)
    {
        switch (true) {
            case $value instanceof Blob:
                return [
                    'blobValue' => ($this->encode)
                        ? base64_encode((string) $value)
                        : (string) $value
                ];

                break;

            case $value instanceof \DateTimeInterface:
                return [
                    'timestampValue' => $value->format(\DateTime::RFC3339)
                ];

                break;

            case $value instanceof Entity:
                return [
                    'entityValue' => $this->objectToRequest($value)
                ];

                break;

            case $value instanceof GeoPoint:
                return [
                    'geoPointValue' => $value->point()
                ];

                break;

            case $value instanceof Key:
                return [
                    'keyValue' => $value->keyObject()
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
     * Convert a non-associative array to a datastore arrayValue type
     *
     * @param array $value The input array
     * @return array The arrayValue property
     */
    private function convertArrayToArrayValue(array $value)
    {
        $values = [];
        foreach ($value as $val) {
            $values[] = $this->valueObject($val);
        }

        return [
            'arrayValue' => [
                'values' => $values
            ]
        ];
    }

    /**
     * Convert an associative array to a datastore entityValue type
     *
     * @param array $value The input array
     * @return array The entityValue property
     */
    private function convertArrayToEntityValue(array $value)
    {
        $properties = [];
        foreach ($value as $key => $val) {
            $properties[$key] = $this->valueObject($val);
        }

        return [
            'entityValue' => [
                'properties' => $properties
            ]
        ];
    }

    private function isEncoded($value)
    {
        // Check if there are valid base64 characters
        if (!preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $value)) {
            return false;
        }

        // Decode the string in strict mode and check the results
        $decoded = base64_decode($value, true);
        if ($decoded == false) {
            return false;
        }

        // Encode the string again
        if (base64_encode($decoded) != $value) {
            return false;
        }

        return true;
    }

    /**
     * Determine the property type and return a converted value
     *
     * @param array $property The API property
     * @return mixed
     */
    private function getPropertyValue(array $property)
    {
        $type = $this->getValueType($property);
        return $this->convertValue($type, $property[$type]);
    }

    /**
     * Get the value type from a value object.
     *
     * @param array $value
     * @return string
     * @throws RuntimeException
     */
    private function getValueType(array $value)
    {
        $keys = array_keys($value);
        $types = array_values(array_filter($keys, function ($key) {
            return strpos($key, 'Value') !== false;
        }));

        if (!empty($types)) {
            return $types[0];
        }

        throw new RuntimeException('Invalid entity property value given');
    }
}
