<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2017 Google Inc.
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//     http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.
//
namespace Google\Cloud\Trace\V2;

/**
 * This file describes an API for collecting and viewing traces and spans
 * within a trace.  A Trace is a collection of spans corresponding to a single
 * operation or set of operations for an application. A span is an individual
 * timed event which forms a node of the trace tree. A single trace may
 * contain span(s) from multiple services.
 */
class TraceServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Sends new spans to new or existing traces. You cannot update
     * existing spans.
     * @param \Google\Cloud\Trace\V2\BatchWriteSpansRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function BatchWriteSpans(\Google\Cloud\Trace\V2\BatchWriteSpansRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.cloudtrace.v2.TraceService/BatchWriteSpans',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new span.
     * @param \Google\Cloud\Trace\V2\Span $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateSpan(\Google\Cloud\Trace\V2\Span $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.cloudtrace.v2.TraceService/CreateSpan',
        $argument,
        ['\Google\Cloud\Trace\V2\Span', 'decode'],
        $metadata, $options);
    }

}
