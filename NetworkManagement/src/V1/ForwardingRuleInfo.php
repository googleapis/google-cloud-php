<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/networkmanagement/v1/trace.proto

namespace Google\Cloud\NetworkManagement\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * For display only. Metadata associated with a Compute Engine forwarding rule.
 *
 * Generated from protobuf message <code>google.cloud.networkmanagement.v1.ForwardingRuleInfo</code>
 */
class ForwardingRuleInfo extends \Google\Protobuf\Internal\Message
{
    /**
     * Name of the forwarding rule.
     *
     * Generated from protobuf field <code>string display_name = 1;</code>
     */
    protected $display_name = '';
    /**
     * URI of the forwarding rule.
     *
     * Generated from protobuf field <code>string uri = 2;</code>
     */
    protected $uri = '';
    /**
     * Protocol defined in the forwarding rule that matches the packet.
     *
     * Generated from protobuf field <code>string matched_protocol = 3;</code>
     */
    protected $matched_protocol = '';
    /**
     * Port range defined in the forwarding rule that matches the packet.
     *
     * Generated from protobuf field <code>string matched_port_range = 6;</code>
     */
    protected $matched_port_range = '';
    /**
     * VIP of the forwarding rule.
     *
     * Generated from protobuf field <code>string vip = 4;</code>
     */
    protected $vip = '';
    /**
     * Target type of the forwarding rule.
     *
     * Generated from protobuf field <code>string target = 5;</code>
     */
    protected $target = '';
    /**
     * Network URI.
     *
     * Generated from protobuf field <code>string network_uri = 7;</code>
     */
    protected $network_uri = '';
    /**
     * Region of the forwarding rule. Set only for regional forwarding rules.
     *
     * Generated from protobuf field <code>string region = 8;</code>
     */
    protected $region = '';
    /**
     * Name of the load balancer the forwarding rule belongs to. Empty for
     * forwarding rules not related to load balancers (like PSC forwarding rules).
     *
     * Generated from protobuf field <code>string load_balancer_name = 9;</code>
     */
    protected $load_balancer_name = '';
    /**
     * URI of the PSC service attachment this forwarding rule targets (if
     * applicable).
     *
     * Generated from protobuf field <code>string psc_service_attachment_uri = 10;</code>
     */
    protected $psc_service_attachment_uri = '';
    /**
     * PSC Google API target this forwarding rule targets (if applicable).
     *
     * Generated from protobuf field <code>string psc_google_api_target = 11;</code>
     */
    protected $psc_google_api_target = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $display_name
     *           Name of the forwarding rule.
     *     @type string $uri
     *           URI of the forwarding rule.
     *     @type string $matched_protocol
     *           Protocol defined in the forwarding rule that matches the packet.
     *     @type string $matched_port_range
     *           Port range defined in the forwarding rule that matches the packet.
     *     @type string $vip
     *           VIP of the forwarding rule.
     *     @type string $target
     *           Target type of the forwarding rule.
     *     @type string $network_uri
     *           Network URI.
     *     @type string $region
     *           Region of the forwarding rule. Set only for regional forwarding rules.
     *     @type string $load_balancer_name
     *           Name of the load balancer the forwarding rule belongs to. Empty for
     *           forwarding rules not related to load balancers (like PSC forwarding rules).
     *     @type string $psc_service_attachment_uri
     *           URI of the PSC service attachment this forwarding rule targets (if
     *           applicable).
     *     @type string $psc_google_api_target
     *           PSC Google API target this forwarding rule targets (if applicable).
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Networkmanagement\V1\Trace::initOnce();
        parent::__construct($data);
    }

    /**
     * Name of the forwarding rule.
     *
     * Generated from protobuf field <code>string display_name = 1;</code>
     * @return string
     */
    public function getDisplayName()
    {
        return $this->display_name;
    }

    /**
     * Name of the forwarding rule.
     *
     * Generated from protobuf field <code>string display_name = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setDisplayName($var)
    {
        GPBUtil::checkString($var, True);
        $this->display_name = $var;

        return $this;
    }

    /**
     * URI of the forwarding rule.
     *
     * Generated from protobuf field <code>string uri = 2;</code>
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * URI of the forwarding rule.
     *
     * Generated from protobuf field <code>string uri = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setUri($var)
    {
        GPBUtil::checkString($var, True);
        $this->uri = $var;

        return $this;
    }

    /**
     * Protocol defined in the forwarding rule that matches the packet.
     *
     * Generated from protobuf field <code>string matched_protocol = 3;</code>
     * @return string
     */
    public function getMatchedProtocol()
    {
        return $this->matched_protocol;
    }

    /**
     * Protocol defined in the forwarding rule that matches the packet.
     *
     * Generated from protobuf field <code>string matched_protocol = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setMatchedProtocol($var)
    {
        GPBUtil::checkString($var, True);
        $this->matched_protocol = $var;

        return $this;
    }

    /**
     * Port range defined in the forwarding rule that matches the packet.
     *
     * Generated from protobuf field <code>string matched_port_range = 6;</code>
     * @return string
     */
    public function getMatchedPortRange()
    {
        return $this->matched_port_range;
    }

    /**
     * Port range defined in the forwarding rule that matches the packet.
     *
     * Generated from protobuf field <code>string matched_port_range = 6;</code>
     * @param string $var
     * @return $this
     */
    public function setMatchedPortRange($var)
    {
        GPBUtil::checkString($var, True);
        $this->matched_port_range = $var;

        return $this;
    }

    /**
     * VIP of the forwarding rule.
     *
     * Generated from protobuf field <code>string vip = 4;</code>
     * @return string
     */
    public function getVip()
    {
        return $this->vip;
    }

    /**
     * VIP of the forwarding rule.
     *
     * Generated from protobuf field <code>string vip = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setVip($var)
    {
        GPBUtil::checkString($var, True);
        $this->vip = $var;

        return $this;
    }

    /**
     * Target type of the forwarding rule.
     *
     * Generated from protobuf field <code>string target = 5;</code>
     * @return string
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Target type of the forwarding rule.
     *
     * Generated from protobuf field <code>string target = 5;</code>
     * @param string $var
     * @return $this
     */
    public function setTarget($var)
    {
        GPBUtil::checkString($var, True);
        $this->target = $var;

        return $this;
    }

    /**
     * Network URI.
     *
     * Generated from protobuf field <code>string network_uri = 7;</code>
     * @return string
     */
    public function getNetworkUri()
    {
        return $this->network_uri;
    }

    /**
     * Network URI.
     *
     * Generated from protobuf field <code>string network_uri = 7;</code>
     * @param string $var
     * @return $this
     */
    public function setNetworkUri($var)
    {
        GPBUtil::checkString($var, True);
        $this->network_uri = $var;

        return $this;
    }

    /**
     * Region of the forwarding rule. Set only for regional forwarding rules.
     *
     * Generated from protobuf field <code>string region = 8;</code>
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Region of the forwarding rule. Set only for regional forwarding rules.
     *
     * Generated from protobuf field <code>string region = 8;</code>
     * @param string $var
     * @return $this
     */
    public function setRegion($var)
    {
        GPBUtil::checkString($var, True);
        $this->region = $var;

        return $this;
    }

    /**
     * Name of the load balancer the forwarding rule belongs to. Empty for
     * forwarding rules not related to load balancers (like PSC forwarding rules).
     *
     * Generated from protobuf field <code>string load_balancer_name = 9;</code>
     * @return string
     */
    public function getLoadBalancerName()
    {
        return $this->load_balancer_name;
    }

    /**
     * Name of the load balancer the forwarding rule belongs to. Empty for
     * forwarding rules not related to load balancers (like PSC forwarding rules).
     *
     * Generated from protobuf field <code>string load_balancer_name = 9;</code>
     * @param string $var
     * @return $this
     */
    public function setLoadBalancerName($var)
    {
        GPBUtil::checkString($var, True);
        $this->load_balancer_name = $var;

        return $this;
    }

    /**
     * URI of the PSC service attachment this forwarding rule targets (if
     * applicable).
     *
     * Generated from protobuf field <code>string psc_service_attachment_uri = 10;</code>
     * @return string
     */
    public function getPscServiceAttachmentUri()
    {
        return $this->psc_service_attachment_uri;
    }

    /**
     * URI of the PSC service attachment this forwarding rule targets (if
     * applicable).
     *
     * Generated from protobuf field <code>string psc_service_attachment_uri = 10;</code>
     * @param string $var
     * @return $this
     */
    public function setPscServiceAttachmentUri($var)
    {
        GPBUtil::checkString($var, True);
        $this->psc_service_attachment_uri = $var;

        return $this;
    }

    /**
     * PSC Google API target this forwarding rule targets (if applicable).
     *
     * Generated from protobuf field <code>string psc_google_api_target = 11;</code>
     * @return string
     */
    public function getPscGoogleApiTarget()
    {
        return $this->psc_google_api_target;
    }

    /**
     * PSC Google API target this forwarding rule targets (if applicable).
     *
     * Generated from protobuf field <code>string psc_google_api_target = 11;</code>
     * @param string $var
     * @return $this
     */
    public function setPscGoogleApiTarget($var)
    {
        GPBUtil::checkString($var, True);
        $this->psc_google_api_target = $var;

        return $this;
    }

}

