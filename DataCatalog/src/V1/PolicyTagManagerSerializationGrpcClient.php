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
namespace Google\Cloud\DataCatalog\V1;

/**
 * Policy Tag Manager Serialization API service allows you to manipulate
 * your policy tags and taxonomies in a serialized format.
 *
 * Taxonomy is a hierarchical group of policy tags.
 */
class PolicyTagManagerSerializationGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Replaces (updates) a taxonomy and all its policy tags.
     *
     * The taxonomy and its entire hierarchy of policy tags must be
     * represented literally by `SerializedTaxonomy` and the nested
     * `SerializedPolicyTag` messages.
     *
     * This operation automatically does the following:
     *
     * - Deletes the existing policy tags that are missing from the
     *   `SerializedPolicyTag`.
     * - Creates policy tags that don't have resource names. They are considered
     *   new.
     * - Updates policy tags with valid resources names accordingly.
     * @param \Google\Cloud\DataCatalog\V1\ReplaceTaxonomyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ReplaceTaxonomy(\Google\Cloud\DataCatalog\V1\ReplaceTaxonomyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.PolicyTagManagerSerialization/ReplaceTaxonomy',
        $argument,
        ['\Google\Cloud\DataCatalog\V1\Taxonomy', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates new taxonomies (including their policy tags) in a given project
     * by importing from inlined or cross-regional sources.
     *
     * For a cross-regional source, new taxonomies are created by copying
     * from a source in another region.
     *
     * For an inlined source, taxonomies and policy tags are created in bulk using
     * nested protocol buffer structures.
     * @param \Google\Cloud\DataCatalog\V1\ImportTaxonomiesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ImportTaxonomies(\Google\Cloud\DataCatalog\V1\ImportTaxonomiesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.PolicyTagManagerSerialization/ImportTaxonomies',
        $argument,
        ['\Google\Cloud\DataCatalog\V1\ImportTaxonomiesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Exports taxonomies in the requested type and returns them,
     * including their policy tags. The requested taxonomies must belong to the
     * same project.
     *
     * This method generates `SerializedTaxonomy` protocol buffers with nested
     * policy tags that can be used as input for `ImportTaxonomies` calls.
     * @param \Google\Cloud\DataCatalog\V1\ExportTaxonomiesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ExportTaxonomies(\Google\Cloud\DataCatalog\V1\ExportTaxonomiesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.PolicyTagManagerSerialization/ExportTaxonomies',
        $argument,
        ['\Google\Cloud\DataCatalog\V1\ExportTaxonomiesResponse', 'decode'],
        $metadata, $options);
    }

}
