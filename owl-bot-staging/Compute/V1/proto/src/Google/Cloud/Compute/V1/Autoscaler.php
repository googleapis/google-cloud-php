<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/compute/v1/compute.proto

namespace Google\Cloud\Compute\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Represents an Autoscaler resource. Google Compute Engine has two Autoscaler resources: * [Zonal](/compute/docs/reference/rest/v1/autoscalers) * [Regional](/compute/docs/reference/rest/v1/regionAutoscalers) Use autoscalers to automatically add or delete instances from a managed instance group according to your defined autoscaling policy. For more information, read Autoscaling Groups of Instances. For zonal managed instance groups resource, use the autoscaler resource. For regional managed instance groups, use the regionAutoscalers resource.
 *
 * Generated from protobuf message <code>google.cloud.compute.v1.Autoscaler</code>
 */
class Autoscaler extends \Google\Protobuf\Internal\Message
{
    /**
     * The configuration parameters for the autoscaling algorithm. You can define one or more signals for an autoscaler: cpuUtilization, customMetricUtilizations, and loadBalancingUtilization. If none of these are specified, the default will be to autoscale based on cpuUtilization to 0.6 or 60%.
     *
     * Generated from protobuf field <code>optional .google.cloud.compute.v1.AutoscalingPolicy autoscaling_policy = 221950041;</code>
     */
    protected $autoscaling_policy = null;
    /**
     * [Output Only] Creation timestamp in RFC3339 text format.
     *
     * Generated from protobuf field <code>optional string creation_timestamp = 30525366;</code>
     */
    protected $creation_timestamp = null;
    /**
     * An optional description of this resource. Provide this property when you create the resource.
     *
     * Generated from protobuf field <code>optional string description = 422937596;</code>
     */
    protected $description = null;
    /**
     * [Output Only] The unique identifier for the resource. This identifier is defined by the server.
     *
     * Generated from protobuf field <code>optional uint64 id = 3355;</code>
     */
    protected $id = null;
    /**
     * [Output Only] Type of the resource. Always compute#autoscaler for autoscalers.
     *
     * Generated from protobuf field <code>optional string kind = 3292052;</code>
     */
    protected $kind = null;
    /**
     * Name of the resource. Provided by the client when the resource is created. The name must be 1-63 characters long, and comply with RFC1035. Specifically, the name must be 1-63 characters long and match the regular expression `[a-z]([-a-z0-9]*[a-z0-9])?` which means the first character must be a lowercase letter, and all following characters must be a dash, lowercase letter, or digit, except the last character, which cannot be a dash.
     *
     * Generated from protobuf field <code>optional string name = 3373707;</code>
     */
    protected $name = null;
    /**
     * [Output Only] Target recommended MIG size (number of instances) computed by autoscaler. Autoscaler calculates the recommended MIG size even when the autoscaling policy mode is different from ON. This field is empty when autoscaler is not connected to an existing managed instance group or autoscaler did not generate its prediction.
     *
     * Generated from protobuf field <code>optional int32 recommended_size = 257915749;</code>
     */
    protected $recommended_size = null;
    /**
     * [Output Only] URL of the region where the instance group resides (for autoscalers living in regional scope).
     *
     * Generated from protobuf field <code>optional string region = 138946292;</code>
     */
    protected $region = null;
    /**
     * [Output Only] Status information of existing scaling schedules.
     *
     * Generated from protobuf field <code>map<string, .google.cloud.compute.v1.ScalingScheduleStatus> scaling_schedule_status = 465950178;</code>
     */
    private $scaling_schedule_status;
    /**
     * [Output Only] Server-defined URL for the resource.
     *
     * Generated from protobuf field <code>optional string self_link = 456214797;</code>
     */
    protected $self_link = null;
    /**
     * [Output Only] The status of the autoscaler configuration. Current set of possible values: - PENDING: Autoscaler backend hasn't read new/updated configuration. - DELETING: Configuration is being deleted. - ACTIVE: Configuration is acknowledged to be effective. Some warnings might be present in the statusDetails field. - ERROR: Configuration has errors. Actionable for users. Details are present in the statusDetails field. New values might be added in the future.
     * Check the Status enum for the list of possible values.
     *
     * Generated from protobuf field <code>optional string status = 181260274;</code>
     */
    protected $status = null;
    /**
     * [Output Only] Human-readable details about the current state of the autoscaler. Read the documentation for Commonly returned status messages for examples of status messages you might encounter.
     *
     * Generated from protobuf field <code>repeated .google.cloud.compute.v1.AutoscalerStatusDetails status_details = 363353845;</code>
     */
    private $status_details;
    /**
     * URL of the managed instance group that this autoscaler will scale. This field is required when creating an autoscaler.
     *
     * Generated from protobuf field <code>optional string target = 192835985;</code>
     */
    protected $target = null;
    /**
     * [Output Only] URL of the zone where the instance group resides (for autoscalers living in zonal scope).
     *
     * Generated from protobuf field <code>optional string zone = 3744684;</code>
     */
    protected $zone = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Cloud\Compute\V1\AutoscalingPolicy $autoscaling_policy
     *           The configuration parameters for the autoscaling algorithm. You can define one or more signals for an autoscaler: cpuUtilization, customMetricUtilizations, and loadBalancingUtilization. If none of these are specified, the default will be to autoscale based on cpuUtilization to 0.6 or 60%.
     *     @type string $creation_timestamp
     *           [Output Only] Creation timestamp in RFC3339 text format.
     *     @type string $description
     *           An optional description of this resource. Provide this property when you create the resource.
     *     @type int|string $id
     *           [Output Only] The unique identifier for the resource. This identifier is defined by the server.
     *     @type string $kind
     *           [Output Only] Type of the resource. Always compute#autoscaler for autoscalers.
     *     @type string $name
     *           Name of the resource. Provided by the client when the resource is created. The name must be 1-63 characters long, and comply with RFC1035. Specifically, the name must be 1-63 characters long and match the regular expression `[a-z]([-a-z0-9]*[a-z0-9])?` which means the first character must be a lowercase letter, and all following characters must be a dash, lowercase letter, or digit, except the last character, which cannot be a dash.
     *     @type int $recommended_size
     *           [Output Only] Target recommended MIG size (number of instances) computed by autoscaler. Autoscaler calculates the recommended MIG size even when the autoscaling policy mode is different from ON. This field is empty when autoscaler is not connected to an existing managed instance group or autoscaler did not generate its prediction.
     *     @type string $region
     *           [Output Only] URL of the region where the instance group resides (for autoscalers living in regional scope).
     *     @type array|\Google\Protobuf\Internal\MapField $scaling_schedule_status
     *           [Output Only] Status information of existing scaling schedules.
     *     @type string $self_link
     *           [Output Only] Server-defined URL for the resource.
     *     @type string $status
     *           [Output Only] The status of the autoscaler configuration. Current set of possible values: - PENDING: Autoscaler backend hasn't read new/updated configuration. - DELETING: Configuration is being deleted. - ACTIVE: Configuration is acknowledged to be effective. Some warnings might be present in the statusDetails field. - ERROR: Configuration has errors. Actionable for users. Details are present in the statusDetails field. New values might be added in the future.
     *           Check the Status enum for the list of possible values.
     *     @type array<\Google\Cloud\Compute\V1\AutoscalerStatusDetails>|\Google\Protobuf\Internal\RepeatedField $status_details
     *           [Output Only] Human-readable details about the current state of the autoscaler. Read the documentation for Commonly returned status messages for examples of status messages you might encounter.
     *     @type string $target
     *           URL of the managed instance group that this autoscaler will scale. This field is required when creating an autoscaler.
     *     @type string $zone
     *           [Output Only] URL of the zone where the instance group resides (for autoscalers living in zonal scope).
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Compute\V1\Compute::initOnce();
        parent::__construct($data);
    }

    /**
     * The configuration parameters for the autoscaling algorithm. You can define one or more signals for an autoscaler: cpuUtilization, customMetricUtilizations, and loadBalancingUtilization. If none of these are specified, the default will be to autoscale based on cpuUtilization to 0.6 or 60%.
     *
     * Generated from protobuf field <code>optional .google.cloud.compute.v1.AutoscalingPolicy autoscaling_policy = 221950041;</code>
     * @return \Google\Cloud\Compute\V1\AutoscalingPolicy|null
     */
    public function getAutoscalingPolicy()
    {
        return $this->autoscaling_policy;
    }

    public function hasAutoscalingPolicy()
    {
        return isset($this->autoscaling_policy);
    }

    public function clearAutoscalingPolicy()
    {
        unset($this->autoscaling_policy);
    }

    /**
     * The configuration parameters for the autoscaling algorithm. You can define one or more signals for an autoscaler: cpuUtilization, customMetricUtilizations, and loadBalancingUtilization. If none of these are specified, the default will be to autoscale based on cpuUtilization to 0.6 or 60%.
     *
     * Generated from protobuf field <code>optional .google.cloud.compute.v1.AutoscalingPolicy autoscaling_policy = 221950041;</code>
     * @param \Google\Cloud\Compute\V1\AutoscalingPolicy $var
     * @return $this
     */
    public function setAutoscalingPolicy($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Compute\V1\AutoscalingPolicy::class);
        $this->autoscaling_policy = $var;

        return $this;
    }

    /**
     * [Output Only] Creation timestamp in RFC3339 text format.
     *
     * Generated from protobuf field <code>optional string creation_timestamp = 30525366;</code>
     * @return string
     */
    public function getCreationTimestamp()
    {
        return isset($this->creation_timestamp) ? $this->creation_timestamp : '';
    }

    public function hasCreationTimestamp()
    {
        return isset($this->creation_timestamp);
    }

    public function clearCreationTimestamp()
    {
        unset($this->creation_timestamp);
    }

    /**
     * [Output Only] Creation timestamp in RFC3339 text format.
     *
     * Generated from protobuf field <code>optional string creation_timestamp = 30525366;</code>
     * @param string $var
     * @return $this
     */
    public function setCreationTimestamp($var)
    {
        GPBUtil::checkString($var, True);
        $this->creation_timestamp = $var;

        return $this;
    }

    /**
     * An optional description of this resource. Provide this property when you create the resource.
     *
     * Generated from protobuf field <code>optional string description = 422937596;</code>
     * @return string
     */
    public function getDescription()
    {
        return isset($this->description) ? $this->description : '';
    }

    public function hasDescription()
    {
        return isset($this->description);
    }

    public function clearDescription()
    {
        unset($this->description);
    }

    /**
     * An optional description of this resource. Provide this property when you create the resource.
     *
     * Generated from protobuf field <code>optional string description = 422937596;</code>
     * @param string $var
     * @return $this
     */
    public function setDescription($var)
    {
        GPBUtil::checkString($var, True);
        $this->description = $var;

        return $this;
    }

    /**
     * [Output Only] The unique identifier for the resource. This identifier is defined by the server.
     *
     * Generated from protobuf field <code>optional uint64 id = 3355;</code>
     * @return int|string
     */
    public function getId()
    {
        return isset($this->id) ? $this->id : 0;
    }

    public function hasId()
    {
        return isset($this->id);
    }

    public function clearId()
    {
        unset($this->id);
    }

    /**
     * [Output Only] The unique identifier for the resource. This identifier is defined by the server.
     *
     * Generated from protobuf field <code>optional uint64 id = 3355;</code>
     * @param int|string $var
     * @return $this
     */
    public function setId($var)
    {
        GPBUtil::checkUint64($var);
        $this->id = $var;

        return $this;
    }

    /**
     * [Output Only] Type of the resource. Always compute#autoscaler for autoscalers.
     *
     * Generated from protobuf field <code>optional string kind = 3292052;</code>
     * @return string
     */
    public function getKind()
    {
        return isset($this->kind) ? $this->kind : '';
    }

    public function hasKind()
    {
        return isset($this->kind);
    }

    public function clearKind()
    {
        unset($this->kind);
    }

    /**
     * [Output Only] Type of the resource. Always compute#autoscaler for autoscalers.
     *
     * Generated from protobuf field <code>optional string kind = 3292052;</code>
     * @param string $var
     * @return $this
     */
    public function setKind($var)
    {
        GPBUtil::checkString($var, True);
        $this->kind = $var;

        return $this;
    }

    /**
     * Name of the resource. Provided by the client when the resource is created. The name must be 1-63 characters long, and comply with RFC1035. Specifically, the name must be 1-63 characters long and match the regular expression `[a-z]([-a-z0-9]*[a-z0-9])?` which means the first character must be a lowercase letter, and all following characters must be a dash, lowercase letter, or digit, except the last character, which cannot be a dash.
     *
     * Generated from protobuf field <code>optional string name = 3373707;</code>
     * @return string
     */
    public function getName()
    {
        return isset($this->name) ? $this->name : '';
    }

    public function hasName()
    {
        return isset($this->name);
    }

    public function clearName()
    {
        unset($this->name);
    }

    /**
     * Name of the resource. Provided by the client when the resource is created. The name must be 1-63 characters long, and comply with RFC1035. Specifically, the name must be 1-63 characters long and match the regular expression `[a-z]([-a-z0-9]*[a-z0-9])?` which means the first character must be a lowercase letter, and all following characters must be a dash, lowercase letter, or digit, except the last character, which cannot be a dash.
     *
     * Generated from protobuf field <code>optional string name = 3373707;</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;

        return $this;
    }

    /**
     * [Output Only] Target recommended MIG size (number of instances) computed by autoscaler. Autoscaler calculates the recommended MIG size even when the autoscaling policy mode is different from ON. This field is empty when autoscaler is not connected to an existing managed instance group or autoscaler did not generate its prediction.
     *
     * Generated from protobuf field <code>optional int32 recommended_size = 257915749;</code>
     * @return int
     */
    public function getRecommendedSize()
    {
        return isset($this->recommended_size) ? $this->recommended_size : 0;
    }

    public function hasRecommendedSize()
    {
        return isset($this->recommended_size);
    }

    public function clearRecommendedSize()
    {
        unset($this->recommended_size);
    }

    /**
     * [Output Only] Target recommended MIG size (number of instances) computed by autoscaler. Autoscaler calculates the recommended MIG size even when the autoscaling policy mode is different from ON. This field is empty when autoscaler is not connected to an existing managed instance group or autoscaler did not generate its prediction.
     *
     * Generated from protobuf field <code>optional int32 recommended_size = 257915749;</code>
     * @param int $var
     * @return $this
     */
    public function setRecommendedSize($var)
    {
        GPBUtil::checkInt32($var);
        $this->recommended_size = $var;

        return $this;
    }

    /**
     * [Output Only] URL of the region where the instance group resides (for autoscalers living in regional scope).
     *
     * Generated from protobuf field <code>optional string region = 138946292;</code>
     * @return string
     */
    public function getRegion()
    {
        return isset($this->region) ? $this->region : '';
    }

    public function hasRegion()
    {
        return isset($this->region);
    }

    public function clearRegion()
    {
        unset($this->region);
    }

    /**
     * [Output Only] URL of the region where the instance group resides (for autoscalers living in regional scope).
     *
     * Generated from protobuf field <code>optional string region = 138946292;</code>
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
     * [Output Only] Status information of existing scaling schedules.
     *
     * Generated from protobuf field <code>map<string, .google.cloud.compute.v1.ScalingScheduleStatus> scaling_schedule_status = 465950178;</code>
     * @return \Google\Protobuf\Internal\MapField
     */
    public function getScalingScheduleStatus()
    {
        return $this->scaling_schedule_status;
    }

    /**
     * [Output Only] Status information of existing scaling schedules.
     *
     * Generated from protobuf field <code>map<string, .google.cloud.compute.v1.ScalingScheduleStatus> scaling_schedule_status = 465950178;</code>
     * @param array|\Google\Protobuf\Internal\MapField $var
     * @return $this
     */
    public function setScalingScheduleStatus($var)
    {
        $arr = GPBUtil::checkMapField($var, \Google\Protobuf\Internal\GPBType::STRING, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\Compute\V1\ScalingScheduleStatus::class);
        $this->scaling_schedule_status = $arr;

        return $this;
    }

    /**
     * [Output Only] Server-defined URL for the resource.
     *
     * Generated from protobuf field <code>optional string self_link = 456214797;</code>
     * @return string
     */
    public function getSelfLink()
    {
        return isset($this->self_link) ? $this->self_link : '';
    }

    public function hasSelfLink()
    {
        return isset($this->self_link);
    }

    public function clearSelfLink()
    {
        unset($this->self_link);
    }

    /**
     * [Output Only] Server-defined URL for the resource.
     *
     * Generated from protobuf field <code>optional string self_link = 456214797;</code>
     * @param string $var
     * @return $this
     */
    public function setSelfLink($var)
    {
        GPBUtil::checkString($var, True);
        $this->self_link = $var;

        return $this;
    }

    /**
     * [Output Only] The status of the autoscaler configuration. Current set of possible values: - PENDING: Autoscaler backend hasn't read new/updated configuration. - DELETING: Configuration is being deleted. - ACTIVE: Configuration is acknowledged to be effective. Some warnings might be present in the statusDetails field. - ERROR: Configuration has errors. Actionable for users. Details are present in the statusDetails field. New values might be added in the future.
     * Check the Status enum for the list of possible values.
     *
     * Generated from protobuf field <code>optional string status = 181260274;</code>
     * @return string
     */
    public function getStatus()
    {
        return isset($this->status) ? $this->status : '';
    }

    public function hasStatus()
    {
        return isset($this->status);
    }

    public function clearStatus()
    {
        unset($this->status);
    }

    /**
     * [Output Only] The status of the autoscaler configuration. Current set of possible values: - PENDING: Autoscaler backend hasn't read new/updated configuration. - DELETING: Configuration is being deleted. - ACTIVE: Configuration is acknowledged to be effective. Some warnings might be present in the statusDetails field. - ERROR: Configuration has errors. Actionable for users. Details are present in the statusDetails field. New values might be added in the future.
     * Check the Status enum for the list of possible values.
     *
     * Generated from protobuf field <code>optional string status = 181260274;</code>
     * @param string $var
     * @return $this
     */
    public function setStatus($var)
    {
        GPBUtil::checkString($var, True);
        $this->status = $var;

        return $this;
    }

    /**
     * [Output Only] Human-readable details about the current state of the autoscaler. Read the documentation for Commonly returned status messages for examples of status messages you might encounter.
     *
     * Generated from protobuf field <code>repeated .google.cloud.compute.v1.AutoscalerStatusDetails status_details = 363353845;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getStatusDetails()
    {
        return $this->status_details;
    }

    /**
     * [Output Only] Human-readable details about the current state of the autoscaler. Read the documentation for Commonly returned status messages for examples of status messages you might encounter.
     *
     * Generated from protobuf field <code>repeated .google.cloud.compute.v1.AutoscalerStatusDetails status_details = 363353845;</code>
     * @param array<\Google\Cloud\Compute\V1\AutoscalerStatusDetails>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setStatusDetails($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\Compute\V1\AutoscalerStatusDetails::class);
        $this->status_details = $arr;

        return $this;
    }

    /**
     * URL of the managed instance group that this autoscaler will scale. This field is required when creating an autoscaler.
     *
     * Generated from protobuf field <code>optional string target = 192835985;</code>
     * @return string
     */
    public function getTarget()
    {
        return isset($this->target) ? $this->target : '';
    }

    public function hasTarget()
    {
        return isset($this->target);
    }

    public function clearTarget()
    {
        unset($this->target);
    }

    /**
     * URL of the managed instance group that this autoscaler will scale. This field is required when creating an autoscaler.
     *
     * Generated from protobuf field <code>optional string target = 192835985;</code>
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
     * [Output Only] URL of the zone where the instance group resides (for autoscalers living in zonal scope).
     *
     * Generated from protobuf field <code>optional string zone = 3744684;</code>
     * @return string
     */
    public function getZone()
    {
        return isset($this->zone) ? $this->zone : '';
    }

    public function hasZone()
    {
        return isset($this->zone);
    }

    public function clearZone()
    {
        unset($this->zone);
    }

    /**
     * [Output Only] URL of the zone where the instance group resides (for autoscalers living in zonal scope).
     *
     * Generated from protobuf field <code>optional string zone = 3744684;</code>
     * @param string $var
     * @return $this
     */
    public function setZone($var)
    {
        GPBUtil::checkString($var, True);
        $this->zone = $var;

        return $this;
    }

}
