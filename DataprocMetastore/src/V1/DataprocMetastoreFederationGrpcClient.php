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
namespace Google\Cloud\Metastore\V1;

/**
 * Configures and manages metastore federation services.
 * Dataproc Metastore Federation Service allows federating a collection of
 * backend metastores like BigQuery, Dataplex Lakes, and other Dataproc
 * Metastores. The Federation Service exposes a gRPC URL through which metadata
 * from the backend metastores are served at query time.
 *
 * The Dataproc Metastore Federation API defines the following resource model:
 * * The service works with a collection of Google Cloud projects.
 * * Each project has a collection of available locations.
 * * Each location has a collection of federations.
 * * Dataproc Metastore Federations are resources with names of the
 * form:
 * `projects/{project_number}/locations/{location_id}/federations/{federation_id}`.
 */
class DataprocMetastoreFederationGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists federations in a project and location.
     * @param \Google\Cloud\Metastore\V1\ListFederationsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListFederations(\Google\Cloud\Metastore\V1\ListFederationsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.metastore.v1.DataprocMetastoreFederation/ListFederations',
        $argument,
        ['\Google\Cloud\Metastore\V1\ListFederationsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the details of a single federation.
     * @param \Google\Cloud\Metastore\V1\GetFederationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetFederation(\Google\Cloud\Metastore\V1\GetFederationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.metastore.v1.DataprocMetastoreFederation/GetFederation',
        $argument,
        ['\Google\Cloud\Metastore\V1\Federation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a metastore federation in a project and location.
     * @param \Google\Cloud\Metastore\V1\CreateFederationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateFederation(\Google\Cloud\Metastore\V1\CreateFederationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.metastore.v1.DataprocMetastoreFederation/CreateFederation',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the fields of a federation.
     * @param \Google\Cloud\Metastore\V1\UpdateFederationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateFederation(\Google\Cloud\Metastore\V1\UpdateFederationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.metastore.v1.DataprocMetastoreFederation/UpdateFederation',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single federation.
     * @param \Google\Cloud\Metastore\V1\DeleteFederationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteFederation(\Google\Cloud\Metastore\V1\DeleteFederationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.metastore.v1.DataprocMetastoreFederation/DeleteFederation',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
