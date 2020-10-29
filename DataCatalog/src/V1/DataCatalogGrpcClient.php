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
namespace Google\Cloud\DataCatalog\V1;

/**
 * Data Catalog API service allows clients to discover, understand, and manage
 * their data.
 */
class DataCatalogGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Searches Data Catalog for multiple resources like entries, tags that
     * match a query.
     *
     * This is a custom method
     * (https://cloud.google.com/apis/design/custom_methods) and does not return
     * the complete resource, only the resource identifier and high level
     * fields. Clients can subsequentally call `Get` methods.
     *
     * Note that Data Catalog search queries do not guarantee full recall. Query
     * results that match your query may not be returned, even in subsequent
     * result pages. Also note that results returned (and not returned) can vary
     * across repeated search queries.
     *
     * See [Data Catalog Search
     * Syntax](https://cloud.google.com/data-catalog/docs/how-to/search-reference)
     * for more information.
     * @param \Google\Cloud\DataCatalog\V1\SearchCatalogRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SearchCatalog(\Google\Cloud\DataCatalog\V1\SearchCatalogRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.DataCatalog/SearchCatalog',
        $argument,
        ['\Google\Cloud\DataCatalog\V1\SearchCatalogResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates an EntryGroup.
     *
     * An entry group contains logically related entries together with Cloud
     * Identity and Access Management policies that specify the users who can
     * create, edit, and view entries within the entry group.
     *
     * Data Catalog automatically creates an entry group for BigQuery entries
     * ("@bigquery") and Pub/Sub topics ("@pubsub"). Users create their own entry
     * group to contain Cloud Storage fileset entries or custom type entries,
     * and the IAM policies associated with those entries. Entry groups, like
     * entries, can be searched.
     *
     * A maximum of 10,000 entry groups may be created per organization across all
     * locations.
     *
     * Users should enable the Data Catalog API in the project identified by
     * the `parent` parameter (see [Data Catalog Resource Project]
     * (https://cloud.google.com/data-catalog/docs/concepts/resource-project) for
     * more information).
     * @param \Google\Cloud\DataCatalog\V1\CreateEntryGroupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateEntryGroup(\Google\Cloud\DataCatalog\V1\CreateEntryGroupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.DataCatalog/CreateEntryGroup',
        $argument,
        ['\Google\Cloud\DataCatalog\V1\EntryGroup', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets an EntryGroup.
     * @param \Google\Cloud\DataCatalog\V1\GetEntryGroupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetEntryGroup(\Google\Cloud\DataCatalog\V1\GetEntryGroupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.DataCatalog/GetEntryGroup',
        $argument,
        ['\Google\Cloud\DataCatalog\V1\EntryGroup', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an EntryGroup. The user should enable the Data Catalog API in the
     * project identified by the `entry_group.name` parameter (see [Data Catalog
     * Resource Project]
     * (https://cloud.google.com/data-catalog/docs/concepts/resource-project) for
     * more information).
     * @param \Google\Cloud\DataCatalog\V1\UpdateEntryGroupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateEntryGroup(\Google\Cloud\DataCatalog\V1\UpdateEntryGroupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.DataCatalog/UpdateEntryGroup',
        $argument,
        ['\Google\Cloud\DataCatalog\V1\EntryGroup', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an EntryGroup. Only entry groups that do not contain entries can be
     * deleted. Users should enable the Data Catalog API in the project
     * identified by the `name` parameter (see [Data Catalog Resource Project]
     * (https://cloud.google.com/data-catalog/docs/concepts/resource-project) for
     * more information).
     * @param \Google\Cloud\DataCatalog\V1\DeleteEntryGroupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteEntryGroup(\Google\Cloud\DataCatalog\V1\DeleteEntryGroupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.DataCatalog/DeleteEntryGroup',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists entry groups.
     * @param \Google\Cloud\DataCatalog\V1\ListEntryGroupsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListEntryGroups(\Google\Cloud\DataCatalog\V1\ListEntryGroupsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.DataCatalog/ListEntryGroups',
        $argument,
        ['\Google\Cloud\DataCatalog\V1\ListEntryGroupsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates an entry. Only entries of 'FILESET' type or user-specified type can
     * be created.
     *
     * Users should enable the Data Catalog API in the project identified by
     * the `parent` parameter (see [Data Catalog Resource Project]
     * (https://cloud.google.com/data-catalog/docs/concepts/resource-project) for
     * more information).
     *
     * A maximum of 100,000 entries may be created per entry group.
     * @param \Google\Cloud\DataCatalog\V1\CreateEntryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateEntry(\Google\Cloud\DataCatalog\V1\CreateEntryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.DataCatalog/CreateEntry',
        $argument,
        ['\Google\Cloud\DataCatalog\V1\Entry', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an existing entry.
     * Users should enable the Data Catalog API in the project identified by
     * the `entry.name` parameter (see [Data Catalog Resource Project]
     * (https://cloud.google.com/data-catalog/docs/concepts/resource-project) for
     * more information).
     * @param \Google\Cloud\DataCatalog\V1\UpdateEntryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateEntry(\Google\Cloud\DataCatalog\V1\UpdateEntryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.DataCatalog/UpdateEntry',
        $argument,
        ['\Google\Cloud\DataCatalog\V1\Entry', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an existing entry. Only entries created through
     * [CreateEntry][google.cloud.datacatalog.v1.DataCatalog.CreateEntry]
     * method can be deleted.
     * Users should enable the Data Catalog API in the project identified by
     * the `name` parameter (see [Data Catalog Resource Project]
     * (https://cloud.google.com/data-catalog/docs/concepts/resource-project) for
     * more information).
     * @param \Google\Cloud\DataCatalog\V1\DeleteEntryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteEntry(\Google\Cloud\DataCatalog\V1\DeleteEntryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.DataCatalog/DeleteEntry',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets an entry.
     * @param \Google\Cloud\DataCatalog\V1\GetEntryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetEntry(\Google\Cloud\DataCatalog\V1\GetEntryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.DataCatalog/GetEntry',
        $argument,
        ['\Google\Cloud\DataCatalog\V1\Entry', 'decode'],
        $metadata, $options);
    }

    /**
     * Get an entry by target resource name. This method allows clients to use
     * the resource name from the source Google Cloud Platform service to get the
     * Data Catalog Entry.
     * @param \Google\Cloud\DataCatalog\V1\LookupEntryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function LookupEntry(\Google\Cloud\DataCatalog\V1\LookupEntryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.DataCatalog/LookupEntry',
        $argument,
        ['\Google\Cloud\DataCatalog\V1\Entry', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists entries.
     * @param \Google\Cloud\DataCatalog\V1\ListEntriesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListEntries(\Google\Cloud\DataCatalog\V1\ListEntriesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.DataCatalog/ListEntries',
        $argument,
        ['\Google\Cloud\DataCatalog\V1\ListEntriesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a tag template. The user should enable the Data Catalog API in
     * the project identified by the `parent` parameter (see [Data Catalog
     * Resource
     * Project](https://cloud.google.com/data-catalog/docs/concepts/resource-project)
     * for more information).
     * @param \Google\Cloud\DataCatalog\V1\CreateTagTemplateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateTagTemplate(\Google\Cloud\DataCatalog\V1\CreateTagTemplateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.DataCatalog/CreateTagTemplate',
        $argument,
        ['\Google\Cloud\DataCatalog\V1\TagTemplate', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a tag template.
     * @param \Google\Cloud\DataCatalog\V1\GetTagTemplateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetTagTemplate(\Google\Cloud\DataCatalog\V1\GetTagTemplateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.DataCatalog/GetTagTemplate',
        $argument,
        ['\Google\Cloud\DataCatalog\V1\TagTemplate', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a tag template. This method cannot be used to update the fields of
     * a template. The tag template fields are represented as separate resources
     * and should be updated using their own create/update/delete methods.
     * Users should enable the Data Catalog API in the project identified by
     * the `tag_template.name` parameter (see [Data Catalog Resource Project]
     * (https://cloud.google.com/data-catalog/docs/concepts/resource-project) for
     * more information).
     * @param \Google\Cloud\DataCatalog\V1\UpdateTagTemplateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateTagTemplate(\Google\Cloud\DataCatalog\V1\UpdateTagTemplateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.DataCatalog/UpdateTagTemplate',
        $argument,
        ['\Google\Cloud\DataCatalog\V1\TagTemplate', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a tag template and all tags using the template.
     * Users should enable the Data Catalog API in the project identified by
     * the `name` parameter (see [Data Catalog Resource Project]
     * (https://cloud.google.com/data-catalog/docs/concepts/resource-project) for
     * more information).
     * @param \Google\Cloud\DataCatalog\V1\DeleteTagTemplateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteTagTemplate(\Google\Cloud\DataCatalog\V1\DeleteTagTemplateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.DataCatalog/DeleteTagTemplate',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a field in a tag template. The user should enable the Data Catalog
     * API in the project identified by the `parent` parameter (see
     * [Data Catalog Resource
     * Project](https://cloud.google.com/data-catalog/docs/concepts/resource-project)
     * for more information).
     * @param \Google\Cloud\DataCatalog\V1\CreateTagTemplateFieldRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateTagTemplateField(\Google\Cloud\DataCatalog\V1\CreateTagTemplateFieldRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.DataCatalog/CreateTagTemplateField',
        $argument,
        ['\Google\Cloud\DataCatalog\V1\TagTemplateField', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a field in a tag template. This method cannot be used to update the
     * field type. Users should enable the Data Catalog API in the project
     * identified by the `name` parameter (see [Data Catalog Resource Project]
     * (https://cloud.google.com/data-catalog/docs/concepts/resource-project) for
     * more information).
     * @param \Google\Cloud\DataCatalog\V1\UpdateTagTemplateFieldRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateTagTemplateField(\Google\Cloud\DataCatalog\V1\UpdateTagTemplateFieldRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.DataCatalog/UpdateTagTemplateField',
        $argument,
        ['\Google\Cloud\DataCatalog\V1\TagTemplateField', 'decode'],
        $metadata, $options);
    }

    /**
     * Renames a field in a tag template. The user should enable the Data Catalog
     * API in the project identified by the `name` parameter (see [Data Catalog
     * Resource
     * Project](https://cloud.google.com/data-catalog/docs/concepts/resource-project)
     * for more information).
     * @param \Google\Cloud\DataCatalog\V1\RenameTagTemplateFieldRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RenameTagTemplateField(\Google\Cloud\DataCatalog\V1\RenameTagTemplateFieldRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.DataCatalog/RenameTagTemplateField',
        $argument,
        ['\Google\Cloud\DataCatalog\V1\TagTemplateField', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a field in a tag template and all uses of that field.
     * Users should enable the Data Catalog API in the project identified by
     * the `name` parameter (see [Data Catalog Resource Project]
     * (https://cloud.google.com/data-catalog/docs/concepts/resource-project) for
     * more information).
     * @param \Google\Cloud\DataCatalog\V1\DeleteTagTemplateFieldRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteTagTemplateField(\Google\Cloud\DataCatalog\V1\DeleteTagTemplateFieldRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.DataCatalog/DeleteTagTemplateField',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a tag on an [Entry][google.cloud.datacatalog.v1.Entry].
     * Note: The project identified by the `parent` parameter for the
     * [tag](https://cloud.google.com/data-catalog/docs/reference/rest/v1/projects.locations.entryGroups.entries.tags/create#path-parameters)
     * and the
     * [tag
     * template](https://cloud.google.com/data-catalog/docs/reference/rest/v1/projects.locations.tagTemplates/create#path-parameters)
     * used to create the tag must be from the same organization.
     * @param \Google\Cloud\DataCatalog\V1\CreateTagRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateTag(\Google\Cloud\DataCatalog\V1\CreateTagRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.DataCatalog/CreateTag',
        $argument,
        ['\Google\Cloud\DataCatalog\V1\Tag', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an existing tag.
     * @param \Google\Cloud\DataCatalog\V1\UpdateTagRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateTag(\Google\Cloud\DataCatalog\V1\UpdateTagRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.DataCatalog/UpdateTag',
        $argument,
        ['\Google\Cloud\DataCatalog\V1\Tag', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a tag.
     * @param \Google\Cloud\DataCatalog\V1\DeleteTagRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteTag(\Google\Cloud\DataCatalog\V1\DeleteTagRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.DataCatalog/DeleteTag',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the tags on an [Entry][google.cloud.datacatalog.v1.Entry].
     * @param \Google\Cloud\DataCatalog\V1\ListTagsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListTags(\Google\Cloud\DataCatalog\V1\ListTagsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.DataCatalog/ListTags',
        $argument,
        ['\Google\Cloud\DataCatalog\V1\ListTagsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Sets the access control policy for a resource. Replaces any existing
     * policy.
     * Supported resources are:
     *   - Tag templates.
     *   - Entries.
     *   - Entry groups.
     * Note, this method cannot be used to manage policies for BigQuery, Pub/Sub
     * and any external Google Cloud Platform resources synced to Data Catalog.
     *
     * Callers must have following Google IAM permission
     *   - `datacatalog.tagTemplates.setIamPolicy` to set policies on tag
     *     templates.
     *   - `datacatalog.entries.setIamPolicy` to set policies on entries.
     *   - `datacatalog.entryGroups.setIamPolicy` to set policies on entry groups.
     * @param \Google\Cloud\Iam\V1\SetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SetIamPolicy(\Google\Cloud\Iam\V1\SetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.DataCatalog/SetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the access control policy for a resource. A `NOT_FOUND` error
     * is returned if the resource does not exist. An empty policy is returned
     * if the resource exists but does not have a policy set on it.
     *
     * Supported resources are:
     *   - Tag templates.
     *   - Entries.
     *   - Entry groups.
     * Note, this method cannot be used to manage policies for BigQuery, Pub/Sub
     * and any external Google Cloud Platform resources synced to Data Catalog.
     *
     * Callers must have following Google IAM permission
     *   - `datacatalog.tagTemplates.getIamPolicy` to get policies on tag
     *     templates.
     *   - `datacatalog.entries.getIamPolicy` to get policies on entries.
     *   - `datacatalog.entryGroups.getIamPolicy` to get policies on entry groups.
     * @param \Google\Cloud\Iam\V1\GetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetIamPolicy(\Google\Cloud\Iam\V1\GetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.DataCatalog/GetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the caller's permissions on a resource.
     * If the resource does not exist, an empty set of permissions is returned
     * (We don't return a `NOT_FOUND` error).
     *
     * Supported resources are:
     *   - Tag templates.
     *   - Entries.
     *   - Entry groups.
     * Note, this method cannot be used to manage policies for BigQuery, Pub/Sub
     * and any external Google Cloud Platform resources synced to Data Catalog.
     *
     * A caller is not required to have Google IAM permission to make this
     * request.
     * @param \Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function TestIamPermissions(\Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.DataCatalog/TestIamPermissions',
        $argument,
        ['\Google\Cloud\Iam\V1\TestIamPermissionsResponse', 'decode'],
        $metadata, $options);
    }

}
