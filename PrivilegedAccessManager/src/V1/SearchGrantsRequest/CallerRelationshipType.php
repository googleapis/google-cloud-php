<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/privilegedaccessmanager/v1/privilegedaccessmanager.proto

namespace Google\Cloud\PrivilegedAccessManager\V1\SearchGrantsRequest;

use UnexpectedValueException;

/**
 * Different types of relationships a user can have with a grant.
 *
 * Protobuf type <code>google.cloud.privilegedaccessmanager.v1.SearchGrantsRequest.CallerRelationshipType</code>
 */
class CallerRelationshipType
{
    /**
     * Unspecified caller relationship type.
     *
     * Generated from protobuf enum <code>CALLER_RELATIONSHIP_TYPE_UNSPECIFIED = 0;</code>
     */
    const CALLER_RELATIONSHIP_TYPE_UNSPECIFIED = 0;
    /**
     * The user created this grant by calling `CreateGrant` earlier.
     *
     * Generated from protobuf enum <code>HAD_CREATED = 1;</code>
     */
    const HAD_CREATED = 1;
    /**
     * The user is an approver for the entitlement that this grant is parented
     * under and can currently approve/deny it.
     *
     * Generated from protobuf enum <code>CAN_APPROVE = 2;</code>
     */
    const CAN_APPROVE = 2;
    /**
     * The caller had successfully approved/denied this grant earlier.
     *
     * Generated from protobuf enum <code>HAD_APPROVED = 3;</code>
     */
    const HAD_APPROVED = 3;

    private static $valueToName = [
        self::CALLER_RELATIONSHIP_TYPE_UNSPECIFIED => 'CALLER_RELATIONSHIP_TYPE_UNSPECIFIED',
        self::HAD_CREATED => 'HAD_CREATED',
        self::CAN_APPROVE => 'CAN_APPROVE',
        self::HAD_APPROVED => 'HAD_APPROVED',
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


