<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/compute/v1/compute.proto

namespace Google\Cloud\Compute\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Represents the physical host topology of the host on which the VM is running.
 *
 * Generated from protobuf message <code>google.cloud.compute.v1.ResourceStatusPhysicalHostTopology</code>
 */
class ResourceStatusPhysicalHostTopology extends \Google\Protobuf\Internal\Message
{
    /**
     * [Output Only] The ID of the block in which the running instance is located. Instances within the same block experience low network latency.
     *
     * Generated from protobuf field <code>optional string block = 93832333;</code>
     */
    private $block = null;
    /**
     * [Output Only] The global name of the Compute Engine cluster where the running instance is located.
     *
     * Generated from protobuf field <code>optional string cluster = 335221242;</code>
     */
    private $cluster = null;
    /**
     * [Output Only] The ID of the host on which the running instance is located. Instances on the same host experience the lowest possible network latency.
     *
     * Generated from protobuf field <code>optional string host = 3208616;</code>
     */
    private $host = null;
    /**
     * [Output Only] The ID of the sub-block in which the running instance is located. Instances in the same sub-block experience lower network latency than instances in the same block.
     *
     * Generated from protobuf field <code>optional string subblock = 70446669;</code>
     */
    private $subblock = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $block
     *           [Output Only] The ID of the block in which the running instance is located. Instances within the same block experience low network latency.
     *     @type string $cluster
     *           [Output Only] The global name of the Compute Engine cluster where the running instance is located.
     *     @type string $host
     *           [Output Only] The ID of the host on which the running instance is located. Instances on the same host experience the lowest possible network latency.
     *     @type string $subblock
     *           [Output Only] The ID of the sub-block in which the running instance is located. Instances in the same sub-block experience lower network latency than instances in the same block.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Compute\V1\Compute::initOnce();
        parent::__construct($data);
    }

    /**
     * [Output Only] The ID of the block in which the running instance is located. Instances within the same block experience low network latency.
     *
     * Generated from protobuf field <code>optional string block = 93832333;</code>
     * @return string
     */
    public function getBlock()
    {
        return isset($this->block) ? $this->block : '';
    }

    public function hasBlock()
    {
        return isset($this->block);
    }

    public function clearBlock()
    {
        unset($this->block);
    }

    /**
     * [Output Only] The ID of the block in which the running instance is located. Instances within the same block experience low network latency.
     *
     * Generated from protobuf field <code>optional string block = 93832333;</code>
     * @param string $var
     * @return $this
     */
    public function setBlock($var)
    {
        GPBUtil::checkString($var, True);
        $this->block = $var;

        return $this;
    }

    /**
     * [Output Only] The global name of the Compute Engine cluster where the running instance is located.
     *
     * Generated from protobuf field <code>optional string cluster = 335221242;</code>
     * @return string
     */
    public function getCluster()
    {
        return isset($this->cluster) ? $this->cluster : '';
    }

    public function hasCluster()
    {
        return isset($this->cluster);
    }

    public function clearCluster()
    {
        unset($this->cluster);
    }

    /**
     * [Output Only] The global name of the Compute Engine cluster where the running instance is located.
     *
     * Generated from protobuf field <code>optional string cluster = 335221242;</code>
     * @param string $var
     * @return $this
     */
    public function setCluster($var)
    {
        GPBUtil::checkString($var, True);
        $this->cluster = $var;

        return $this;
    }

    /**
     * [Output Only] The ID of the host on which the running instance is located. Instances on the same host experience the lowest possible network latency.
     *
     * Generated from protobuf field <code>optional string host = 3208616;</code>
     * @return string
     */
    public function getHost()
    {
        return isset($this->host) ? $this->host : '';
    }

    public function hasHost()
    {
        return isset($this->host);
    }

    public function clearHost()
    {
        unset($this->host);
    }

    /**
     * [Output Only] The ID of the host on which the running instance is located. Instances on the same host experience the lowest possible network latency.
     *
     * Generated from protobuf field <code>optional string host = 3208616;</code>
     * @param string $var
     * @return $this
     */
    public function setHost($var)
    {
        GPBUtil::checkString($var, True);
        $this->host = $var;

        return $this;
    }

    /**
     * [Output Only] The ID of the sub-block in which the running instance is located. Instances in the same sub-block experience lower network latency than instances in the same block.
     *
     * Generated from protobuf field <code>optional string subblock = 70446669;</code>
     * @return string
     */
    public function getSubblock()
    {
        return isset($this->subblock) ? $this->subblock : '';
    }

    public function hasSubblock()
    {
        return isset($this->subblock);
    }

    public function clearSubblock()
    {
        unset($this->subblock);
    }

    /**
     * [Output Only] The ID of the sub-block in which the running instance is located. Instances in the same sub-block experience lower network latency than instances in the same block.
     *
     * Generated from protobuf field <code>optional string subblock = 70446669;</code>
     * @param string $var
     * @return $this
     */
    public function setSubblock($var)
    {
        GPBUtil::checkString($var, True);
        $this->subblock = $var;

        return $this;
    }

}

