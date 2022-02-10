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
 * Data Catalog API service allows you to discover, understand, and manage
 * your data.
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
     * Searches Data Catalog for multiple resources like entries and tags that
     * match a query.
     *
     * This is a [Custom Method]
     * (https://cloud.google.com/apis/design/custom_methods) that doesn't return
     * all information on a resource, only its ID and high level fields. To get
     * more information, you can subsequently call specific get methods.
     *
     * Note: Data Catalog search queries don't guarantee full recall. Results
     * that match your query might not be returned, even in subsequent
     * result pages. Additionally, returned (and not returned) results can vary
     * if you repeat search queries.
     *
     * For more information, see [Data Catalog search syntax]
     * (https://cloud.google.com/data-catalog/docs/how-to/search-reference).
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
     * Creates an entry group.
     *
     * An entry group contains logically related entries together with [Cloud
     * Identity and Access Management](https://cloud.google.com/data-catalog/docs/concepts/iam) policies.
     * These policies specify users who can create, edit, and view entries
     * within entry groups.
     *
     * Data Catalog automatically creates entry groups with names that start with
     * the `@` symbol for the following resources:
     *
     * * BigQuery entries (`@bigquery`)
     * * Pub/Sub topics (`@pubsub`)
     * * Dataproc Metastore services (`@dataproc_metastore_{SERVICE_NAME_HASH}`)
     *
     * You can create your own entry groups for Cloud Storage fileset entries
     * and custom entries together with the corresponding IAM policies.
     * User-created entry groups can't contain the `@` symbol, it is reserved
     * for automatically created groups.
     *
     * Entry groups, like entries, can be searched.
     *
     * A maximum of 10,000 entry groups may be created per organization across all
     * locations.
     *
     * You must enable the Data Catalog API in the project identified by
     * the `parent` parameter. For more information, see [Data Catalog resource
     * project](https://cloud.google.com/data-catalog/docs/concepts/resource-project).
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
     * Gets an entry group.
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
     * Updates an entry group.
     *
     * You must enable the Data Catalog API in the project identified by
     * the `entry_group.name` parameter. For more information, see [Data Catalog
     * resource
     * project](https://cloud.google.com/data-catalog/docs/concepts/resource-project).
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
     * Deletes an entry group.
     *
     * You must enable the Data Catalog API in the project
     * identified by the `name` parameter. For more information, see [Data Catalog
     * resource
     * project](https://cloud.google.com/data-catalog/docs/concepts/resource-project).
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
     * Creates an entry.
     *
     * You can create entries only with 'FILESET', 'CLUSTER', 'DATA_STREAM',
     * or custom types. Data Catalog automatically creates entries with other
     * types during metadata ingestion from integrated systems.
     *
     * You must enable the Data Catalog API in the project identified by
     * the `parent` parameter. For more information, see [Data Catalog resource
     * project](https://cloud.google.com/data-catalog/docs/concepts/resource-project).
     *
     * An entry group can have a maximum of 100,000 entries.
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
     *
     * You must enable the Data Catalog API in the project identified by
     * the `entry.name` parameter. For more information, see [Data Catalog
     * resource
     * project](https://cloud.google.com/data-catalog/docs/concepts/resource-project).
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
     * Deletes an existing entry.
     *
     * You can delete only the entries created by the
     * [CreateEntry][google.cloud.datacatalog.v1.DataCatalog.CreateEntry]
     * method.
     *
     * You must enable the Data Catalog API in the project identified by
     * the `name` parameter. For more information, see [Data Catalog
     * resource
     * project](https://cloud.google.com/data-catalog/docs/concepts/resource-project).
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
     * Gets an entry by its target resource name.
     *
     * The resource name comes from the source Google Cloud Platform service.
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
     *
     * Note: Currently, this method can list only custom entries.
     * To get a list of both custom and automatically created entries, use
     * [SearchCatalog][google.cloud.datacatalog.v1.DataCatalog.SearchCatalog].
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
     * Modifies entry overview, part of the business context of an
     * [Entry][google.cloud.datacatalog.v1.Entry].
     *
     * To call this method, you must have the `datacatalog.entries.updateOverview`
     * IAM permission on the corresponding project.
     * @param \Google\Cloud\DataCatalog\V1\ModifyEntryOverviewRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ModifyEntryOverview(\Google\Cloud\DataCatalog\V1\ModifyEntryOverviewRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.DataCatalog/ModifyEntryOverview',
        $argument,
        ['\Google\Cloud\DataCatalog\V1\EntryOverview', 'decode'],
        $metadata, $options);
    }

    /**
     * Modifies contacts, part of the business context of an
     * [Entry][google.cloud.datacatalog.v1.Entry].
     *
     * To call this method, you must have the `datacatalog.entries.updateContacts`
     * IAM permission on the corresponding project.
     * @param \Google\Cloud\DataCatalog\V1\ModifyEntryContactsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ModifyEntryContacts(\Google\Cloud\DataCatalog\V1\ModifyEntryContactsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.DataCatalog/ModifyEntryContacts',
        $argument,
        ['\Google\Cloud\DataCatalog\V1\Contacts', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a tag template.
     *
     * You must enable the Data Catalog API in the project identified by the
     * `parent` parameter.
     * For more information, see [Data Catalog resource project]
     * (https://cloud.google.com/data-catalog/docs/concepts/resource-project).
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
     * Updates a tag template.
     *
     * You can't update template fields with this method. These fields are
     * separate resources with their own create, update, and delete methods.
     *
     * You must enable the Data Catalog API in the project identified by
     * the `tag_template.name` parameter. For more information, see [Data Catalog
     * resource
     * project](https://cloud.google.com/data-catalog/docs/concepts/resource-project).
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
     * Deletes a tag template and all tags that use it.
     *
     * You must enable the Data Catalog API in the project identified by
     * the `name` parameter. For more information, see [Data Catalog resource
     * project](https://cloud.google.com/data-catalog/docs/concepts/resource-project).
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
     * Creates a field in a tag template.
     *
     * You must enable the Data Catalog API in the project identified by
     * the `parent` parameter. For more information, see [Data Catalog resource
     * project](https://cloud.google.com/data-catalog/docs/concepts/resource-project).
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
     * Updates a field in a tag template.
     *
     * You can't update the field type with this method.
     *
     * You must enable the Data Catalog API in the project
     * identified by the `name` parameter. For more information, see [Data Catalog
     * resource
     * project](https://cloud.google.com/data-catalog/docs/concepts/resource-project).
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
     * Renames a field in a tag template.
     *
     * You must enable the Data Catalog API in the project identified by the
     * `name` parameter. For more information, see [Data Catalog resource project]
     * (https://cloud.google.com/data-catalog/docs/concepts/resource-project).
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
     * Renames an enum value in a tag template.
     *
     * Within a single enum field, enum values must be unique.
     * @param \Google\Cloud\DataCatalog\V1\RenameTagTemplateFieldEnumValueRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RenameTagTemplateFieldEnumValue(\Google\Cloud\DataCatalog\V1\RenameTagTemplateFieldEnumValueRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.DataCatalog/RenameTagTemplateFieldEnumValue',
        $argument,
        ['\Google\Cloud\DataCatalog\V1\TagTemplateField', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a field in a tag template and all uses of this field from the tags
     * based on this template.
     *
     * You must enable the Data Catalog API in the project identified by
     * the `name` parameter. For more information, see [Data Catalog resource
     * project](https://cloud.google.com/data-catalog/docs/concepts/resource-project).
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
     * Creates a tag and assigns it to:
     *
     * * An [Entry][google.cloud.datacatalog.v1.Entry] if the method name is
     *   `projects.locations.entryGroups.entries.tags.create`.
     * * Or [EntryGroup][google.cloud.datacatalog.v1.EntryGroup]if the method
     *   name is `projects.locations.entryGroups.tags.create`.
     *
     * Note: The project identified by the `parent` parameter for the [tag]
     * (https://cloud.google.com/data-catalog/docs/reference/rest/v1/projects.locations.entryGroups.entries.tags/create#path-parameters)
     * and the [tag template]
     * (https://cloud.google.com/data-catalog/docs/reference/rest/v1/projects.locations.tagTemplates/create#path-parameters)
     * used to create the tag must be in the same organization.
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
     * Lists tags assigned to an [Entry][google.cloud.datacatalog.v1.Entry].
     * The [columns][google.cloud.datacatalog.v1.Tag.column] in the response are
     * lowercased.
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
     * Marks an [Entry][google.cloud.datacatalog.v1.Entry] as starred by
     * the current user. Starring information is private to each user.
     * @param \Google\Cloud\DataCatalog\V1\StarEntryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function StarEntry(\Google\Cloud\DataCatalog\V1\StarEntryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.DataCatalog/StarEntry',
        $argument,
        ['\Google\Cloud\DataCatalog\V1\StarEntryResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Marks an [Entry][google.cloud.datacatalog.v1.Entry] as NOT starred by
     * the current user. Starring information is private to each user.
     * @param \Google\Cloud\DataCatalog\V1\UnstarEntryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UnstarEntry(\Google\Cloud\DataCatalog\V1\UnstarEntryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.datacatalog.v1.DataCatalog/UnstarEntry',
        $argument,
        ['\Google\Cloud\DataCatalog\V1\UnstarEntryResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Sets an access control policy for a resource. Replaces any existing
     * policy.
     *
     * Supported resources are:
     *
     * - Tag templates
     * - Entry groups
     *
     * Note: This method sets policies only within Data Catalog and can't be
     * used to manage policies in BigQuery, Pub/Sub, Dataproc Metastore, and any
     * external Google Cloud Platform resources synced with the Data Catalog.
     *
     * To call this method, you must have the following Google IAM permissions:
     *
     * - `datacatalog.tagTemplates.setIamPolicy` to set policies on tag
     *   templates.
     * - `datacatalog.entryGroups.setIamPolicy` to set policies on entry groups.
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
     * Gets the access control policy for a resource.
     *
     * May return:
     *
     * * A`NOT_FOUND` error if the resource doesn't exist or you don't have the
     *   permission to view it.
     * * An empty policy if the resource exists but doesn't have a set policy.
     *
     * Supported resources are:
     *
     * - Tag templates
     * - Entry groups
     *
     * Note: This method doesn't get policies from Google Cloud Platform
     * resources ingested into Data Catalog.
     *
     * To call this method, you must have the following Google IAM permissions:
     *
     * - `datacatalog.tagTemplates.getIamPolicy` to get policies on tag
     *   templates.
     * - `datacatalog.entryGroups.getIamPolicy` to get policies on entry groups.
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
     * Gets your permissions on a resource.
     *
     * Returns an empty set of permissions if the resource doesn't exist.
     *
     * Supported resources are:
     *
     * - Tag templates
     * - Entry groups
     *
     * Note: This method gets policies only within Data Catalog and can't be
     * used to get policies from BigQuery, Pub/Sub, Dataproc Metastore, and any
     * external Google Cloud Platform resources ingested into Data Catalog.
     *
     * No Google IAM permissions are required to call this method.
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
