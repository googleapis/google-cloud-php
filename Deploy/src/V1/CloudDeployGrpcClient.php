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
namespace Google\Cloud\Deploy\V1;

/**
 * CloudDeploy service creates and manages Continuous Delivery operations
 * on Google Cloud Platform via Skaffold (https://skaffold.dev).
 */
class CloudDeployGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists DeliveryPipelines in a given project and location.
     * @param \Google\Cloud\Deploy\V1\ListDeliveryPipelinesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListDeliveryPipelines(\Google\Cloud\Deploy\V1\ListDeliveryPipelinesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.deploy.v1.CloudDeploy/ListDeliveryPipelines',
        $argument,
        ['\Google\Cloud\Deploy\V1\ListDeliveryPipelinesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single DeliveryPipeline.
     * @param \Google\Cloud\Deploy\V1\GetDeliveryPipelineRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetDeliveryPipeline(\Google\Cloud\Deploy\V1\GetDeliveryPipelineRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.deploy.v1.CloudDeploy/GetDeliveryPipeline',
        $argument,
        ['\Google\Cloud\Deploy\V1\DeliveryPipeline', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new DeliveryPipeline in a given project and location.
     * @param \Google\Cloud\Deploy\V1\CreateDeliveryPipelineRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateDeliveryPipeline(\Google\Cloud\Deploy\V1\CreateDeliveryPipelineRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.deploy.v1.CloudDeploy/CreateDeliveryPipeline',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the parameters of a single DeliveryPipeline.
     * @param \Google\Cloud\Deploy\V1\UpdateDeliveryPipelineRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateDeliveryPipeline(\Google\Cloud\Deploy\V1\UpdateDeliveryPipelineRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.deploy.v1.CloudDeploy/UpdateDeliveryPipeline',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single DeliveryPipeline.
     * @param \Google\Cloud\Deploy\V1\DeleteDeliveryPipelineRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteDeliveryPipeline(\Google\Cloud\Deploy\V1\DeleteDeliveryPipelineRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.deploy.v1.CloudDeploy/DeleteDeliveryPipeline',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists Targets in a given project and location.
     * @param \Google\Cloud\Deploy\V1\ListTargetsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListTargets(\Google\Cloud\Deploy\V1\ListTargetsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.deploy.v1.CloudDeploy/ListTargets',
        $argument,
        ['\Google\Cloud\Deploy\V1\ListTargetsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single Target.
     * @param \Google\Cloud\Deploy\V1\GetTargetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetTarget(\Google\Cloud\Deploy\V1\GetTargetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.deploy.v1.CloudDeploy/GetTarget',
        $argument,
        ['\Google\Cloud\Deploy\V1\Target', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new Target in a given project and location.
     * @param \Google\Cloud\Deploy\V1\CreateTargetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateTarget(\Google\Cloud\Deploy\V1\CreateTargetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.deploy.v1.CloudDeploy/CreateTarget',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the parameters of a single Target.
     * @param \Google\Cloud\Deploy\V1\UpdateTargetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateTarget(\Google\Cloud\Deploy\V1\UpdateTargetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.deploy.v1.CloudDeploy/UpdateTarget',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single Target.
     * @param \Google\Cloud\Deploy\V1\DeleteTargetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteTarget(\Google\Cloud\Deploy\V1\DeleteTargetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.deploy.v1.CloudDeploy/DeleteTarget',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists Releases in a given project and location.
     * @param \Google\Cloud\Deploy\V1\ListReleasesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListReleases(\Google\Cloud\Deploy\V1\ListReleasesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.deploy.v1.CloudDeploy/ListReleases',
        $argument,
        ['\Google\Cloud\Deploy\V1\ListReleasesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single Release.
     * @param \Google\Cloud\Deploy\V1\GetReleaseRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetRelease(\Google\Cloud\Deploy\V1\GetReleaseRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.deploy.v1.CloudDeploy/GetRelease',
        $argument,
        ['\Google\Cloud\Deploy\V1\Release', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new Release in a given project and location.
     * @param \Google\Cloud\Deploy\V1\CreateReleaseRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateRelease(\Google\Cloud\Deploy\V1\CreateReleaseRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.deploy.v1.CloudDeploy/CreateRelease',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Abandons a Release in the Delivery Pipeline.
     * @param \Google\Cloud\Deploy\V1\AbandonReleaseRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function AbandonRelease(\Google\Cloud\Deploy\V1\AbandonReleaseRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.deploy.v1.CloudDeploy/AbandonRelease',
        $argument,
        ['\Google\Cloud\Deploy\V1\AbandonReleaseResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Approves a Rollout.
     * @param \Google\Cloud\Deploy\V1\ApproveRolloutRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ApproveRollout(\Google\Cloud\Deploy\V1\ApproveRolloutRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.deploy.v1.CloudDeploy/ApproveRollout',
        $argument,
        ['\Google\Cloud\Deploy\V1\ApproveRolloutResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists Rollouts in a given project and location.
     * @param \Google\Cloud\Deploy\V1\ListRolloutsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListRollouts(\Google\Cloud\Deploy\V1\ListRolloutsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.deploy.v1.CloudDeploy/ListRollouts',
        $argument,
        ['\Google\Cloud\Deploy\V1\ListRolloutsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single Rollout.
     * @param \Google\Cloud\Deploy\V1\GetRolloutRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetRollout(\Google\Cloud\Deploy\V1\GetRolloutRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.deploy.v1.CloudDeploy/GetRollout',
        $argument,
        ['\Google\Cloud\Deploy\V1\Rollout', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new Rollout in a given project and location.
     * @param \Google\Cloud\Deploy\V1\CreateRolloutRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateRollout(\Google\Cloud\Deploy\V1\CreateRolloutRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.deploy.v1.CloudDeploy/CreateRollout',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Retries the specified Job in a Rollout.
     * @param \Google\Cloud\Deploy\V1\RetryJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RetryJob(\Google\Cloud\Deploy\V1\RetryJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.deploy.v1.CloudDeploy/RetryJob',
        $argument,
        ['\Google\Cloud\Deploy\V1\RetryJobResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists JobRuns in a given project and location.
     * @param \Google\Cloud\Deploy\V1\ListJobRunsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListJobRuns(\Google\Cloud\Deploy\V1\ListJobRunsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.deploy.v1.CloudDeploy/ListJobRuns',
        $argument,
        ['\Google\Cloud\Deploy\V1\ListJobRunsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single JobRun.
     * @param \Google\Cloud\Deploy\V1\GetJobRunRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetJobRun(\Google\Cloud\Deploy\V1\GetJobRunRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.deploy.v1.CloudDeploy/GetJobRun',
        $argument,
        ['\Google\Cloud\Deploy\V1\JobRun', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the configuration for a location.
     * @param \Google\Cloud\Deploy\V1\GetConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetConfig(\Google\Cloud\Deploy\V1\GetConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.deploy.v1.CloudDeploy/GetConfig',
        $argument,
        ['\Google\Cloud\Deploy\V1\Config', 'decode'],
        $metadata, $options);
    }

}
