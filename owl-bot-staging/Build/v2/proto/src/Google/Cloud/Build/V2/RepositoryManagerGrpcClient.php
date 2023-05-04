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
namespace Google\Cloud\Build\V2;

/**
 * Manages connections to source code repostiories.
 */
class RepositoryManagerGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a Connection.
     * @param \Google\Cloud\Build\V2\CreateConnectionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateConnection(\Google\Cloud\Build\V2\CreateConnectionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.cloudbuild.v2.RepositoryManager/CreateConnection',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single connection.
     * @param \Google\Cloud\Build\V2\GetConnectionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetConnection(\Google\Cloud\Build\V2\GetConnectionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.cloudbuild.v2.RepositoryManager/GetConnection',
        $argument,
        ['\Google\Cloud\Build\V2\Connection', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists Connections in a given project and location.
     * @param \Google\Cloud\Build\V2\ListConnectionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListConnections(\Google\Cloud\Build\V2\ListConnectionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.cloudbuild.v2.RepositoryManager/ListConnections',
        $argument,
        ['\Google\Cloud\Build\V2\ListConnectionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a single connection.
     * @param \Google\Cloud\Build\V2\UpdateConnectionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateConnection(\Google\Cloud\Build\V2\UpdateConnectionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.cloudbuild.v2.RepositoryManager/UpdateConnection',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single connection.
     * @param \Google\Cloud\Build\V2\DeleteConnectionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteConnection(\Google\Cloud\Build\V2\DeleteConnectionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.cloudbuild.v2.RepositoryManager/DeleteConnection',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a Repository.
     * @param \Google\Cloud\Build\V2\CreateRepositoryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateRepository(\Google\Cloud\Build\V2\CreateRepositoryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.cloudbuild.v2.RepositoryManager/CreateRepository',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates multiple repositories inside a connection.
     * @param \Google\Cloud\Build\V2\BatchCreateRepositoriesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BatchCreateRepositories(\Google\Cloud\Build\V2\BatchCreateRepositoriesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.cloudbuild.v2.RepositoryManager/BatchCreateRepositories',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single repository.
     * @param \Google\Cloud\Build\V2\GetRepositoryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetRepository(\Google\Cloud\Build\V2\GetRepositoryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.cloudbuild.v2.RepositoryManager/GetRepository',
        $argument,
        ['\Google\Cloud\Build\V2\Repository', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists Repositories in a given connection.
     * @param \Google\Cloud\Build\V2\ListRepositoriesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListRepositories(\Google\Cloud\Build\V2\ListRepositoriesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.cloudbuild.v2.RepositoryManager/ListRepositories',
        $argument,
        ['\Google\Cloud\Build\V2\ListRepositoriesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single repository.
     * @param \Google\Cloud\Build\V2\DeleteRepositoryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteRepository(\Google\Cloud\Build\V2\DeleteRepositoryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.cloudbuild.v2.RepositoryManager/DeleteRepository',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Fetches read/write token of a given repository.
     * @param \Google\Cloud\Build\V2\FetchReadWriteTokenRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function FetchReadWriteToken(\Google\Cloud\Build\V2\FetchReadWriteTokenRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.cloudbuild.v2.RepositoryManager/FetchReadWriteToken',
        $argument,
        ['\Google\Cloud\Build\V2\FetchReadWriteTokenResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Fetches read token of a given repository.
     * @param \Google\Cloud\Build\V2\FetchReadTokenRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function FetchReadToken(\Google\Cloud\Build\V2\FetchReadTokenRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.cloudbuild.v2.RepositoryManager/FetchReadToken',
        $argument,
        ['\Google\Cloud\Build\V2\FetchReadTokenResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * FetchLinkableRepositories get repositories from SCM that are
     * accessible and could be added to the connection.
     * @param \Google\Cloud\Build\V2\FetchLinkableRepositoriesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function FetchLinkableRepositories(\Google\Cloud\Build\V2\FetchLinkableRepositoriesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.cloudbuild.v2.RepositoryManager/FetchLinkableRepositories',
        $argument,
        ['\Google\Cloud\Build\V2\FetchLinkableRepositoriesResponse', 'decode'],
        $metadata, $options);
    }

}
