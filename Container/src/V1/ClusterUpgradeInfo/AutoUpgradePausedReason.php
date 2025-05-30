<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/container/v1/cluster_service.proto

namespace Google\Cloud\Container\V1\ClusterUpgradeInfo;

use UnexpectedValueException;

/**
 * AutoUpgradePausedReason indicates the reason for auto upgrade paused
 * status.
 *
 * Protobuf type <code>google.container.v1.ClusterUpgradeInfo.AutoUpgradePausedReason</code>
 */
class AutoUpgradePausedReason
{
    /**
     * AUTO_UPGRADE_PAUSED_REASON_UNSPECIFIED indicates an unspecified reason.
     *
     * Generated from protobuf enum <code>AUTO_UPGRADE_PAUSED_REASON_UNSPECIFIED = 0;</code>
     */
    const AUTO_UPGRADE_PAUSED_REASON_UNSPECIFIED = 0;
    /**
     * MAINTENANCE_WINDOW indicates the cluster is outside customer maintenance
     * window.
     *
     * Generated from protobuf enum <code>MAINTENANCE_WINDOW = 1;</code>
     */
    const MAINTENANCE_WINDOW = 1;
    /**
     * MAINTENANCE_EXCLUSION_NO_UPGRADES indicates the cluster is in a
     * maintenance exclusion with scope NO_UPGRADES.
     *
     * Generated from protobuf enum <code>MAINTENANCE_EXCLUSION_NO_UPGRADES = 5;</code>
     */
    const MAINTENANCE_EXCLUSION_NO_UPGRADES = 5;
    /**
     * MAINTENANCE_EXCLUSION_NO_MINOR_UPGRADES indicates the cluster is in a
     * maintenance exclusion with scope NO_MINOR_UPGRADES.
     *
     * Generated from protobuf enum <code>MAINTENANCE_EXCLUSION_NO_MINOR_UPGRADES = 6;</code>
     */
    const MAINTENANCE_EXCLUSION_NO_MINOR_UPGRADES = 6;
    /**
     * CLUSTER_DISRUPTION_BUDGET indicates the cluster is outside the cluster
     * disruption budget.
     *
     * Generated from protobuf enum <code>CLUSTER_DISRUPTION_BUDGET = 4;</code>
     */
    const CLUSTER_DISRUPTION_BUDGET = 4;
    /**
     * CLUSTER_DISRUPTION_BUDGET_MINOR_UPGRADE indicates the cluster is outside
     * the cluster disruption budget for minor version upgrade.
     *
     * Generated from protobuf enum <code>CLUSTER_DISRUPTION_BUDGET_MINOR_UPGRADE = 7;</code>
     */
    const CLUSTER_DISRUPTION_BUDGET_MINOR_UPGRADE = 7;
    /**
     * SYSTEM_CONFIG indicates the cluster upgrade is paused  by system config.
     *
     * Generated from protobuf enum <code>SYSTEM_CONFIG = 8;</code>
     */
    const SYSTEM_CONFIG = 8;

    private static $valueToName = [
        self::AUTO_UPGRADE_PAUSED_REASON_UNSPECIFIED => 'AUTO_UPGRADE_PAUSED_REASON_UNSPECIFIED',
        self::MAINTENANCE_WINDOW => 'MAINTENANCE_WINDOW',
        self::MAINTENANCE_EXCLUSION_NO_UPGRADES => 'MAINTENANCE_EXCLUSION_NO_UPGRADES',
        self::MAINTENANCE_EXCLUSION_NO_MINOR_UPGRADES => 'MAINTENANCE_EXCLUSION_NO_MINOR_UPGRADES',
        self::CLUSTER_DISRUPTION_BUDGET => 'CLUSTER_DISRUPTION_BUDGET',
        self::CLUSTER_DISRUPTION_BUDGET_MINOR_UPGRADE => 'CLUSTER_DISRUPTION_BUDGET_MINOR_UPGRADE',
        self::SYSTEM_CONFIG => 'SYSTEM_CONFIG',
    ];

    public static function name($value)
    {
        if (!isset(self::$valueToName[$value])) {
            throw new UnexpectedValueException(sprintf(
                    'Enum %s has no name defined for value %s', __CLASS__, $value));
        }
        return self::$valueToName[$value];
    }


    public static function value($name)
    {
        $const = __CLASS__ . '::' . strtoupper($name);
        if (!defined($const)) {
            throw new UnexpectedValueException(sprintf(
                    'Enum %s has no value defined for name %s', __CLASS__, $name));
        }
        return constant($const);
    }
}


