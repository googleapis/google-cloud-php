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
namespace Google\Cloud\Dataplex\V1;

/**
 * ContentService manages Notebook and SQL Scripts for Dataplex.
 */
class ContentServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Create a content.
     * @param \Google\Cloud\Dataplex\V1\CreateContentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateContent(\Google\Cloud\Dataplex\V1\CreateContentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.ContentService/CreateContent',
        $argument,
        ['\Google\Cloud\Dataplex\V1\Content', 'decode'],
        $metadata, $options);
    }

    /**
     * Update a content. Only supports full resource update.
     * @param \Google\Cloud\Dataplex\V1\UpdateContentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateContent(\Google\Cloud\Dataplex\V1\UpdateContentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.ContentService/UpdateContent',
        $argument,
        ['\Google\Cloud\Dataplex\V1\Content', 'decode'],
        $metadata, $options);
    }

    /**
     * Delete a content.
     * @param \Google\Cloud\Dataplex\V1\DeleteContentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteContent(\Google\Cloud\Dataplex\V1\DeleteContentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.ContentService/DeleteContent',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Get a content resource.
     * @param \Google\Cloud\Dataplex\V1\GetContentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetContent(\Google\Cloud\Dataplex\V1\GetContentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.ContentService/GetContent',
        $argument,
        ['\Google\Cloud\Dataplex\V1\Content', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the access control policy for a contentitem resource. A `NOT_FOUND`
     * error is returned if the resource does not exist. An empty policy is
     * returned if the resource exists but does not have a policy set on it.
     *
     * Caller must have Google IAM `dataplex.content.getIamPolicy` permission
     * on the resource.
     * @param \Google\Cloud\Iam\V1\GetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetIamPolicy(\Google\Cloud\Iam\V1\GetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.ContentService/GetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Sets the access control policy on the specified contentitem resource.
     * Replaces any existing policy.
     *
     * Caller must have Google IAM `dataplex.content.setIamPolicy` permission
     * on the resource.
     * @param \Google\Cloud\Iam\V1\SetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SetIamPolicy(\Google\Cloud\Iam\V1\SetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.ContentService/SetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the caller's permissions on a resource.
     * If the resource does not exist, an empty set of
     * permissions is returned (a `NOT_FOUND` error is not returned).
     *
     * A caller is not required to have Google IAM permission to make this
     * request.
     *
     * Note: This operation is designed to be used for building permission-aware
     * UIs and command-line tools, not for authorization checking. This operation
     * may "fail open" without warning.
     * @param \Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function TestIamPermissions(\Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.ContentService/TestIamPermissions',
        $argument,
        ['\Google\Cloud\Iam\V1\TestIamPermissionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * List content.
     * @param \Google\Cloud\Dataplex\V1\ListContentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListContent(\Google\Cloud\Dataplex\V1\ListContentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.ContentService/ListContent',
        $argument,
        ['\Google\Cloud\Dataplex\V1\ListContentResponse', 'decode'],
        $metadata, $options);
    }

}
