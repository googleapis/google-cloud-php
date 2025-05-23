<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/deploy/v1/cloud_deploy.proto

namespace Google\Cloud\Deploy\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * CanaryDeployment represents the canary deployment configuration
 *
 * Generated from protobuf message <code>google.cloud.deploy.v1.CanaryDeployment</code>
 */
class CanaryDeployment extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The percentage based deployments that will occur as a part of a
     * `Rollout`. List is expected in ascending order and each integer n is
     * 0 <= n < 100.
     * If the GatewayServiceMesh is configured for Kubernetes, then the range for
     * n is 0 <= n <= 100.
     *
     * Generated from protobuf field <code>repeated int32 percentages = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    private $percentages;
    /**
     * Optional. Whether to run verify tests after each percentage deployment via
     * `skaffold verify`.
     *
     * Generated from protobuf field <code>bool verify = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $verify = false;
    /**
     * Optional. Configuration for the predeploy job of the first phase. If this
     * is not configured, there will be no predeploy job for this phase.
     *
     * Generated from protobuf field <code>.google.cloud.deploy.v1.Predeploy predeploy = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $predeploy = null;
    /**
     * Optional. Configuration for the postdeploy job of the last phase. If this
     * is not configured, there will be no postdeploy job for this phase.
     *
     * Generated from protobuf field <code>.google.cloud.deploy.v1.Postdeploy postdeploy = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $postdeploy = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<int>|\Google\Protobuf\Internal\RepeatedField $percentages
     *           Required. The percentage based deployments that will occur as a part of a
     *           `Rollout`. List is expected in ascending order and each integer n is
     *           0 <= n < 100.
     *           If the GatewayServiceMesh is configured for Kubernetes, then the range for
     *           n is 0 <= n <= 100.
     *     @type bool $verify
     *           Optional. Whether to run verify tests after each percentage deployment via
     *           `skaffold verify`.
     *     @type \Google\Cloud\Deploy\V1\Predeploy $predeploy
     *           Optional. Configuration for the predeploy job of the first phase. If this
     *           is not configured, there will be no predeploy job for this phase.
     *     @type \Google\Cloud\Deploy\V1\Postdeploy $postdeploy
     *           Optional. Configuration for the postdeploy job of the last phase. If this
     *           is not configured, there will be no postdeploy job for this phase.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Deploy\V1\CloudDeploy::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The percentage based deployments that will occur as a part of a
     * `Rollout`. List is expected in ascending order and each integer n is
     * 0 <= n < 100.
     * If the GatewayServiceMesh is configured for Kubernetes, then the range for
     * n is 0 <= n <= 100.
     *
     * Generated from protobuf field <code>repeated int32 percentages = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getPercentages()
    {
        return $this->percentages;
    }

    /**
     * Required. The percentage based deployments that will occur as a part of a
     * `Rollout`. List is expected in ascending order and each integer n is
     * 0 <= n < 100.
     * If the GatewayServiceMesh is configured for Kubernetes, then the range for
     * n is 0 <= n <= 100.
     *
     * Generated from protobuf field <code>repeated int32 percentages = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param array<int>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setPercentages($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::INT32);
        $this->percentages = $arr;

        return $this;
    }

    /**
     * Optional. Whether to run verify tests after each percentage deployment via
     * `skaffold verify`.
     *
     * Generated from protobuf field <code>bool verify = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return bool
     */
    public function getVerify()
    {
        return $this->verify;
    }

    /**
     * Optional. Whether to run verify tests after each percentage deployment via
     * `skaffold verify`.
     *
     * Generated from protobuf field <code>bool verify = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param bool $var
     * @return $this
     */
    public function setVerify($var)
    {
        GPBUtil::checkBool($var);
        $this->verify = $var;

        return $this;
    }

    /**
     * Optional. Configuration for the predeploy job of the first phase. If this
     * is not configured, there will be no predeploy job for this phase.
     *
     * Generated from protobuf field <code>.google.cloud.deploy.v1.Predeploy predeploy = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Cloud\Deploy\V1\Predeploy|null
     */
    public function getPredeploy()
    {
        return $this->predeploy;
    }

    public function hasPredeploy()
    {
        return isset($this->predeploy);
    }

    public function clearPredeploy()
    {
        unset($this->predeploy);
    }

    /**
     * Optional. Configuration for the predeploy job of the first phase. If this
     * is not configured, there will be no predeploy job for this phase.
     *
     * Generated from protobuf field <code>.google.cloud.deploy.v1.Predeploy predeploy = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param \Google\Cloud\Deploy\V1\Predeploy $var
     * @return $this
     */
    public function setPredeploy($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Deploy\V1\Predeploy::class);
        $this->predeploy = $var;

        return $this;
    }

    /**
     * Optional. Configuration for the postdeploy job of the last phase. If this
     * is not configured, there will be no postdeploy job for this phase.
     *
     * Generated from protobuf field <code>.google.cloud.deploy.v1.Postdeploy postdeploy = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Cloud\Deploy\V1\Postdeploy|null
     */
    public function getPostdeploy()
    {
        return $this->postdeploy;
    }

    public function hasPostdeploy()
    {
        return isset($this->postdeploy);
    }

    public function clearPostdeploy()
    {
        unset($this->postdeploy);
    }

    /**
     * Optional. Configuration for the postdeploy job of the last phase. If this
     * is not configured, there will be no postdeploy job for this phase.
     *
     * Generated from protobuf field <code>.google.cloud.deploy.v1.Postdeploy postdeploy = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param \Google\Cloud\Deploy\V1\Postdeploy $var
     * @return $this
     */
    public function setPostdeploy($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Deploy\V1\Postdeploy::class);
        $this->postdeploy = $var;

        return $this;
    }

}

