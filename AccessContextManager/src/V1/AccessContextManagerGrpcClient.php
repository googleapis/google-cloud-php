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
 * API for setting [Access Levels]
 * [google.identity.accesscontextmanager.v1.AccessLevel] and [Service
 * Perimeters] [google.identity.accesscontextmanager.v1.ServicePerimeter]
 * for Google Cloud Projects. Each organization has one [AccessPolicy]
 * [google.identity.accesscontextmanager.v1.AccessPolicy] containing the
 * [Access Levels] [google.identity.accesscontextmanager.v1.AccessLevel]
 * and [Service Perimeters]
 * [google.identity.accesscontextmanager.v1.ServicePerimeter]. This
 * [AccessPolicy] [google.identity.accesscontextmanager.v1.AccessPolicy] is
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
     * List all [AccessPolicies]
     * [google.identity.accesscontextmanager.v1.AccessPolicy] under a
     * container.
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
     * Get an [AccessPolicy]
     * [google.identity.accesscontextmanager.v1.AccessPolicy] by name.
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
     * Create an `AccessPolicy`. Fails if this organization already has a
     * `AccessPolicy`. The longrunning Operation will have a successful status
     * once the `AccessPolicy` has propagated to long-lasting storage.
     * Syntactic and basic semantic errors will be returned in `metadata` as a
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
     * Update an [AccessPolicy]
     * [google.identity.accesscontextmanager.v1.AccessPolicy]. The
     * longrunning Operation from this RPC will have a successful status once the
     * changes to the [AccessPolicy]
     * [google.identity.accesscontextmanager.v1.AccessPolicy] have propagated
     * to long-lasting storage. Syntactic and basic semantic errors will be
     * returned in `metadata` as a BadRequest proto.
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
     * Delete an [AccessPolicy]
     * [google.identity.accesscontextmanager.v1.AccessPolicy] by resource
     * name. The longrunning Operation will have a successful status once the
     * [AccessPolicy] [google.identity.accesscontextmanager.v1.AccessPolicy]
     * has been removed from long-lasting storage.
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
     * List all [Access Levels]
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
     * Get an [Access Level]
     * [google.identity.accesscontextmanager.v1.AccessLevel] by resource
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
     * Create an [Access Level]
     * [google.identity.accesscontextmanager.v1.AccessLevel]. The longrunning
     * operation from this RPC will have a successful status once the [Access
     * Level] [google.identity.accesscontextmanager.v1.AccessLevel] has
     * propagated to long-lasting storage. [Access Levels]
     * [google.identity.accesscontextmanager.v1.AccessLevel] containing
     * errors will result in an error response for the first error encountered.
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
     * Update an [Access Level]
     * [google.identity.accesscontextmanager.v1.AccessLevel]. The longrunning
     * operation from this RPC will have a successful status once the changes to
     * the [Access Level]
     * [google.identity.accesscontextmanager.v1.AccessLevel] have propagated
     * to long-lasting storage. [Access Levels]
     * [google.identity.accesscontextmanager.v1.AccessLevel] containing
     * errors will result in an error response for the first error encountered.
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
     * Delete an [Access Level]
     * [google.identity.accesscontextmanager.v1.AccessLevel] by resource
     * name. The longrunning operation from this RPC will have a successful status
     * once the [Access Level]
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
     * Replace all existing [Access Levels]
     * [google.identity.accesscontextmanager.v1.AccessLevel] in an [Access
     * Policy] [google.identity.accesscontextmanager.v1.AccessPolicy] with
     * the [Access Levels]
     * [google.identity.accesscontextmanager.v1.AccessLevel] provided. This
     * is done atomically. The longrunning operation from this RPC will have a
     * successful status once all replacements have propagated to long-lasting
     * storage. Replacements containing errors will result in an error response
     * for the first error encountered.  Replacement will be cancelled on error,
     * existing [Access Levels]
     * [google.identity.accesscontextmanager.v1.AccessLevel] will not be
     * affected. Operation.response field will contain
     * ReplaceAccessLevelsResponse. Removing [Access Levels]
     * [google.identity.accesscontextmanager.v1.AccessLevel] contained in existing
     * [Service Perimeters]
     * [google.identity.accesscontextmanager.v1.ServicePerimeter] will result in
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
     * List all [Service Perimeters]
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
     * Get a [Service Perimeter]
     * [google.identity.accesscontextmanager.v1.ServicePerimeter] by resource
     * name.
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
     * Create a [Service Perimeter]
     * [google.identity.accesscontextmanager.v1.ServicePerimeter]. The
     * longrunning operation from this RPC will have a successful status once the
     * [Service Perimeter]
     * [google.identity.accesscontextmanager.v1.ServicePerimeter] has
     * propagated to long-lasting storage. [Service Perimeters]
     * [google.identity.accesscontextmanager.v1.ServicePerimeter] containing
     * errors will result in an error response for the first error encountered.
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
     * Update a [Service Perimeter]
     * [google.identity.accesscontextmanager.v1.ServicePerimeter]. The
     * longrunning operation from this RPC will have a successful status once the
     * changes to the [Service Perimeter]
     * [google.identity.accesscontextmanager.v1.ServicePerimeter] have
     * propagated to long-lasting storage. [Service Perimeter]
     * [google.identity.accesscontextmanager.v1.ServicePerimeter] containing
     * errors will result in an error response for the first error encountered.
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
     * Delete a [Service Perimeter]
     * [google.identity.accesscontextmanager.v1.ServicePerimeter] by resource
     * name. The longrunning operation from this RPC will have a successful status
     * once the [Service Perimeter]
     * [google.identity.accesscontextmanager.v1.ServicePerimeter] has been
     * removed from long-lasting storage.
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
     * Replace all existing [Service Perimeters]
     * [google.identity.accesscontextmanager.v1.ServicePerimeter] in an
     * [Access Policy] [google.identity.accesscontextmanager.v1.AccessPolicy]
     * with the [Service Perimeters]
     * [google.identity.accesscontextmanager.v1.ServicePerimeter] provided.
     * This is done atomically. The longrunning operation from this
     * RPC will have a successful status once all replacements have propagated to
     * long-lasting storage. Replacements containing errors will result in an
     * error response for the first error encountered. Replacement will be
     * cancelled on error, existing [Service Perimeters]
     * [google.identity.accesscontextmanager.v1.ServicePerimeter] will not be
     * affected. Operation.response field will contain
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
     * Commit the dry-run spec for all the [Service Perimeters]
     * [google.identity.accesscontextmanager.v1.ServicePerimeter] in an
     * [Access Policy][google.identity.accesscontextmanager.v1.AccessPolicy].
     * A commit operation on a Service Perimeter involves copying its `spec` field
     * to that Service Perimeter's `status` field. Only [Service Perimeters]
     * [google.identity.accesscontextmanager.v1.ServicePerimeter] with
     * `use_explicit_dry_run_spec` field set to true are affected by a commit
     * operation. The longrunning operation from this RPC will have a successful
     * status once the dry-run specs for all the [Service Perimeters]
     * [google.identity.accesscontextmanager.v1.ServicePerimeter] have been
     * committed. If a commit fails, it will cause the longrunning operation to
     * return an error response and the entire commit operation will be cancelled.
     * When successful, Operation.response field will contain
     * CommitServicePerimetersResponse. The `dry_run` and the `spec` fields will
     * be cleared after a successful commit operation.
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
     * the server will ignore it. Fails if a resource already exists with the same
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

}
