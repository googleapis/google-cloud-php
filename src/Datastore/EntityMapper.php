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

class EntityMapper
{
    private $encode;

    public function __construct($encode)
    {
        $this->encode = $encode;
    }

    use DatastoreTrait;

    public function responseToProperties(array $entityData)
    {

        $props = [];
        $excludes = [];

        foreach ($entityData as $key => $property) {
            $type = key($property);

            $props[$key] = $this->convertValue($type, $property[$type]);

            if (isset($property['excludeFromIndexes']) && $property['excludeFromIndexes']) {
                $excludes[] = $key;
            }
        }

        return $props;
    }

    /**
     * Translate an Entity to a datastore representation.
     *
     * @param Entity $entity The input entity.
     * @param bool $encode Whether to encode blobs as base64.
     * @return array [Entity](https://cloud.google.com/datastore/reference/rest/v1/Entity)
     */
    public function objectToRequest(Entity $entity)
    {
        $data = $entity->get();

        $properties = [];
        foreach ($data as $key => $value) {
            $exclude = in_array($key, $entity->excludedProperties());

            $properties[$key] = $this->valueObject(
                $value,
                $this->encode,
                $exclude
            );
        }

        return [
            'key' => $entity->key(),
            'properties' => $properties
        ];
    }

    private function convertValue($type, $value)
    {
        $result = null;

        switch ($type) {
            case 'timestampValue':
                try {
                    $result = new \DateTimeImmutable($value);
                } catch (\TypeError $e) {
                    print_R($value);exit;
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

            case 'geoPointValue':
                $value += [
                    'latitude' => null,
                    'longitude' => null
                ];

                $result = new GeoPoint($value['latitude'], $value['longitude']);

                break;

            case 'entityValue':
                $result = $this->translateIncomingEntity($value);

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
                    $type = key($val);

                    $result[] = $this->convertValue($type, $val[$type]);
                }

                break;

            default:
                $result = $value;
                break;
        }


        return $result;
    }
}
