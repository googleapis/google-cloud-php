<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/compute/v1/compute.proto

namespace Google\Cloud\Compute\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A request message for RegionNetworkFirewallPolicies.CloneRules. See the method description for details.
 *
 * Generated from protobuf message <code>google.cloud.compute.v1.CloneRulesRegionNetworkFirewallPolicyRequest</code>
 */
class CloneRulesRegionNetworkFirewallPolicyRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Name of the firewall policy to update.
     *
     * Generated from protobuf field <code>string firewall_policy = 498173265 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $firewall_policy = '';
    /**
     * Project ID for this request.
     *
     * Generated from protobuf field <code>string project = 227560217 [(.google.api.field_behavior) = REQUIRED, (.google.cloud.operation_request_field) = "project"];</code>
     */
    protected $project = '';
    /**
     * Name of the region scoping this request.
     *
     * Generated from protobuf field <code>string region = 138946292 [(.google.api.field_behavior) = REQUIRED, (.google.cloud.operation_request_field) = "region"];</code>
     */
    protected $region = '';
    /**
     * An optional request ID to identify requests. Specify a unique request ID so that if you must retry your request, the server will know to ignore the request if it has already been completed. For example, consider a situation where you make an initial request and the request times out. If you make the request again with the same request ID, the server can check if original operation with the same request ID was received, and if so, will ignore the second request. This prevents clients from accidentally creating duplicate commitments. The request ID must be a valid UUID with the exception that zero UUID is not supported ( 00000000-0000-0000-0000-000000000000).
     *
     * Generated from protobuf field <code>optional string request_id = 37109963;</code>
     */
    protected $request_id = null;
    /**
     * The firewall policy from which to copy rules.
     *
     * Generated from protobuf field <code>optional string source_firewall_policy = 25013549;</code>
     */
    protected $source_firewall_policy = null;

    /**
     * @param string $project        Project ID for this request.
     * @param string $region         Name of the region scoping this request.
     * @param string $firewallPolicy Name of the firewall policy to update.
     *
     * @return \Google\Cloud\Compute\V1\CloneRulesRegionNetworkFirewallPolicyRequest
     *
     * @experimental
     */
    public static function build(string $project, string $region, string $firewallPolicy): self
    {
        return (new self())
            ->setProject($project)
            ->setRegion($region)
            ->setFirewallPolicy($firewallPolicy);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $firewall_policy
     *           Name of the firewall policy to update.
     *     @type string $project
     *           Project ID for this request.
     *     @type string $region
     *           Name of the region scoping this request.
     *     @type string $request_id
     *           An optional request ID to identify requests. Specify a unique request ID so that if you must retry your request, the server will know to ignore the request if it has already been completed. For example, consider a situation where you make an initial request and the request times out. If you make the request again with the same request ID, the server can check if original operation with the same request ID was received, and if so, will ignore the second request. This prevents clients from accidentally creating duplicate commitments. The request ID must be a valid UUID with the exception that zero UUID is not supported ( 00000000-0000-0000-0000-000000000000).
     *     @type string $source_firewall_policy
     *           The firewall policy from which to copy rules.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Compute\V1\Compute::initOnce();
        parent::__construct($data);
    }

    /**
     * Name of the firewall policy to update.
     *
     * Generated from protobuf field <code>string firewall_policy = 498173265 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getFirewallPolicy()
    {
        return $this->firewall_policy;
    }

    /**
     * Name of the firewall policy to update.
     *
     * Generated from protobuf field <code>string firewall_policy = 498173265 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setFirewallPolicy($var)
    {
        GPBUtil::checkString($var, True);
        $this->firewall_policy = $var;

        return $this;
    }

    /**
     * Project ID for this request.
     *
     * Generated from protobuf field <code>string project = 227560217 [(.google.api.field_behavior) = REQUIRED, (.google.cloud.operation_request_field) = "project"];</code>
     * @return string
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Project ID for this request.
     *
     * Generated from protobuf field <code>string project = 227560217 [(.google.api.field_behavior) = REQUIRED, (.google.cloud.operation_request_field) = "project"];</code>
     * @param string $var
     * @return $this
     */
    public function setProject($var)
    {
        GPBUtil::checkString($var, True);
        $this->project = $var;

        return $this;
    }

    /**
     * Name of the region scoping this request.
     *
     * Generated from protobuf field <code>string region = 138946292 [(.google.api.field_behavior) = REQUIRED, (.google.cloud.operation_request_field) = "region"];</code>
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Name of the region scoping this request.
     *
     * Generated from protobuf field <code>string region = 138946292 [(.google.api.field_behavior) = REQUIRED, (.google.cloud.operation_request_field) = "region"];</code>
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
     * An optional request ID to identify requests. Specify a unique request ID so that if you must retry your request, the server will know to ignore the request if it has already been completed. For example, consider a situation where you make an initial request and the request times out. If you make the request again with the same request ID, the server can check if original operation with the same request ID was received, and if so, will ignore the second request. This prevents clients from accidentally creating duplicate commitments. The request ID must be a valid UUID with the exception that zero UUID is not supported ( 00000000-0000-0000-0000-000000000000).
     *
     * Generated from protobuf field <code>optional string request_id = 37109963;</code>
     * @return string
     */
    public function getRequestId()
    {
        return isset($this->request_id) ? $this->request_id : '';
    }

    public function hasRequestId()
    {
        return isset($this->request_id);
    }

    public function clearRequestId()
    {
        unset($this->request_id);
    }

    /**
     * An optional request ID to identify requests. Specify a unique request ID so that if you must retry your request, the server will know to ignore the request if it has already been completed. For example, consider a situation where you make an initial request and the request times out. If you make the request again with the same request ID, the server can check if original operation with the same request ID was received, and if so, will ignore the second request. This prevents clients from accidentally creating duplicate commitments. The request ID must be a valid UUID with the exception that zero UUID is not supported ( 00000000-0000-0000-0000-000000000000).
     *
     * Generated from protobuf field <code>optional string request_id = 37109963;</code>
     * @param string $var
     * @return $this
     */
    public function setRequestId($var)
    {
        GPBUtil::checkString($var, True);
        $this->request_id = $var;

        return $this;
    }

    /**
     * The firewall policy from which to copy rules.
     *
     * Generated from protobuf field <code>optional string source_firewall_policy = 25013549;</code>
     * @return string
     */
    public function getSourceFirewallPolicy()
    {
        return isset($this->source_firewall_policy) ? $this->source_firewall_policy : '';
    }

    public function hasSourceFirewallPolicy()
    {
        return isset($this->source_firewall_policy);
    }

    public function clearSourceFirewallPolicy()
    {
        unset($this->source_firewall_policy);
    }

    /**
     * The firewall policy from which to copy rules.
     *
     * Generated from protobuf field <code>optional string source_firewall_policy = 25013549;</code>
     * @param string $var
     * @return $this
     */
    public function setSourceFirewallPolicy($var)
    {
        GPBUtil::checkString($var, True);
        $this->source_firewall_policy = $var;

        return $this;
    }

}
