<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2021 Google LLC
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
namespace Google\Cloud\Dataflow\V1beta3;

/**
 * Provides methods to manage snapshots of Google Cloud Dataflow jobs.
 */
class SnapshotsV1Beta3GrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Gets information about a snapshot.
     * @param \Google\Cloud\Dataflow\V1beta3\GetSnapshotRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetSnapshot(\Google\Cloud\Dataflow\V1beta3\GetSnapshotRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.dataflow.v1beta3.SnapshotsV1Beta3/GetSnapshot',
        $argument,
        ['\Google\Cloud\Dataflow\V1beta3\Snapshot', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a snapshot.
     * @param \Google\Cloud\Dataflow\V1beta3\DeleteSnapshotRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteSnapshot(\Google\Cloud\Dataflow\V1beta3\DeleteSnapshotRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.dataflow.v1beta3.SnapshotsV1Beta3/DeleteSnapshot',
        $argument,
        ['\Google\Cloud\Dataflow\V1beta3\DeleteSnapshotResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists snapshots.
     * @param \Google\Cloud\Dataflow\V1beta3\ListSnapshotsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListSnapshots(\Google\Cloud\Dataflow\V1beta3\ListSnapshotsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.dataflow.v1beta3.SnapshotsV1Beta3/ListSnapshots',
        $argument,
        ['\Google\Cloud\Dataflow\V1beta3\ListSnapshotsResponse', 'decode'],
        $metadata, $options);
    }

}
