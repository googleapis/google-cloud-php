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

namespace Google\Cloud\BigQuery;

use Google\Cloud\ArrayTrait;

/**
 * Maps values to their expected BigQuery types.
 */
class ValueMapper
{
    use ArrayTrait;

    const TYPE_BOOL = 'BOOL';
    const TYPE_INT64 = 'INT64';
    const TYPE_FLOAT64 = 'FLOAT64';
    const TYPE_STRING = 'STRING';
    const TYPE_BYTES = 'BYTES';
    const TYPE_DATE = 'DATE';
    const TYPE_DATETIME = 'DATETIME';
    const TYPE_TIME = 'TIME';
    const TYPE_TIMESTAMP = 'TIMESTAMP';
    const TYPE_ARRAY = 'ARRAY';
    const TYPE_STRUCT = 'STRUCT';

    const DATETIME_FORMAT = 'Y-m-d H:i:s.u';

    /**
     * Maps a value to the expected parameter format.
     *
     * @param mixed $value The value to map.
     * @return array
     * @throws \InvalidArgumentException
     */
    public function toParameter($value)
    {
        $pValue = ['value' => $value];
        $type = gettype($value);

        switch ($type) {
            case 'boolean':
                $pType['type'] = self::TYPE_BOOL;

                break;
            case 'integer':
                $pType['type'] = self::TYPE_INT64;

                break;
            case 'double':
                $pType['type'] = self::TYPE_FLOAT64;

                break;
            case 'string':
                $pType['type'] = self::TYPE_STRING;

                break;
            case 'resource':
                $pType['type'] = self::TYPE_BYTES;
                $pValue['value'] = base64_encode(stream_get_contents($value));

                break;
            case 'object':
                list($pType, $pValue) = $this->objectToParameter($value);

                break;
            case 'array':
                list($pType, $pValue) = $this->isAssoc($value)
                    ? $this->assocArrayToParameter($value)
                    : $this->arrayToParameter($value);

                break;
            default:
                throw new \InvalidArgumentException(sprintf(
                    'Unrecognized value type %s. Please ensure you are using the latest version of google/cloud.',
                    $type
                ));

                break;
        }

        return [
            'parameterType' => $pType,
            'parameterValue' => $pValue
        ];
    }

    /**
     * @param mixed $object The object to map.
     * @return array
     * @throws \InvalidArgumentException
     */
    private function objectToParameter($object)
    {
        if ($object instanceof ValueInterface) {
            return [
                ['type' => $object->type()],
                ['value' => $object->toApi()]
            ];
        }

        if ($object instanceof \DateTimeInterface) {
            return [
                ['type' => self::TYPE_DATETIME],
                ['value' => $object->format(self::DATETIME_FORMAT)]
            ];
        }

        throw new \InvalidArgumentException(sprintf(
            'Unrecognized object %s. Please ensure you are using the latest version of google/cloud.',
            get_class($object)
        ));
    }

    /**
     * @param array $array The array to map.
     * @return array
     */
    private function arrayToParameter(array $array)
    {
        $type = [];
        $values = [];

        foreach ($array as $value) {
            $param = $this->toParameter($value);
            $type = $param['parameterType'];
            $values[] = $param['parameterValue'];
        }

        return [
            [
                'type' => self::TYPE_ARRAY,
                'arrayType' => $type
            ],
            ['arrayValues' => $values]
        ];
    }

    /**
     * @param array $struct The struct to map.
     * @return array
     */
    private function assocArrayToParameter(array $struct)
    {
        $types = [];
        $values = [];

        foreach ($struct as $name => $value) {
            $param = $this->toParameter($value);
            $types[] = [
                'name' => $name,
                'type' => $param['parameterType']
            ];
            $values[$name] = $param['parameterValue'];
        }

        return [
            [
                'type' => self::TYPE_STRUCT,
                'structTypes' => $types
            ],
            ['structValues' => $values]
        ];
    }
}
