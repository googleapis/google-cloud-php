<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/compute/v1/compute.proto

namespace Google\Cloud\Compute\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A request message for Firewalls.Get. See the method description for details.
 *
 * Generated from protobuf message <code>google.cloud.compute.v1.GetFirewallRequest</code>
 */
class GetFirewallRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Name of the firewall rule to return.
     *
     * Generated from protobuf field <code>string firewall = 511016192 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $firewall = '';
    /**
     * Project ID for this request.
     *
     * Generated from protobuf field <code>string project = 227560217 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $project = '';

    /**
     * @param string $project  Project ID for this request.
     * @param string $firewall Name of the firewall rule to return.
     *
     * @return \Google\Cloud\Compute\V1\GetFirewallRequest
     *
     * @experimental
     */
    public static function build(string $project, string $firewall): self
    {
        return (new self())
            ->setProject($project)
            ->setFirewall($firewall);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $firewall
     *           Name of the firewall rule to return.
     *     @type string $project
     *           Project ID for this request.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Compute\V1\Compute::initOnce();
        parent::__construct($data);
    }

    /**
     * Name of the firewall rule to return.
     *
     * Generated from protobuf field <code>string firewall = 511016192 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getFirewall()
    {
        return $this->firewall;
    }

    /**
     * Name of the firewall rule to return.
     *
     * Generated from protobuf field <code>string firewall = 511016192 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setFirewall($var)
    {
        GPBUtil::checkString($var, True);
        $this->firewall = $var;

        return $this;
    }

    /**
     * Project ID for this request.
     *
     * Generated from protobuf field <code>string project = 227560217 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Project ID for this request.
     *
     * Generated from protobuf field <code>string project = 227560217 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setProject($var)
    {
        GPBUtil::checkString($var, True);
        $this->project = $var;

        return $this;
    }

}
