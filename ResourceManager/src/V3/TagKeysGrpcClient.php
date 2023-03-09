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
 * Allow users to create and manage tag keys.
 */
class TagKeysGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists all TagKeys for a parent resource.
     * @param \Google\Cloud\ResourceManager\V3\ListTagKeysRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListTagKeys(\Google\Cloud\ResourceManager\V3\ListTagKeysRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.TagKeys/ListTagKeys',
        $argument,
        ['\Google\Cloud\ResourceManager\V3\ListTagKeysResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves a TagKey. This method will return `PERMISSION_DENIED` if the
     * key does not exist or the user does not have permission to view it.
     * @param \Google\Cloud\ResourceManager\V3\GetTagKeyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetTagKey(\Google\Cloud\ResourceManager\V3\GetTagKeyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.TagKeys/GetTagKey',
        $argument,
        ['\Google\Cloud\ResourceManager\V3\TagKey', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new TagKey. If another request with the same parameters is
     * sent while the original request is in process, the second request
     * will receive an error. A maximum of 300 TagKeys can exist under a parent at
     * any given time.
     * @param \Google\Cloud\ResourceManager\V3\CreateTagKeyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateTagKey(\Google\Cloud\ResourceManager\V3\CreateTagKeyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.TagKeys/CreateTagKey',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the attributes of the TagKey resource.
     * @param \Google\Cloud\ResourceManager\V3\UpdateTagKeyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateTagKey(\Google\Cloud\ResourceManager\V3\UpdateTagKeyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.TagKeys/UpdateTagKey',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a TagKey. The TagKey cannot be deleted if it has any child
     * TagValues.
     * @param \Google\Cloud\ResourceManager\V3\DeleteTagKeyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteTagKey(\Google\Cloud\ResourceManager\V3\DeleteTagKeyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.TagKeys/DeleteTagKey',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the access control policy for a TagKey. The returned policy may be
     * empty if no such policy or resource exists. The `resource` field should
     * be the TagKey's resource name. For example, "tagKeys/1234".
     * The caller must have
     * `cloudresourcemanager.googleapis.com/tagKeys.getIamPolicy` permission on
     * the specified TagKey.
     * @param \Google\Cloud\Iam\V1\GetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetIamPolicy(\Google\Cloud\Iam\V1\GetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.TagKeys/GetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Sets the access control policy on a TagKey, replacing any existing
     * policy. The `resource` field should be the TagKey's resource name.
     * For example, "tagKeys/1234".
     * The caller must have `resourcemanager.tagKeys.setIamPolicy` permission
     * on the identified tagValue.
     * @param \Google\Cloud\Iam\V1\SetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SetIamPolicy(\Google\Cloud\Iam\V1\SetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.TagKeys/SetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns permissions that a caller has on the specified TagKey.
     * The `resource` field should be the TagKey's resource name.
     * For example, "tagKeys/1234".
     *
     * There are no permissions required for making this API call.
     * @param \Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function TestIamPermissions(\Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.TagKeys/TestIamPermissions',
        $argument,
        ['\Google\Cloud\Iam\V1\TestIamPermissionsResponse', 'decode'],
        $metadata, $options);
    }

}
