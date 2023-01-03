<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2022 Google LLC
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
namespace Google\Cloud\BigQuery\DataPolicies\V1beta1;

/**
 * Data Policy Service provides APIs for managing the label-policy bindings.
 */
class DataPolicyServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a new data policy under a project with the given `dataPolicyId`
     * (used as the display name), policy tag, and data policy type.
     * @param \Google\Cloud\BigQuery\DataPolicies\V1beta1\CreateDataPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateDataPolicy(\Google\Cloud\BigQuery\DataPolicies\V1beta1\CreateDataPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.datapolicies.v1beta1.DataPolicyService/CreateDataPolicy',
        $argument,
        ['\Google\Cloud\BigQuery\DataPolicies\V1beta1\DataPolicy', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the metadata for an existing data policy. The target data policy
     * can be specified by the resource name.
     * @param \Google\Cloud\BigQuery\DataPolicies\V1beta1\UpdateDataPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateDataPolicy(\Google\Cloud\BigQuery\DataPolicies\V1beta1\UpdateDataPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.datapolicies.v1beta1.DataPolicyService/UpdateDataPolicy',
        $argument,
        ['\Google\Cloud\BigQuery\DataPolicies\V1beta1\DataPolicy', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the data policy specified by its resource name.
     * @param \Google\Cloud\BigQuery\DataPolicies\V1beta1\DeleteDataPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteDataPolicy(\Google\Cloud\BigQuery\DataPolicies\V1beta1\DeleteDataPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.datapolicies.v1beta1.DataPolicyService/DeleteDataPolicy',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the data policy specified by its resource name.
     * @param \Google\Cloud\BigQuery\DataPolicies\V1beta1\GetDataPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetDataPolicy(\Google\Cloud\BigQuery\DataPolicies\V1beta1\GetDataPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.datapolicies.v1beta1.DataPolicyService/GetDataPolicy',
        $argument,
        ['\Google\Cloud\BigQuery\DataPolicies\V1beta1\DataPolicy', 'decode'],
        $metadata, $options);
    }

    /**
     * List all of the data policies in the specified parent project.
     * @param \Google\Cloud\BigQuery\DataPolicies\V1beta1\ListDataPoliciesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListDataPolicies(\Google\Cloud\BigQuery\DataPolicies\V1beta1\ListDataPoliciesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.datapolicies.v1beta1.DataPolicyService/ListDataPolicies',
        $argument,
        ['\Google\Cloud\BigQuery\DataPolicies\V1beta1\ListDataPoliciesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the IAM policy for the specified data policy.
     * @param \Google\Cloud\Iam\V1\GetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetIamPolicy(\Google\Cloud\Iam\V1\GetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.datapolicies.v1beta1.DataPolicyService/GetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Sets the IAM policy for the specified data policy.
     * @param \Google\Cloud\Iam\V1\SetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SetIamPolicy(\Google\Cloud\Iam\V1\SetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.datapolicies.v1beta1.DataPolicyService/SetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the caller's permission on the specified data policy resource.
     * @param \Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function TestIamPermissions(\Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.datapolicies.v1beta1.DataPolicyService/TestIamPermissions',
        $argument,
        ['\Google\Cloud\Iam\V1\TestIamPermissionsResponse', 'decode'],
        $metadata, $options);
    }

}
