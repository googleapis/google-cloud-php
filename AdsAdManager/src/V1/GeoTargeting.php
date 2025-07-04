<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/ads/admanager/v1/targeting.proto

namespace Google\Ads\AdManager\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Represents a list of targeted and excluded geos.
 *
 * Generated from protobuf message <code>google.ads.admanager.v1.GeoTargeting</code>
 */
class GeoTargeting extends \Google\Protobuf\Internal\Message
{
    /**
     * Optional. A list of geo resource names that should be targeted/included.
     *
     * Generated from protobuf field <code>repeated string targeted_geos = 3 [(.google.api.field_behavior) = OPTIONAL, (.google.api.resource_reference) = {</code>
     */
    private $targeted_geos;
    /**
     * Optional. A list of geo resource names that should be excluded.
     *
     * Generated from protobuf field <code>repeated string excluded_geos = 4 [(.google.api.field_behavior) = OPTIONAL, (.google.api.resource_reference) = {</code>
     */
    private $excluded_geos;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<string>|\Google\Protobuf\Internal\RepeatedField $targeted_geos
     *           Optional. A list of geo resource names that should be targeted/included.
     *     @type array<string>|\Google\Protobuf\Internal\RepeatedField $excluded_geos
     *           Optional. A list of geo resource names that should be excluded.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Ads\Admanager\V1\Targeting::initOnce();
        parent::__construct($data);
    }

    /**
     * Optional. A list of geo resource names that should be targeted/included.
     *
     * Generated from protobuf field <code>repeated string targeted_geos = 3 [(.google.api.field_behavior) = OPTIONAL, (.google.api.resource_reference) = {</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getTargetedGeos()
    {
        return $this->targeted_geos;
    }

    /**
     * Optional. A list of geo resource names that should be targeted/included.
     *
     * Generated from protobuf field <code>repeated string targeted_geos = 3 [(.google.api.field_behavior) = OPTIONAL, (.google.api.resource_reference) = {</code>
     * @param array<string>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setTargetedGeos($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->targeted_geos = $arr;

        return $this;
    }

    /**
     * Optional. A list of geo resource names that should be excluded.
     *
     * Generated from protobuf field <code>repeated string excluded_geos = 4 [(.google.api.field_behavior) = OPTIONAL, (.google.api.resource_reference) = {</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getExcludedGeos()
    {
        return $this->excluded_geos;
    }

    /**
     * Optional. A list of geo resource names that should be excluded.
     *
     * Generated from protobuf field <code>repeated string excluded_geos = 4 [(.google.api.field_behavior) = OPTIONAL, (.google.api.resource_reference) = {</code>
     * @param array<string>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setExcludedGeos($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->excluded_geos = $arr;

        return $this;
    }

}

