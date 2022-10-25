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
namespace Google\Cloud\AIPlatform\V1;

/**
 * Service for reading and writing metadata entries.
 */
class MetadataServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Initializes a MetadataStore, including allocation of resources.
     * @param \Google\Cloud\AIPlatform\V1\CreateMetadataStoreRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateMetadataStore(\Google\Cloud\AIPlatform\V1\CreateMetadataStoreRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.MetadataService/CreateMetadataStore',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves a specific MetadataStore.
     * @param \Google\Cloud\AIPlatform\V1\GetMetadataStoreRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetMetadataStore(\Google\Cloud\AIPlatform\V1\GetMetadataStoreRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.MetadataService/GetMetadataStore',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\MetadataStore', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists MetadataStores for a Location.
     * @param \Google\Cloud\AIPlatform\V1\ListMetadataStoresRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListMetadataStores(\Google\Cloud\AIPlatform\V1\ListMetadataStoresRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.MetadataService/ListMetadataStores',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\ListMetadataStoresResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single MetadataStore and all its child resources (Artifacts,
     * Executions, and Contexts).
     * @param \Google\Cloud\AIPlatform\V1\DeleteMetadataStoreRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteMetadataStore(\Google\Cloud\AIPlatform\V1\DeleteMetadataStoreRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.MetadataService/DeleteMetadataStore',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates an Artifact associated with a MetadataStore.
     * @param \Google\Cloud\AIPlatform\V1\CreateArtifactRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateArtifact(\Google\Cloud\AIPlatform\V1\CreateArtifactRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.MetadataService/CreateArtifact',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\Artifact', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves a specific Artifact.
     * @param \Google\Cloud\AIPlatform\V1\GetArtifactRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetArtifact(\Google\Cloud\AIPlatform\V1\GetArtifactRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.MetadataService/GetArtifact',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\Artifact', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists Artifacts in the MetadataStore.
     * @param \Google\Cloud\AIPlatform\V1\ListArtifactsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListArtifacts(\Google\Cloud\AIPlatform\V1\ListArtifactsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.MetadataService/ListArtifacts',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\ListArtifactsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a stored Artifact.
     * @param \Google\Cloud\AIPlatform\V1\UpdateArtifactRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateArtifact(\Google\Cloud\AIPlatform\V1\UpdateArtifactRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.MetadataService/UpdateArtifact',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\Artifact', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an Artifact.
     * @param \Google\Cloud\AIPlatform\V1\DeleteArtifactRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteArtifact(\Google\Cloud\AIPlatform\V1\DeleteArtifactRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.MetadataService/DeleteArtifact',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Purges Artifacts.
     * @param \Google\Cloud\AIPlatform\V1\PurgeArtifactsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function PurgeArtifacts(\Google\Cloud\AIPlatform\V1\PurgeArtifactsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.MetadataService/PurgeArtifacts',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a Context associated with a MetadataStore.
     * @param \Google\Cloud\AIPlatform\V1\CreateContextRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateContext(\Google\Cloud\AIPlatform\V1\CreateContextRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.MetadataService/CreateContext',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\Context', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves a specific Context.
     * @param \Google\Cloud\AIPlatform\V1\GetContextRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetContext(\Google\Cloud\AIPlatform\V1\GetContextRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.MetadataService/GetContext',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\Context', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists Contexts on the MetadataStore.
     * @param \Google\Cloud\AIPlatform\V1\ListContextsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListContexts(\Google\Cloud\AIPlatform\V1\ListContextsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.MetadataService/ListContexts',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\ListContextsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a stored Context.
     * @param \Google\Cloud\AIPlatform\V1\UpdateContextRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateContext(\Google\Cloud\AIPlatform\V1\UpdateContextRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.MetadataService/UpdateContext',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\Context', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a stored Context.
     * @param \Google\Cloud\AIPlatform\V1\DeleteContextRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteContext(\Google\Cloud\AIPlatform\V1\DeleteContextRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.MetadataService/DeleteContext',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Purges Contexts.
     * @param \Google\Cloud\AIPlatform\V1\PurgeContextsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function PurgeContexts(\Google\Cloud\AIPlatform\V1\PurgeContextsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.MetadataService/PurgeContexts',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Adds a set of Artifacts and Executions to a Context. If any of the
     * Artifacts or Executions have already been added to a Context, they are
     * simply skipped.
     * @param \Google\Cloud\AIPlatform\V1\AddContextArtifactsAndExecutionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function AddContextArtifactsAndExecutions(\Google\Cloud\AIPlatform\V1\AddContextArtifactsAndExecutionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.MetadataService/AddContextArtifactsAndExecutions',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\AddContextArtifactsAndExecutionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Adds a set of Contexts as children to a parent Context. If any of the
     * child Contexts have already been added to the parent Context, they are
     * simply skipped. If this call would create a cycle or cause any Context to
     * have more than 10 parents, the request will fail with an INVALID_ARGUMENT
     * error.
     * @param \Google\Cloud\AIPlatform\V1\AddContextChildrenRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function AddContextChildren(\Google\Cloud\AIPlatform\V1\AddContextChildrenRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.MetadataService/AddContextChildren',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\AddContextChildrenResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Remove a set of children contexts from a parent Context. If any of the
     * child Contexts were NOT added to the parent Context, they are
     * simply skipped.
     * @param \Google\Cloud\AIPlatform\V1\RemoveContextChildrenRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RemoveContextChildren(\Google\Cloud\AIPlatform\V1\RemoveContextChildrenRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.MetadataService/RemoveContextChildren',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\RemoveContextChildrenResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves Artifacts and Executions within the specified Context, connected
     * by Event edges and returned as a LineageSubgraph.
     * @param \Google\Cloud\AIPlatform\V1\QueryContextLineageSubgraphRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function QueryContextLineageSubgraph(\Google\Cloud\AIPlatform\V1\QueryContextLineageSubgraphRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.MetadataService/QueryContextLineageSubgraph',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\LineageSubgraph', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates an Execution associated with a MetadataStore.
     * @param \Google\Cloud\AIPlatform\V1\CreateExecutionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateExecution(\Google\Cloud\AIPlatform\V1\CreateExecutionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.MetadataService/CreateExecution',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\Execution', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves a specific Execution.
     * @param \Google\Cloud\AIPlatform\V1\GetExecutionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetExecution(\Google\Cloud\AIPlatform\V1\GetExecutionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.MetadataService/GetExecution',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\Execution', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists Executions in the MetadataStore.
     * @param \Google\Cloud\AIPlatform\V1\ListExecutionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListExecutions(\Google\Cloud\AIPlatform\V1\ListExecutionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.MetadataService/ListExecutions',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\ListExecutionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a stored Execution.
     * @param \Google\Cloud\AIPlatform\V1\UpdateExecutionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateExecution(\Google\Cloud\AIPlatform\V1\UpdateExecutionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.MetadataService/UpdateExecution',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\Execution', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an Execution.
     * @param \Google\Cloud\AIPlatform\V1\DeleteExecutionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteExecution(\Google\Cloud\AIPlatform\V1\DeleteExecutionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.MetadataService/DeleteExecution',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Purges Executions.
     * @param \Google\Cloud\AIPlatform\V1\PurgeExecutionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function PurgeExecutions(\Google\Cloud\AIPlatform\V1\PurgeExecutionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.MetadataService/PurgeExecutions',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Adds Events to the specified Execution. An Event indicates whether an
     * Artifact was used as an input or output for an Execution. If an Event
     * already exists between the Execution and the Artifact, the Event is
     * skipped.
     * @param \Google\Cloud\AIPlatform\V1\AddExecutionEventsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function AddExecutionEvents(\Google\Cloud\AIPlatform\V1\AddExecutionEventsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.MetadataService/AddExecutionEvents',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\AddExecutionEventsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Obtains the set of input and output Artifacts for this Execution, in the
     * form of LineageSubgraph that also contains the Execution and connecting
     * Events.
     * @param \Google\Cloud\AIPlatform\V1\QueryExecutionInputsAndOutputsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function QueryExecutionInputsAndOutputs(\Google\Cloud\AIPlatform\V1\QueryExecutionInputsAndOutputsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.MetadataService/QueryExecutionInputsAndOutputs',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\LineageSubgraph', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a MetadataSchema.
     * @param \Google\Cloud\AIPlatform\V1\CreateMetadataSchemaRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateMetadataSchema(\Google\Cloud\AIPlatform\V1\CreateMetadataSchemaRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.MetadataService/CreateMetadataSchema',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\MetadataSchema', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves a specific MetadataSchema.
     * @param \Google\Cloud\AIPlatform\V1\GetMetadataSchemaRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetMetadataSchema(\Google\Cloud\AIPlatform\V1\GetMetadataSchemaRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.MetadataService/GetMetadataSchema',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\MetadataSchema', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists MetadataSchemas.
     * @param \Google\Cloud\AIPlatform\V1\ListMetadataSchemasRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListMetadataSchemas(\Google\Cloud\AIPlatform\V1\ListMetadataSchemasRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.MetadataService/ListMetadataSchemas',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\ListMetadataSchemasResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves lineage of an Artifact represented through Artifacts and
     * Executions connected by Event edges and returned as a LineageSubgraph.
     * @param \Google\Cloud\AIPlatform\V1\QueryArtifactLineageSubgraphRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function QueryArtifactLineageSubgraph(\Google\Cloud\AIPlatform\V1\QueryArtifactLineageSubgraphRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.MetadataService/QueryArtifactLineageSubgraph',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\LineageSubgraph', 'decode'],
        $metadata, $options);
    }

}
