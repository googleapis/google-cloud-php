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
namespace Google\Cloud\Logging\V2 {

  // Service for configuring sinks used to export log entries outside of
  // Stackdriver Logging.
  class ConfigServiceV2GrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
      parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists sinks.
     * @param \Google\Cloud\Logging\V2\ListSinksRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListSinks(\Google\Cloud\Logging\V2\ListSinksRequest $argument,
      $metadata = [], $options = []) {
      return $this->_simpleRequest('/google.logging.v2.ConfigServiceV2/ListSinks',
      $argument,
      ['\Google\Cloud\Logging\V2\ListSinksResponse', 'decode'],
      $metadata, $options);
    }

    /**
     * Gets a sink.
     * @param \Google\Cloud\Logging\V2\GetSinkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetSink(\Google\Cloud\Logging\V2\GetSinkRequest $argument,
      $metadata = [], $options = []) {
      return $this->_simpleRequest('/google.logging.v2.ConfigServiceV2/GetSink',
      $argument,
      ['\Google\Cloud\Logging\V2\LogSink', 'decode'],
      $metadata, $options);
    }

    /**
     * Creates a sink that exports specified log entries to a destination.  The
     * export of newly-ingested log entries begins immediately, unless the current
     * time is outside the sink's start and end times or the sink's
     * `writer_identity` is not permitted to write to the destination.  A sink can
     * export log entries only from the resource owning the sink.
     * @param \Google\Cloud\Logging\V2\CreateSinkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateSink(\Google\Cloud\Logging\V2\CreateSinkRequest $argument,
      $metadata = [], $options = []) {
      return $this->_simpleRequest('/google.logging.v2.ConfigServiceV2/CreateSink',
      $argument,
      ['\Google\Cloud\Logging\V2\LogSink', 'decode'],
      $metadata, $options);
    }

    /**
     * Updates a sink. If the named sink doesn't exist, then this method is
     * identical to
     * [sinks.create](/logging/docs/api/reference/rest/v2/projects.sinks/create).
     * If the named sink does exist, then this method replaces the following
     * fields in the existing sink with values from the new sink: `destination`,
     * `filter`, `output_version_format`, `start_time`, and `end_time`.
     * The updated filter might also have a new `writer_identity`; see the
     * `unique_writer_identity` field.
     * @param \Google\Cloud\Logging\V2\UpdateSinkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UpdateSink(\Google\Cloud\Logging\V2\UpdateSinkRequest $argument,
      $metadata = [], $options = []) {
      return $this->_simpleRequest('/google.logging.v2.ConfigServiceV2/UpdateSink',
      $argument,
      ['\Google\Cloud\Logging\V2\LogSink', 'decode'],
      $metadata, $options);
    }

    /**
     * Deletes a sink. If the sink has a unique `writer_identity`, then that
     * service account is also deleted.
     * @param \Google\Cloud\Logging\V2\DeleteSinkRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteSink(\Google\Cloud\Logging\V2\DeleteSinkRequest $argument,
      $metadata = [], $options = []) {
      return $this->_simpleRequest('/google.logging.v2.ConfigServiceV2/DeleteSink',
      $argument,
      ['\Google\Protobuf\GPBEmpty', 'decode'],
      $metadata, $options);
    }

  }

}
