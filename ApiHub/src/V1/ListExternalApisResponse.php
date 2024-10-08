<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/apihub/v1/apihub_service.proto

namespace Google\Cloud\ApiHub\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The [ListExternalApis][google.cloud.apihub.v1.ApiHub.ListExternalApis]
 * method's response.
 *
 * Generated from protobuf message <code>google.cloud.apihub.v1.ListExternalApisResponse</code>
 */
class ListExternalApisResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * The External API resources present in the API hub.
     * Only following fields will be populated in the response: name,
     * display_name, documentation.external_uri.
     *
     * Generated from protobuf field <code>repeated .google.cloud.apihub.v1.ExternalApi external_apis = 1;</code>
     */
    private $external_apis;
    /**
     * A token, which can be sent as `page_token` to retrieve the next page.
     * If this field is omitted, there are no subsequent pages.
     *
     * Generated from protobuf field <code>string next_page_token = 2;</code>
     */
    protected $next_page_token = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<\Google\Cloud\ApiHub\V1\ExternalApi>|\Google\Protobuf\Internal\RepeatedField $external_apis
     *           The External API resources present in the API hub.
     *           Only following fields will be populated in the response: name,
     *           display_name, documentation.external_uri.
     *     @type string $next_page_token
     *           A token, which can be sent as `page_token` to retrieve the next page.
     *           If this field is omitted, there are no subsequent pages.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Apihub\V1\ApihubService::initOnce();
        parent::__construct($data);
    }

    /**
     * The External API resources present in the API hub.
     * Only following fields will be populated in the response: name,
     * display_name, documentation.external_uri.
     *
     * Generated from protobuf field <code>repeated .google.cloud.apihub.v1.ExternalApi external_apis = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getExternalApis()
    {
        return $this->external_apis;
    }

    /**
     * The External API resources present in the API hub.
     * Only following fields will be populated in the response: name,
     * display_name, documentation.external_uri.
     *
     * Generated from protobuf field <code>repeated .google.cloud.apihub.v1.ExternalApi external_apis = 1;</code>
     * @param array<\Google\Cloud\ApiHub\V1\ExternalApi>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setExternalApis($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\ApiHub\V1\ExternalApi::class);
        $this->external_apis = $arr;

        return $this;
    }

    /**
     * A token, which can be sent as `page_token` to retrieve the next page.
     * If this field is omitted, there are no subsequent pages.
     *
     * Generated from protobuf field <code>string next_page_token = 2;</code>
     * @return string
     */
    public function getNextPageToken()
    {
        return $this->next_page_token;
    }

    /**
     * A token, which can be sent as `page_token` to retrieve the next page.
     * If this field is omitted, there are no subsequent pages.
     *
     * Generated from protobuf field <code>string next_page_token = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setNextPageToken($var)
    {
        GPBUtil::checkString($var, True);
        $this->next_page_token = $var;

        return $this;
    }

}

