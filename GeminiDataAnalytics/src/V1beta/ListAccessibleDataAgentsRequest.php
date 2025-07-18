<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/geminidataanalytics/v1beta/data_agent_service.proto

namespace Google\Cloud\GeminiDataAnalytics\V1beta;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Message for requesting list of accessible DataAgents.
 *
 * Generated from protobuf message <code>google.cloud.geminidataanalytics.v1beta.ListAccessibleDataAgentsRequest</code>
 */
class ListAccessibleDataAgentsRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. Parent value for ListAccessibleDataAgentsRequest.
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $parent = '';
    /**
     * Optional. Server may return fewer items than requested.
     * If unspecified, server will pick an appropriate default.
     *
     * Generated from protobuf field <code>int32 page_size = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $page_size = 0;
    /**
     * Optional. A page token, received from a previous `ListAccessibleDataAgents`
     * call. Provide this to retrieve the subsequent page.
     * When paginating, all other parameters provided to
     * `ListAccessibleDataAgents` must match the call that provided the page
     * token. The service may return fewer than this value.
     *
     * Generated from protobuf field <code>string page_token = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $page_token = '';
    /**
     * Optional. Filtering results. See [AIP-160](https://google.aip.dev/160) for
     * syntax.
     *
     * Generated from protobuf field <code>string filter = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $filter = '';
    /**
     * Optional. User specification for how to order the results.
     *
     * Generated from protobuf field <code>string order_by = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $order_by = '';
    /**
     * Optional. If true, the list results will include soft-deleted DataAgents.
     * Defaults to false.
     *
     * Generated from protobuf field <code>bool show_deleted = 6 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $show_deleted = false;
    /**
     * Optional. Filter for the creator of the agent.
     *
     * Generated from protobuf field <code>.google.cloud.geminidataanalytics.v1beta.ListAccessibleDataAgentsRequest.CreatorFilter creator_filter = 7 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $creator_filter = 0;

    /**
     * @param string $parent Required. Parent value for ListAccessibleDataAgentsRequest. Please see
     *                       {@see DataAgentServiceClient::locationName()} for help formatting this field.
     *
     * @return \Google\Cloud\GeminiDataAnalytics\V1beta\ListAccessibleDataAgentsRequest
     *
     * @experimental
     */
    public static function build(string $parent): self
    {
        return (new self())
            ->setParent($parent);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $parent
     *           Required. Parent value for ListAccessibleDataAgentsRequest.
     *     @type int $page_size
     *           Optional. Server may return fewer items than requested.
     *           If unspecified, server will pick an appropriate default.
     *     @type string $page_token
     *           Optional. A page token, received from a previous `ListAccessibleDataAgents`
     *           call. Provide this to retrieve the subsequent page.
     *           When paginating, all other parameters provided to
     *           `ListAccessibleDataAgents` must match the call that provided the page
     *           token. The service may return fewer than this value.
     *     @type string $filter
     *           Optional. Filtering results. See [AIP-160](https://google.aip.dev/160) for
     *           syntax.
     *     @type string $order_by
     *           Optional. User specification for how to order the results.
     *     @type bool $show_deleted
     *           Optional. If true, the list results will include soft-deleted DataAgents.
     *           Defaults to false.
     *     @type int $creator_filter
     *           Optional. Filter for the creator of the agent.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Geminidataanalytics\V1Beta\DataAgentService::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. Parent value for ListAccessibleDataAgentsRequest.
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Required. Parent value for ListAccessibleDataAgentsRequest.
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
     * Optional. Server may return fewer items than requested.
     * If unspecified, server will pick an appropriate default.
     *
     * Generated from protobuf field <code>int32 page_size = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return int
     */
    public function getPageSize()
    {
        return $this->page_size;
    }

    /**
     * Optional. Server may return fewer items than requested.
     * If unspecified, server will pick an appropriate default.
     *
     * Generated from protobuf field <code>int32 page_size = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param int $var
     * @return $this
     */
    public function setPageSize($var)
    {
        GPBUtil::checkInt32($var);
        $this->page_size = $var;

        return $this;
    }

    /**
     * Optional. A page token, received from a previous `ListAccessibleDataAgents`
     * call. Provide this to retrieve the subsequent page.
     * When paginating, all other parameters provided to
     * `ListAccessibleDataAgents` must match the call that provided the page
     * token. The service may return fewer than this value.
     *
     * Generated from protobuf field <code>string page_token = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getPageToken()
    {
        return $this->page_token;
    }

    /**
     * Optional. A page token, received from a previous `ListAccessibleDataAgents`
     * call. Provide this to retrieve the subsequent page.
     * When paginating, all other parameters provided to
     * `ListAccessibleDataAgents` must match the call that provided the page
     * token. The service may return fewer than this value.
     *
     * Generated from protobuf field <code>string page_token = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setPageToken($var)
    {
        GPBUtil::checkString($var, True);
        $this->page_token = $var;

        return $this;
    }

    /**
     * Optional. Filtering results. See [AIP-160](https://google.aip.dev/160) for
     * syntax.
     *
     * Generated from protobuf field <code>string filter = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * Optional. Filtering results. See [AIP-160](https://google.aip.dev/160) for
     * syntax.
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

    /**
     * Optional. User specification for how to order the results.
     *
     * Generated from protobuf field <code>string order_by = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getOrderBy()
    {
        return $this->order_by;
    }

    /**
     * Optional. User specification for how to order the results.
     *
     * Generated from protobuf field <code>string order_by = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setOrderBy($var)
    {
        GPBUtil::checkString($var, True);
        $this->order_by = $var;

        return $this;
    }

    /**
     * Optional. If true, the list results will include soft-deleted DataAgents.
     * Defaults to false.
     *
     * Generated from protobuf field <code>bool show_deleted = 6 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return bool
     */
    public function getShowDeleted()
    {
        return $this->show_deleted;
    }

    /**
     * Optional. If true, the list results will include soft-deleted DataAgents.
     * Defaults to false.
     *
     * Generated from protobuf field <code>bool show_deleted = 6 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param bool $var
     * @return $this
     */
    public function setShowDeleted($var)
    {
        GPBUtil::checkBool($var);
        $this->show_deleted = $var;

        return $this;
    }

    /**
     * Optional. Filter for the creator of the agent.
     *
     * Generated from protobuf field <code>.google.cloud.geminidataanalytics.v1beta.ListAccessibleDataAgentsRequest.CreatorFilter creator_filter = 7 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return int
     */
    public function getCreatorFilter()
    {
        return $this->creator_filter;
    }

    /**
     * Optional. Filter for the creator of the agent.
     *
     * Generated from protobuf field <code>.google.cloud.geminidataanalytics.v1beta.ListAccessibleDataAgentsRequest.CreatorFilter creator_filter = 7 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param int $var
     * @return $this
     */
    public function setCreatorFilter($var)
    {
        GPBUtil::checkEnum($var, \Google\Cloud\GeminiDataAnalytics\V1beta\ListAccessibleDataAgentsRequest\CreatorFilter::class);
        $this->creator_filter = $var;

        return $this;
    }

}

