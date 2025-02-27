<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/securitycentermanagement/v1/security_center_management.proto

namespace Google\Cloud\SecurityCenterManagement\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request message for
 * [SecurityCenterManagement.UpdateSecurityCenterService][google.cloud.securitycentermanagement.v1.SecurityCenterManagement.UpdateSecurityCenterService].
 *
 * Generated from protobuf message <code>google.cloud.securitycentermanagement.v1.UpdateSecurityCenterServiceRequest</code>
 */
class UpdateSecurityCenterServiceRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The updated service.
     *
     * Generated from protobuf field <code>.google.cloud.securitycentermanagement.v1.SecurityCenterService security_center_service = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $security_center_service = null;
    /**
     * Required. The fields to update. Accepts the following values:
     * * `intended_enablement_state`
     * * `modules`
     * If omitted, then all eligible fields are updated.
     *
     * Generated from protobuf field <code>.google.protobuf.FieldMask update_mask = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $update_mask = null;
    /**
     * Optional. When set to `true`, the request will be validated (including IAM
     * checks), but no service will be updated. An `OK` response indicates that
     * the request is valid, while an error response indicates that the request is
     * invalid.
     * If the request is valid, a subsequent request to update the service could
     * still fail for one of the following reasons:
     * *  The state of your cloud resources changed; for example, you lost a
     *    required IAM permission
     * *  An error occurred during update of the service
     * Defaults to `false`.
     *
     * Generated from protobuf field <code>bool validate_only = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $validate_only = false;

    /**
     * @param \Google\Cloud\SecurityCenterManagement\V1\SecurityCenterService $securityCenterService Required. The updated service.
     * @param \Google\Protobuf\FieldMask                                      $updateMask            Required. The fields to update. Accepts the following values:
     *
     *                                                                                               * `intended_enablement_state`
     *                                                                                               * `modules`
     *
     *                                                                                               If omitted, then all eligible fields are updated.
     *
     * @return \Google\Cloud\SecurityCenterManagement\V1\UpdateSecurityCenterServiceRequest
     *
     * @experimental
     */
    public static function build(\Google\Cloud\SecurityCenterManagement\V1\SecurityCenterService $securityCenterService, \Google\Protobuf\FieldMask $updateMask): self
    {
        return (new self())
            ->setSecurityCenterService($securityCenterService)
            ->setUpdateMask($updateMask);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Cloud\SecurityCenterManagement\V1\SecurityCenterService $security_center_service
     *           Required. The updated service.
     *     @type \Google\Protobuf\FieldMask $update_mask
     *           Required. The fields to update. Accepts the following values:
     *           * `intended_enablement_state`
     *           * `modules`
     *           If omitted, then all eligible fields are updated.
     *     @type bool $validate_only
     *           Optional. When set to `true`, the request will be validated (including IAM
     *           checks), but no service will be updated. An `OK` response indicates that
     *           the request is valid, while an error response indicates that the request is
     *           invalid.
     *           If the request is valid, a subsequent request to update the service could
     *           still fail for one of the following reasons:
     *           *  The state of your cloud resources changed; for example, you lost a
     *              required IAM permission
     *           *  An error occurred during update of the service
     *           Defaults to `false`.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Securitycentermanagement\V1\SecurityCenterManagement::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The updated service.
     *
     * Generated from protobuf field <code>.google.cloud.securitycentermanagement.v1.SecurityCenterService security_center_service = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Cloud\SecurityCenterManagement\V1\SecurityCenterService|null
     */
    public function getSecurityCenterService()
    {
        return $this->security_center_service;
    }

    public function hasSecurityCenterService()
    {
        return isset($this->security_center_service);
    }

    public function clearSecurityCenterService()
    {
        unset($this->security_center_service);
    }

    /**
     * Required. The updated service.
     *
     * Generated from protobuf field <code>.google.cloud.securitycentermanagement.v1.SecurityCenterService security_center_service = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Cloud\SecurityCenterManagement\V1\SecurityCenterService $var
     * @return $this
     */
    public function setSecurityCenterService($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\SecurityCenterManagement\V1\SecurityCenterService::class);
        $this->security_center_service = $var;

        return $this;
    }

    /**
     * Required. The fields to update. Accepts the following values:
     * * `intended_enablement_state`
     * * `modules`
     * If omitted, then all eligible fields are updated.
     *
     * Generated from protobuf field <code>.google.protobuf.FieldMask update_mask = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Protobuf\FieldMask|null
     */
    public function getUpdateMask()
    {
        return $this->update_mask;
    }

    public function hasUpdateMask()
    {
        return isset($this->update_mask);
    }

    public function clearUpdateMask()
    {
        unset($this->update_mask);
    }

    /**
     * Required. The fields to update. Accepts the following values:
     * * `intended_enablement_state`
     * * `modules`
     * If omitted, then all eligible fields are updated.
     *
     * Generated from protobuf field <code>.google.protobuf.FieldMask update_mask = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Protobuf\FieldMask $var
     * @return $this
     */
    public function setUpdateMask($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\FieldMask::class);
        $this->update_mask = $var;

        return $this;
    }

    /**
     * Optional. When set to `true`, the request will be validated (including IAM
     * checks), but no service will be updated. An `OK` response indicates that
     * the request is valid, while an error response indicates that the request is
     * invalid.
     * If the request is valid, a subsequent request to update the service could
     * still fail for one of the following reasons:
     * *  The state of your cloud resources changed; for example, you lost a
     *    required IAM permission
     * *  An error occurred during update of the service
     * Defaults to `false`.
     *
     * Generated from protobuf field <code>bool validate_only = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return bool
     */
    public function getValidateOnly()
    {
        return $this->validate_only;
    }

    /**
     * Optional. When set to `true`, the request will be validated (including IAM
     * checks), but no service will be updated. An `OK` response indicates that
     * the request is valid, while an error response indicates that the request is
     * invalid.
     * If the request is valid, a subsequent request to update the service could
     * still fail for one of the following reasons:
     * *  The state of your cloud resources changed; for example, you lost a
     *    required IAM permission
     * *  An error occurred during update of the service
     * Defaults to `false`.
     *
     * Generated from protobuf field <code>bool validate_only = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param bool $var
     * @return $this
     */
    public function setValidateOnly($var)
    {
        GPBUtil::checkBool($var);
        $this->validate_only = $var;

        return $this;
    }

}

