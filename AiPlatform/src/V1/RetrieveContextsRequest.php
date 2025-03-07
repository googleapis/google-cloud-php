<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/aiplatform/v1/vertex_rag_service.proto

namespace Google\Cloud\AIPlatform\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request message for
 * [VertexRagService.RetrieveContexts][google.cloud.aiplatform.v1.VertexRagService.RetrieveContexts].
 *
 * Generated from protobuf message <code>google.cloud.aiplatform.v1.RetrieveContextsRequest</code>
 */
class RetrieveContextsRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The resource name of the Location from which to retrieve
     * RagContexts. The users must have permission to make a call in the project.
     * Format:
     * `projects/{project}/locations/{location}`.
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $parent = '';
    /**
     * Required. Single RAG retrieve query.
     *
     * Generated from protobuf field <code>.google.cloud.aiplatform.v1.RagQuery query = 3 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $query = null;
    protected $data_source;

    /**
     * @param string                               $parent Required. The resource name of the Location from which to retrieve
     *                                                     RagContexts. The users must have permission to make a call in the project.
     *                                                     Format:
     *                                                     `projects/{project}/locations/{location}`. Please see
     *                                                     {@see VertexRagServiceClient::locationName()} for help formatting this field.
     * @param \Google\Cloud\AIPlatform\V1\RagQuery $query  Required. Single RAG retrieve query.
     *
     * @return \Google\Cloud\AIPlatform\V1\RetrieveContextsRequest
     *
     * @experimental
     */
    public static function build(string $parent, \Google\Cloud\AIPlatform\V1\RagQuery $query): self
    {
        return (new self())
            ->setParent($parent)
            ->setQuery($query);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Cloud\AIPlatform\V1\RetrieveContextsRequest\VertexRagStore $vertex_rag_store
     *           The data source for Vertex RagStore.
     *     @type string $parent
     *           Required. The resource name of the Location from which to retrieve
     *           RagContexts. The users must have permission to make a call in the project.
     *           Format:
     *           `projects/{project}/locations/{location}`.
     *     @type \Google\Cloud\AIPlatform\V1\RagQuery $query
     *           Required. Single RAG retrieve query.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Aiplatform\V1\VertexRagService::initOnce();
        parent::__construct($data);
    }

    /**
     * The data source for Vertex RagStore.
     *
     * Generated from protobuf field <code>.google.cloud.aiplatform.v1.RetrieveContextsRequest.VertexRagStore vertex_rag_store = 2;</code>
     * @return \Google\Cloud\AIPlatform\V1\RetrieveContextsRequest\VertexRagStore|null
     */
    public function getVertexRagStore()
    {
        return $this->readOneof(2);
    }

    public function hasVertexRagStore()
    {
        return $this->hasOneof(2);
    }

    /**
     * The data source for Vertex RagStore.
     *
     * Generated from protobuf field <code>.google.cloud.aiplatform.v1.RetrieveContextsRequest.VertexRagStore vertex_rag_store = 2;</code>
     * @param \Google\Cloud\AIPlatform\V1\RetrieveContextsRequest\VertexRagStore $var
     * @return $this
     */
    public function setVertexRagStore($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\AIPlatform\V1\RetrieveContextsRequest\VertexRagStore::class);
        $this->writeOneof(2, $var);

        return $this;
    }

    /**
     * Required. The resource name of the Location from which to retrieve
     * RagContexts. The users must have permission to make a call in the project.
     * Format:
     * `projects/{project}/locations/{location}`.
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Required. The resource name of the Location from which to retrieve
     * RagContexts. The users must have permission to make a call in the project.
     * Format:
     * `projects/{project}/locations/{location}`.
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setParent($var)
    {
        GPBUtil::checkString($var, True);
        $this->parent = $var;

        return $this;
    }

    /**
     * Required. Single RAG retrieve query.
     *
     * Generated from protobuf field <code>.google.cloud.aiplatform.v1.RagQuery query = 3 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Cloud\AIPlatform\V1\RagQuery|null
     */
    public function getQuery()
    {
        return $this->query;
    }

    public function hasQuery()
    {
        return isset($this->query);
    }

    public function clearQuery()
    {
        unset($this->query);
    }

    /**
     * Required. Single RAG retrieve query.
     *
     * Generated from protobuf field <code>.google.cloud.aiplatform.v1.RagQuery query = 3 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Cloud\AIPlatform\V1\RagQuery $var
     * @return $this
     */
    public function setQuery($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\AIPlatform\V1\RagQuery::class);
        $this->query = $var;

        return $this;
    }

    /**
     * @return string
     */
    public function getDataSource()
    {
        return $this->whichOneof("data_source");
    }

}

