<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/container/v1/cluster_service.proto

namespace Google\Cloud\Container\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Eviction signals are the current state of a particular resource at a specific
 * point in time. The kubelet uses eviction signals to make eviction decisions
 * by comparing the signals to eviction thresholds, which are the minimum amount
 * of the resource that should be available on the node.
 *
 * Generated from protobuf message <code>google.container.v1.EvictionSignals</code>
 */
class EvictionSignals extends \Google\Protobuf\Internal\Message
{
    /**
     * Optional. Memory available (i.e. capacity - workingSet), in bytes. Defines
     * the amount of "memory.available" signal in kubelet. Default is unset, if
     * not specified in the kubelet config. Format: positive number + unit, e.g.
     * 100Ki, 10Mi, 5Gi. Valid units are Ki, Mi, Gi. Must be >= 100Mi and <= 50%
     * of the node's memory. See
     * https://kubernetes.io/docs/concepts/scheduling-eviction/node-pressure-eviction/#eviction-signals
     *
     * Generated from protobuf field <code>string memory_available = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $memory_available = '';
    /**
     * Optional. Amount of storage available on filesystem that kubelet uses for
     * volumes, daemon logs, etc. Defines the amount of "nodefs.available" signal
     * in kubelet. Default is unset, if not specified in the kubelet config. It
     * takses percentage value for now. Sample format: "30%". Must be >= 10% and
     * <= 50%. See
     * https://kubernetes.io/docs/concepts/scheduling-eviction/node-pressure-eviction/#eviction-signals
     *
     * Generated from protobuf field <code>string nodefs_available = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $nodefs_available = '';
    /**
     * Optional. Amount of inodes available on filesystem that kubelet uses for
     * volumes, daemon logs, etc. Defines the amount of "nodefs.inodesFree" signal
     * in kubelet. Default is unset, if not specified in the kubelet config. Linux
     * only. It takses percentage value for now. Sample format: "30%". Must be >=
     * 5% and <= 50%. See
     * https://kubernetes.io/docs/concepts/scheduling-eviction/node-pressure-eviction/#eviction-signals
     *
     * Generated from protobuf field <code>string nodefs_inodes_free = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $nodefs_inodes_free = '';
    /**
     * Optional. Amount of storage available on filesystem that container runtime
     * uses for storing images layers. If the container filesystem and image
     * filesystem are not separate, then imagefs can store both image layers and
     * writeable layers. Defines the amount of "imagefs.available" signal in
     * kubelet. Default is unset, if not specified in the kubelet config. It
     * takses percentage value for now. Sample format: "30%". Must be >= 15% and
     * <= 50%. See
     * https://kubernetes.io/docs/concepts/scheduling-eviction/node-pressure-eviction/#eviction-signals
     *
     * Generated from protobuf field <code>string imagefs_available = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $imagefs_available = '';
    /**
     * Optional. Amount of inodes available on filesystem that container runtime
     * uses for storing images layers. Defines the amount of "imagefs.inodesFree"
     * signal in kubelet. Default is unset, if not specified in the kubelet
     * config. Linux only. It takses percentage value for now. Sample format:
     * "30%". Must be >= 5% and <= 50%. See
     * https://kubernetes.io/docs/concepts/scheduling-eviction/node-pressure-eviction/#eviction-signals
     *
     * Generated from protobuf field <code>string imagefs_inodes_free = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $imagefs_inodes_free = '';
    /**
     * Optional. Amount of PID available for pod allocation. Defines the amount of
     * "pid.available" signal in kubelet. Default is unset, if not specified in
     * the kubelet config. It takses percentage value for now. Sample format:
     * "30%". Must be >= 10% and <= 50%. See
     * https://kubernetes.io/docs/concepts/scheduling-eviction/node-pressure-eviction/#eviction-signals
     *
     * Generated from protobuf field <code>string pid_available = 6 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $pid_available = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $memory_available
     *           Optional. Memory available (i.e. capacity - workingSet), in bytes. Defines
     *           the amount of "memory.available" signal in kubelet. Default is unset, if
     *           not specified in the kubelet config. Format: positive number + unit, e.g.
     *           100Ki, 10Mi, 5Gi. Valid units are Ki, Mi, Gi. Must be >= 100Mi and <= 50%
     *           of the node's memory. See
     *           https://kubernetes.io/docs/concepts/scheduling-eviction/node-pressure-eviction/#eviction-signals
     *     @type string $nodefs_available
     *           Optional. Amount of storage available on filesystem that kubelet uses for
     *           volumes, daemon logs, etc. Defines the amount of "nodefs.available" signal
     *           in kubelet. Default is unset, if not specified in the kubelet config. It
     *           takses percentage value for now. Sample format: "30%". Must be >= 10% and
     *           <= 50%. See
     *           https://kubernetes.io/docs/concepts/scheduling-eviction/node-pressure-eviction/#eviction-signals
     *     @type string $nodefs_inodes_free
     *           Optional. Amount of inodes available on filesystem that kubelet uses for
     *           volumes, daemon logs, etc. Defines the amount of "nodefs.inodesFree" signal
     *           in kubelet. Default is unset, if not specified in the kubelet config. Linux
     *           only. It takses percentage value for now. Sample format: "30%". Must be >=
     *           5% and <= 50%. See
     *           https://kubernetes.io/docs/concepts/scheduling-eviction/node-pressure-eviction/#eviction-signals
     *     @type string $imagefs_available
     *           Optional. Amount of storage available on filesystem that container runtime
     *           uses for storing images layers. If the container filesystem and image
     *           filesystem are not separate, then imagefs can store both image layers and
     *           writeable layers. Defines the amount of "imagefs.available" signal in
     *           kubelet. Default is unset, if not specified in the kubelet config. It
     *           takses percentage value for now. Sample format: "30%". Must be >= 15% and
     *           <= 50%. See
     *           https://kubernetes.io/docs/concepts/scheduling-eviction/node-pressure-eviction/#eviction-signals
     *     @type string $imagefs_inodes_free
     *           Optional. Amount of inodes available on filesystem that container runtime
     *           uses for storing images layers. Defines the amount of "imagefs.inodesFree"
     *           signal in kubelet. Default is unset, if not specified in the kubelet
     *           config. Linux only. It takses percentage value for now. Sample format:
     *           "30%". Must be >= 5% and <= 50%. See
     *           https://kubernetes.io/docs/concepts/scheduling-eviction/node-pressure-eviction/#eviction-signals
     *     @type string $pid_available
     *           Optional. Amount of PID available for pod allocation. Defines the amount of
     *           "pid.available" signal in kubelet. Default is unset, if not specified in
     *           the kubelet config. It takses percentage value for now. Sample format:
     *           "30%". Must be >= 10% and <= 50%. See
     *           https://kubernetes.io/docs/concepts/scheduling-eviction/node-pressure-eviction/#eviction-signals
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Container\V1\ClusterService::initOnce();
        parent::__construct($data);
    }

    /**
     * Optional. Memory available (i.e. capacity - workingSet), in bytes. Defines
     * the amount of "memory.available" signal in kubelet. Default is unset, if
     * not specified in the kubelet config. Format: positive number + unit, e.g.
     * 100Ki, 10Mi, 5Gi. Valid units are Ki, Mi, Gi. Must be >= 100Mi and <= 50%
     * of the node's memory. See
     * https://kubernetes.io/docs/concepts/scheduling-eviction/node-pressure-eviction/#eviction-signals
     *
     * Generated from protobuf field <code>string memory_available = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getMemoryAvailable()
    {
        return $this->memory_available;
    }

    /**
     * Optional. Memory available (i.e. capacity - workingSet), in bytes. Defines
     * the amount of "memory.available" signal in kubelet. Default is unset, if
     * not specified in the kubelet config. Format: positive number + unit, e.g.
     * 100Ki, 10Mi, 5Gi. Valid units are Ki, Mi, Gi. Must be >= 100Mi and <= 50%
     * of the node's memory. See
     * https://kubernetes.io/docs/concepts/scheduling-eviction/node-pressure-eviction/#eviction-signals
     *
     * Generated from protobuf field <code>string memory_available = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setMemoryAvailable($var)
    {
        GPBUtil::checkString($var, True);
        $this->memory_available = $var;

        return $this;
    }

    /**
     * Optional. Amount of storage available on filesystem that kubelet uses for
     * volumes, daemon logs, etc. Defines the amount of "nodefs.available" signal
     * in kubelet. Default is unset, if not specified in the kubelet config. It
     * takses percentage value for now. Sample format: "30%". Must be >= 10% and
     * <= 50%. See
     * https://kubernetes.io/docs/concepts/scheduling-eviction/node-pressure-eviction/#eviction-signals
     *
     * Generated from protobuf field <code>string nodefs_available = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getNodefsAvailable()
    {
        return $this->nodefs_available;
    }

    /**
     * Optional. Amount of storage available on filesystem that kubelet uses for
     * volumes, daemon logs, etc. Defines the amount of "nodefs.available" signal
     * in kubelet. Default is unset, if not specified in the kubelet config. It
     * takses percentage value for now. Sample format: "30%". Must be >= 10% and
     * <= 50%. See
     * https://kubernetes.io/docs/concepts/scheduling-eviction/node-pressure-eviction/#eviction-signals
     *
     * Generated from protobuf field <code>string nodefs_available = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setNodefsAvailable($var)
    {
        GPBUtil::checkString($var, True);
        $this->nodefs_available = $var;

        return $this;
    }

    /**
     * Optional. Amount of inodes available on filesystem that kubelet uses for
     * volumes, daemon logs, etc. Defines the amount of "nodefs.inodesFree" signal
     * in kubelet. Default is unset, if not specified in the kubelet config. Linux
     * only. It takses percentage value for now. Sample format: "30%". Must be >=
     * 5% and <= 50%. See
     * https://kubernetes.io/docs/concepts/scheduling-eviction/node-pressure-eviction/#eviction-signals
     *
     * Generated from protobuf field <code>string nodefs_inodes_free = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getNodefsInodesFree()
    {
        return $this->nodefs_inodes_free;
    }

    /**
     * Optional. Amount of inodes available on filesystem that kubelet uses for
     * volumes, daemon logs, etc. Defines the amount of "nodefs.inodesFree" signal
     * in kubelet. Default is unset, if not specified in the kubelet config. Linux
     * only. It takses percentage value for now. Sample format: "30%". Must be >=
     * 5% and <= 50%. See
     * https://kubernetes.io/docs/concepts/scheduling-eviction/node-pressure-eviction/#eviction-signals
     *
     * Generated from protobuf field <code>string nodefs_inodes_free = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setNodefsInodesFree($var)
    {
        GPBUtil::checkString($var, True);
        $this->nodefs_inodes_free = $var;

        return $this;
    }

    /**
     * Optional. Amount of storage available on filesystem that container runtime
     * uses for storing images layers. If the container filesystem and image
     * filesystem are not separate, then imagefs can store both image layers and
     * writeable layers. Defines the amount of "imagefs.available" signal in
     * kubelet. Default is unset, if not specified in the kubelet config. It
     * takses percentage value for now. Sample format: "30%". Must be >= 15% and
     * <= 50%. See
     * https://kubernetes.io/docs/concepts/scheduling-eviction/node-pressure-eviction/#eviction-signals
     *
     * Generated from protobuf field <code>string imagefs_available = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getImagefsAvailable()
    {
        return $this->imagefs_available;
    }

    /**
     * Optional. Amount of storage available on filesystem that container runtime
     * uses for storing images layers. If the container filesystem and image
     * filesystem are not separate, then imagefs can store both image layers and
     * writeable layers. Defines the amount of "imagefs.available" signal in
     * kubelet. Default is unset, if not specified in the kubelet config. It
     * takses percentage value for now. Sample format: "30%". Must be >= 15% and
     * <= 50%. See
     * https://kubernetes.io/docs/concepts/scheduling-eviction/node-pressure-eviction/#eviction-signals
     *
     * Generated from protobuf field <code>string imagefs_available = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setImagefsAvailable($var)
    {
        GPBUtil::checkString($var, True);
        $this->imagefs_available = $var;

        return $this;
    }

    /**
     * Optional. Amount of inodes available on filesystem that container runtime
     * uses for storing images layers. Defines the amount of "imagefs.inodesFree"
     * signal in kubelet. Default is unset, if not specified in the kubelet
     * config. Linux only. It takses percentage value for now. Sample format:
     * "30%". Must be >= 5% and <= 50%. See
     * https://kubernetes.io/docs/concepts/scheduling-eviction/node-pressure-eviction/#eviction-signals
     *
     * Generated from protobuf field <code>string imagefs_inodes_free = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getImagefsInodesFree()
    {
        return $this->imagefs_inodes_free;
    }

    /**
     * Optional. Amount of inodes available on filesystem that container runtime
     * uses for storing images layers. Defines the amount of "imagefs.inodesFree"
     * signal in kubelet. Default is unset, if not specified in the kubelet
     * config. Linux only. It takses percentage value for now. Sample format:
     * "30%". Must be >= 5% and <= 50%. See
     * https://kubernetes.io/docs/concepts/scheduling-eviction/node-pressure-eviction/#eviction-signals
     *
     * Generated from protobuf field <code>string imagefs_inodes_free = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setImagefsInodesFree($var)
    {
        GPBUtil::checkString($var, True);
        $this->imagefs_inodes_free = $var;

        return $this;
    }

    /**
     * Optional. Amount of PID available for pod allocation. Defines the amount of
     * "pid.available" signal in kubelet. Default is unset, if not specified in
     * the kubelet config. It takses percentage value for now. Sample format:
     * "30%". Must be >= 10% and <= 50%. See
     * https://kubernetes.io/docs/concepts/scheduling-eviction/node-pressure-eviction/#eviction-signals
     *
     * Generated from protobuf field <code>string pid_available = 6 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getPidAvailable()
    {
        return $this->pid_available;
    }

    /**
     * Optional. Amount of PID available for pod allocation. Defines the amount of
     * "pid.available" signal in kubelet. Default is unset, if not specified in
     * the kubelet config. It takses percentage value for now. Sample format:
     * "30%". Must be >= 10% and <= 50%. See
     * https://kubernetes.io/docs/concepts/scheduling-eviction/node-pressure-eviction/#eviction-signals
     *
     * Generated from protobuf field <code>string pid_available = 6 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setPidAvailable($var)
    {
        GPBUtil::checkString($var, True);
        $this->pid_available = $var;

        return $this;
    }

}

