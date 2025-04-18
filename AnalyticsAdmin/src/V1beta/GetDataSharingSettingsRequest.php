<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/admin/v1beta/analytics_admin.proto

namespace Google\Analytics\Admin\V1beta;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request message for GetDataSharingSettings RPC.
 *
 * Generated from protobuf message <code>google.analytics.admin.v1beta.GetDataSharingSettingsRequest</code>
 */
class GetDataSharingSettingsRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The name of the settings to lookup.
     * Format: accounts/{account}/dataSharingSettings
     * Example: `accounts/1000/dataSharingSettings`
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $name = '';

    /**
     * @param string $name Required. The name of the settings to lookup.
     *                     Format: accounts/{account}/dataSharingSettings
     *
     *                     Example: `accounts/1000/dataSharingSettings`
     *                     Please see {@see AnalyticsAdminServiceClient::dataSharingSettingsName()} for help formatting this field.
     *
     * @return \Google\Analytics\Admin\V1beta\GetDataSharingSettingsRequest
     *
     * @experimental
     */
    public static function build(string $name): self
    {
        return (new self())
            ->setName($name);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           Required. The name of the settings to lookup.
     *           Format: accounts/{account}/dataSharingSettings
     *           Example: `accounts/1000/dataSharingSettings`
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Analytics\Admin\V1Beta\AnalyticsAdmin::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The name of the settings to lookup.
     * Format: accounts/{account}/dataSharingSettings
     * Example: `accounts/1000/dataSharingSettings`
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Required. The name of the settings to lookup.
     * Format: accounts/{account}/dataSharingSettings
     * Example: `accounts/1000/dataSharingSettings`
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

}

