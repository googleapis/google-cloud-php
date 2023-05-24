<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2023 Google LLC
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
namespace Google\Cloud\Support\V2;

/**
 * A service to manage Google Cloud support cases.
 */
class CaseServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Retrieve the specified case.
     * @param \Google\Cloud\Support\V2\GetCaseRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCase(\Google\Cloud\Support\V2\GetCaseRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.support.v2.CaseService/GetCase',
        $argument,
        ['\Google\Cloud\Support\V2\PBCase', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieve all cases under the specified parent.
     *
     * Note: Listing cases under an Organization returns only the cases directly
     * parented by that organization. To retrieve all cases under an organization,
     * including cases parented by projects under that organization, use
     * `cases.search`.
     * @param \Google\Cloud\Support\V2\ListCasesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListCases(\Google\Cloud\Support\V2\ListCasesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.support.v2.CaseService/ListCases',
        $argument,
        ['\Google\Cloud\Support\V2\ListCasesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Search cases using the specified query.
     * @param \Google\Cloud\Support\V2\SearchCasesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SearchCases(\Google\Cloud\Support\V2\SearchCasesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.support.v2.CaseService/SearchCases',
        $argument,
        ['\Google\Cloud\Support\V2\SearchCasesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Create a new case and associate it with the given Google Cloud Resource.
     * The case object must have the following fields set: `display_name`,
     * `description`, `classification`, and `priority`.
     * @param \Google\Cloud\Support\V2\CreateCaseRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateCase(\Google\Cloud\Support\V2\CreateCaseRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.support.v2.CaseService/CreateCase',
        $argument,
        ['\Google\Cloud\Support\V2\PBCase', 'decode'],
        $metadata, $options);
    }

    /**
     * Update the specified case. Only a subset of fields can be updated.
     * @param \Google\Cloud\Support\V2\UpdateCaseRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateCase(\Google\Cloud\Support\V2\UpdateCaseRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.support.v2.CaseService/UpdateCase',
        $argument,
        ['\Google\Cloud\Support\V2\PBCase', 'decode'],
        $metadata, $options);
    }

    /**
     * Escalate a case. Escalating a case will initiate the Google Cloud Support
     * escalation management process.
     *
     * This operation is only available to certain Customer Care tiers. Go to
     * https://cloud.google.com/support and look for 'Technical support
     * escalations' in the feature list to find out which tiers are able to
     * perform escalations.
     * @param \Google\Cloud\Support\V2\EscalateCaseRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function EscalateCase(\Google\Cloud\Support\V2\EscalateCaseRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.support.v2.CaseService/EscalateCase',
        $argument,
        ['\Google\Cloud\Support\V2\PBCase', 'decode'],
        $metadata, $options);
    }

    /**
     * Close the specified case.
     * @param \Google\Cloud\Support\V2\CloseCaseRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CloseCase(\Google\Cloud\Support\V2\CloseCaseRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.support.v2.CaseService/CloseCase',
        $argument,
        ['\Google\Cloud\Support\V2\PBCase', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieve valid classifications to be used when creating a support case.
     * The classications are hierarchical, with each classification containing
     * all levels of the hierarchy, separated by " > ". For example "Technical
     * Issue > Compute > Compute Engine".
     * @param \Google\Cloud\Support\V2\SearchCaseClassificationsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SearchCaseClassifications(\Google\Cloud\Support\V2\SearchCaseClassificationsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.support.v2.CaseService/SearchCaseClassifications',
        $argument,
        ['\Google\Cloud\Support\V2\SearchCaseClassificationsResponse', 'decode'],
        $metadata, $options);
    }

}
