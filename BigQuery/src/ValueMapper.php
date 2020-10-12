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

use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\Int64;

/**
 * Maps values to their expected BigQuery types. This class is intended for
 * internal use only.
 */
class ValueMapper
{
    use ArrayTrait;

    const TYPE_BOOL = 'BOOL';
    const TYPE_BOOLEAN = 'BOOLEAN';
    const TYPE_INT64 = 'INT64';
    const TYPE_INTEGER = 'INTEGER';
    const TYPE_FLOAT64 = 'FLOAT64';
    const TYPE_FLOAT = 'FLOAT';
    const TYPE_NUMERIC = 'NUMERIC';
    const TYPE_STRING = 'STRING';
    const TYPE_BYTES = 'BYTES';
    const TYPE_DATE = 'DATE';
    const TYPE_DATETIME = 'DATETIME';
    const TYPE_TIME = 'TIME';
    const TYPE_TIMESTAMP = 'TIMESTAMP';
    const TYPE_ARRAY = 'ARRAY';
    const TYPE_STRUCT = 'STRUCT';
    const TYPE_RECORD = 'RECORD';
    const TYPE_GEOGRAPHY = 'GEOGRAPHY';

    const DATETIME_FORMAT = 'Y-m-d H:i:s.u';
    const DATETIME_FORMAT_INSERT = 'Y-m-d\TH:i:s.u';

    /**
     * @var bool $returnInt64AsObject If true, 64 bit integers will be returned
     *      as a {@see Google\Cloud\Core\Int64} object for 32 bit platform
     *      compatibility.
     */
    private $returnInt64AsObject;

    /**
     * @param bool $returnInt64AsObject If true, 64 bit integers will be
     *        returned as a {@see Google\Cloud\Core\Int64} object for 32 bit
     *        platform compatibility.
     */
    public function __construct($returnInt64AsObject)
    {
        $this->returnInt64AsObject = $returnInt64AsObject;
    }

    /**
     * Maps a value coming from BigQuery to the expected format for use in the
     * library.
     *
     * @param array $value The value to map.
     * @param array $schema The schema describing the value.
     * @throws \InvalidArgumentException
     */
    public function fromBigQuery(array $value, array $schema)
    {
        $value = $value['v'];

        if (isset($schema['mode'])) {
            if ($schema['mode'] === 'REPEATED') {
                return $this->repeatedValueFromBigQuery($value, $schema);
            }

            if ($schema['mode'] === 'NULLABLE' && $value === null) {
                return $value;
            }
        }

        switch ($schema['type']) {
            case self::TYPE_BOOLEAN:
                return $value === 'true';
            case self::TYPE_INTEGER:
                return $this->returnInt64AsObject
                    ? new Int64($value)
                    : (int) $value;
            case self::TYPE_FLOAT:
                return (float) $value;
            case self::TYPE_NUMERIC:
                return new Numeric($value);
            case self::TYPE_STRING:
                return (string) $value;
            case self::TYPE_BYTES:
                return new Bytes(base64_decode($value));
            case self::TYPE_DATE:
                return new Date(new \DateTime($value));
            case self::TYPE_DATETIME:
                return new \DateTime($value);
            case self::TYPE_TIME:
                return new Time(new \DateTime($value));
            case self::TYPE_TIMESTAMP:
                return $this->timestampFromBigQuery($value);
            case self::TYPE_RECORD:
                return $this->recordFromBigQuery($value, $schema['fields']);
            case self::TYPE_GEOGRAPHY:
                return new Geography((string) $value);
            default:
                throw new \InvalidArgumentException(sprintf(
                    'Unrecognized value type %s. Please ensure you are using the latest version of google/cloud.',
                    $schema['type']
                ));

                break;
        }
    }

    /**
     * Maps a user provided value to the expected BigQuery format.
     *
     * @param mixed $value The value to map.
     * @return mixed
     */
    public function toBigQuery($value)
    {
        if ($value instanceof ValueInterface || $value instanceof Int64) {
            return (string) $value;
        }

        if ($value instanceof \DateTime) {
            return $value->format(self::DATETIME_FORMAT_INSERT);
        }

        if (is_array($value)) {
            foreach ($value as $key => $item) {
                $value[$key] = $this->toBigQuery($item);
            }

            return $value;
        }

        return $value;
    }

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
     * @param array $value The value to map.
     * @param array $schema The schema describing the value.
     * @return array
     */
    private function recordFromBigQuery(array $value, array $schema)
    {
        $record = [];

        foreach ($value['f'] as $key => $val) {
            $record[$schema[$key]['name']] = $this->fromBigQuery($val, $schema[$key]);
        }

        return $record;
    }

    /**
     * @param array $value The value to map.
     * @param array $schema The schema describing the value.
     * @return array
     */
    private function repeatedValueFromBigQuery(array $value, array $schema)
    {
        $repeatedValues = [];

        foreach ($value as $repeatedValue) {
            unset($schema['mode']);
            $repeatedValues[] = $this->fromBigQuery($repeatedValue, $schema);
        }

        return $repeatedValues;
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
                ['value' => (string) $object]
            ];
        }

        if ($object instanceof \DateTimeInterface) {
            return [
                ['type' => self::TYPE_DATETIME],
                ['value' => $object->format(self::DATETIME_FORMAT)]
            ];
        }

        if ($object instanceof Int64) {
            return [
                ['type' => self::TYPE_INT64],
                ['value' => $object->get()]
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

    /**
     * Converts a timestamp in string format received from BigQuery to a
     * {@see Google\Cloud\BigQuery\Timestamp}.
     *
     * @param string $value The timestamp.
     * @return Timestamp
     */
    private function timestampFromBigQuery($value)
    {
        // If the string contains 'E' convert from exponential notation to
        // decimal notation. This doesn't cast to a float because precision can
        // be lost.
        if (strpos($value, 'E')) {
            list($value, $exponent) = explode('E', $value);
            list($firstDigit, $remainingDigits) = explode('.', $value);

            if (strlen($remainingDigits) > $exponent) {
                $value = $firstDigit . substr_replace($remainingDigits, '.', $exponent, 0);
            } else {
                $value = $firstDigit . str_pad($remainingDigits, $exponent, '0') . '.0';
            }
        }

        $parts = explode('.', $value);
        $unixTimestamp = $parts[0];
        $microSeconds = isset($parts[1])
            ? $parts[1]
            : 0;

        $dateTime = new \DateTime("@$unixTimestamp");

        // If the timestamp is before the epoch, make sure we account for that
        // before concatenating the microseconds.
        if ($microSeconds > 0 && $unixTimestamp[0] === '-') {
            $microSeconds = 1000000 - (int) str_pad($microSeconds, 6, '0');
            $dateTime->modify('-1 second');
        }

        return new Timestamp(
            new \DateTime(
                sprintf(
                    '%s.%s+00:00',
                    $dateTime->format('Y-m-d H:i:s'),
                    $microSeconds
                )
            )
        );
    }
}
