<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/retail/v2/search_service.proto

namespace Google\Cloud\Retail\V2\SearchRequest;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Specification to determine under which conditions query expansion should
 * occur.
 *
 * Generated from protobuf message <code>google.cloud.retail.v2.SearchRequest.QueryExpansionSpec</code>
 */
class QueryExpansionSpec extends \Google\Protobuf\Internal\Message
{
    /**
     * The condition under which query expansion should occur. Default to
     * [Condition.DISABLED][google.cloud.retail.v2.SearchRequest.QueryExpansionSpec.Condition.DISABLED].
     *
     * Generated from protobuf field <code>.google.cloud.retail.v2.SearchRequest.QueryExpansionSpec.Condition condition = 1;</code>
     */
    protected $condition = 0;
    /**
     * Whether to pin unexpanded results. The default value is false. If this
     * field is set to true,
     * unexpanded products are always at the top of the search results, followed
     * by the expanded results.
     *
     * Generated from protobuf field <code>bool pin_unexpanded_results = 2;</code>
     */
    protected $pin_unexpanded_results = false;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $condition
     *           The condition under which query expansion should occur. Default to
     *           [Condition.DISABLED][google.cloud.retail.v2.SearchRequest.QueryExpansionSpec.Condition.DISABLED].
     *     @type bool $pin_unexpanded_results
     *           Whether to pin unexpanded results. The default value is false. If this
     *           field is set to true,
     *           unexpanded products are always at the top of the search results, followed
     *           by the expanded results.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Retail\V2\SearchService::initOnce();
        parent::__construct($data);
    }

    /**
     * The condition under which query expansion should occur. Default to
     * [Condition.DISABLED][google.cloud.retail.v2.SearchRequest.QueryExpansionSpec.Condition.DISABLED].
     *
     * Generated from protobuf field <code>.google.cloud.retail.v2.SearchRequest.QueryExpansionSpec.Condition condition = 1;</code>
     * @return int
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * The condition under which query expansion should occur. Default to
     * [Condition.DISABLED][google.cloud.retail.v2.SearchRequest.QueryExpansionSpec.Condition.DISABLED].
     *
     * Generated from protobuf field <code>.google.cloud.retail.v2.SearchRequest.QueryExpansionSpec.Condition condition = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setCondition($var)
    {
        GPBUtil::checkEnum($var, \Google\Cloud\Retail\V2\SearchRequest\QueryExpansionSpec\Condition::class);
        $this->condition = $var;

        return $this;
    }

    /**
     * Whether to pin unexpanded results. The default value is false. If this
     * field is set to true,
     * unexpanded products are always at the top of the search results, followed
     * by the expanded results.
     *
     * Generated from protobuf field <code>bool pin_unexpanded_results = 2;</code>
     * @return bool
     */
    public function getPinUnexpandedResults()
    {
        return $this->pin_unexpanded_results;
    }

    /**
     * Whether to pin unexpanded results. The default value is false. If this
     * field is set to true,
     * unexpanded products are always at the top of the search results, followed
     * by the expanded results.
     *
     * Generated from protobuf field <code>bool pin_unexpanded_results = 2;</code>
     * @param bool $var
     * @return $this
     */
    public function setPinUnexpandedResults($var)
    {
        GPBUtil::checkBool($var);
        $this->pin_unexpanded_results = $var;

        return $this;
    }

}


