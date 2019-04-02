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
 * A service that handles tenant management, including CRUD and enumeration.
 */
class TenantServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a new tenant entity.
     * @param \Google\Cloud\Talent\V4beta1\CreateTenantRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateTenant(\Google\Cloud\Talent\V4beta1\CreateTenantRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.talent.v4beta1.TenantService/CreateTenant',
        $argument,
        ['\Google\Cloud\Talent\V4beta1\Tenant', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves specified tenant.
     * @param \Google\Cloud\Talent\V4beta1\GetTenantRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetTenant(\Google\Cloud\Talent\V4beta1\GetTenantRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.talent.v4beta1.TenantService/GetTenant',
        $argument,
        ['\Google\Cloud\Talent\V4beta1\Tenant', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates specified tenant.
     * @param \Google\Cloud\Talent\V4beta1\UpdateTenantRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UpdateTenant(\Google\Cloud\Talent\V4beta1\UpdateTenantRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.talent.v4beta1.TenantService/UpdateTenant',
        $argument,
        ['\Google\Cloud\Talent\V4beta1\Tenant', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes specified tenant.
     * @param \Google\Cloud\Talent\V4beta1\DeleteTenantRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteTenant(\Google\Cloud\Talent\V4beta1\DeleteTenantRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.talent.v4beta1.TenantService/DeleteTenant',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all tenants associated with the project.
     * @param \Google\Cloud\Talent\V4beta1\ListTenantsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListTenants(\Google\Cloud\Talent\V4beta1\ListTenantsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.talent.v4beta1.TenantService/ListTenants',
        $argument,
        ['\Google\Cloud\Talent\V4beta1\ListTenantsResponse', 'decode'],
        $metadata, $options);
    }

}
