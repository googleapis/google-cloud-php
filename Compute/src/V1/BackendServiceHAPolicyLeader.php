<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/compute/v1/compute.proto

namespace Google\Cloud\Compute\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *
 * Generated from protobuf message <code>google.cloud.compute.v1.BackendServiceHAPolicyLeader</code>
 */
class BackendServiceHAPolicyLeader extends \Google\Protobuf\Internal\Message
{
    /**
     * A fully-qualified URL (starting with https://www.googleapis.com/) of the zonal Network Endpoint Group (NEG) with `GCE_VM_IP` endpoints that the leader is attached to. The leader's backendGroup must already be specified as a backend of this backend service. Removing a backend that is designated as the leader's backendGroup is not permitted.
     *
     * Generated from protobuf field <code>optional string backend_group = 457777428;</code>
     */
    private $backend_group = null;
    /**
     * The network endpoint within the leader.backendGroup that is designated as the leader. This network endpoint cannot be detached from the NEG specified in the haPolicy.leader.backendGroup until the leader is updated with another network endpoint, or the leader is removed from the haPolicy.
     *
     * Generated from protobuf field <code>optional .google.cloud.compute.v1.BackendServiceHAPolicyLeaderNetworkEndpoint network_endpoint = 56789126;</code>
     */
    private $network_endpoint = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $backend_group
     *           A fully-qualified URL (starting with https://www.googleapis.com/) of the zonal Network Endpoint Group (NEG) with `GCE_VM_IP` endpoints that the leader is attached to. The leader's backendGroup must already be specified as a backend of this backend service. Removing a backend that is designated as the leader's backendGroup is not permitted.
     *     @type \Google\Cloud\Compute\V1\BackendServiceHAPolicyLeaderNetworkEndpoint $network_endpoint
     *           The network endpoint within the leader.backendGroup that is designated as the leader. This network endpoint cannot be detached from the NEG specified in the haPolicy.leader.backendGroup until the leader is updated with another network endpoint, or the leader is removed from the haPolicy.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Compute\V1\Compute::initOnce();
        parent::__construct($data);
    }

    /**
     * A fully-qualified URL (starting with https://www.googleapis.com/) of the zonal Network Endpoint Group (NEG) with `GCE_VM_IP` endpoints that the leader is attached to. The leader's backendGroup must already be specified as a backend of this backend service. Removing a backend that is designated as the leader's backendGroup is not permitted.
     *
     * Generated from protobuf field <code>optional string backend_group = 457777428;</code>
     * @return string
     */
    public function getBackendGroup()
    {
        return isset($this->backend_group) ? $this->backend_group : '';
    }

    public function hasBackendGroup()
    {
        return isset($this->backend_group);
    }

    public function clearBackendGroup()
    {
        unset($this->backend_group);
    }

    /**
     * A fully-qualified URL (starting with https://www.googleapis.com/) of the zonal Network Endpoint Group (NEG) with `GCE_VM_IP` endpoints that the leader is attached to. The leader's backendGroup must already be specified as a backend of this backend service. Removing a backend that is designated as the leader's backendGroup is not permitted.
     *
     * Generated from protobuf field <code>optional string backend_group = 457777428;</code>
     * @param string $var
     * @return $this
     */
    public function setBackendGroup($var)
    {
        GPBUtil::checkString($var, True);
        $this->backend_group = $var;

        return $this;
    }

    /**
     * The network endpoint within the leader.backendGroup that is designated as the leader. This network endpoint cannot be detached from the NEG specified in the haPolicy.leader.backendGroup until the leader is updated with another network endpoint, or the leader is removed from the haPolicy.
     *
     * Generated from protobuf field <code>optional .google.cloud.compute.v1.BackendServiceHAPolicyLeaderNetworkEndpoint network_endpoint = 56789126;</code>
     * @return \Google\Cloud\Compute\V1\BackendServiceHAPolicyLeaderNetworkEndpoint|null
     */
    public function getNetworkEndpoint()
    {
        return $this->network_endpoint;
    }

    public function hasNetworkEndpoint()
    {
        return isset($this->network_endpoint);
    }

    public function clearNetworkEndpoint()
    {
        unset($this->network_endpoint);
    }

    /**
     * The network endpoint within the leader.backendGroup that is designated as the leader. This network endpoint cannot be detached from the NEG specified in the haPolicy.leader.backendGroup until the leader is updated with another network endpoint, or the leader is removed from the haPolicy.
     *
     * Generated from protobuf field <code>optional .google.cloud.compute.v1.BackendServiceHAPolicyLeaderNetworkEndpoint network_endpoint = 56789126;</code>
     * @param \Google\Cloud\Compute\V1\BackendServiceHAPolicyLeaderNetworkEndpoint $var
     * @return $this
     */
    public function setNetworkEndpoint($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Compute\V1\BackendServiceHAPolicyLeaderNetworkEndpoint::class);
        $this->network_endpoint = $var;

        return $this;
    }

}

