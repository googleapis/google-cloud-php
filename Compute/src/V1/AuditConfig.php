<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/compute/v1/compute.proto

namespace Google\Cloud\Compute\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Specifies the audit configuration for a service. The configuration determines which permission types are logged, and what identities, if any, are exempted from logging. An AuditConfig must have one or more AuditLogConfigs. If there are AuditConfigs for both `allServices` and a specific service, the union of the two AuditConfigs is used for that service: the log_types specified in each AuditConfig are enabled, and the exempted_members in each AuditLogConfig are exempted. Example Policy with multiple AuditConfigs: { "audit_configs": [ { "service": "allServices", "audit_log_configs": [ { "log_type": "DATA_READ", "exempted_members": [ "user:jose&#64;example.com" ] }, { "log_type": "DATA_WRITE" }, { "log_type": "ADMIN_READ" } ] }, { "service": "sampleservice.googleapis.com", "audit_log_configs": [ { "log_type": "DATA_READ" }, { "log_type": "DATA_WRITE", "exempted_members": [ "user:aliya&#64;example.com" ] } ] } ] } For sampleservice, this policy enables DATA_READ, DATA_WRITE and ADMIN_READ logging. It also exempts `jose&#64;example.com` from DATA_READ logging, and `aliya&#64;example.com` from DATA_WRITE logging.
 *
 * Generated from protobuf message <code>google.cloud.compute.v1.AuditConfig</code>
 */
class AuditConfig extends \Google\Protobuf\Internal\Message
{
    /**
     * The configuration for logging of each type of permission.
     *
     * Generated from protobuf field <code>repeated .google.cloud.compute.v1.AuditLogConfig audit_log_configs = 488420626;</code>
     */
    private $audit_log_configs;
    /**
     * Generated from protobuf field <code>repeated string exempted_members = 232615576;</code>
     */
    private $exempted_members;
    /**
     * Specifies a service that will be enabled for audit logging. For example, `storage.googleapis.com`, `cloudsql.googleapis.com`. `allServices` is a special value that covers all services.
     *
     * Generated from protobuf field <code>optional string service = 373540533;</code>
     */
    private $service = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<\Google\Cloud\Compute\V1\AuditLogConfig>|\Google\Protobuf\Internal\RepeatedField $audit_log_configs
     *           The configuration for logging of each type of permission.
     *     @type array<string>|\Google\Protobuf\Internal\RepeatedField $exempted_members
     *     @type string $service
     *           Specifies a service that will be enabled for audit logging. For example, `storage.googleapis.com`, `cloudsql.googleapis.com`. `allServices` is a special value that covers all services.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Compute\V1\Compute::initOnce();
        parent::__construct($data);
    }

    /**
     * The configuration for logging of each type of permission.
     *
     * Generated from protobuf field <code>repeated .google.cloud.compute.v1.AuditLogConfig audit_log_configs = 488420626;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getAuditLogConfigs()
    {
        return $this->audit_log_configs;
    }

    /**
     * The configuration for logging of each type of permission.
     *
     * Generated from protobuf field <code>repeated .google.cloud.compute.v1.AuditLogConfig audit_log_configs = 488420626;</code>
     * @param array<\Google\Cloud\Compute\V1\AuditLogConfig>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setAuditLogConfigs($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\Compute\V1\AuditLogConfig::class);
        $this->audit_log_configs = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>repeated string exempted_members = 232615576;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getExemptedMembers()
    {
        return $this->exempted_members;
    }

    /**
     * Generated from protobuf field <code>repeated string exempted_members = 232615576;</code>
     * @param array<string>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setExemptedMembers($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->exempted_members = $arr;

        return $this;
    }

    /**
     * Specifies a service that will be enabled for audit logging. For example, `storage.googleapis.com`, `cloudsql.googleapis.com`. `allServices` is a special value that covers all services.
     *
     * Generated from protobuf field <code>optional string service = 373540533;</code>
     * @return string
     */
    public function getService()
    {
        return isset($this->service) ? $this->service : '';
    }

    public function hasService()
    {
        return isset($this->service);
    }

    public function clearService()
    {
        unset($this->service);
    }

    /**
     * Specifies a service that will be enabled for audit logging. For example, `storage.googleapis.com`, `cloudsql.googleapis.com`. `allServices` is a special value that covers all services.
     *
     * Generated from protobuf field <code>optional string service = 373540533;</code>
     * @param string $var
     * @return $this
     */
    public function setService($var)
    {
        GPBUtil::checkString($var, True);
        $this->service = $var;

        return $this;
    }

}

