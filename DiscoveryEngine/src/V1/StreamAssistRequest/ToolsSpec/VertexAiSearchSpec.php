<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/discoveryengine/v1/assistant_service.proto

namespace Google\Cloud\DiscoveryEngine\V1\StreamAssistRequest\ToolsSpec;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Specification of the Vertex AI Search tool.
 *
 * Generated from protobuf message <code>google.cloud.discoveryengine.v1.StreamAssistRequest.ToolsSpec.VertexAiSearchSpec</code>
 */
class VertexAiSearchSpec extends \Google\Protobuf\Internal\Message
{
    /**
     * Optional. Specs defining
     * [DataStore][google.cloud.discoveryengine.v1.DataStore]s to filter on in
     * a search call and configurations for those data stores. This is only
     * considered for [Engine][google.cloud.discoveryengine.v1.Engine]s with
     * multiple data stores.
     *
     * Generated from protobuf field <code>repeated .google.cloud.discoveryengine.v1.SearchRequest.DataStoreSpec data_store_specs = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    private $data_store_specs;
    /**
     * Optional. The filter syntax consists of an expression language for
     * constructing a predicate from one or more fields of the documents being
     * filtered. Filter expression is case-sensitive.
     * If this field is unrecognizable, an  `INVALID_ARGUMENT`  is returned.
     * Filtering in Vertex AI Search is done by mapping the LHS filter key to
     * a key property defined in the Vertex AI Search backend -- this mapping
     * is defined by the customer in their schema. For example a media
     * customer might have a field 'name' in their schema. In this case the
     * filter would look like this: filter --> name:'ANY("king kong")'
     * For more information about filtering including syntax and filter
     * operators, see
     * [Filter](https://cloud.google.com/generative-ai-app-builder/docs/filter-search-metadata)
     *
     * Generated from protobuf field <code>string filter = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $filter = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<\Google\Cloud\DiscoveryEngine\V1\SearchRequest\DataStoreSpec>|\Google\Protobuf\Internal\RepeatedField $data_store_specs
     *           Optional. Specs defining
     *           [DataStore][google.cloud.discoveryengine.v1.DataStore]s to filter on in
     *           a search call and configurations for those data stores. This is only
     *           considered for [Engine][google.cloud.discoveryengine.v1.Engine]s with
     *           multiple data stores.
     *     @type string $filter
     *           Optional. The filter syntax consists of an expression language for
     *           constructing a predicate from one or more fields of the documents being
     *           filtered. Filter expression is case-sensitive.
     *           If this field is unrecognizable, an  `INVALID_ARGUMENT`  is returned.
     *           Filtering in Vertex AI Search is done by mapping the LHS filter key to
     *           a key property defined in the Vertex AI Search backend -- this mapping
     *           is defined by the customer in their schema. For example a media
     *           customer might have a field 'name' in their schema. In this case the
     *           filter would look like this: filter --> name:'ANY("king kong")'
     *           For more information about filtering including syntax and filter
     *           operators, see
     *           [Filter](https://cloud.google.com/generative-ai-app-builder/docs/filter-search-metadata)
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Discoveryengine\V1\AssistantService::initOnce();
        parent::__construct($data);
    }

    /**
     * Optional. Specs defining
     * [DataStore][google.cloud.discoveryengine.v1.DataStore]s to filter on in
     * a search call and configurations for those data stores. This is only
     * considered for [Engine][google.cloud.discoveryengine.v1.Engine]s with
     * multiple data stores.
     *
     * Generated from protobuf field <code>repeated .google.cloud.discoveryengine.v1.SearchRequest.DataStoreSpec data_store_specs = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getDataStoreSpecs()
    {
        return $this->data_store_specs;
    }

    /**
     * Optional. Specs defining
     * [DataStore][google.cloud.discoveryengine.v1.DataStore]s to filter on in
     * a search call and configurations for those data stores. This is only
     * considered for [Engine][google.cloud.discoveryengine.v1.Engine]s with
     * multiple data stores.
     *
     * Generated from protobuf field <code>repeated .google.cloud.discoveryengine.v1.SearchRequest.DataStoreSpec data_store_specs = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param array<\Google\Cloud\DiscoveryEngine\V1\SearchRequest\DataStoreSpec>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setDataStoreSpecs($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\DiscoveryEngine\V1\SearchRequest\DataStoreSpec::class);
        $this->data_store_specs = $arr;

        return $this;
    }

    /**
     * Optional. The filter syntax consists of an expression language for
     * constructing a predicate from one or more fields of the documents being
     * filtered. Filter expression is case-sensitive.
     * If this field is unrecognizable, an  `INVALID_ARGUMENT`  is returned.
     * Filtering in Vertex AI Search is done by mapping the LHS filter key to
     * a key property defined in the Vertex AI Search backend -- this mapping
     * is defined by the customer in their schema. For example a media
     * customer might have a field 'name' in their schema. In this case the
     * filter would look like this: filter --> name:'ANY("king kong")'
     * For more information about filtering including syntax and filter
     * operators, see
     * [Filter](https://cloud.google.com/generative-ai-app-builder/docs/filter-search-metadata)
     *
     * Generated from protobuf field <code>string filter = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * Optional. The filter syntax consists of an expression language for
     * constructing a predicate from one or more fields of the documents being
     * filtered. Filter expression is case-sensitive.
     * If this field is unrecognizable, an  `INVALID_ARGUMENT`  is returned.
     * Filtering in Vertex AI Search is done by mapping the LHS filter key to
     * a key property defined in the Vertex AI Search backend -- this mapping
     * is defined by the customer in their schema. For example a media
     * customer might have a field 'name' in their schema. In this case the
     * filter would look like this: filter --> name:'ANY("king kong")'
     * For more information about filtering including syntax and filter
     * operators, see
     * [Filter](https://cloud.google.com/generative-ai-app-builder/docs/filter-search-metadata)
     *
     * Generated from protobuf field <code>string filter = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setFilter($var)
    {
        GPBUtil::checkString($var, True);
        $this->filter = $var;

        return $this;
    }

}


