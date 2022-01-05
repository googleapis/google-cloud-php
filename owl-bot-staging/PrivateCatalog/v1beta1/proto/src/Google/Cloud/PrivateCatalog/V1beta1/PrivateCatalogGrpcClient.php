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
namespace Google\Cloud\PrivateCatalog\V1beta1;

/**
 * `PrivateCatalog` allows catalog consumers to retrieve `Catalog`, `Product`
 * and `Version` resources under a target resource context.
 *
 * `Catalog` is computed based on the [Association][]s linked to the target
 * resource and its ancestors. Each association's
 * [google.cloud.privatecatalogproducer.v1beta.Catalog][] is transformed into a
 * `Catalog`. If multiple associations have the same parent
 * [google.cloud.privatecatalogproducer.v1beta.Catalog][], they are
 * de-duplicated into one `Catalog`. Users must have
 * `cloudprivatecatalog.catalogTargets.get` IAM permission on the resource
 * context in order to access catalogs. `Catalog` contains the resource name and
 * a subset of data of the original
 * [google.cloud.privatecatalogproducer.v1beta.Catalog][].
 *
 * `Product` is child resource of the catalog. A `Product` contains the resource
 * name and a subset of the data of the original
 * [google.cloud.privatecatalogproducer.v1beta.Product][].
 *
 * `Version` is child resource of the product. A `Version` contains the resource
 * name and a subset of the data of the original
 * [google.cloud.privatecatalogproducer.v1beta.Version][].
 */
class PrivateCatalogGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Search [Catalog][google.cloud.privatecatalog.v1beta1.Catalog] resources that consumers have access to, within the
     * scope of the consumer cloud resource hierarchy context.
     * @param \Google\Cloud\PrivateCatalog\V1beta1\SearchCatalogsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SearchCatalogs(\Google\Cloud\PrivateCatalog\V1beta1\SearchCatalogsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.privatecatalog.v1beta1.PrivateCatalog/SearchCatalogs',
        $argument,
        ['\Google\Cloud\PrivateCatalog\V1beta1\SearchCatalogsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Search [Product][google.cloud.privatecatalog.v1beta1.Product] resources that consumers have access to, within the
     * scope of the consumer cloud resource hierarchy context.
     * @param \Google\Cloud\PrivateCatalog\V1beta1\SearchProductsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SearchProducts(\Google\Cloud\PrivateCatalog\V1beta1\SearchProductsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.privatecatalog.v1beta1.PrivateCatalog/SearchProducts',
        $argument,
        ['\Google\Cloud\PrivateCatalog\V1beta1\SearchProductsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Search [Version][google.cloud.privatecatalog.v1beta1.Version] resources that consumers have access to, within the
     * scope of the consumer cloud resource hierarchy context.
     * @param \Google\Cloud\PrivateCatalog\V1beta1\SearchVersionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SearchVersions(\Google\Cloud\PrivateCatalog\V1beta1\SearchVersionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.privatecatalog.v1beta1.PrivateCatalog/SearchVersions',
        $argument,
        ['\Google\Cloud\PrivateCatalog\V1beta1\SearchVersionsResponse', 'decode'],
        $metadata, $options);
    }

}
