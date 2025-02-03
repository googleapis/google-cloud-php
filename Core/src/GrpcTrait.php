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

use Google\ApiCore\CredentialsWrapper;
use Google\Auth\GetUniverseDomainInterface;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Exception\ServiceException;
use Google\Protobuf\NullValue;

/**
 * Provides shared functionality for gRPC service implementations.
 */
trait GrpcTrait
{
    use WhitelistTrait;
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
     * Get the GrpcRequestWrapper.
     *
     * @return GrpcRequestWrapper|null
     */
    public function requestWrapper()
    {
        return $this->requestWrapper;
    }

    /**
     * Delivers a request.
     *
     * @param callable $request
     * @param array $args
     * @param bool $whitelisted
     * @return \Generator|array
     * @throws ServiceException
     */
    public function send(callable $request, array $args, $whitelisted = false)
    {
        $requestOptions = $this->pluckArray([
            'grpcOptions',
            'retries',
            'requestTimeout',
            'grpcRetryFunction'
        ], $args[count($args) - 1]);

        try {
            return $this->requestWrapper->send($request, $args, $requestOptions);
        } catch (NotFoundException $e) {
            if ($whitelisted) {
                throw $this->modifyWhitelistedError($e);
            }

            throw $e;
        }
    }

    /**
     * Gets the default configuration for generated clients.
     *
     * @param string $version
     * @param callable|null $authHttpHandler
     * @param string|null $universeDomain
     * @return array
     */
    private function getGaxConfig(
        $version,
        ?callable $authHttpHandler = null,
        ?string $universeDomain = null
    ) {
        $config = [
            'libName' => 'gccl',
            'libVersion' => $version,
            'transport' => 'grpc'
        ];

        // GAX v0.32.0 introduced the CredentialsWrapper class and a different
        // way to configure credentials. If the class exists, use this new method
        // otherwise default to legacy usage.
        if (class_exists(CredentialsWrapper::class)) {
            $config['credentials'] = new CredentialsWrapper(
                $this->requestWrapper->getCredentialsFetcher(),
                $authHttpHandler,
                // If the universe domain hasn't been explicitly set, check the the environment variable,
                // otherwise assume GDU ("googleapis.com").
                $universeDomain
                    ?: getenv('GOOGLE_CLOUD_UNIVERSE_DOMAIN')
                    ?: GetUniverseDomainInterface::DEFAULT_UNIVERSE_DOMAIN
            );
        } else {
            $config += [
                'credentialsLoader' => $this->requestWrapper->getCredentialsFetcher(),
                'authHttpHandler' => $authHttpHandler,
                'enableCaching' => false
            ];
        }

        return $config;
    }

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
        list($dt, $nanos) = $this->parseTimeString($value);

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
}
