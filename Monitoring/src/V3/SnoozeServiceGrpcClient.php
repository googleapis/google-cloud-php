<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2022 Google LLC
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
namespace Google\Cloud\Monitoring\V3;

/**
 * The SnoozeService API is used to temporarily prevent an alert policy from
 * generating alerts. A Snooze is a description of the criteria under which one
 * or more alert policies should not fire alerts for the specified duration.
 */
class SnoozeServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a `Snooze` that will prevent alerts, which match the provided
     * criteria, from being opened. The `Snooze` applies for a specific time
     * interval.
     * @param \Google\Cloud\Monitoring\V3\CreateSnoozeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateSnooze(\Google\Cloud\Monitoring\V3\CreateSnoozeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.SnoozeService/CreateSnooze',
        $argument,
        ['\Google\Cloud\Monitoring\V3\Snooze', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the `Snooze`s associated with a project. Can optionally pass in
     * `filter`, which specifies predicates to match `Snooze`s.
     * @param \Google\Cloud\Monitoring\V3\ListSnoozesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListSnoozes(\Google\Cloud\Monitoring\V3\ListSnoozesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.SnoozeService/ListSnoozes',
        $argument,
        ['\Google\Cloud\Monitoring\V3\ListSnoozesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves a `Snooze` by `name`.
     * @param \Google\Cloud\Monitoring\V3\GetSnoozeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetSnooze(\Google\Cloud\Monitoring\V3\GetSnoozeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.SnoozeService/GetSnooze',
        $argument,
        ['\Google\Cloud\Monitoring\V3\Snooze', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a `Snooze`, identified by its `name`, with the parameters in the
     * given `Snooze` object.
     * @param \Google\Cloud\Monitoring\V3\UpdateSnoozeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateSnooze(\Google\Cloud\Monitoring\V3\UpdateSnoozeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.SnoozeService/UpdateSnooze',
        $argument,
        ['\Google\Cloud\Monitoring\V3\Snooze', 'decode'],
        $metadata, $options);
    }

}
