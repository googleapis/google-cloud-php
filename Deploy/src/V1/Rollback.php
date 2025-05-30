<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/deploy/v1/cloud_deploy.proto

namespace Google\Cloud\Deploy\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Rolls back a `Rollout`.
 *
 * Generated from protobuf message <code>google.cloud.deploy.v1.Rollback</code>
 */
class Rollback extends \Google\Protobuf\Internal\Message
{
    /**
     * Optional. The starting phase ID for the `Rollout`. If unspecified, the
     * `Rollout` will start in the stable phase.
     *
     * Generated from protobuf field <code>string destination_phase = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $destination_phase = '';
    /**
     * Optional. If pending rollout exists on the target, the rollback operation
     * will be aborted.
     *
     * Generated from protobuf field <code>bool disable_rollback_if_rollout_pending = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $disable_rollback_if_rollout_pending = false;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $destination_phase
     *           Optional. The starting phase ID for the `Rollout`. If unspecified, the
     *           `Rollout` will start in the stable phase.
     *     @type bool $disable_rollback_if_rollout_pending
     *           Optional. If pending rollout exists on the target, the rollback operation
     *           will be aborted.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Deploy\V1\CloudDeploy::initOnce();
        parent::__construct($data);
    }

    /**
     * Optional. The starting phase ID for the `Rollout`. If unspecified, the
     * `Rollout` will start in the stable phase.
     *
     * Generated from protobuf field <code>string destination_phase = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getDestinationPhase()
    {
        return $this->destination_phase;
    }

    /**
     * Optional. The starting phase ID for the `Rollout`. If unspecified, the
     * `Rollout` will start in the stable phase.
     *
     * Generated from protobuf field <code>string destination_phase = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setDestinationPhase($var)
    {
        GPBUtil::checkString($var, True);
        $this->destination_phase = $var;

        return $this;
    }

    /**
     * Optional. If pending rollout exists on the target, the rollback operation
     * will be aborted.
     *
     * Generated from protobuf field <code>bool disable_rollback_if_rollout_pending = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return bool
     */
    public function getDisableRollbackIfRolloutPending()
    {
        return $this->disable_rollback_if_rollout_pending;
    }

    /**
     * Optional. If pending rollout exists on the target, the rollback operation
     * will be aborted.
     *
     * Generated from protobuf field <code>bool disable_rollback_if_rollout_pending = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param bool $var
     * @return $this
     */
    public function setDisableRollbackIfRolloutPending($var)
    {
        GPBUtil::checkBool($var);
        $this->disable_rollback_if_rollout_pending = $var;

        return $this;
    }

}

