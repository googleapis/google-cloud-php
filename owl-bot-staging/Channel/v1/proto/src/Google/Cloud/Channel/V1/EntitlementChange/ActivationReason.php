<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/channel/v1/entitlement_changes.proto

namespace Google\Cloud\Channel\V1\EntitlementChange;

use UnexpectedValueException;

/**
 * The Entitlement's activation reason
 *
 * Protobuf type <code>google.cloud.channel.v1.EntitlementChange.ActivationReason</code>
 */
class ActivationReason
{
    /**
     * Not used.
     *
     * Generated from protobuf enum <code>ACTIVATION_REASON_UNSPECIFIED = 0;</code>
     */
    const ACTIVATION_REASON_UNSPECIFIED = 0;
    /**
     * Reseller reactivated a suspended Entitlement.
     *
     * Generated from protobuf enum <code>RESELLER_REVOKED_SUSPENSION = 1;</code>
     */
    const RESELLER_REVOKED_SUSPENSION = 1;
    /**
     * Customer accepted pending terms of service.
     *
     * Generated from protobuf enum <code>CUSTOMER_ACCEPTED_PENDING_TOS = 2;</code>
     */
    const CUSTOMER_ACCEPTED_PENDING_TOS = 2;
    /**
     * Reseller updated the renewal settings on an entitlement that was
     * suspended due to cancellation, and this update reactivated the
     * entitlement.
     *
     * Generated from protobuf enum <code>RENEWAL_SETTINGS_CHANGED = 3;</code>
     */
    const RENEWAL_SETTINGS_CHANGED = 3;
    /**
     * Other reasons (Activated temporarily for cancellation, added a payment
     * plan to a trial entitlement, etc.)
     *
     * Generated from protobuf enum <code>OTHER_ACTIVATION_REASON = 100;</code>
     */
    const OTHER_ACTIVATION_REASON = 100;

    private static $valueToName = [
        self::ACTIVATION_REASON_UNSPECIFIED => 'ACTIVATION_REASON_UNSPECIFIED',
        self::RESELLER_REVOKED_SUSPENSION => 'RESELLER_REVOKED_SUSPENSION',
        self::CUSTOMER_ACCEPTED_PENDING_TOS => 'CUSTOMER_ACCEPTED_PENDING_TOS',
        self::RENEWAL_SETTINGS_CHANGED => 'RENEWAL_SETTINGS_CHANGED',
        self::OTHER_ACTIVATION_REASON => 'OTHER_ACTIVATION_REASON',
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

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(ActivationReason::class, \Google\Cloud\Channel\V1\EntitlementChange_ActivationReason::class);
