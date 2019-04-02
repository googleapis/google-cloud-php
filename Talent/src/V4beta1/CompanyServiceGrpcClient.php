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
 * A service that handles company management, including CRUD and enumeration.
 */
class CompanyServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a new company entity.
     * @param \Google\Cloud\Talent\V4beta1\CreateCompanyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateCompany(\Google\Cloud\Talent\V4beta1\CreateCompanyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.talent.v4beta1.CompanyService/CreateCompany',
        $argument,
        ['\Google\Cloud\Talent\V4beta1\Company', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves specified company.
     * @param \Google\Cloud\Talent\V4beta1\GetCompanyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetCompany(\Google\Cloud\Talent\V4beta1\GetCompanyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.talent.v4beta1.CompanyService/GetCompany',
        $argument,
        ['\Google\Cloud\Talent\V4beta1\Company', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates specified company.
     * @param \Google\Cloud\Talent\V4beta1\UpdateCompanyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UpdateCompany(\Google\Cloud\Talent\V4beta1\UpdateCompanyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.talent.v4beta1.CompanyService/UpdateCompany',
        $argument,
        ['\Google\Cloud\Talent\V4beta1\Company', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes specified company.
     * Prerequisite: The company has no jobs associated with it.
     * @param \Google\Cloud\Talent\V4beta1\DeleteCompanyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteCompany(\Google\Cloud\Talent\V4beta1\DeleteCompanyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.talent.v4beta1.CompanyService/DeleteCompany',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all companies associated with the project.
     * @param \Google\Cloud\Talent\V4beta1\ListCompaniesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListCompanies(\Google\Cloud\Talent\V4beta1\ListCompaniesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.talent.v4beta1.CompanyService/ListCompanies',
        $argument,
        ['\Google\Cloud\Talent\V4beta1\ListCompaniesResponse', 'decode'],
        $metadata, $options);
    }

}
