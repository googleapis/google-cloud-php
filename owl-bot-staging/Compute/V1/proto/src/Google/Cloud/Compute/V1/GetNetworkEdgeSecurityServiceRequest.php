<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/compute/v1/compute.proto

namespace Google\Cloud\Compute\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A request message for NetworkEdgeSecurityServices.Get. See the method description for details.
 *
 * Generated from protobuf message <code>google.cloud.compute.v1.GetNetworkEdgeSecurityServiceRequest</code>
 */
class GetNetworkEdgeSecurityServiceRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Name of the network edge security service to get.
     *
     * Generated from protobuf field <code>string network_edge_security_service = 157011879 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $network_edge_security_service = '';
    /**
     * Project ID for this request.
     *
     * Generated from protobuf field <code>string project = 227560217 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $project = '';
    /**
     * Name of the region scoping this request.
     *
     * Generated from protobuf field <code>string region = 138946292 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $region = '';

    /**
     * @param string $project                    Project ID for this request.
     * @param string $region                     Name of the region scoping this request.
     * @param string $networkEdgeSecurityService Name of the network edge security service to get.
     *
     * @return \Google\Cloud\Compute\V1\GetNetworkEdgeSecurityServiceRequest
     *
     * @experimental
     */
    public static function build(string $project, string $region, string $networkEdgeSecurityService): self
    {
        return (new self())
            ->setProject($project)
            ->setRegion($region)
            ->setNetworkEdgeSecurityService($networkEdgeSecurityService);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $network_edge_security_service
     *           Name of the network edge security service to get.
     *     @type string $project
     *           Project ID for this request.
     *     @type string $region
     *           Name of the region scoping this request.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Compute\V1\Compute::initOnce();
        parent::__construct($data);
    }

    /**
     * Name of the network edge security service to get.
     *
     * Generated from protobuf field <code>string network_edge_security_service = 157011879 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getNetworkEdgeSecurityService()
    {
        return $this->network_edge_security_service;
    }

    /**
     * Name of the network edge security service to get.
     *
     * Generated from protobuf field <code>string network_edge_security_service = 157011879 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setNetworkEdgeSecurityService($var)
    {
        GPBUtil::checkString($var, True);
        $this->network_edge_security_service = $var;

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

    /**
     * Name of the region scoping this request.
     *
     * Generated from protobuf field <code>string region = 138946292 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Name of the region scoping this request.
     *
     * Generated from protobuf field <code>string region = 138946292 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setRegion($var)
    {
        GPBUtil::checkString($var, True);
        $this->region = $var;

        return $this;
    }

}
