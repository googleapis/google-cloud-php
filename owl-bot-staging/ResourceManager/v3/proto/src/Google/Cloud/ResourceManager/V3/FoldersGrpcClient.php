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
 * Manages Cloud Platform folder resources.
 * Folders can be used to organize the resources under an
 * organization and to control the policies applied to groups of resources.
 */
class FoldersGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Retrieves a folder identified by the supplied resource name.
     * Valid folder resource names have the format `folders/{folder_id}`
     * (for example, `folders/1234`).
     * The caller must have `resourcemanager.folders.get` permission on the
     * identified folder.
     * @param \Google\Cloud\ResourceManager\V3\GetFolderRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetFolder(\Google\Cloud\ResourceManager\V3\GetFolderRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.Folders/GetFolder',
        $argument,
        ['\Google\Cloud\ResourceManager\V3\Folder', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the folders that are direct descendants of supplied parent resource.
     * `list()` provides a strongly consistent view of the folders underneath
     * the specified parent resource.
     * `list()` returns folders sorted based upon the (ascending) lexical ordering
     * of their display_name.
     * The caller must have `resourcemanager.folders.list` permission on the
     * identified parent.
     * @param \Google\Cloud\ResourceManager\V3\ListFoldersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListFolders(\Google\Cloud\ResourceManager\V3\ListFoldersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.Folders/ListFolders',
        $argument,
        ['\Google\Cloud\ResourceManager\V3\ListFoldersResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Search for folders that match specific filter criteria.
     * `search()` provides an eventually consistent view of the folders a user has
     * access to which meet the specified filter criteria.
     *
     * This will only return folders on which the caller has the
     * permission `resourcemanager.folders.get`.
     * @param \Google\Cloud\ResourceManager\V3\SearchFoldersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SearchFolders(\Google\Cloud\ResourceManager\V3\SearchFoldersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.Folders/SearchFolders',
        $argument,
        ['\Google\Cloud\ResourceManager\V3\SearchFoldersResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a folder in the resource hierarchy.
     * Returns an `Operation` which can be used to track the progress of the
     * folder creation workflow.
     * Upon success, the `Operation.response` field will be populated with the
     * created Folder.
     *
     * In order to succeed, the addition of this new folder must not violate
     * the folder naming, height, or fanout constraints.
     *
     * + The folder's `display_name` must be distinct from all other folders that
     * share its parent.
     * + The addition of the folder must not cause the active folder hierarchy
     * to exceed a height of 10. Note, the full active + deleted folder hierarchy
     * is allowed to reach a height of 20; this provides additional headroom when
     * moving folders that contain deleted folders.
     * + The addition of the folder must not cause the total number of folders
     * under its parent to exceed 300.
     *
     * If the operation fails due to a folder constraint violation, some errors
     * may be returned by the `CreateFolder` request, with status code
     * `FAILED_PRECONDITION` and an error description. Other folder constraint
     * violations will be communicated in the `Operation`, with the specific
     * `PreconditionFailure` returned in the details list in the `Operation.error`
     * field.
     *
     * The caller must have `resourcemanager.folders.create` permission on the
     * identified parent.
     * @param \Google\Cloud\ResourceManager\V3\CreateFolderRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateFolder(\Google\Cloud\ResourceManager\V3\CreateFolderRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.Folders/CreateFolder',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a folder, changing its `display_name`.
     * Changes to the folder `display_name` will be rejected if they violate
     * either the `display_name` formatting rules or the naming constraints
     * described in the [CreateFolder][google.cloud.resourcemanager.v3.Folders.CreateFolder] documentation.
     *
     * The folder's `display_name` must start and end with a letter or digit,
     * may contain letters, digits, spaces, hyphens and underscores and can be
     * between 3 and 30 characters. This is captured by the regular expression:
     * `[\p{L}\p{N}][\p{L}\p{N}_- ]{1,28}[\p{L}\p{N}]`.
     * The caller must have `resourcemanager.folders.update` permission on the
     * identified folder.
     *
     * If the update fails due to the unique name constraint then a
     * `PreconditionFailure` explaining this violation will be returned
     * in the Status.details field.
     * @param \Google\Cloud\ResourceManager\V3\UpdateFolderRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateFolder(\Google\Cloud\ResourceManager\V3\UpdateFolderRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.Folders/UpdateFolder',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Moves a folder under a new resource parent.
     * Returns an `Operation` which can be used to track the progress of the
     * folder move workflow.
     * Upon success, the `Operation.response` field will be populated with the
     * moved folder.
     * Upon failure, a `FolderOperationError` categorizing the failure cause will
     * be returned - if the failure occurs synchronously then the
     * `FolderOperationError` will be returned in the `Status.details` field.
     * If it occurs asynchronously, then the FolderOperation will be returned
     * in the `Operation.error` field.
     * In addition, the `Operation.metadata` field will be populated with a
     * `FolderOperation` message as an aid to stateless clients.
     * Folder moves will be rejected if they violate either the naming, height,
     * or fanout constraints described in the
     * [CreateFolder][google.cloud.resourcemanager.v3.Folders.CreateFolder] documentation.
     * The caller must have `resourcemanager.folders.move` permission on the
     * folder's current and proposed new parent.
     * @param \Google\Cloud\ResourceManager\V3\MoveFolderRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function MoveFolder(\Google\Cloud\ResourceManager\V3\MoveFolderRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.Folders/MoveFolder',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Requests deletion of a folder. The folder is moved into the
     * [DELETE_REQUESTED][google.cloud.resourcemanager.v3.Folder.State.DELETE_REQUESTED] state
     * immediately, and is deleted approximately 30 days later. This method may
     * only be called on an empty folder, where a folder is empty if it doesn't
     * contain any folders or projects in the [ACTIVE][google.cloud.resourcemanager.v3.Folder.State.ACTIVE] state.
     * If called on a folder in [DELETE_REQUESTED][google.cloud.resourcemanager.v3.Folder.State.DELETE_REQUESTED]
     * state the operation will result in a no-op success.
     * The caller must have `resourcemanager.folders.delete` permission on the
     * identified folder.
     * @param \Google\Cloud\ResourceManager\V3\DeleteFolderRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteFolder(\Google\Cloud\ResourceManager\V3\DeleteFolderRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.Folders/DeleteFolder',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Cancels the deletion request for a folder. This method may be called on a
     * folder in any state. If the folder is in the [ACTIVE][google.cloud.resourcemanager.v3.Folder.State.ACTIVE]
     * state the result will be a no-op success. In order to succeed, the folder's
     * parent must be in the [ACTIVE][google.cloud.resourcemanager.v3.Folder.State.ACTIVE] state. In addition,
     * reintroducing the folder into the tree must not violate folder naming,
     * height, and fanout constraints described in the
     * [CreateFolder][google.cloud.resourcemanager.v3.Folders.CreateFolder] documentation.
     * The caller must have `resourcemanager.folders.undelete` permission on the
     * identified folder.
     * @param \Google\Cloud\ResourceManager\V3\UndeleteFolderRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UndeleteFolder(\Google\Cloud\ResourceManager\V3\UndeleteFolderRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.Folders/UndeleteFolder',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the access control policy for a folder. The returned policy may be
     * empty if no such policy or resource exists. The `resource` field should
     * be the folder's resource name, for example: "folders/1234".
     * The caller must have `resourcemanager.folders.getIamPolicy` permission
     * on the identified folder.
     * @param \Google\Cloud\Iam\V1\GetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetIamPolicy(\Google\Cloud\Iam\V1\GetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.Folders/GetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Sets the access control policy on a folder, replacing any existing policy.
     * The `resource` field should be the folder's resource name, for example:
     * "folders/1234".
     * The caller must have `resourcemanager.folders.setIamPolicy` permission
     * on the identified folder.
     * @param \Google\Cloud\Iam\V1\SetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SetIamPolicy(\Google\Cloud\Iam\V1\SetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.Folders/SetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns permissions that a caller has on the specified folder.
     * The `resource` field should be the folder's resource name,
     * for example: "folders/1234".
     *
     * There are no permissions required for making this API call.
     * @param \Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function TestIamPermissions(\Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.Folders/TestIamPermissions',
        $argument,
        ['\Google\Cloud\Iam\V1\TestIamPermissionsResponse', 'decode'],
        $metadata, $options);
    }

}
