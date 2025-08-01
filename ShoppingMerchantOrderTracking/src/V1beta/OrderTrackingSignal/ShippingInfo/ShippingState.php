<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/shopping/merchant/ordertracking/v1beta/order_tracking_signals.proto

namespace Google\Shopping\Merchant\OrderTracking\V1beta\OrderTrackingSignal\ShippingInfo;

use UnexpectedValueException;

/**
 * The current status of the shipments.
 *
 * Protobuf type <code>google.shopping.merchant.ordertracking.v1beta.OrderTrackingSignal.ShippingInfo.ShippingState</code>
 */
class ShippingState
{
    /**
     * The shipping status is not known to business.
     *
     * Generated from protobuf enum <code>SHIPPING_STATE_UNSPECIFIED = 0;</code>
     */
    const SHIPPING_STATE_UNSPECIFIED = 0;
    /**
     * All items are shipped.
     *
     * Generated from protobuf enum <code>SHIPPED = 1;</code>
     */
    const SHIPPED = 1;
    /**
     * The shipment is already delivered.
     *
     * Generated from protobuf enum <code>DELIVERED = 2;</code>
     */
    const DELIVERED = 2;

    private static $valueToName = [
        self::SHIPPING_STATE_UNSPECIFIED => 'SHIPPING_STATE_UNSPECIFIED',
        self::SHIPPED => 'SHIPPED',
        self::DELIVERED => 'DELIVERED',
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


