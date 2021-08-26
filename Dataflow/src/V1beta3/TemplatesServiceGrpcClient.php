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
 * Provides a method to create Cloud Dataflow jobs from templates.
 */
class TemplatesServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a Cloud Dataflow job from a template.
     * @param \Google\Cloud\Dataflow\V1beta3\CreateJobFromTemplateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateJobFromTemplate(\Google\Cloud\Dataflow\V1beta3\CreateJobFromTemplateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.dataflow.v1beta3.TemplatesService/CreateJobFromTemplate',
        $argument,
        ['\Google\Cloud\Dataflow\V1beta3\Job', 'decode'],
        $metadata, $options);
    }

    /**
     * Launch a template.
     * @param \Google\Cloud\Dataflow\V1beta3\LaunchTemplateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function LaunchTemplate(\Google\Cloud\Dataflow\V1beta3\LaunchTemplateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.dataflow.v1beta3.TemplatesService/LaunchTemplate',
        $argument,
        ['\Google\Cloud\Dataflow\V1beta3\LaunchTemplateResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get the template associated with a template.
     * @param \Google\Cloud\Dataflow\V1beta3\GetTemplateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetTemplate(\Google\Cloud\Dataflow\V1beta3\GetTemplateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.dataflow.v1beta3.TemplatesService/GetTemplate',
        $argument,
        ['\Google\Cloud\Dataflow\V1beta3\GetTemplateResponse', 'decode'],
        $metadata, $options);
    }

}
