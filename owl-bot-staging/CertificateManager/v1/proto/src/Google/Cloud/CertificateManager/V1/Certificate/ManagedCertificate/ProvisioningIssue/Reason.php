<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/certificatemanager/v1/certificate_manager.proto

namespace Google\Cloud\CertificateManager\V1\Certificate\ManagedCertificate\ProvisioningIssue;

use UnexpectedValueException;

/**
 * Reason for provisioning failures.
 *
 * Protobuf type <code>google.cloud.certificatemanager.v1.Certificate.ManagedCertificate.ProvisioningIssue.Reason</code>
 */
class Reason
{
    /**
     * Reason is unspecified.
     *
     * Generated from protobuf enum <code>REASON_UNSPECIFIED = 0;</code>
     */
    const REASON_UNSPECIFIED = 0;
    /**
     * Certificate provisioning failed due to an issue with one or more of
     * the domains on the certificate.
     * For details of which domains failed, consult the
     * `authorization_attempt_info` field.
     *
     * Generated from protobuf enum <code>AUTHORIZATION_ISSUE = 1;</code>
     */
    const AUTHORIZATION_ISSUE = 1;
    /**
     * Exceeded Certificate Authority quotas or internal rate limits of the
     * system. Provisioning may take longer to complete.
     *
     * Generated from protobuf enum <code>RATE_LIMITED = 2;</code>
     */
    const RATE_LIMITED = 2;

    private static $valueToName = [
        self::REASON_UNSPECIFIED => 'REASON_UNSPECIFIED',
        self::AUTHORIZATION_ISSUE => 'AUTHORIZATION_ISSUE',
        self::RATE_LIMITED => 'RATE_LIMITED',
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
class_alias(Reason::class, \Google\Cloud\CertificateManager\V1\Certificate_ManagedCertificate_ProvisioningIssue_Reason::class);
