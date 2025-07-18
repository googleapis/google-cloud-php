<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/discoveryengine/v1/document.proto

namespace Google\Cloud\DiscoveryEngine\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Document captures all raw metadata information of items to be recommended or
 * searched.
 *
 * Generated from protobuf message <code>google.cloud.discoveryengine.v1.Document</code>
 */
class Document extends \Google\Protobuf\Internal\Message
{
    /**
     * Immutable. The full resource name of the document.
     * Format:
     * `projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}/branches/{branch}/documents/{document_id}`.
     * This field must be a UTF-8 encoded string with a length limit of 1024
     * characters.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = IMMUTABLE];</code>
     */
    protected $name = '';
    /**
     * Immutable. The identifier of the document.
     * Id should conform to [RFC-1034](https://tools.ietf.org/html/rfc1034)
     * standard with a length limit of 128 characters.
     *
     * Generated from protobuf field <code>string id = 2 [(.google.api.field_behavior) = IMMUTABLE];</code>
     */
    protected $id = '';
    /**
     * The identifier of the schema located in the same data store.
     *
     * Generated from protobuf field <code>string schema_id = 3;</code>
     */
    protected $schema_id = '';
    /**
     * The unstructured data linked to this document. Content can only be set
     * and must be set if this document is under a `CONTENT_REQUIRED` data store.
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.Document.Content content = 10;</code>
     */
    protected $content = null;
    /**
     * The identifier of the parent document. Currently supports at most two level
     * document hierarchy.
     * Id should conform to [RFC-1034](https://tools.ietf.org/html/rfc1034)
     * standard with a length limit of 63 characters.
     *
     * Generated from protobuf field <code>string parent_document_id = 7;</code>
     */
    protected $parent_document_id = '';
    /**
     * Output only. This field is OUTPUT_ONLY.
     * It contains derived data that are not in the original input document.
     *
     * Generated from protobuf field <code>.google.protobuf.Struct derived_struct_data = 6 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $derived_struct_data = null;
    /**
     * Access control information for the document.
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.Document.AclInfo acl_info = 11;</code>
     */
    protected $acl_info = null;
    /**
     * Output only. The last time the document was indexed. If this field is set,
     * the document could be returned in search results.
     * This field is OUTPUT_ONLY. If this field is not populated, it means the
     * document has never been indexed.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp index_time = 13 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $index_time = null;
    /**
     * Output only. The index status of the document.
     * * If document is indexed successfully, the index_time field is populated.
     * * Otherwise, if document is not indexed due to errors, the error_samples
     *   field is populated.
     * * Otherwise, if document's index is in progress, the pending_message field
     *   is populated.
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.Document.IndexStatus index_status = 15 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $index_status = null;
    protected $data;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Protobuf\Struct $struct_data
     *           The structured JSON data for the document. It should conform to the
     *           registered [Schema][google.cloud.discoveryengine.v1.Schema] or an
     *           `INVALID_ARGUMENT` error is thrown.
     *     @type string $json_data
     *           The JSON string representation of the document. It should conform to the
     *           registered [Schema][google.cloud.discoveryengine.v1.Schema] or an
     *           `INVALID_ARGUMENT` error is thrown.
     *     @type string $name
     *           Immutable. The full resource name of the document.
     *           Format:
     *           `projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}/branches/{branch}/documents/{document_id}`.
     *           This field must be a UTF-8 encoded string with a length limit of 1024
     *           characters.
     *     @type string $id
     *           Immutable. The identifier of the document.
     *           Id should conform to [RFC-1034](https://tools.ietf.org/html/rfc1034)
     *           standard with a length limit of 128 characters.
     *     @type string $schema_id
     *           The identifier of the schema located in the same data store.
     *     @type \Google\Cloud\DiscoveryEngine\V1\Document\Content $content
     *           The unstructured data linked to this document. Content can only be set
     *           and must be set if this document is under a `CONTENT_REQUIRED` data store.
     *     @type string $parent_document_id
     *           The identifier of the parent document. Currently supports at most two level
     *           document hierarchy.
     *           Id should conform to [RFC-1034](https://tools.ietf.org/html/rfc1034)
     *           standard with a length limit of 63 characters.
     *     @type \Google\Protobuf\Struct $derived_struct_data
     *           Output only. This field is OUTPUT_ONLY.
     *           It contains derived data that are not in the original input document.
     *     @type \Google\Cloud\DiscoveryEngine\V1\Document\AclInfo $acl_info
     *           Access control information for the document.
     *     @type \Google\Protobuf\Timestamp $index_time
     *           Output only. The last time the document was indexed. If this field is set,
     *           the document could be returned in search results.
     *           This field is OUTPUT_ONLY. If this field is not populated, it means the
     *           document has never been indexed.
     *     @type \Google\Cloud\DiscoveryEngine\V1\Document\IndexStatus $index_status
     *           Output only. The index status of the document.
     *           * If document is indexed successfully, the index_time field is populated.
     *           * Otherwise, if document is not indexed due to errors, the error_samples
     *             field is populated.
     *           * Otherwise, if document's index is in progress, the pending_message field
     *             is populated.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Discoveryengine\V1\Document::initOnce();
        parent::__construct($data);
    }

    /**
     * The structured JSON data for the document. It should conform to the
     * registered [Schema][google.cloud.discoveryengine.v1.Schema] or an
     * `INVALID_ARGUMENT` error is thrown.
     *
     * Generated from protobuf field <code>.google.protobuf.Struct struct_data = 4;</code>
     * @return \Google\Protobuf\Struct|null
     */
    public function getStructData()
    {
        return $this->readOneof(4);
    }

    public function hasStructData()
    {
        return $this->hasOneof(4);
    }

    /**
     * The structured JSON data for the document. It should conform to the
     * registered [Schema][google.cloud.discoveryengine.v1.Schema] or an
     * `INVALID_ARGUMENT` error is thrown.
     *
     * Generated from protobuf field <code>.google.protobuf.Struct struct_data = 4;</code>
     * @param \Google\Protobuf\Struct $var
     * @return $this
     */
    public function setStructData($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Struct::class);
        $this->writeOneof(4, $var);

        return $this;
    }

    /**
     * The JSON string representation of the document. It should conform to the
     * registered [Schema][google.cloud.discoveryengine.v1.Schema] or an
     * `INVALID_ARGUMENT` error is thrown.
     *
     * Generated from protobuf field <code>string json_data = 5;</code>
     * @return string
     */
    public function getJsonData()
    {
        return $this->readOneof(5);
    }

    public function hasJsonData()
    {
        return $this->hasOneof(5);
    }

    /**
     * The JSON string representation of the document. It should conform to the
     * registered [Schema][google.cloud.discoveryengine.v1.Schema] or an
     * `INVALID_ARGUMENT` error is thrown.
     *
     * Generated from protobuf field <code>string json_data = 5;</code>
     * @param string $var
     * @return $this
     */
    public function setJsonData($var)
    {
        GPBUtil::checkString($var, True);
        $this->writeOneof(5, $var);

        return $this;
    }

    /**
     * Immutable. The full resource name of the document.
     * Format:
     * `projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}/branches/{branch}/documents/{document_id}`.
     * This field must be a UTF-8 encoded string with a length limit of 1024
     * characters.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = IMMUTABLE];</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Immutable. The full resource name of the document.
     * Format:
     * `projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}/branches/{branch}/documents/{document_id}`.
     * This field must be a UTF-8 encoded string with a length limit of 1024
     * characters.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = IMMUTABLE];</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;

        return $this;
    }

    /**
     * Immutable. The identifier of the document.
     * Id should conform to [RFC-1034](https://tools.ietf.org/html/rfc1034)
     * standard with a length limit of 128 characters.
     *
     * Generated from protobuf field <code>string id = 2 [(.google.api.field_behavior) = IMMUTABLE];</code>
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Immutable. The identifier of the document.
     * Id should conform to [RFC-1034](https://tools.ietf.org/html/rfc1034)
     * standard with a length limit of 128 characters.
     *
     * Generated from protobuf field <code>string id = 2 [(.google.api.field_behavior) = IMMUTABLE];</code>
     * @param string $var
     * @return $this
     */
    public function setId($var)
    {
        GPBUtil::checkString($var, True);
        $this->id = $var;

        return $this;
    }

    /**
     * The identifier of the schema located in the same data store.
     *
     * Generated from protobuf field <code>string schema_id = 3;</code>
     * @return string
     */
    public function getSchemaId()
    {
        return $this->schema_id;
    }

    /**
     * The identifier of the schema located in the same data store.
     *
     * Generated from protobuf field <code>string schema_id = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setSchemaId($var)
    {
        GPBUtil::checkString($var, True);
        $this->schema_id = $var;

        return $this;
    }

    /**
     * The unstructured data linked to this document. Content can only be set
     * and must be set if this document is under a `CONTENT_REQUIRED` data store.
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.Document.Content content = 10;</code>
     * @return \Google\Cloud\DiscoveryEngine\V1\Document\Content|null
     */
    public function getContent()
    {
        return $this->content;
    }

    public function hasContent()
    {
        return isset($this->content);
    }

    public function clearContent()
    {
        unset($this->content);
    }

    /**
     * The unstructured data linked to this document. Content can only be set
     * and must be set if this document is under a `CONTENT_REQUIRED` data store.
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.Document.Content content = 10;</code>
     * @param \Google\Cloud\DiscoveryEngine\V1\Document\Content $var
     * @return $this
     */
    public function setContent($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\DiscoveryEngine\V1\Document\Content::class);
        $this->content = $var;

        return $this;
    }

    /**
     * The identifier of the parent document. Currently supports at most two level
     * document hierarchy.
     * Id should conform to [RFC-1034](https://tools.ietf.org/html/rfc1034)
     * standard with a length limit of 63 characters.
     *
     * Generated from protobuf field <code>string parent_document_id = 7;</code>
     * @return string
     */
    public function getParentDocumentId()
    {
        return $this->parent_document_id;
    }

    /**
     * The identifier of the parent document. Currently supports at most two level
     * document hierarchy.
     * Id should conform to [RFC-1034](https://tools.ietf.org/html/rfc1034)
     * standard with a length limit of 63 characters.
     *
     * Generated from protobuf field <code>string parent_document_id = 7;</code>
     * @param string $var
     * @return $this
     */
    public function setParentDocumentId($var)
    {
        GPBUtil::checkString($var, True);
        $this->parent_document_id = $var;

        return $this;
    }

    /**
     * Output only. This field is OUTPUT_ONLY.
     * It contains derived data that are not in the original input document.
     *
     * Generated from protobuf field <code>.google.protobuf.Struct derived_struct_data = 6 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return \Google\Protobuf\Struct|null
     */
    public function getDerivedStructData()
    {
        return $this->derived_struct_data;
    }

    public function hasDerivedStructData()
    {
        return isset($this->derived_struct_data);
    }

    public function clearDerivedStructData()
    {
        unset($this->derived_struct_data);
    }

    /**
     * Output only. This field is OUTPUT_ONLY.
     * It contains derived data that are not in the original input document.
     *
     * Generated from protobuf field <code>.google.protobuf.Struct derived_struct_data = 6 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param \Google\Protobuf\Struct $var
     * @return $this
     */
    public function setDerivedStructData($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Struct::class);
        $this->derived_struct_data = $var;

        return $this;
    }

    /**
     * Access control information for the document.
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.Document.AclInfo acl_info = 11;</code>
     * @return \Google\Cloud\DiscoveryEngine\V1\Document\AclInfo|null
     */
    public function getAclInfo()
    {
        return $this->acl_info;
    }

    public function hasAclInfo()
    {
        return isset($this->acl_info);
    }

    public function clearAclInfo()
    {
        unset($this->acl_info);
    }

    /**
     * Access control information for the document.
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.Document.AclInfo acl_info = 11;</code>
     * @param \Google\Cloud\DiscoveryEngine\V1\Document\AclInfo $var
     * @return $this
     */
    public function setAclInfo($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\DiscoveryEngine\V1\Document\AclInfo::class);
        $this->acl_info = $var;

        return $this;
    }

    /**
     * Output only. The last time the document was indexed. If this field is set,
     * the document could be returned in search results.
     * This field is OUTPUT_ONLY. If this field is not populated, it means the
     * document has never been indexed.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp index_time = 13 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return \Google\Protobuf\Timestamp|null
     */
    public function getIndexTime()
    {
        return $this->index_time;
    }

    public function hasIndexTime()
    {
        return isset($this->index_time);
    }

    public function clearIndexTime()
    {
        unset($this->index_time);
    }

    /**
     * Output only. The last time the document was indexed. If this field is set,
     * the document could be returned in search results.
     * This field is OUTPUT_ONLY. If this field is not populated, it means the
     * document has never been indexed.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp index_time = 13 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setIndexTime($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->index_time = $var;

        return $this;
    }

    /**
     * Output only. The index status of the document.
     * * If document is indexed successfully, the index_time field is populated.
     * * Otherwise, if document is not indexed due to errors, the error_samples
     *   field is populated.
     * * Otherwise, if document's index is in progress, the pending_message field
     *   is populated.
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.Document.IndexStatus index_status = 15 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return \Google\Cloud\DiscoveryEngine\V1\Document\IndexStatus|null
     */
    public function getIndexStatus()
    {
        return $this->index_status;
    }

    public function hasIndexStatus()
    {
        return isset($this->index_status);
    }

    public function clearIndexStatus()
    {
        unset($this->index_status);
    }

    /**
     * Output only. The index status of the document.
     * * If document is indexed successfully, the index_time field is populated.
     * * Otherwise, if document is not indexed due to errors, the error_samples
     *   field is populated.
     * * Otherwise, if document's index is in progress, the pending_message field
     *   is populated.
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.Document.IndexStatus index_status = 15 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param \Google\Cloud\DiscoveryEngine\V1\Document\IndexStatus $var
     * @return $this
     */
    public function setIndexStatus($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\DiscoveryEngine\V1\Document\IndexStatus::class);
        $this->index_status = $var;

        return $this;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->whichOneof("data");
    }

}

