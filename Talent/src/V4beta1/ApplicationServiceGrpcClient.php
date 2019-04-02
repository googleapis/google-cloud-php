<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2019 Google LLC.
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
//
namespace Google\Cloud\Talent\V4beta1;

/**
 * A service that handles application management, including CRUD and
 * enumeration.
 */
class ApplicationServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a new application entity.
     * @param \Google\Cloud\Talent\V4beta1\CreateApplicationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateApplication(\Google\Cloud\Talent\V4beta1\CreateApplicationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.talent.v4beta1.ApplicationService/CreateApplication',
        $argument,
        ['\Google\Cloud\Talent\V4beta1\Application', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves specified application.
     * @param \Google\Cloud\Talent\V4beta1\GetApplicationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetApplication(\Google\Cloud\Talent\V4beta1\GetApplicationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.talent.v4beta1.ApplicationService/GetApplication',
        $argument,
        ['\Google\Cloud\Talent\V4beta1\Application', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates specified application.
     * @param \Google\Cloud\Talent\V4beta1\UpdateApplicationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UpdateApplication(\Google\Cloud\Talent\V4beta1\UpdateApplicationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.talent.v4beta1.ApplicationService/UpdateApplication',
        $argument,
        ['\Google\Cloud\Talent\V4beta1\Application', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes specified application.
     * @param \Google\Cloud\Talent\V4beta1\DeleteApplicationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteApplication(\Google\Cloud\Talent\V4beta1\DeleteApplicationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.talent.v4beta1.ApplicationService/DeleteApplication',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all applications associated with the profile.
     * @param \Google\Cloud\Talent\V4beta1\ListApplicationsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListApplications(\Google\Cloud\Talent\V4beta1\ListApplicationsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.talent.v4beta1.ApplicationService/ListApplications',
        $argument,
        ['\Google\Cloud\Talent\V4beta1\ListApplicationsResponse', 'decode'],
        $metadata, $options);
    }

}
