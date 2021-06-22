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
namespace Google\Cloud\LifeSciences\V2beta;

/**
 * A service for running workflows, such as pipelines consisting of Docker
 * containers.
 */
class WorkflowsServiceV2BetaGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Runs a pipeline.  The returned Operation's [metadata]
     * [google.longrunning.Operation.metadata] field will contain a
     * [google.cloud.lifesciences.v2beta.Metadata][google.cloud.lifesciences.v2beta.Metadata] object describing the status
     * of the pipeline execution. The
     * [response][google.longrunning.Operation.response] field will contain a
     * [google.cloud.lifesciences.v2beta.RunPipelineResponse][google.cloud.lifesciences.v2beta.RunPipelineResponse] object if the
     * pipeline completes successfully.
     *
     * **Note:** Before you can use this method, the *Life Sciences Service Agent*
     * must have access to your project. This is done automatically when the
     * Cloud Life Sciences API is first enabled, but if you delete this permission
     * you must disable and re-enable the API to grant the Life Sciences
     * Service Agent the required permissions.
     * Authorization requires the following [Google
     * IAM](https://cloud.google.com/iam/) permission:
     *
     * * `lifesciences.workflows.run`
     * @param \Google\Cloud\LifeSciences\V2beta\RunPipelineRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RunPipeline(\Google\Cloud\LifeSciences\V2beta\RunPipelineRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.lifesciences.v2beta.WorkflowsServiceV2Beta/RunPipeline',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
