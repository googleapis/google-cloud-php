<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/securitycenter/v2/ip_rules.proto

namespace Google\Cloud\SecurityCenter\V2;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * IP rule information.
 *
 * Generated from protobuf message <code>google.cloud.securitycenter.v2.IpRule</code>
 */
class IpRule extends \Google\Protobuf\Internal\Message
{
    /**
     * The IP protocol this rule applies to. This value can either be one of the
     * following well known protocol strings (TCP, UDP, ICMP, ESP, AH, IPIP,
     * SCTP) or a string representation of the integer value.
     *
     * Generated from protobuf field <code>string protocol = 1;</code>
     */
    protected $protocol = '';
    /**
     * Optional. An optional list of ports to which this rule applies. This field
     * is only applicable for the UDP or (S)TCP protocols. Each entry must be
     * either an integer or a range including a min and max port number.
     *
     * Generated from protobuf field <code>repeated .google.cloud.securitycenter.v2.IpRule.PortRange port_ranges = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    private $port_ranges;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $protocol
     *           The IP protocol this rule applies to. This value can either be one of the
     *           following well known protocol strings (TCP, UDP, ICMP, ESP, AH, IPIP,
     *           SCTP) or a string representation of the integer value.
     *     @type array<\Google\Cloud\SecurityCenter\V2\IpRule\PortRange>|\Google\Protobuf\Internal\RepeatedField $port_ranges
     *           Optional. An optional list of ports to which this rule applies. This field
     *           is only applicable for the UDP or (S)TCP protocols. Each entry must be
     *           either an integer or a range including a min and max port number.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Securitycenter\V2\IpRules::initOnce();
        parent::__construct($data);
    }

    /**
     * The IP protocol this rule applies to. This value can either be one of the
     * following well known protocol strings (TCP, UDP, ICMP, ESP, AH, IPIP,
     * SCTP) or a string representation of the integer value.
     *
     * Generated from protobuf field <code>string protocol = 1;</code>
     * @return string
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     * The IP protocol this rule applies to. This value can either be one of the
     * following well known protocol strings (TCP, UDP, ICMP, ESP, AH, IPIP,
     * SCTP) or a string representation of the integer value.
     *
     * Generated from protobuf field <code>string protocol = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setProtocol($var)
    {
        GPBUtil::checkString($var, True);
        $this->protocol = $var;

        return $this;
    }

    /**
     * Optional. An optional list of ports to which this rule applies. This field
     * is only applicable for the UDP or (S)TCP protocols. Each entry must be
     * either an integer or a range including a min and max port number.
     *
     * Generated from protobuf field <code>repeated .google.cloud.securitycenter.v2.IpRule.PortRange port_ranges = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getPortRanges()
    {
        return $this->port_ranges;
    }

    /**
     * Optional. An optional list of ports to which this rule applies. This field
     * is only applicable for the UDP or (S)TCP protocols. Each entry must be
     * either an integer or a range including a min and max port number.
     *
     * Generated from protobuf field <code>repeated .google.cloud.securitycenter.v2.IpRule.PortRange port_ranges = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param array<\Google\Cloud\SecurityCenter\V2\IpRule\PortRange>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setPortRanges($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\SecurityCenter\V2\IpRule\PortRange::class);
        $this->port_ranges = $arr;

        return $this;
    }

}

