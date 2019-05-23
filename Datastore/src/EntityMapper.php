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

use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\Int64;
use Google\Cloud\Datastore\Entity;
use Google\Cloud\Datastore\GeoPoint;
use Google\Cloud\Datastore\Key;

/**
 * Utility methods for mapping between datastore and {@see Google\Cloud\Datastore\Entity}.
 */
class EntityMapper
{
    use ArrayTrait;
    use DatastoreTrait;

    const DATE_FORMAT = 'Y-m-d\TH:i:s.uP';
    const DATE_FORMAT_NO_MS = 'Y-m-d\TH:i:sP';

    /**
     * @var string
     */
    private $projectId;

    /**
     * @var bool
     */
    private $encode;

    /**
     * @var bool
     */
    private $returnInt64AsObject;

    /**
     * Create an Entity Mapper
     *
     * @param string $projectId The datastore project ID
     * @param bool $encode Whether to encode blobs as base64.
     * @param bool $returnInt64AsObject If true, 64 bit integers will be
     *        returned as a {@see Google\Cloud\Core\Int64} object for 32 bit
     *        platform compatibility.
     */
    public function __construct($projectId, $encode, $returnInt64AsObject)
    {
        $this->projectId = $projectId;
        $this->encode = $encode;
        $this->returnInt64AsObject = $returnInt64AsObject;
    }

    /**
     * Convert an entity response to properties, excludes and meanings.
     *
     * @param array $entityData The incoming entity
     * @param string $className The name of a class to use as the entity. Must
     *        implement {@see Google\Cloud\Datastore\EntityInterface}.
     * @return array
     * @throws \InvalidArgumentException If the value of $className does not
     *       implement {@see Google\Cloud\Datastore\EntityInterface}.
     * @throws \InvalidArgumentException If the custom entity type containts invalid
     *       mappings for embedded entities.
     */
    public function responseToEntityProperties(array $entityData, $className = Entity::class)
    {
        if (!is_subclass_of($className, EntityInterface::class)) {
            throw new \InvalidArgumentException(sprintf(
                'Class %s must implement EntityInterface.',
                $className
            ));
        }

        $properties = [];
        $excludes = [];
        $meanings = [];

        $mappings = $className::mappings();
        foreach ($entityData as $key => $property) {
            $mapClassName = Entity::class;
            if (array_key_exists($key, $mappings)) {
                $mapClassName = $mappings[$key];
            }

            if ($mapClassName) {
                if (!is_subclass_of($mapClassName, EntityInterface::class)) {
                    throw new \InvalidArgumentException(sprintf(
                        'Class %s must implement EntityInterface. (Found in mappings on %s)',
                        $mapClassName,
                        $className
                    ));
                }
            }

            $properties[$key] = $this->getPropertyValue($property, $mapClassName);

            if (isset($property['excludeFromIndexes']) && $property['excludeFromIndexes']) {
                $excludes[] = $key;
            }

            if (isset($property['meaning']) && $property['meaning']) {
                $meanings[$key] = $property['meaning'];
            }
        }

        return [
            'properties' => $properties,
            'excludes' => $excludes,
            'meanings' => $meanings
        ];
    }

    /**
     * Translate an Entity to a datastore representation.
     *
     * @param EntityInterface $entity The input entity.
     * @return array A Datastore [Entity](https://cloud.google.com/datastore/reference/rest/v1/Entity)
     */
    public function objectToRequest(EntityInterface $entity)
    {
        $data = $entity->get();

        $properties = [];
        foreach ($data as $key => $value) {
            $exclude = in_array($key, $entity->excludedProperties());
            $meaning = (isset($entity->meanings()[$key]))
                ? $entity->meanings()[$key]
                : null;

            $properties[$key] = $this->valueObject(
                $value,
                $exclude,
                $meaning
            );
        }

        $key = $entity->key()
            ? $entity->key()->keyObject()
            : null;

        return array_filter([
            'key' => $key,
            'properties' => $properties
        ]);
    }

    /**
     * Convert a Datastore value object to a simple value
     *
     * @param string $type The value type
     * @param mixed $value The value
     * @param string $className [optional] The object type to decode to, if type is entityValue.
     * @return mixed
     */
    public function convertValue($type, $value, $className = Entity::class)
    {
        $result = null;

        switch ($type) {
            case 'nullValue':
                $result = null;

                break;

            case 'booleanValue':
                $result = (bool) $value;
                break;

            case 'integerValue':
                $result = $this->returnInt64AsObject
                    ? new Int64((string) $value)
                    : (int) $value;

                break;

            case 'doubleValue':
                $result = (float) $value;

                break;

            case 'timestampValue':
                $result = \DateTimeImmutable::createFromFormat(self::DATE_FORMAT, $value);

                if (!$result) {
                    $result = \DateTimeImmutable::createFromFormat(self::DATE_FORMAT_NO_MS, $value);
                }

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

            case 'stringValue':
                $result = $value;

                break;

            case 'blobValue':
                if ($this->isEncoded($value)) {
                    $value = base64_decode($value);
                }

                $result = new Blob($value);

                break;

            case 'geoPointValue':
                $value += [
                    'latitude' => null,
                    'longitude' => null
                ];

                $result = new GeoPoint($value['latitude'], $value['longitude'], true);

                break;

            case 'entityValue':
                $properties = isset($value['properties'])
                    ? $value['properties']
                    : [];

                $decoded = $this->responseToEntityProperties($properties, $className);
                $props = $decoded['properties'];
                $excludes = $decoded['excludes'];

                // @todo (major) all embedded entities should be of type Entity or given EntityInterface type.
                if (isset($value['key']) || $className !== Entity::class) {
                    $key = null;

                    if (isset($value['key']['path'])) {
                        $namespaceId = (isset($value['key']['partitionId']['namespaceId']))
                            ? $value['key']['partitionId']['namespaceId']
                            : null;

                        $key = new Key($this->projectId, [
                            'path' => $value['key']['path'],
                            'namespaceId' => $namespaceId
                        ]);
                    }

                    $result = $className::build($key, $props, [
                        'populatedByService' => true,
                        'excludeFromIndexes' => $excludes
                    ]);
                } else {
                    $result = [];

                    foreach ($properties as $key => $property) {
                        $result[$key] = $this->getPropertyValue($property);
                    }

                    if ($excludes) {
                        $result[Entity::EXCLUDE_FROM_INDEXES] = $excludes;
                    }
                }

                break;

            case 'arrayValue':
                $result = [];

                if (array_key_exists('values', $value)) {
                    foreach ($value['values'] as $val) {
                        $result[] = $this->getPropertyValue($val);
                    }
                }

                break;

            default:
                throw new \RuntimeException(sprintf(
                    'Unrecognized value type %s. Please ensure you are using the latest version of google/cloud.',
                    $type
                ));

                break;
        }


        return $result;
    }

    /**
     * Format values for the API
     *
     * @param mixed $value
     * @param bool $exclude [optional] If true, value will be excluded from datastore indexes.
     * @param int $meaning [optional] The Meaning value. Maintained only for backwards compatibility.
     * @return array
     */
    public function valueObject($value, $exclude = false, $meaning = null)
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
                throw new \InvalidArgumentException(sprintf(
                    'Unknown type for `%s',
                    $value
                ));
                break;

            default:
                throw new \InvalidArgumentException(sprintf(
                    'Invalid type for `%s',
                    $value
                ));
                break;
            //@codeCoverageIgnoreEnd
        }

        if ($exclude) {
            $propertyValue['excludeFromIndexes'] = true;
        }

        if ($meaning) {
            $propertyValue['meaning'] = $meaning;
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
            case $value instanceof Int64:
                return [
                    'integerValue' => $value->get()
                ];

                break;
            case $value instanceof Blob:
                return [
                    'blobValue' => ($this->encode)
                        ? base64_encode((string) $value)
                        : (string) $value
                ];

                break;

            case $value instanceof \DateTimeInterface:
                return [
                    'timestampValue' => $value->format(self::DATE_FORMAT)
                ];

                break;

            case $value instanceof EntityInterface:
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

            case $value instanceof \stdClass:
                return $this->convertArrayToEntityValue((array) $value);

            default:
                throw new \InvalidArgumentException(
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
            // ListValues may not contain nested ListValues.
            // Therefore, if an empty array is provided as part of an array,
            // we can encode it as an EntityValue.
            if (is_array($val) && empty($val)) {
                $val = (object) $val;
            }

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
        $excludes = $this->pluck(Entity::EXCLUDE_FROM_INDEXES, $value, false) ?: [];

        $properties = [];
        foreach ($value as $key => $val) {
            $properties[$key] = $this->valueObject(
                $val,
                in_array($key, $excludes)
            );
        }

        if (!$properties) {
            $properties = (object) $properties;
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
        return base64_encode($decoded) == $value;
    }

    /**
     * Determine the property type and return a converted value
     *
     * @param array $property The API property
     * @param string $className [optional] The type to decode into, if property is an entity.
     * @return mixed
     */
    private function getPropertyValue(array $property, $className = Entity::class)
    {
        $type = $this->getValueType($property);
        return $this->convertValue($type, $property[$type], $className);
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

        throw new \RuntimeException('Invalid entity property value given');
    }
}
