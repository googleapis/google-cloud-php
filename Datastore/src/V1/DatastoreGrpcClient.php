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
namespace Google\Cloud\Datastore\V1;

/**
 * Each RPC normalizes the partition IDs of the keys in its input entities,
 * and always returns entities with keys with normalized partition IDs.
 * This applies to all keys and entities, including those in values, except keys
 * with both an empty path and an empty or unset partition ID. Normalization of
 * input keys sets the project ID (if not already set) to the project ID from
 * the request.
 *
 */
class DatastoreGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Looks up entities by key.
     * @param \Google\Cloud\Datastore\V1\LookupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Lookup(\Google\Cloud\Datastore\V1\LookupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.datastore.v1.Datastore/Lookup',
        $argument,
        ['\Google\Cloud\Datastore\V1\LookupResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Queries for entities.
     * @param \Google\Cloud\Datastore\V1\RunQueryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function RunQuery(\Google\Cloud\Datastore\V1\RunQueryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.datastore.v1.Datastore/RunQuery',
        $argument,
        ['\Google\Cloud\Datastore\V1\RunQueryResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Begins a new transaction.
     * @param \Google\Cloud\Datastore\V1\BeginTransactionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function BeginTransaction(\Google\Cloud\Datastore\V1\BeginTransactionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.datastore.v1.Datastore/BeginTransaction',
        $argument,
        ['\Google\Cloud\Datastore\V1\BeginTransactionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Commits a transaction, optionally creating, deleting or modifying some
     * entities.
     * @param \Google\Cloud\Datastore\V1\CommitRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Commit(\Google\Cloud\Datastore\V1\CommitRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.datastore.v1.Datastore/Commit',
        $argument,
        ['\Google\Cloud\Datastore\V1\CommitResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Rolls back a transaction.
     * @param \Google\Cloud\Datastore\V1\RollbackRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Rollback(\Google\Cloud\Datastore\V1\RollbackRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.datastore.v1.Datastore/Rollback',
        $argument,
        ['\Google\Cloud\Datastore\V1\RollbackResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Allocates IDs for the given keys, which is useful for referencing an entity
     * before it is inserted.
     * @param \Google\Cloud\Datastore\V1\AllocateIdsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function AllocateIds(\Google\Cloud\Datastore\V1\AllocateIdsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.datastore.v1.Datastore/AllocateIds',
        $argument,
        ['\Google\Cloud\Datastore\V1\AllocateIdsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Prevents the supplied keys' IDs from being auto-allocated by Cloud
     * Datastore.
     * @param \Google\Cloud\Datastore\V1\ReserveIdsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ReserveIds(\Google\Cloud\Datastore\V1\ReserveIdsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.datastore.v1.Datastore/ReserveIds',
        $argument,
        ['\Google\Cloud\Datastore\V1\ReserveIdsResponse', 'decode'],
        $metadata, $options);
    }

}
