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
namespace Google\Identity\AccessContextManager\V1;

/**
 * API for setting [access levels]
 * [google.identity.accesscontextmanager.v1.AccessLevel] and [service
 * perimeters] [google.identity.accesscontextmanager.v1.ServicePerimeter]
 * for Google Cloud projects. Each organization has one [access policy]
 * [google.identity.accesscontextmanager.v1.AccessPolicy] that contains the
 * [access levels] [google.identity.accesscontextmanager.v1.AccessLevel]
 * and [service perimeters]
 * [google.identity.accesscontextmanager.v1.ServicePerimeter]. This
 * [access policy] [google.identity.accesscontextmanager.v1.AccessPolicy] is
 * applicable to all resources in the organization.
 * AccessPolicies
 */
class AccessContextManagerGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists all [access policies]
     * [google.identity.accesscontextmanager.v1.AccessPolicy] in an
     * organization.
     * @param \Google\Identity\AccessContextManager\V1\ListAccessPoliciesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListAccessPolicies(\Google\Identity\AccessContextManager\V1\ListAccessPoliciesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.identity.accesscontextmanager.v1.AccessContextManager/ListAccessPolicies',
        $argument,
        ['\Google\Identity\AccessContextManager\V1\ListAccessPoliciesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns an [access policy]
     * [google.identity.accesscontextmanager.v1.AccessPolicy] based on the name.
     * @param \Google\Identity\AccessContextManager\V1\GetAccessPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAccessPolicy(\Google\Identity\AccessContextManager\V1\GetAccessPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.identity.accesscontextmanager.v1.AccessContextManager/GetAccessPolicy',
        $argument,
        ['\Google\Identity\AccessContextManager\V1\AccessPolicy', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates an access policy. This method fails if the organization already has
     * an access policy. The long-running operation has a successful status
     * after the access policy propagates to long-lasting storage.
     * Syntactic and basic semantic errors are returned in `metadata` as a
     * BadRequest proto.
     * @param \Google\Identity\AccessContextManager\V1\AccessPolicy $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateAccessPolicy(\Google\Identity\AccessContextManager\V1\AccessPolicy $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.identity.accesscontextmanager.v1.AccessContextManager/CreateAccessPolicy',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an [access policy]
     * [google.identity.accesscontextmanager.v1.AccessPolicy]. The
     * long-running operation from this RPC has a successful status after the
     * changes to the [access policy]
     * [google.identity.accesscontextmanager.v1.AccessPolicy] propagate
     * to long-lasting storage.
     * @param \Google\Identity\AccessContextManager\V1\UpdateAccessPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateAccessPolicy(\Google\Identity\AccessContextManager\V1\UpdateAccessPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.identity.accesscontextmanager.v1.AccessContextManager/UpdateAccessPolicy',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an [access policy]
     * [google.identity.accesscontextmanager.v1.AccessPolicy] based on the
     * resource name. The long-running operation has a successful status after the
     * [access policy] [google.identity.accesscontextmanager.v1.AccessPolicy]
     * is removed from long-lasting storage.
     * @param \Google\Identity\AccessContextManager\V1\DeleteAccessPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteAccessPolicy(\Google\Identity\AccessContextManager\V1\DeleteAccessPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.identity.accesscontextmanager.v1.AccessContextManager/DeleteAccessPolicy',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all [access levels]
     * [google.identity.accesscontextmanager.v1.AccessLevel] for an access
     * policy.
     * @param \Google\Identity\AccessContextManager\V1\ListAccessLevelsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListAccessLevels(\Google\Identity\AccessContextManager\V1\ListAccessLevelsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.identity.accesscontextmanager.v1.AccessContextManager/ListAccessLevels',
        $argument,
        ['\Google\Identity\AccessContextManager\V1\ListAccessLevelsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets an [access level]
     * [google.identity.accesscontextmanager.v1.AccessLevel] based on the resource
     * name.
     * @param \Google\Identity\AccessContextManager\V1\GetAccessLevelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAccessLevel(\Google\Identity\AccessContextManager\V1\GetAccessLevelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.identity.accesscontextmanager.v1.AccessContextManager/GetAccessLevel',
        $argument,
        ['\Google\Identity\AccessContextManager\V1\AccessLevel', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates an [access level]
     * [google.identity.accesscontextmanager.v1.AccessLevel]. The long-running
     * operation from this RPC has a successful status after the [access
     * level] [google.identity.accesscontextmanager.v1.AccessLevel]
     * propagates to long-lasting storage. If [access levels]
     * [google.identity.accesscontextmanager.v1.AccessLevel] contain
     * errors, an error response is returned for the first error encountered.
     * @param \Google\Identity\AccessContextManager\V1\CreateAccessLevelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateAccessLevel(\Google\Identity\AccessContextManager\V1\CreateAccessLevelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.identity.accesscontextmanager.v1.AccessContextManager/CreateAccessLevel',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an [access level]
     * [google.identity.accesscontextmanager.v1.AccessLevel]. The long-running
     * operation from this RPC has a successful status after the changes to
     * the [access level]
     * [google.identity.accesscontextmanager.v1.AccessLevel] propagate
     * to long-lasting storage. If [access levels]
     * [google.identity.accesscontextmanager.v1.AccessLevel] contain
     * errors, an error response is returned for the first error encountered.
     * @param \Google\Identity\AccessContextManager\V1\UpdateAccessLevelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateAccessLevel(\Google\Identity\AccessContextManager\V1\UpdateAccessLevelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.identity.accesscontextmanager.v1.AccessContextManager/UpdateAccessLevel',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an [access level]
     * [google.identity.accesscontextmanager.v1.AccessLevel] based on the resource
     * name. The long-running operation from this RPC has a successful status
     * after the [access level]
     * [google.identity.accesscontextmanager.v1.AccessLevel] has been removed
     * from long-lasting storage.
     * @param \Google\Identity\AccessContextManager\V1\DeleteAccessLevelRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteAccessLevel(\Google\Identity\AccessContextManager\V1\DeleteAccessLevelRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.identity.accesscontextmanager.v1.AccessContextManager/DeleteAccessLevel',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Replaces all existing [access levels]
     * [google.identity.accesscontextmanager.v1.AccessLevel] in an [access
     * policy] [google.identity.accesscontextmanager.v1.AccessPolicy] with
     * the [access levels]
     * [google.identity.accesscontextmanager.v1.AccessLevel] provided. This
     * is done atomically. The long-running operation from this RPC has a
     * successful status after all replacements propagate to long-lasting
     * storage. If the replacement contains errors, an error response is returned
     * for the first error encountered.  Upon error, the replacement is cancelled,
     * and existing [access levels]
     * [google.identity.accesscontextmanager.v1.AccessLevel] are not
     * affected. The Operation.response field contains
     * ReplaceAccessLevelsResponse. Removing [access levels]
     * [google.identity.accesscontextmanager.v1.AccessLevel] contained in existing
     * [service perimeters]
     * [google.identity.accesscontextmanager.v1.ServicePerimeter] result in an
     * error.
     * @param \Google\Identity\AccessContextManager\V1\ReplaceAccessLevelsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ReplaceAccessLevels(\Google\Identity\AccessContextManager\V1\ReplaceAccessLevelsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.identity.accesscontextmanager.v1.AccessContextManager/ReplaceAccessLevels',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all [service perimeters]
     * [google.identity.accesscontextmanager.v1.ServicePerimeter] for an
     * access policy.
     * @param \Google\Identity\AccessContextManager\V1\ListServicePerimetersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListServicePerimeters(\Google\Identity\AccessContextManager\V1\ListServicePerimetersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.identity.accesscontextmanager.v1.AccessContextManager/ListServicePerimeters',
        $argument,
        ['\Google\Identity\AccessContextManager\V1\ListServicePerimetersResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a [service perimeter]
     * [google.identity.accesscontextmanager.v1.ServicePerimeter] based on the
     * resource name.
     * @param \Google\Identity\AccessContextManager\V1\GetServicePerimeterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetServicePerimeter(\Google\Identity\AccessContextManager\V1\GetServicePerimeterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.identity.accesscontextmanager.v1.AccessContextManager/GetServicePerimeter',
        $argument,
        ['\Google\Identity\AccessContextManager\V1\ServicePerimeter', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a [service perimeter]
     * [google.identity.accesscontextmanager.v1.ServicePerimeter]. The
     * long-running operation from this RPC has a successful status after the
     * [service perimeter]
     * [google.identity.accesscontextmanager.v1.ServicePerimeter]
     * propagates to long-lasting storage. If a [service perimeter]
     * [google.identity.accesscontextmanager.v1.ServicePerimeter] contains
     * errors, an error response is returned for the first error encountered.
     * @param \Google\Identity\AccessContextManager\V1\CreateServicePerimeterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateServicePerimeter(\Google\Identity\AccessContextManager\V1\CreateServicePerimeterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.identity.accesscontextmanager.v1.AccessContextManager/CreateServicePerimeter',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a [service perimeter]
     * [google.identity.accesscontextmanager.v1.ServicePerimeter]. The
     * long-running operation from this RPC has a successful status after the
     * [service perimeter]
     * [google.identity.accesscontextmanager.v1.ServicePerimeter]
     * propagates to long-lasting storage. If a [service perimeter]
     * [google.identity.accesscontextmanager.v1.ServicePerimeter] contains
     * errors, an error response is returned for the first error encountered.
     * @param \Google\Identity\AccessContextManager\V1\UpdateServicePerimeterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateServicePerimeter(\Google\Identity\AccessContextManager\V1\UpdateServicePerimeterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.identity.accesscontextmanager.v1.AccessContextManager/UpdateServicePerimeter',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a [service perimeter]
     * [google.identity.accesscontextmanager.v1.ServicePerimeter] based on the
     * resource name. The long-running operation from this RPC has a successful
     * status after the [service perimeter]
     * [google.identity.accesscontextmanager.v1.ServicePerimeter] is removed from
     * long-lasting storage.
     * @param \Google\Identity\AccessContextManager\V1\DeleteServicePerimeterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteServicePerimeter(\Google\Identity\AccessContextManager\V1\DeleteServicePerimeterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.identity.accesscontextmanager.v1.AccessContextManager/DeleteServicePerimeter',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Replace all existing [service perimeters]
     * [google.identity.accesscontextmanager.v1.ServicePerimeter] in an [access
     * policy] [google.identity.accesscontextmanager.v1.AccessPolicy] with the
     * [service perimeters]
     * [google.identity.accesscontextmanager.v1.ServicePerimeter] provided. This
     * is done atomically. The long-running operation from this RPC has a
     * successful status after all replacements propagate to long-lasting storage.
     * Replacements containing errors result in an error response for the first
     * error encountered. Upon an error, replacement are cancelled and existing
     * [service perimeters]
     * [google.identity.accesscontextmanager.v1.ServicePerimeter] are not
     * affected. The Operation.response field contains
     * ReplaceServicePerimetersResponse.
     * @param \Google\Identity\AccessContextManager\V1\ReplaceServicePerimetersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ReplaceServicePerimeters(\Google\Identity\AccessContextManager\V1\ReplaceServicePerimetersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.identity.accesscontextmanager.v1.AccessContextManager/ReplaceServicePerimeters',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Commits the dry-run specification for all the [service perimeters]
     * [google.identity.accesscontextmanager.v1.ServicePerimeter] in an
     * [access policy][google.identity.accesscontextmanager.v1.AccessPolicy].
     * A commit operation on a service perimeter involves copying its `spec` field
     * to the `status` field of the service perimeter. Only [service perimeters]
     * [google.identity.accesscontextmanager.v1.ServicePerimeter] with
     * `use_explicit_dry_run_spec` field set to true are affected by a commit
     * operation. The long-running operation from this RPC has a successful
     * status after the dry-run specifications for all the [service perimeters]
     * [google.identity.accesscontextmanager.v1.ServicePerimeter] have been
     * committed. If a commit fails, it causes the long-running operation to
     * return an error response and the entire commit operation is cancelled.
     * When successful, the Operation.response field contains
     * CommitServicePerimetersResponse. The `dry_run` and the `spec` fields are
     * cleared after a successful commit operation.
     * @param \Google\Identity\AccessContextManager\V1\CommitServicePerimetersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CommitServicePerimeters(\Google\Identity\AccessContextManager\V1\CommitServicePerimetersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.identity.accesscontextmanager.v1.AccessContextManager/CommitServicePerimeters',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all [GcpUserAccessBindings]
     * [google.identity.accesscontextmanager.v1.GcpUserAccessBinding] for a
     * Google Cloud organization.
     * @param \Google\Identity\AccessContextManager\V1\ListGcpUserAccessBindingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListGcpUserAccessBindings(\Google\Identity\AccessContextManager\V1\ListGcpUserAccessBindingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.identity.accesscontextmanager.v1.AccessContextManager/ListGcpUserAccessBindings',
        $argument,
        ['\Google\Identity\AccessContextManager\V1\ListGcpUserAccessBindingsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the [GcpUserAccessBinding]
     * [google.identity.accesscontextmanager.v1.GcpUserAccessBinding] with
     * the given name.
     * @param \Google\Identity\AccessContextManager\V1\GetGcpUserAccessBindingRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetGcpUserAccessBinding(\Google\Identity\AccessContextManager\V1\GetGcpUserAccessBindingRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.identity.accesscontextmanager.v1.AccessContextManager/GetGcpUserAccessBinding',
        $argument,
        ['\Google\Identity\AccessContextManager\V1\GcpUserAccessBinding', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a [GcpUserAccessBinding]
     * [google.identity.accesscontextmanager.v1.GcpUserAccessBinding]. If the
     * client specifies a [name]
     * [google.identity.accesscontextmanager.v1.GcpUserAccessBinding.name],
     * the server ignores it. Fails if a resource already exists with the same
     * [group_key]
     * [google.identity.accesscontextmanager.v1.GcpUserAccessBinding.group_key].
     * Completion of this long-running operation does not necessarily signify that
     * the new binding is deployed onto all affected users, which may take more
     * time.
     * @param \Google\Identity\AccessContextManager\V1\CreateGcpUserAccessBindingRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateGcpUserAccessBinding(\Google\Identity\AccessContextManager\V1\CreateGcpUserAccessBindingRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.identity.accesscontextmanager.v1.AccessContextManager/CreateGcpUserAccessBinding',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a [GcpUserAccessBinding]
     * [google.identity.accesscontextmanager.v1.GcpUserAccessBinding].
     * Completion of this long-running operation does not necessarily signify that
     * the changed binding is deployed onto all affected users, which may take
     * more time.
     * @param \Google\Identity\AccessContextManager\V1\UpdateGcpUserAccessBindingRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateGcpUserAccessBinding(\Google\Identity\AccessContextManager\V1\UpdateGcpUserAccessBindingRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.identity.accesscontextmanager.v1.AccessContextManager/UpdateGcpUserAccessBinding',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a [GcpUserAccessBinding]
     * [google.identity.accesscontextmanager.v1.GcpUserAccessBinding].
     * Completion of this long-running operation does not necessarily signify that
     * the binding deletion is deployed onto all affected users, which may take
     * more time.
     * @param \Google\Identity\AccessContextManager\V1\DeleteGcpUserAccessBindingRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteGcpUserAccessBinding(\Google\Identity\AccessContextManager\V1\DeleteGcpUserAccessBindingRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.identity.accesscontextmanager.v1.AccessContextManager/DeleteGcpUserAccessBinding',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Sets the IAM policy for the specified Access Context Manager
     * [access policy][google.identity.accesscontextmanager.v1.AccessPolicy].
     * This method replaces the existing IAM policy on the access policy. The IAM
     * policy controls the set of users who can perform specific operations on the
     * Access Context Manager [access
     * policy][google.identity.accesscontextmanager.v1.AccessPolicy].
     * @param \Google\Cloud\Iam\V1\SetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SetIamPolicy(\Google\Cloud\Iam\V1\SetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.identity.accesscontextmanager.v1.AccessContextManager/SetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the IAM policy for the specified Access Context Manager
     * [access policy][google.identity.accesscontextmanager.v1.AccessPolicy].
     * @param \Google\Cloud\Iam\V1\GetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetIamPolicy(\Google\Cloud\Iam\V1\GetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.identity.accesscontextmanager.v1.AccessContextManager/GetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the IAM permissions that the caller has on the specified Access
     * Context Manager resource. The resource can be an
     * [AccessPolicy][google.identity.accesscontextmanager.v1.AccessPolicy],
     * [AccessLevel][google.identity.accesscontextmanager.v1.AccessLevel], or
     * [ServicePerimeter][google.identity.accesscontextmanager.v1.ServicePerimeter
     * ]. This method does not support other resources.
     * @param \Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function TestIamPermissions(\Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.identity.accesscontextmanager.v1.AccessContextManager/TestIamPermissions',
        $argument,
        ['\Google\Cloud\Iam\V1\TestIamPermissionsResponse', 'decode'],
        $metadata, $options);
    }

}
