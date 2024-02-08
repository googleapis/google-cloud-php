<?php

/**
 * Copyright 2023 Google Inc. All Rights Reserved.
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
namespace Google\Cloud\Core;

use Google\ApiCore\ArrayTrait;
use Google\ApiCore\Options\CallOptions;
use Google\Protobuf\NullValue;
use Google\Cloud\Core\Duration;

/**
 * @internal
 * Supplies helper methods to interact with the APIs.
 */
trait ApiHelperTrait
{
    use ArrayTrait;
    use TimeTrait;

    /**
     * Format a struct for the API.
     *
     * @param array $fields
     * @return array
     */
    private function formatStructForApi(array $fields)
    {
        $fFields = [];

        foreach ($fields as $key => $value) {
            $fFields[$key] = $this->formatValueForApi($value);
        }

        return ['fields' => $fFields];
    }

    private function unpackStructFromApi(array $struct)
    {
        $vals = [];
        foreach ($struct['fields'] as $key => $val) {
            $vals[$key] = $this->unpackValue($val);
        }
        return $vals;
    }

    private function unpackValue($value)
    {
        if (count($value) > 1) {
            throw new \RuntimeException("Unexpected fields in struct: $value");
        }

        foreach ($value as $setField => $setValue) {
            switch ($setField) {
                case 'listValue':
                    $valueList = [];
                    foreach ($setValue['values'] as $innerValue) {
                        $valueList[] = $this->unpackValue($innerValue);
                    }
                    return $valueList;
                case 'structValue':
                    return $this->unpackStructFromApi($value['structValue']);
                default:
                    return $setValue;
            }
        }
    }

    private function flattenStruct(array $struct)
    {
        return $struct['fields'];
    }

    private function flattenValue(array $value)
    {
        if (count($value) > 1) {
            throw new \RuntimeException("Unexpected fields in struct: $value");
        }

        if (isset($value['nullValue'])) {
            return null;
        }

        return array_pop($value);
    }

    private function flattenListValue(array $value)
    {
        return $value['values'];
    }

    /**
     * Format a list for the API.
     *
     * @param array $list
     * @return array
     */
    private function formatListForApi(array $list)
    {
        $values = [];

        foreach ($list as $value) {
            $values[] = $this->formatValueForApi($value);
        }

        return ['values' => $values];
    }

    /**
     * Format a value for the API.
     *
     * @param mixed $value
     * @return array
     */
    private function formatValueForApi($value)
    {
        $type = gettype($value);

        switch ($type) {
            case 'string':
                return ['string_value' => $value];
            case 'double':
            case 'integer':
                return ['number_value' => $value];
            case 'boolean':
                return ['bool_value' => $value];
            case 'NULL':
                return ['null_value' => NullValue::NULL_VALUE];
            case 'array':
                if (!empty($value) && $this->isAssoc($value)) {
                    return ['struct_value' => $this->formatStructForApi($value)];
                }

                return ['list_value' => $this->formatListForApi($value)];
        }

        return [];
    }

    /**
     * Format a gRPC timestamp to match the format returned by the REST API.
     *
     * @param array $timestamp
     * @return string
     */
    private function formatTimestampFromApi(array $timestamp)
    {
        $timestamp += [
            'seconds' => 0,
            'nanos' => 0
        ];

        $dt = $this->createDateTimeFromSeconds($timestamp['seconds']);

        return $this->formatTimeAsString($dt, $timestamp['nanos']);
    }

    /**
     * Format a timestamp for the API with nanosecond precision.
     *
     * @param string $value
     * @return array
     */
    private function formatTimestampForApi($value)
    {
        list ($dt, $nanos) = $this->parseTimeString($value);

        return [
            'seconds' => (int) $dt->format('U'),
            'nanos' => (int) $nanos
        ];
    }

    /**
     * Format a duration for the API.
     *
     * @param string|mixed $value
     * @return array
     */
    private function formatDurationForApi($value)
    {
        if (is_string($value)) {
            $d = explode('.', trim($value, 's'));
            if (count($d) < 2) {
                $seconds = $d[0];
                $nanos = 0;
            } else {
                $seconds = (int) $d[0];
                $nanos = $this->convertFractionToNanoSeconds($d[1]);
            }
        } elseif ($value instanceof Duration) {
            $d = $value->get();
            $seconds = $d['seconds'];
            $nanos = $d['nanos'];
        }

        return [
            'seconds' => $seconds,
            'nanos' => $nanos
        ];
    }

    /**
     * Construct a gapic client. Allows for tests to intercept.
     *
     * @param string $gapicName
     * @param array $config
     * @return mixed
     */
    protected function constructGapic($gapicName, array $config)
    {
        return new $gapicName($config);
    }

    /**
     * Helper function to convert selective elements into protos out of a given input array.
     *
     * Example:
     * ```
     * $output = $topic->convertDataToProtos(['schema' =>[], 'other vals'], ['schema' => Schema::class]);
     * $output['schema']; // This will be of the Schema type.
     * ```
     *
     * @param array $input The input array.
     * @param array $map The key,value pairs specifying the elements and the proto classes.
     *
     * @return array The modified array
     */
    private function convertDataToProtos(array $input, array $map) : array
    {
        foreach ($map as $key => $className) {
            if (isset($input[$key])) {
                $input[$key] = $this->serializer->decodeMessage(new $className, $input[$key]);
            }
        }

        return $input;
    }

    /**
     * Helper method used to split a supplied set of options into parameters that are passed into
     * a proto message and optional args.
     * We strictly treat the parameters allowed by `CallOptions` in GAX as the optional params
     * and everything else that is passed is passed to the Proto message constructor.
     */
    private function splitOptionalArgs(array $input, array $extraAllowedKeys = []) : array
    {
        $callOptionFields = array_keys((new CallOptions([]))->toArray());
        $keys = array_merge($callOptionFields, $extraAllowedKeys);

        $optionalArgs = $this->pluckArray($keys, $input);

        return [$input, $optionalArgs];
    }
}
