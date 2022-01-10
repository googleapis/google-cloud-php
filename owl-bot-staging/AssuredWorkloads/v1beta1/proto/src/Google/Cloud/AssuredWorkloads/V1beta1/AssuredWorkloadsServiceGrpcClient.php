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
namespace Google\Cloud\AssuredWorkloads\V1beta1;

/**
 * Service to manage AssuredWorkloads.
 */
class AssuredWorkloadsServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates Assured Workload.
     * @param \Google\Cloud\AssuredWorkloads\V1beta1\CreateWorkloadRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateWorkload(\Google\Cloud\AssuredWorkloads\V1beta1\CreateWorkloadRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.assuredworkloads.v1beta1.AssuredWorkloadsService/CreateWorkload',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an existing workload.
     * Currently allows updating of workload display_name and labels.
     * For force updates don't set etag field in the Workload.
     * Only one update operation per workload can be in progress.
     * @param \Google\Cloud\AssuredWorkloads\V1beta1\UpdateWorkloadRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateWorkload(\Google\Cloud\AssuredWorkloads\V1beta1\UpdateWorkloadRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.assuredworkloads.v1beta1.AssuredWorkloadsService/UpdateWorkload',
        $argument,
        ['\Google\Cloud\AssuredWorkloads\V1beta1\Workload', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the workload. Make sure that workload's direct children are already
     * in a deleted state, otherwise the request will fail with a
     * FAILED_PRECONDITION error.
     * @param \Google\Cloud\AssuredWorkloads\V1beta1\DeleteWorkloadRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteWorkload(\Google\Cloud\AssuredWorkloads\V1beta1\DeleteWorkloadRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.assuredworkloads.v1beta1.AssuredWorkloadsService/DeleteWorkload',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets Assured Workload associated with a CRM Node
     * @param \Google\Cloud\AssuredWorkloads\V1beta1\GetWorkloadRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetWorkload(\Google\Cloud\AssuredWorkloads\V1beta1\GetWorkloadRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.assuredworkloads.v1beta1.AssuredWorkloadsService/GetWorkload',
        $argument,
        ['\Google\Cloud\AssuredWorkloads\V1beta1\Workload', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists Assured Workloads under a CRM Node.
     * @param \Google\Cloud\AssuredWorkloads\V1beta1\ListWorkloadsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListWorkloads(\Google\Cloud\AssuredWorkloads\V1beta1\ListWorkloadsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.assuredworkloads.v1beta1.AssuredWorkloadsService/ListWorkloads',
        $argument,
        ['\Google\Cloud\AssuredWorkloads\V1beta1\ListWorkloadsResponse', 'decode'],
        $metadata, $options);
    }

}
