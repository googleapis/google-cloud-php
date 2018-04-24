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
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->serializer = new Serializer([
            'start_time' => function ($v) {
                return $this->formatTimestampFromApi($v);
            },
            'end_time' => function ($v) {
                return $this->formatTimestampFromApi($v);
            }
        ], [
            'google.protobuf.Value' => function ($v) {
                return $this->flattenValue($v);
            },
            'google.protobuf.ListValue' => function ($v) {
                return $this->flattenListValue($v);
            },
            'google.protobuf.Struct' => function ($v) {
                return $this->flattenStruct($v);
            },
            'google.protobuf.Timestamp' => function ($v) {
                var_dump('TIMESTAMPPPPPPPPPPPPPP');
                return $v;
            }
        ]);

        $config['serializer'] = $this->serializer;
        $this->setRequestWrapper(new GrpcRequestWrapper($config));
        $gaxConfig = $this->getGaxConfig(
            TraceClient::VERSION,
            isset($config['authHttpHandler'])
                ? $config['authHttpHandler']
                : null
        );

        $this->traceClient = new TraceServiceClient($gaxConfig);
    }

    /**
     * @param  array $args
     */
    public function traceBatchWrite(array $args)
    {
        $spans = $this->pluck('spans', $args);
        return $this->send([$this->traceClient, 'batchWriteSpans'], [
            TraceServiceClient::projectName($this->pluck('projectsId', $args)),
            array_map([$this, 'buildSpan'], $spans),
            $args
        ]);
    }

    /**
     * @param  array $args
     */
    public function traceSpanCreate(array $args)
    {
        return $this->send([$this->traceClient, 'createSpan'], [

        ]);
    }

    private function buildSpan(array $span)
    {
        if (isset($span['startTime'])) {
            $span['startTime'] = $this->formatTimestampForApi($span['startTime']);
        }
        if (isset($span['endTime'])) {
            $span['endTime'] = $this->formatTimestampForApi($span['endTime']);
        }
        if (isset($span['timeEvents'])) {
            foreach ($span['timeEvents']['timeEvent'] as &$timeEvent) {
                if (isset($timeEvent['time'])) {
                    $timeEvent['time'] = $this->formatTimestampForApi($timeEvent['time']);
                }
            }
        }
        return $this->serializer->decodeMessage(new Span(), $span);
    }
}
