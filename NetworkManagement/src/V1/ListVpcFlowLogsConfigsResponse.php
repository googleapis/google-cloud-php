<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/networkmanagement/v1/vpc_flow_logs.proto

namespace Google\Cloud\NetworkManagement\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Response for the `ListVpcFlowLogsConfigs` method.
 *
 * Generated from protobuf message <code>google.cloud.networkmanagement.v1.ListVpcFlowLogsConfigsResponse</code>
 */
class ListVpcFlowLogsConfigsResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * List of VPC Flow Log configurations.
     *
     * Generated from protobuf field <code>repeated .google.cloud.networkmanagement.v1.VpcFlowLogsConfig vpc_flow_logs_configs = 1;</code>
     */
    private $vpc_flow_logs_configs;
    /**
     * Page token to fetch the next set of configurations.
     *
     * Generated from protobuf field <code>string next_page_token = 2;</code>
     */
    protected $next_page_token = '';
    /**
     * Locations that could not be reached (when querying all locations with `-`).
     *
     * Generated from protobuf field <code>repeated string unreachable = 3;</code>
     */
    private $unreachable;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<\Google\Cloud\NetworkManagement\V1\VpcFlowLogsConfig>|\Google\Protobuf\Internal\RepeatedField $vpc_flow_logs_configs
     *           List of VPC Flow Log configurations.
     *     @type string $next_page_token
     *           Page token to fetch the next set of configurations.
     *     @type array<string>|\Google\Protobuf\Internal\RepeatedField $unreachable
     *           Locations that could not be reached (when querying all locations with `-`).
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Networkmanagement\V1\VpcFlowLogs::initOnce();
        parent::__construct($data);
    }

    /**
     * List of VPC Flow Log configurations.
     *
     * Generated from protobuf field <code>repeated .google.cloud.networkmanagement.v1.VpcFlowLogsConfig vpc_flow_logs_configs = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getVpcFlowLogsConfigs()
    {
        return $this->vpc_flow_logs_configs;
    }

    /**
     * List of VPC Flow Log configurations.
     *
     * Generated from protobuf field <code>repeated .google.cloud.networkmanagement.v1.VpcFlowLogsConfig vpc_flow_logs_configs = 1;</code>
     * @param array<\Google\Cloud\NetworkManagement\V1\VpcFlowLogsConfig>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setVpcFlowLogsConfigs($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\NetworkManagement\V1\VpcFlowLogsConfig::class);
        $this->vpc_flow_logs_configs = $arr;

        return $this;
    }

    /**
     * Page token to fetch the next set of configurations.
     *
     * Generated from protobuf field <code>string next_page_token = 2;</code>
     * @return string
     */
    public function getNextPageToken()
    {
        return $this->next_page_token;
    }

    /**
     * Page token to fetch the next set of configurations.
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

    /**
     * Locations that could not be reached (when querying all locations with `-`).
     *
     * Generated from protobuf field <code>repeated string unreachable = 3;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getUnreachable()
    {
        return $this->unreachable;
    }

    /**
     * Locations that could not be reached (when querying all locations with `-`).
     *
     * Generated from protobuf field <code>repeated string unreachable = 3;</code>
     * @param array<string>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setUnreachable($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->unreachable = $arr;

        return $this;
    }

}

