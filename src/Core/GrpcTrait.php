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

namespace Google\Cloud\Core;

use DateTime;
use DateTimeZone;
use Google\Auth\FetchAuthTokenCache;
use Google\Auth\Cache\MemoryCacheItemPool;
use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\GrpcRequestWrapper;

/**
 * Provides shared functionality for gRPC service implementations.
 */
trait GrpcTrait
{
    use ArrayTrait;

    /**
     * @var GrpcRequestWrapper Wrapper used to handle sending requests to the
     * gRPC API.
     */
    private $requestWrapper;

    /**
     * Sets the request wrapper.
     *
     * @param GrpcRequestWrapper $requestWrapper
     */
    public function setRequestWrapper(GrpcRequestWrapper $requestWrapper)
    {
        $this->requestWrapper = $requestWrapper;
    }

    /**
     * Delivers a request.
     *
     * @param callable $request
     * @param array $args
     * @return array
     */
    public function send(callable $request, array $args)
    {
        $requestOptions = $this->pluckArray([
            'grpcOptions',
            'retries',
            'requestTimeout'
        ], $args[count($args) - 1]);

        return $this->requestWrapper->send($request, $args, $requestOptions);
    }

    /**
     * Gets the default configuration for generated GAX clients.
     *
     * @return array
     */
    private function getGaxConfig($version)
    {
        return [
            'credentialsLoader' => $this->requestWrapper->getCredentialsFetcher(),
            'enableCaching' => false,
            'libName' => 'gccl',
            'libVersion' => $version
        ];
    }

    /**
     * Format a gRPC timestamp to match the format returned by the REST API.
     *
     * @param array $timestamp
     * @return string
     */
    private function formatTimestampFromApi(array $timestamp)
    {
        $formattedTime = (new DateTime())
            ->setTimeZone(new DateTimeZone('UTC'))
            ->setTimestamp($timestamp['seconds'])
            ->format('Y-m-d\TH:i:s');
        return $formattedTime .= sprintf('.%sZ', rtrim($timestamp['nanos'], '0'));
    }

    /**
     * Format a set of labels for the API.
     *
     * @param array $labels
     * @return array
     */
    private function formatLabelsForApi(array $labels)
    {
        $fLabels = [];

        foreach ($labels as $key => $value) {
            $fLabels[] = [
                'key' => $key,
                'value' => $value
            ];
        }

        return $fLabels;
    }

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
            $fFields[] = [
                'key' => $key,
                'value' => $this->formatValueForApi($value)
            ];
        }

        return ['fields' => $fFields];
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
     * @param array $value
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
            case 'array':
                if ($this->isAssoc($value)) {
                    return ['struct_value' => $this->formatStructForApi($value)];
                }

                return ['list_value' => $this->formatListForApi($value)];
        }
    }
}
