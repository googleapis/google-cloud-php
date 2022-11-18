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
namespace Google\Cloud\Retail\V2;

/**
 * Service for managing catalog configuration.
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
     * Lists all the [Catalog][google.cloud.retail.v2.Catalog]s associated with
     * the project.
     * @param \Google\Cloud\Retail\V2\ListCatalogsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListCatalogs(\Google\Cloud\Retail\V2\ListCatalogsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.CatalogService/ListCatalogs',
        $argument,
        ['\Google\Cloud\Retail\V2\ListCatalogsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the [Catalog][google.cloud.retail.v2.Catalog]s.
     * @param \Google\Cloud\Retail\V2\UpdateCatalogRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateCatalog(\Google\Cloud\Retail\V2\UpdateCatalogRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.CatalogService/UpdateCatalog',
        $argument,
        ['\Google\Cloud\Retail\V2\Catalog', 'decode'],
        $metadata, $options);
    }

    /**
     * Set a specified branch id as default branch. API methods such as
     * [SearchService.Search][google.cloud.retail.v2.SearchService.Search],
     * [ProductService.GetProduct][google.cloud.retail.v2.ProductService.GetProduct],
     * [ProductService.ListProducts][google.cloud.retail.v2.ProductService.ListProducts]
     * will treat requests using "default_branch" to the actual branch id set as
     * default.
     *
     * For example, if `projects/&#42;/locations/&#42;/catalogs/&#42;/branches/1` is set as
     * default, setting
     * [SearchRequest.branch][google.cloud.retail.v2.SearchRequest.branch] to
     * `projects/&#42;/locations/&#42;/catalogs/&#42;/branches/default_branch` is equivalent
     * to setting
     * [SearchRequest.branch][google.cloud.retail.v2.SearchRequest.branch] to
     * `projects/&#42;/locations/&#42;/catalogs/&#42;/branches/1`.
     *
     * Using multiple branches can be useful when developers would like
     * to have a staging branch to test and verify for future usage. When it
     * becomes ready, developers switch on the staging branch using this API while
     * keeping using `projects/&#42;/locations/&#42;/catalogs/&#42;/branches/default_branch`
     * as [SearchRequest.branch][google.cloud.retail.v2.SearchRequest.branch] to
     * route the traffic to this staging branch.
     *
     * CAUTION: If you have live predict/search traffic, switching the default
     * branch could potentially cause outages if the ID space of the new branch is
     * very different from the old one.
     *
     * More specifically:
     *
     * * PredictionService will only return product IDs from branch {newBranch}.
     * * SearchService will only return product IDs from branch {newBranch}
     *   (if branch is not explicitly set).
     * * UserEventService will only join events with products from branch
     *   {newBranch}.
     * @param \Google\Cloud\Retail\V2\SetDefaultBranchRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SetDefaultBranch(\Google\Cloud\Retail\V2\SetDefaultBranchRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.CatalogService/SetDefaultBranch',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Get which branch is currently default branch set by
     * [CatalogService.SetDefaultBranch][google.cloud.retail.v2.CatalogService.SetDefaultBranch]
     * method under a specified parent catalog.
     * @param \Google\Cloud\Retail\V2\GetDefaultBranchRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetDefaultBranch(\Google\Cloud\Retail\V2\GetDefaultBranchRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.CatalogService/GetDefaultBranch',
        $argument,
        ['\Google\Cloud\Retail\V2\GetDefaultBranchResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a [CompletionConfig][google.cloud.retail.v2.CompletionConfig].
     * @param \Google\Cloud\Retail\V2\GetCompletionConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCompletionConfig(\Google\Cloud\Retail\V2\GetCompletionConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.CatalogService/GetCompletionConfig',
        $argument,
        ['\Google\Cloud\Retail\V2\CompletionConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the [CompletionConfig][google.cloud.retail.v2.CompletionConfig]s.
     * @param \Google\Cloud\Retail\V2\UpdateCompletionConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateCompletionConfig(\Google\Cloud\Retail\V2\UpdateCompletionConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.CatalogService/UpdateCompletionConfig',
        $argument,
        ['\Google\Cloud\Retail\V2\CompletionConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets an [AttributesConfig][google.cloud.retail.v2.AttributesConfig].
     * @param \Google\Cloud\Retail\V2\GetAttributesConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAttributesConfig(\Google\Cloud\Retail\V2\GetAttributesConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.CatalogService/GetAttributesConfig',
        $argument,
        ['\Google\Cloud\Retail\V2\AttributesConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the [AttributesConfig][google.cloud.retail.v2.AttributesConfig].
     *
     * The catalog attributes in the request will be updated in the catalog, or
     * inserted if they do not exist. Existing catalog attributes not included in
     * the request will remain unchanged. Attributes that are assigned to
     * products, but do not exist at the catalog level, are always included in the
     * response. The product attribute is assigned default values for missing
     * catalog attribute fields, e.g., searchable and dynamic facetable options.
     * @param \Google\Cloud\Retail\V2\UpdateAttributesConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateAttributesConfig(\Google\Cloud\Retail\V2\UpdateAttributesConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.CatalogService/UpdateAttributesConfig',
        $argument,
        ['\Google\Cloud\Retail\V2\AttributesConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Adds the specified
     * [CatalogAttribute][google.cloud.retail.v2.CatalogAttribute] to the
     * [AttributesConfig][google.cloud.retail.v2.AttributesConfig].
     *
     * If the [CatalogAttribute][google.cloud.retail.v2.CatalogAttribute] to add
     * already exists, an ALREADY_EXISTS error is returned.
     * @param \Google\Cloud\Retail\V2\AddCatalogAttributeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function AddCatalogAttribute(\Google\Cloud\Retail\V2\AddCatalogAttributeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.CatalogService/AddCatalogAttribute',
        $argument,
        ['\Google\Cloud\Retail\V2\AttributesConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Removes the specified
     * [CatalogAttribute][google.cloud.retail.v2.CatalogAttribute] from the
     * [AttributesConfig][google.cloud.retail.v2.AttributesConfig].
     *
     * If the [CatalogAttribute][google.cloud.retail.v2.CatalogAttribute] to
     * remove does not exist, a NOT_FOUND error is returned.
     * @param \Google\Cloud\Retail\V2\RemoveCatalogAttributeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RemoveCatalogAttribute(\Google\Cloud\Retail\V2\RemoveCatalogAttributeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.CatalogService/RemoveCatalogAttribute',
        $argument,
        ['\Google\Cloud\Retail\V2\AttributesConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Replaces the specified
     * [CatalogAttribute][google.cloud.retail.v2.CatalogAttribute] in the
     * [AttributesConfig][google.cloud.retail.v2.AttributesConfig] by updating the
     * catalog attribute with the same
     * [CatalogAttribute.key][google.cloud.retail.v2.CatalogAttribute.key].
     *
     * If the [CatalogAttribute][google.cloud.retail.v2.CatalogAttribute] to
     * replace does not exist, a NOT_FOUND error is returned.
     * @param \Google\Cloud\Retail\V2\ReplaceCatalogAttributeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ReplaceCatalogAttribute(\Google\Cloud\Retail\V2\ReplaceCatalogAttributeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.CatalogService/ReplaceCatalogAttribute',
        $argument,
        ['\Google\Cloud\Retail\V2\AttributesConfig', 'decode'],
        $metadata, $options);
    }

}
