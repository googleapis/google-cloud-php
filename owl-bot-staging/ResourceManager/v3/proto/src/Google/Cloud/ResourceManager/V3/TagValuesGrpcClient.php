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
namespace Google\Cloud\ResourceManager\V3;

/**
 * Allow users to create and manage tag values.
 */
class TagValuesGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists all TagValues for a specific TagKey.
     * @param \Google\Cloud\ResourceManager\V3\ListTagValuesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListTagValues(\Google\Cloud\ResourceManager\V3\ListTagValuesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.TagValues/ListTagValues',
        $argument,
        ['\Google\Cloud\ResourceManager\V3\ListTagValuesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves TagValue. If the TagValue or namespaced name does not exist, or
     * if the user does not have permission to view it, this method will return
     * `PERMISSION_DENIED`.
     * @param \Google\Cloud\ResourceManager\V3\GetTagValueRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetTagValue(\Google\Cloud\ResourceManager\V3\GetTagValueRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.TagValues/GetTagValue',
        $argument,
        ['\Google\Cloud\ResourceManager\V3\TagValue', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a TagValue as a child of the specified TagKey. If a another
     * request with the same parameters is sent while the original request is in
     * process the second request will receive an error. A maximum of 300
     * TagValues can exist under a TagKey at any given time.
     * @param \Google\Cloud\ResourceManager\V3\CreateTagValueRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateTagValue(\Google\Cloud\ResourceManager\V3\CreateTagValueRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.TagValues/CreateTagValue',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the attributes of the TagValue resource.
     * @param \Google\Cloud\ResourceManager\V3\UpdateTagValueRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateTagValue(\Google\Cloud\ResourceManager\V3\UpdateTagValueRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.TagValues/UpdateTagValue',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a TagValue. The TagValue cannot have any bindings when it is
     * deleted.
     * @param \Google\Cloud\ResourceManager\V3\DeleteTagValueRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteTagValue(\Google\Cloud\ResourceManager\V3\DeleteTagValueRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.TagValues/DeleteTagValue',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the access control policy for a TagValue. The returned policy may be
     * empty if no such policy or resource exists. The `resource` field should
     * be the TagValue's resource name. For example: `tagValues/1234`.
     * The caller must have the
     * `cloudresourcemanager.googleapis.com/tagValues.getIamPolicy` permission on
     * the identified TagValue to get the access control policy.
     * @param \Google\Cloud\Iam\V1\GetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetIamPolicy(\Google\Cloud\Iam\V1\GetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.TagValues/GetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Sets the access control policy on a TagValue, replacing any existing
     * policy. The `resource` field should be the TagValue's resource name.
     * For example: `tagValues/1234`.
     * The caller must have `resourcemanager.tagValues.setIamPolicy` permission
     * on the identified tagValue.
     * @param \Google\Cloud\Iam\V1\SetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SetIamPolicy(\Google\Cloud\Iam\V1\SetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.TagValues/SetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns permissions that a caller has on the specified TagValue.
     * The `resource` field should be the TagValue's resource name. For example:
     * `tagValues/1234`.
     *
     * There are no permissions required for making this API call.
     * @param \Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function TestIamPermissions(\Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.TagValues/TestIamPermissions',
        $argument,
        ['\Google\Cloud\Iam\V1\TestIamPermissionsResponse', 'decode'],
        $metadata, $options);
    }

}
