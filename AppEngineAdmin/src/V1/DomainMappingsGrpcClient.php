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
namespace Google\Cloud\AppEngine\V1;

/**
 * Manages domains serving an application.
 */
class DomainMappingsGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists the domain mappings on an application.
     * @param \Google\Cloud\AppEngine\V1\ListDomainMappingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListDomainMappings(\Google\Cloud\AppEngine\V1\ListDomainMappingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.appengine.v1.DomainMappings/ListDomainMappings',
        $argument,
        ['\Google\Cloud\AppEngine\V1\ListDomainMappingsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the specified domain mapping.
     * @param \Google\Cloud\AppEngine\V1\GetDomainMappingRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetDomainMapping(\Google\Cloud\AppEngine\V1\GetDomainMappingRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.appengine.v1.DomainMappings/GetDomainMapping',
        $argument,
        ['\Google\Cloud\AppEngine\V1\DomainMapping', 'decode'],
        $metadata, $options);
    }

    /**
     * Maps a domain to an application. A user must be authorized to administer a
     * domain in order to map it to an application. For a list of available
     * authorized domains, see [`AuthorizedDomains.ListAuthorizedDomains`]().
     * @param \Google\Cloud\AppEngine\V1\CreateDomainMappingRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateDomainMapping(\Google\Cloud\AppEngine\V1\CreateDomainMappingRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.appengine.v1.DomainMappings/CreateDomainMapping',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the specified domain mapping. To map an SSL certificate to a
     * domain mapping, update `certificate_id` to point to an `AuthorizedCertificate`
     * resource. A user must be authorized to administer the associated domain
     * in order to update a `DomainMapping` resource.
     * @param \Google\Cloud\AppEngine\V1\UpdateDomainMappingRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateDomainMapping(\Google\Cloud\AppEngine\V1\UpdateDomainMappingRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.appengine.v1.DomainMappings/UpdateDomainMapping',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the specified domain mapping. A user must be authorized to
     * administer the associated domain in order to delete a `DomainMapping`
     * resource.
     * @param \Google\Cloud\AppEngine\V1\DeleteDomainMappingRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteDomainMapping(\Google\Cloud\AppEngine\V1\DeleteDomainMappingRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.appengine.v1.DomainMappings/DeleteDomainMapping',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
