<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/container/v1/cluster_service.proto

namespace Google\Cloud\Container\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * ManagedPrometheusConfig defines the configuration for
 * Google Cloud Managed Service for Prometheus.
 *
 * Generated from protobuf message <code>google.container.v1.ManagedPrometheusConfig</code>
 */
class ManagedPrometheusConfig extends \Google\Protobuf\Internal\Message
{
    /**
     * Enable Managed Collection.
     *
     * Generated from protobuf field <code>bool enabled = 1;</code>
     */
    protected $enabled = false;
    /**
     * GKE Workload Auto-Monitoring Configuration.
     *
     * Generated from protobuf field <code>.google.container.v1.AutoMonitoringConfig auto_monitoring_config = 2;</code>
     */
    protected $auto_monitoring_config = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type bool $enabled
     *           Enable Managed Collection.
     *     @type \Google\Cloud\Container\V1\AutoMonitoringConfig $auto_monitoring_config
     *           GKE Workload Auto-Monitoring Configuration.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Container\V1\ClusterService::initOnce();
        parent::__construct($data);
    }

    /**
     * Enable Managed Collection.
     *
     * Generated from protobuf field <code>bool enabled = 1;</code>
     * @return bool
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Enable Managed Collection.
     *
     * Generated from protobuf field <code>bool enabled = 1;</code>
     * @param bool $var
     * @return $this
     */
    public function setEnabled($var)
    {
        GPBUtil::checkBool($var);
        $this->enabled = $var;

        return $this;
    }

    /**
     * GKE Workload Auto-Monitoring Configuration.
     *
     * Generated from protobuf field <code>.google.container.v1.AutoMonitoringConfig auto_monitoring_config = 2;</code>
     * @return \Google\Cloud\Container\V1\AutoMonitoringConfig|null
     */
    public function getAutoMonitoringConfig()
    {
        return $this->auto_monitoring_config;
    }

    public function hasAutoMonitoringConfig()
    {
        return isset($this->auto_monitoring_config);
    }

    public function clearAutoMonitoringConfig()
    {
        unset($this->auto_monitoring_config);
    }

    /**
     * GKE Workload Auto-Monitoring Configuration.
     *
     * Generated from protobuf field <code>.google.container.v1.AutoMonitoringConfig auto_monitoring_config = 2;</code>
     * @param \Google\Cloud\Container\V1\AutoMonitoringConfig $var
     * @return $this
     */
    public function setAutoMonitoringConfig($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Container\V1\AutoMonitoringConfig::class);
        $this->auto_monitoring_config = $var;

        return $this;
    }

}

