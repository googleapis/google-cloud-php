<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/retail/v2/completion_service.proto

namespace Google\Cloud\Retail\V2\CompleteQueryResponse;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Deprecated: Recent search of this user.
 *
 * @deprecated
 * Generated from protobuf message <code>google.cloud.retail.v2.CompleteQueryResponse.RecentSearchResult</code>
 */
class RecentSearchResult extends \Google\Protobuf\Internal\Message
{
    /**
     * The recent search query.
     *
     * Generated from protobuf field <code>string recent_search = 1;</code>
     */
    protected $recent_search = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $recent_search
     *           The recent search query.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Retail\V2\CompletionService::initOnce();
        parent::__construct($data);
    }

    /**
     * The recent search query.
     *
     * Generated from protobuf field <code>string recent_search = 1;</code>
     * @return string
     */
    public function getRecentSearch()
    {
        return $this->recent_search;
    }

    /**
     * The recent search query.
     *
     * Generated from protobuf field <code>string recent_search = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setRecentSearch($var)
    {
        GPBUtil::checkString($var, True);
        $this->recent_search = $var;

        return $this;
    }

}


