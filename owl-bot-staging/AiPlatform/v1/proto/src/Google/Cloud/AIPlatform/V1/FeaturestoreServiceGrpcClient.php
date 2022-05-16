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
 * The service that handles CRUD and List for resources for Featurestore.
 */
class FeaturestoreServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a new Featurestore in a given project and location.
     * @param \Google\Cloud\AIPlatform\V1\CreateFeaturestoreRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateFeaturestore(\Google\Cloud\AIPlatform\V1\CreateFeaturestoreRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.FeaturestoreService/CreateFeaturestore',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single Featurestore.
     * @param \Google\Cloud\AIPlatform\V1\GetFeaturestoreRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetFeaturestore(\Google\Cloud\AIPlatform\V1\GetFeaturestoreRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.FeaturestoreService/GetFeaturestore',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\Featurestore', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists Featurestores in a given project and location.
     * @param \Google\Cloud\AIPlatform\V1\ListFeaturestoresRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListFeaturestores(\Google\Cloud\AIPlatform\V1\ListFeaturestoresRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.FeaturestoreService/ListFeaturestores',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\ListFeaturestoresResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the parameters of a single Featurestore.
     * @param \Google\Cloud\AIPlatform\V1\UpdateFeaturestoreRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateFeaturestore(\Google\Cloud\AIPlatform\V1\UpdateFeaturestoreRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.FeaturestoreService/UpdateFeaturestore',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single Featurestore. The Featurestore must not contain any
     * EntityTypes or `force` must be set to true for the request to succeed.
     * @param \Google\Cloud\AIPlatform\V1\DeleteFeaturestoreRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteFeaturestore(\Google\Cloud\AIPlatform\V1\DeleteFeaturestoreRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.FeaturestoreService/DeleteFeaturestore',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new EntityType in a given Featurestore.
     * @param \Google\Cloud\AIPlatform\V1\CreateEntityTypeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateEntityType(\Google\Cloud\AIPlatform\V1\CreateEntityTypeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.FeaturestoreService/CreateEntityType',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single EntityType.
     * @param \Google\Cloud\AIPlatform\V1\GetEntityTypeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetEntityType(\Google\Cloud\AIPlatform\V1\GetEntityTypeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.FeaturestoreService/GetEntityType',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\EntityType', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists EntityTypes in a given Featurestore.
     * @param \Google\Cloud\AIPlatform\V1\ListEntityTypesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListEntityTypes(\Google\Cloud\AIPlatform\V1\ListEntityTypesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.FeaturestoreService/ListEntityTypes',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\ListEntityTypesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the parameters of a single EntityType.
     * @param \Google\Cloud\AIPlatform\V1\UpdateEntityTypeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateEntityType(\Google\Cloud\AIPlatform\V1\UpdateEntityTypeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.FeaturestoreService/UpdateEntityType',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\EntityType', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single EntityType. The EntityType must not have any Features
     * or `force` must be set to true for the request to succeed.
     * @param \Google\Cloud\AIPlatform\V1\DeleteEntityTypeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteEntityType(\Google\Cloud\AIPlatform\V1\DeleteEntityTypeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.FeaturestoreService/DeleteEntityType',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new Feature in a given EntityType.
     * @param \Google\Cloud\AIPlatform\V1\CreateFeatureRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateFeature(\Google\Cloud\AIPlatform\V1\CreateFeatureRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.FeaturestoreService/CreateFeature',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a batch of Features in a given EntityType.
     * @param \Google\Cloud\AIPlatform\V1\BatchCreateFeaturesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BatchCreateFeatures(\Google\Cloud\AIPlatform\V1\BatchCreateFeaturesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.FeaturestoreService/BatchCreateFeatures',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single Feature.
     * @param \Google\Cloud\AIPlatform\V1\GetFeatureRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetFeature(\Google\Cloud\AIPlatform\V1\GetFeatureRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.FeaturestoreService/GetFeature',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\Feature', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists Features in a given EntityType.
     * @param \Google\Cloud\AIPlatform\V1\ListFeaturesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListFeatures(\Google\Cloud\AIPlatform\V1\ListFeaturesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.FeaturestoreService/ListFeatures',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\ListFeaturesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the parameters of a single Feature.
     * @param \Google\Cloud\AIPlatform\V1\UpdateFeatureRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateFeature(\Google\Cloud\AIPlatform\V1\UpdateFeatureRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.FeaturestoreService/UpdateFeature',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\Feature', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single Feature.
     * @param \Google\Cloud\AIPlatform\V1\DeleteFeatureRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteFeature(\Google\Cloud\AIPlatform\V1\DeleteFeatureRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.FeaturestoreService/DeleteFeature',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Imports Feature values into the Featurestore from a source storage.
     *
     * The progress of the import is tracked by the returned operation. The
     * imported features are guaranteed to be visible to subsequent read
     * operations after the operation is marked as successfully done.
     *
     * If an import operation fails, the Feature values returned from
     * reads and exports may be inconsistent. If consistency is
     * required, the caller must retry the same import request again and wait till
     * the new operation returned is marked as successfully done.
     *
     * There are also scenarios where the caller can cause inconsistency.
     *
     *  - Source data for import contains multiple distinct Feature values for
     *    the same entity ID and timestamp.
     *  - Source is modified during an import. This includes adding, updating, or
     *  removing source data and/or metadata. Examples of updating metadata
     *  include but are not limited to changing storage location, storage class,
     *  or retention policy.
     *  - Online serving cluster is under-provisioned.
     * @param \Google\Cloud\AIPlatform\V1\ImportFeatureValuesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ImportFeatureValues(\Google\Cloud\AIPlatform\V1\ImportFeatureValuesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.FeaturestoreService/ImportFeatureValues',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Batch reads Feature values from a Featurestore.
     *
     * This API enables batch reading Feature values, where each read
     * instance in the batch may read Feature values of entities from one or
     * more EntityTypes. Point-in-time correctness is guaranteed for Feature
     * values of each read instance as of each instance's read timestamp.
     * @param \Google\Cloud\AIPlatform\V1\BatchReadFeatureValuesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BatchReadFeatureValues(\Google\Cloud\AIPlatform\V1\BatchReadFeatureValuesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.FeaturestoreService/BatchReadFeatureValues',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Exports Feature values from all the entities of a target EntityType.
     * @param \Google\Cloud\AIPlatform\V1\ExportFeatureValuesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ExportFeatureValues(\Google\Cloud\AIPlatform\V1\ExportFeatureValuesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.FeaturestoreService/ExportFeatureValues',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Searches Features matching a query in a given project.
     * @param \Google\Cloud\AIPlatform\V1\SearchFeaturesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SearchFeatures(\Google\Cloud\AIPlatform\V1\SearchFeaturesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.FeaturestoreService/SearchFeatures',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\SearchFeaturesResponse', 'decode'],
        $metadata, $options);
    }

}
