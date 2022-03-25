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
 * Policy Tag Manager API service allows you to manage your policy tags and
 * taxonomies.
 *
 * Policy tags are used to tag BigQuery columns and apply additional access
 * control policies. A taxonomy is a hierarchical grouping of policy tags that
 * classify data along a common axis.
 */
class PolicyTagManagerGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a taxonomy in a specified project.
     *
     * The taxonomy is initially empty, that is, it doesn't contain policy tags.
     * @param \Google\Cloud\DataCatalog\V1\CreateTaxonomyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateTaxonomy(\Google\Cloud\DataCatalog\V1\CreateTaxonomyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.PolicyTagManager/CreateTaxonomy',
        $argument,
        ['\Google\Cloud\DataCatalog\V1\Taxonomy', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a taxonomy, including all policy tags in this
     * taxonomy, their associated policies, and the policy tags references from
     * BigQuery columns.
     * @param \Google\Cloud\DataCatalog\V1\DeleteTaxonomyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteTaxonomy(\Google\Cloud\DataCatalog\V1\DeleteTaxonomyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.PolicyTagManager/DeleteTaxonomy',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a taxonomy, including its display name,
     * description, and activated policy types.
     * @param \Google\Cloud\DataCatalog\V1\UpdateTaxonomyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateTaxonomy(\Google\Cloud\DataCatalog\V1\UpdateTaxonomyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.PolicyTagManager/UpdateTaxonomy',
        $argument,
        ['\Google\Cloud\DataCatalog\V1\Taxonomy', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all taxonomies in a project in a particular location that you
     * have a permission to view.
     * @param \Google\Cloud\DataCatalog\V1\ListTaxonomiesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListTaxonomies(\Google\Cloud\DataCatalog\V1\ListTaxonomiesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.PolicyTagManager/ListTaxonomies',
        $argument,
        ['\Google\Cloud\DataCatalog\V1\ListTaxonomiesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a taxonomy.
     * @param \Google\Cloud\DataCatalog\V1\GetTaxonomyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetTaxonomy(\Google\Cloud\DataCatalog\V1\GetTaxonomyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.PolicyTagManager/GetTaxonomy',
        $argument,
        ['\Google\Cloud\DataCatalog\V1\Taxonomy', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a policy tag in a taxonomy.
     * @param \Google\Cloud\DataCatalog\V1\CreatePolicyTagRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreatePolicyTag(\Google\Cloud\DataCatalog\V1\CreatePolicyTagRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.PolicyTagManager/CreatePolicyTag',
        $argument,
        ['\Google\Cloud\DataCatalog\V1\PolicyTag', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a policy tag together with the following:
     *
     * * All of its descendant policy tags, if any
     * * Policies associated with the policy tag and its descendants
     * * References from BigQuery table schema of the policy tag and its
     *   descendants
     * @param \Google\Cloud\DataCatalog\V1\DeletePolicyTagRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeletePolicyTag(\Google\Cloud\DataCatalog\V1\DeletePolicyTagRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.PolicyTagManager/DeletePolicyTag',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a policy tag, including its display
     * name, description, and parent policy tag.
     * @param \Google\Cloud\DataCatalog\V1\UpdatePolicyTagRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdatePolicyTag(\Google\Cloud\DataCatalog\V1\UpdatePolicyTagRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.PolicyTagManager/UpdatePolicyTag',
        $argument,
        ['\Google\Cloud\DataCatalog\V1\PolicyTag', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all policy tags in a taxonomy.
     * @param \Google\Cloud\DataCatalog\V1\ListPolicyTagsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListPolicyTags(\Google\Cloud\DataCatalog\V1\ListPolicyTagsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.PolicyTagManager/ListPolicyTags',
        $argument,
        ['\Google\Cloud\DataCatalog\V1\ListPolicyTagsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a policy tag.
     * @param \Google\Cloud\DataCatalog\V1\GetPolicyTagRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetPolicyTag(\Google\Cloud\DataCatalog\V1\GetPolicyTagRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.PolicyTagManager/GetPolicyTag',
        $argument,
        ['\Google\Cloud\DataCatalog\V1\PolicyTag', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the IAM policy for a policy tag or a taxonomy.
     * @param \Google\Cloud\Iam\V1\GetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetIamPolicy(\Google\Cloud\Iam\V1\GetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.PolicyTagManager/GetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Sets the IAM policy for a policy tag or a taxonomy.
     * @param \Google\Cloud\Iam\V1\SetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SetIamPolicy(\Google\Cloud\Iam\V1\SetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.PolicyTagManager/SetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns your permissions on a specified policy tag or
     * taxonomy.
     * @param \Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function TestIamPermissions(\Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.PolicyTagManager/TestIamPermissions',
        $argument,
        ['\Google\Cloud\Iam\V1\TestIamPermissionsResponse', 'decode'],
        $metadata, $options);
    }

}
