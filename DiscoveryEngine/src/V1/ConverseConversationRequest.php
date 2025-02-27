<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/discoveryengine/v1/conversational_search_service.proto

namespace Google\Cloud\DiscoveryEngine\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request message for
 * [ConversationalSearchService.ConverseConversation][google.cloud.discoveryengine.v1.ConversationalSearchService.ConverseConversation]
 * method.
 *
 * Generated from protobuf message <code>google.cloud.discoveryengine.v1.ConverseConversationRequest</code>
 */
class ConverseConversationRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The resource name of the Conversation to get. Format:
     * `projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store_id}/conversations/{conversation_id}`.
     * Use
     * `projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store_id}/conversations/-`
     * to activate auto session mode, which automatically creates a new
     * conversation inside a ConverseConversation session.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $name = '';
    /**
     * Required. Current user input.
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.TextInput query = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $query = null;
    /**
     * The resource name of the Serving Config to use. Format:
     * `projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store_id}/servingConfigs/{serving_config_id}`
     * If this is not set, the default serving config will be used.
     *
     * Generated from protobuf field <code>string serving_config = 3 [(.google.api.resource_reference) = {</code>
     */
    protected $serving_config = '';
    /**
     * The conversation to be used by auto session only. The name field will be
     * ignored as we automatically assign new name for the conversation in auto
     * session.
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.Conversation conversation = 5;</code>
     */
    protected $conversation = null;
    /**
     * Whether to turn on safe search.
     *
     * Generated from protobuf field <code>bool safe_search = 6;</code>
     */
    protected $safe_search = false;
    /**
     * The user labels applied to a resource must meet the following requirements:
     * * Each resource can have multiple labels, up to a maximum of 64.
     * * Each label must be a key-value pair.
     * * Keys have a minimum length of 1 character and a maximum length of 63
     *   characters and cannot be empty. Values can be empty and have a maximum
     *   length of 63 characters.
     * * Keys and values can contain only lowercase letters, numeric characters,
     *   underscores, and dashes. All characters must use UTF-8 encoding, and
     *   international characters are allowed.
     * * The key portion of a label must be unique. However, you can use the same
     *   key with multiple resources.
     * * Keys must start with a lowercase letter or international character.
     * See [Google Cloud
     * Document](https://cloud.google.com/resource-manager/docs/creating-managing-labels#requirements)
     * for more details.
     *
     * Generated from protobuf field <code>map<string, string> user_labels = 7;</code>
     */
    private $user_labels;
    /**
     * A specification for configuring the summary returned in the response.
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.SearchRequest.ContentSearchSpec.SummarySpec summary_spec = 8;</code>
     */
    protected $summary_spec = null;
    /**
     * The filter syntax consists of an expression language for constructing a
     * predicate from one or more fields of the documents being filtered. Filter
     * expression is case-sensitive. This will be used to filter search results
     * which may affect the summary response.
     * If this field is unrecognizable, an  `INVALID_ARGUMENT`  is returned.
     * Filtering in Vertex AI Search is done by mapping the LHS filter key to a
     * key property defined in the Vertex AI Search backend -- this mapping is
     * defined by the customer in their schema. For example a media customer might
     * have a field 'name' in their schema. In this case the filter would look
     * like this: filter --> name:'ANY("king kong")'
     * For more information about filtering including syntax and filter
     * operators, see
     * [Filter](https://cloud.google.com/generative-ai-app-builder/docs/filter-search-metadata)
     *
     * Generated from protobuf field <code>string filter = 9;</code>
     */
    protected $filter = '';
    /**
     * Boost specification to boost certain documents in search results which may
     * affect the converse response. For more information on boosting, see
     * [Boosting](https://cloud.google.com/retail/docs/boosting#boost)
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.SearchRequest.BoostSpec boost_spec = 10;</code>
     */
    protected $boost_spec = null;

    /**
     * @param string                                     $name  Required. The resource name of the Conversation to get. Format:
     *                                                          `projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store_id}/conversations/{conversation_id}`.
     *                                                          Use
     *                                                          `projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store_id}/conversations/-`
     *                                                          to activate auto session mode, which automatically creates a new
     *                                                          conversation inside a ConverseConversation session. Please see
     *                                                          {@see ConversationalSearchServiceClient::conversationName()} for help formatting this field.
     * @param \Google\Cloud\DiscoveryEngine\V1\TextInput $query Required. Current user input.
     *
     * @return \Google\Cloud\DiscoveryEngine\V1\ConverseConversationRequest
     *
     * @experimental
     */
    public static function build(string $name, \Google\Cloud\DiscoveryEngine\V1\TextInput $query): self
    {
        return (new self())
            ->setName($name)
            ->setQuery($query);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           Required. The resource name of the Conversation to get. Format:
     *           `projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store_id}/conversations/{conversation_id}`.
     *           Use
     *           `projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store_id}/conversations/-`
     *           to activate auto session mode, which automatically creates a new
     *           conversation inside a ConverseConversation session.
     *     @type \Google\Cloud\DiscoveryEngine\V1\TextInput $query
     *           Required. Current user input.
     *     @type string $serving_config
     *           The resource name of the Serving Config to use. Format:
     *           `projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store_id}/servingConfigs/{serving_config_id}`
     *           If this is not set, the default serving config will be used.
     *     @type \Google\Cloud\DiscoveryEngine\V1\Conversation $conversation
     *           The conversation to be used by auto session only. The name field will be
     *           ignored as we automatically assign new name for the conversation in auto
     *           session.
     *     @type bool $safe_search
     *           Whether to turn on safe search.
     *     @type array|\Google\Protobuf\Internal\MapField $user_labels
     *           The user labels applied to a resource must meet the following requirements:
     *           * Each resource can have multiple labels, up to a maximum of 64.
     *           * Each label must be a key-value pair.
     *           * Keys have a minimum length of 1 character and a maximum length of 63
     *             characters and cannot be empty. Values can be empty and have a maximum
     *             length of 63 characters.
     *           * Keys and values can contain only lowercase letters, numeric characters,
     *             underscores, and dashes. All characters must use UTF-8 encoding, and
     *             international characters are allowed.
     *           * The key portion of a label must be unique. However, you can use the same
     *             key with multiple resources.
     *           * Keys must start with a lowercase letter or international character.
     *           See [Google Cloud
     *           Document](https://cloud.google.com/resource-manager/docs/creating-managing-labels#requirements)
     *           for more details.
     *     @type \Google\Cloud\DiscoveryEngine\V1\SearchRequest\ContentSearchSpec\SummarySpec $summary_spec
     *           A specification for configuring the summary returned in the response.
     *     @type string $filter
     *           The filter syntax consists of an expression language for constructing a
     *           predicate from one or more fields of the documents being filtered. Filter
     *           expression is case-sensitive. This will be used to filter search results
     *           which may affect the summary response.
     *           If this field is unrecognizable, an  `INVALID_ARGUMENT`  is returned.
     *           Filtering in Vertex AI Search is done by mapping the LHS filter key to a
     *           key property defined in the Vertex AI Search backend -- this mapping is
     *           defined by the customer in their schema. For example a media customer might
     *           have a field 'name' in their schema. In this case the filter would look
     *           like this: filter --> name:'ANY("king kong")'
     *           For more information about filtering including syntax and filter
     *           operators, see
     *           [Filter](https://cloud.google.com/generative-ai-app-builder/docs/filter-search-metadata)
     *     @type \Google\Cloud\DiscoveryEngine\V1\SearchRequest\BoostSpec $boost_spec
     *           Boost specification to boost certain documents in search results which may
     *           affect the converse response. For more information on boosting, see
     *           [Boosting](https://cloud.google.com/retail/docs/boosting#boost)
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Discoveryengine\V1\ConversationalSearchService::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The resource name of the Conversation to get. Format:
     * `projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store_id}/conversations/{conversation_id}`.
     * Use
     * `projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store_id}/conversations/-`
     * to activate auto session mode, which automatically creates a new
     * conversation inside a ConverseConversation session.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Required. The resource name of the Conversation to get. Format:
     * `projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store_id}/conversations/{conversation_id}`.
     * Use
     * `projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store_id}/conversations/-`
     * to activate auto session mode, which automatically creates a new
     * conversation inside a ConverseConversation session.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
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
     * Required. Current user input.
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.TextInput query = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Cloud\DiscoveryEngine\V1\TextInput|null
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
     * Required. Current user input.
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.TextInput query = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Cloud\DiscoveryEngine\V1\TextInput $var
     * @return $this
     */
    public function setQuery($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\DiscoveryEngine\V1\TextInput::class);
        $this->query = $var;

        return $this;
    }

    /**
     * The resource name of the Serving Config to use. Format:
     * `projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store_id}/servingConfigs/{serving_config_id}`
     * If this is not set, the default serving config will be used.
     *
     * Generated from protobuf field <code>string serving_config = 3 [(.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getServingConfig()
    {
        return $this->serving_config;
    }

    /**
     * The resource name of the Serving Config to use. Format:
     * `projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store_id}/servingConfigs/{serving_config_id}`
     * If this is not set, the default serving config will be used.
     *
     * Generated from protobuf field <code>string serving_config = 3 [(.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setServingConfig($var)
    {
        GPBUtil::checkString($var, True);
        $this->serving_config = $var;

        return $this;
    }

    /**
     * The conversation to be used by auto session only. The name field will be
     * ignored as we automatically assign new name for the conversation in auto
     * session.
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.Conversation conversation = 5;</code>
     * @return \Google\Cloud\DiscoveryEngine\V1\Conversation|null
     */
    public function getConversation()
    {
        return $this->conversation;
    }

    public function hasConversation()
    {
        return isset($this->conversation);
    }

    public function clearConversation()
    {
        unset($this->conversation);
    }

    /**
     * The conversation to be used by auto session only. The name field will be
     * ignored as we automatically assign new name for the conversation in auto
     * session.
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.Conversation conversation = 5;</code>
     * @param \Google\Cloud\DiscoveryEngine\V1\Conversation $var
     * @return $this
     */
    public function setConversation($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\DiscoveryEngine\V1\Conversation::class);
        $this->conversation = $var;

        return $this;
    }

    /**
     * Whether to turn on safe search.
     *
     * Generated from protobuf field <code>bool safe_search = 6;</code>
     * @return bool
     */
    public function getSafeSearch()
    {
        return $this->safe_search;
    }

    /**
     * Whether to turn on safe search.
     *
     * Generated from protobuf field <code>bool safe_search = 6;</code>
     * @param bool $var
     * @return $this
     */
    public function setSafeSearch($var)
    {
        GPBUtil::checkBool($var);
        $this->safe_search = $var;

        return $this;
    }

    /**
     * The user labels applied to a resource must meet the following requirements:
     * * Each resource can have multiple labels, up to a maximum of 64.
     * * Each label must be a key-value pair.
     * * Keys have a minimum length of 1 character and a maximum length of 63
     *   characters and cannot be empty. Values can be empty and have a maximum
     *   length of 63 characters.
     * * Keys and values can contain only lowercase letters, numeric characters,
     *   underscores, and dashes. All characters must use UTF-8 encoding, and
     *   international characters are allowed.
     * * The key portion of a label must be unique. However, you can use the same
     *   key with multiple resources.
     * * Keys must start with a lowercase letter or international character.
     * See [Google Cloud
     * Document](https://cloud.google.com/resource-manager/docs/creating-managing-labels#requirements)
     * for more details.
     *
     * Generated from protobuf field <code>map<string, string> user_labels = 7;</code>
     * @return \Google\Protobuf\Internal\MapField
     */
    public function getUserLabels()
    {
        return $this->user_labels;
    }

    /**
     * The user labels applied to a resource must meet the following requirements:
     * * Each resource can have multiple labels, up to a maximum of 64.
     * * Each label must be a key-value pair.
     * * Keys have a minimum length of 1 character and a maximum length of 63
     *   characters and cannot be empty. Values can be empty and have a maximum
     *   length of 63 characters.
     * * Keys and values can contain only lowercase letters, numeric characters,
     *   underscores, and dashes. All characters must use UTF-8 encoding, and
     *   international characters are allowed.
     * * The key portion of a label must be unique. However, you can use the same
     *   key with multiple resources.
     * * Keys must start with a lowercase letter or international character.
     * See [Google Cloud
     * Document](https://cloud.google.com/resource-manager/docs/creating-managing-labels#requirements)
     * for more details.
     *
     * Generated from protobuf field <code>map<string, string> user_labels = 7;</code>
     * @param array|\Google\Protobuf\Internal\MapField $var
     * @return $this
     */
    public function setUserLabels($var)
    {
        $arr = GPBUtil::checkMapField($var, \Google\Protobuf\Internal\GPBType::STRING, \Google\Protobuf\Internal\GPBType::STRING);
        $this->user_labels = $arr;

        return $this;
    }

    /**
     * A specification for configuring the summary returned in the response.
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.SearchRequest.ContentSearchSpec.SummarySpec summary_spec = 8;</code>
     * @return \Google\Cloud\DiscoveryEngine\V1\SearchRequest\ContentSearchSpec\SummarySpec|null
     */
    public function getSummarySpec()
    {
        return $this->summary_spec;
    }

    public function hasSummarySpec()
    {
        return isset($this->summary_spec);
    }

    public function clearSummarySpec()
    {
        unset($this->summary_spec);
    }

    /**
     * A specification for configuring the summary returned in the response.
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.SearchRequest.ContentSearchSpec.SummarySpec summary_spec = 8;</code>
     * @param \Google\Cloud\DiscoveryEngine\V1\SearchRequest\ContentSearchSpec\SummarySpec $var
     * @return $this
     */
    public function setSummarySpec($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\DiscoveryEngine\V1\SearchRequest\ContentSearchSpec\SummarySpec::class);
        $this->summary_spec = $var;

        return $this;
    }

    /**
     * The filter syntax consists of an expression language for constructing a
     * predicate from one or more fields of the documents being filtered. Filter
     * expression is case-sensitive. This will be used to filter search results
     * which may affect the summary response.
     * If this field is unrecognizable, an  `INVALID_ARGUMENT`  is returned.
     * Filtering in Vertex AI Search is done by mapping the LHS filter key to a
     * key property defined in the Vertex AI Search backend -- this mapping is
     * defined by the customer in their schema. For example a media customer might
     * have a field 'name' in their schema. In this case the filter would look
     * like this: filter --> name:'ANY("king kong")'
     * For more information about filtering including syntax and filter
     * operators, see
     * [Filter](https://cloud.google.com/generative-ai-app-builder/docs/filter-search-metadata)
     *
     * Generated from protobuf field <code>string filter = 9;</code>
     * @return string
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * The filter syntax consists of an expression language for constructing a
     * predicate from one or more fields of the documents being filtered. Filter
     * expression is case-sensitive. This will be used to filter search results
     * which may affect the summary response.
     * If this field is unrecognizable, an  `INVALID_ARGUMENT`  is returned.
     * Filtering in Vertex AI Search is done by mapping the LHS filter key to a
     * key property defined in the Vertex AI Search backend -- this mapping is
     * defined by the customer in their schema. For example a media customer might
     * have a field 'name' in their schema. In this case the filter would look
     * like this: filter --> name:'ANY("king kong")'
     * For more information about filtering including syntax and filter
     * operators, see
     * [Filter](https://cloud.google.com/generative-ai-app-builder/docs/filter-search-metadata)
     *
     * Generated from protobuf field <code>string filter = 9;</code>
     * @param string $var
     * @return $this
     */
    public function setFilter($var)
    {
        GPBUtil::checkString($var, True);
        $this->filter = $var;

        return $this;
    }

    /**
     * Boost specification to boost certain documents in search results which may
     * affect the converse response. For more information on boosting, see
     * [Boosting](https://cloud.google.com/retail/docs/boosting#boost)
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.SearchRequest.BoostSpec boost_spec = 10;</code>
     * @return \Google\Cloud\DiscoveryEngine\V1\SearchRequest\BoostSpec|null
     */
    public function getBoostSpec()
    {
        return $this->boost_spec;
    }

    public function hasBoostSpec()
    {
        return isset($this->boost_spec);
    }

    public function clearBoostSpec()
    {
        unset($this->boost_spec);
    }

    /**
     * Boost specification to boost certain documents in search results which may
     * affect the converse response. For more information on boosting, see
     * [Boosting](https://cloud.google.com/retail/docs/boosting#boost)
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.SearchRequest.BoostSpec boost_spec = 10;</code>
     * @param \Google\Cloud\DiscoveryEngine\V1\SearchRequest\BoostSpec $var
     * @return $this
     */
    public function setBoostSpec($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\DiscoveryEngine\V1\SearchRequest\BoostSpec::class);
        $this->boost_spec = $var;

        return $this;
    }

}

