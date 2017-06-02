<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2016 Google Inc.
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
namespace Google\Cloud\Trace\V1 {

  // This file describes an API for collecting and viewing traces and spans
  // within a trace.  A Trace is a collection of spans corresponding to a single
  // operation or set of operations for an application. A span is an individual
  // timed event which forms a node of the trace tree. Spans for a single trace
  // may span multiple services.
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
     * Returns of a list of traces that match the specified filter conditions.
     * @param \Google\Cloud\Trace\V1\ListTracesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListTraces(\Google\Cloud\Trace\V1\ListTracesRequest $argument,
      $metadata = [], $options = []) {
      return $this->_simpleRequest('/google.devtools.cloudtrace.v1.TraceService/ListTraces',
      $argument,
      ['\Google\Cloud\Trace\V1\ListTracesResponse', 'decode'],
      $metadata, $options);
    }

    /**
     * Gets a single trace by its ID.
     * @param \Google\Cloud\Trace\V1\GetTraceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetTrace(\Google\Cloud\Trace\V1\GetTraceRequest $argument,
      $metadata = [], $options = []) {
      return $this->_simpleRequest('/google.devtools.cloudtrace.v1.TraceService/GetTrace',
      $argument,
      ['\Google\Cloud\Trace\V1\Trace', 'decode'],
      $metadata, $options);
    }

    /**
     * Sends new traces to Stackdriver Trace or updates existing traces. If the ID
     * of a trace that you send matches that of an existing trace, any fields
     * in the existing trace and its spans are overwritten by the provided values,
     * and any new fields provided are merged with the existing trace data. If the
     * ID does not match, a new trace is created.
     * @param \Google\Cloud\Trace\V1\PatchTracesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function PatchTraces(\Google\Cloud\Trace\V1\PatchTracesRequest $argument,
      $metadata = [], $options = []) {
      return $this->_simpleRequest('/google.devtools.cloudtrace.v1.TraceService/PatchTraces',
      $argument,
      ['\Google\Protobuf\GPBEmpty', 'decode'],
      $metadata, $options);
    }

  }

}
