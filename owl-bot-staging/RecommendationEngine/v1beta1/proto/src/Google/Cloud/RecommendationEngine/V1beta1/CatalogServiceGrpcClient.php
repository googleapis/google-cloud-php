<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2020 Google LLC
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
namespace Google\Cloud\RecommendationEngine\V1beta1;

/**
 * Service for ingesting catalog information of the customer's website.
 */
class CatalogServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a catalog item.
     * @param \Google\Cloud\RecommendationEngine\V1beta1\CreateCatalogItemRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateCatalogItem(\Google\Cloud\RecommendationEngine\V1beta1\CreateCatalogItemRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.recommendationengine.v1beta1.CatalogService/CreateCatalogItem',
        $argument,
        ['\Google\Cloud\RecommendationEngine\V1beta1\CatalogItem', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a specific catalog item.
     * @param \Google\Cloud\RecommendationEngine\V1beta1\GetCatalogItemRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCatalogItem(\Google\Cloud\RecommendationEngine\V1beta1\GetCatalogItemRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.recommendationengine.v1beta1.CatalogService/GetCatalogItem',
        $argument,
        ['\Google\Cloud\RecommendationEngine\V1beta1\CatalogItem', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a list of catalog items.
     * @param \Google\Cloud\RecommendationEngine\V1beta1\ListCatalogItemsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListCatalogItems(\Google\Cloud\RecommendationEngine\V1beta1\ListCatalogItemsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.recommendationengine.v1beta1.CatalogService/ListCatalogItems',
        $argument,
        ['\Google\Cloud\RecommendationEngine\V1beta1\ListCatalogItemsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a catalog item. Partial updating is supported. Non-existing
     * items will be created.
     * @param \Google\Cloud\RecommendationEngine\V1beta1\UpdateCatalogItemRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateCatalogItem(\Google\Cloud\RecommendationEngine\V1beta1\UpdateCatalogItemRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.recommendationengine.v1beta1.CatalogService/UpdateCatalogItem',
        $argument,
        ['\Google\Cloud\RecommendationEngine\V1beta1\CatalogItem', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a catalog item.
     * @param \Google\Cloud\RecommendationEngine\V1beta1\DeleteCatalogItemRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteCatalogItem(\Google\Cloud\RecommendationEngine\V1beta1\DeleteCatalogItemRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.recommendationengine.v1beta1.CatalogService/DeleteCatalogItem',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Bulk import of multiple catalog items. Request processing may be
     * synchronous. No partial updating supported. Non-existing items will be
     * created.
     *
     * Operation.response is of type ImportResponse. Note that it is
     * possible for a subset of the items to be successfully updated.
     * @param \Google\Cloud\RecommendationEngine\V1beta1\ImportCatalogItemsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ImportCatalogItems(\Google\Cloud\RecommendationEngine\V1beta1\ImportCatalogItemsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.recommendationengine.v1beta1.CatalogService/ImportCatalogItems',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
