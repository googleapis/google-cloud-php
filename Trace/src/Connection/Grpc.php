<?php
/**
 * Copyright 2018 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Trace\Connection;

use Google\ApiCore\Serializer;
use Google\Cloud\Core\GrpcRequestWrapper;
use Google\Cloud\Core\GrpcTrait;
use Google\Cloud\Trace\TraceClient;
use Google\Cloud\Trace\V2\TraceServiceClient;
use Google\Cloud\Trace\V2\Span;

/**
 * Implementation of the
 * [Google Trace gRPC API](https://cloud.google.com/trace/docs/).
 */
class Grpc implements ConnectionInterface
{
    use GrpcTrait;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @var TraceServiceClient
     */
    private $traceClient;

    /**
     * @param array $config [optional] Configuration options. Please see
     *        {@see Google\Cloud\Core\GrpcRequestWrapper::__construct()} for
     *        the available options.
     */
    public function __construct(array $config = [])
    {
        $this->serializer = new Serializer(
            [],
            [
                'google.protobuf.Timestamp' => function ($v) {
                    return $this->formatTimestampFromApi($v);
                }
            ],
            [],
            [
                'google.protobuf.Timestamp' => function ($v) {
                    return $this->formatTimestampForApi($v);
                }
            ]
        );
        $config['serializer'] = $this->serializer;
        $this->setRequestWrapper(new GrpcRequestWrapper($config));
        $gaxConfig = $this->getGaxConfig(
            TraceClient::VERSION,
            isset($config['authHttpHandler'])
                ? $config['authHttpHandler']
                : null
        );

        if (isset($config['apiEndpoint'])) {
            $gaxConfig['apiEndpoint'] = $config['apiEndpoint'];
        }

        $this->traceClient = $this->constructGapic(TraceServiceClient::class, $gaxConfig);
    }

    /**
     * Sends new spans to new or existing traces. You cannot update existing
     * spans.
     *
     * @param array $args {
     *      Batch write params.
     *
     *      @type string $projectsId The ID of the Google Cloud Project
     *      @type array $spans Array of associative array span data. See
     *          {@see Google\Cloud\Trace\Span::info()} for format.
     * }
     */
    public function traceBatchWrite(array $args)
    {
        $spans = $this->pluck('spans', $args);
        return $this->send([$this->traceClient, 'batchWriteSpans'], [
            TraceServiceClient::projectName($this->pluck('projectsId', $args)),
            array_map(function (array $span) {
                return $this->serializer->decodeMessage(new Span(), $span);
            }, $spans),
            $args
        ]);
    }

    /**
     * @param array $args
     */
    public function traceSpanCreate(array $args)
    {
        return $this->send([$this->traceClient, 'createSpan'], [
            TraceServiceClient::projectName($this->pluck('projectsId', $args)),
            $this->pluck('spanId', $args),
            $this->pluck('displayName', $args),
            $this->formatTimestampForApi($this->pluck('startTime', $args)),
            $this->formatTimestampForApi($this->pluck('endTime', $args)),
            $args
        ]);
    }
}
