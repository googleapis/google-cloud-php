<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/deploy/v1/cloud_deploy.proto

namespace Google\Cloud\Deploy\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * RuntimeConfig contains the runtime specific configurations for a deployment
 * strategy.
 *
 * Generated from protobuf message <code>google.cloud.deploy.v1.RuntimeConfig</code>
 */
class RuntimeConfig extends \Google\Protobuf\Internal\Message
{
    protected $runtime_config;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Cloud\Deploy\V1\KubernetesConfig $kubernetes
     *           Optional. Kubernetes runtime configuration.
     *     @type \Google\Cloud\Deploy\V1\CloudRunConfig $cloud_run
     *           Optional. Cloud Run runtime configuration.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Deploy\V1\CloudDeploy::initOnce();
        parent::__construct($data);
    }

    /**
     * Optional. Kubernetes runtime configuration.
     *
     * Generated from protobuf field <code>.google.cloud.deploy.v1.KubernetesConfig kubernetes = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Cloud\Deploy\V1\KubernetesConfig|null
     */
    public function getKubernetes()
    {
        return $this->readOneof(1);
    }

    public function hasKubernetes()
    {
        return $this->hasOneof(1);
    }

    /**
     * Optional. Kubernetes runtime configuration.
     *
     * Generated from protobuf field <code>.google.cloud.deploy.v1.KubernetesConfig kubernetes = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param \Google\Cloud\Deploy\V1\KubernetesConfig $var
     * @return $this
     */
    public function setKubernetes($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Deploy\V1\KubernetesConfig::class);
        $this->writeOneof(1, $var);

        return $this;
    }

    /**
     * Optional. Cloud Run runtime configuration.
     *
     * Generated from protobuf field <code>.google.cloud.deploy.v1.CloudRunConfig cloud_run = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Cloud\Deploy\V1\CloudRunConfig|null
     */
    public function getCloudRun()
    {
        return $this->readOneof(2);
    }

    public function hasCloudRun()
    {
        return $this->hasOneof(2);
    }

    /**
     * Optional. Cloud Run runtime configuration.
     *
     * Generated from protobuf field <code>.google.cloud.deploy.v1.CloudRunConfig cloud_run = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param \Google\Cloud\Deploy\V1\CloudRunConfig $var
     * @return $this
     */
    public function setCloudRun($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Deploy\V1\CloudRunConfig::class);
        $this->writeOneof(2, $var);

        return $this;
    }

    /**
     * @return string
     */
    public function getRuntimeConfig()
    {
        return $this->whichOneof("runtime_config");
    }

}

