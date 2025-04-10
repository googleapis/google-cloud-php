<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/securitycentermanagement/v1/security_center_management.proto

namespace Google\Cloud\SecurityCenterManagement\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request message for
 * [SecurityCenterManagement.CreateSecurityHealthAnalyticsCustomModule][google.cloud.securitycentermanagement.v1.SecurityCenterManagement.CreateSecurityHealthAnalyticsCustomModule].
 *
 * Generated from protobuf message <code>google.cloud.securitycentermanagement.v1.CreateSecurityHealthAnalyticsCustomModuleRequest</code>
 */
class CreateSecurityHealthAnalyticsCustomModuleRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. Name of the parent organization, folder, or project of the
     * module, in one of the following formats:
     * * `organizations/{organization}/locations/{location}`
     * * `folders/{folder}/locations/{location}`
     * * `projects/{project}/locations/{location}`
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $parent = '';
    /**
     * Required. The resource being created.
     *
     * Generated from protobuf field <code>.google.cloud.securitycentermanagement.v1.SecurityHealthAnalyticsCustomModule security_health_analytics_custom_module = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $security_health_analytics_custom_module = null;
    /**
     * Optional. When set to `true`, the request will be validated (including IAM
     * checks), but no module will be created. An `OK` response indicates that the
     * request is valid, while an error response indicates that the request is
     * invalid.
     * If the request is valid, a subsequent request to create the module could
     * still fail for one of the following reasons:
     * *  The state of your cloud resources changed; for example, you lost a
     *    required IAM permission
     * *  An error occurred during creation of the module
     * Defaults to `false`.
     *
     * Generated from protobuf field <code>bool validate_only = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $validate_only = false;

    /**
     * @param string                                                                        $parent                              Required. Name of the parent organization, folder, or project of the
     *                                                                                                                           module, in one of the following formats:
     *
     *                                                                                                                           * `organizations/{organization}/locations/{location}`
     *                                                                                                                           * `folders/{folder}/locations/{location}`
     *                                                                                                                           * `projects/{project}/locations/{location}`
     *                                                                                                                           Please see {@see SecurityCenterManagementClient::organizationLocationName()} for help formatting this field.
     * @param \Google\Cloud\SecurityCenterManagement\V1\SecurityHealthAnalyticsCustomModule $securityHealthAnalyticsCustomModule Required. The resource being created.
     *
     * @return \Google\Cloud\SecurityCenterManagement\V1\CreateSecurityHealthAnalyticsCustomModuleRequest
     *
     * @experimental
     */
    public static function build(string $parent, \Google\Cloud\SecurityCenterManagement\V1\SecurityHealthAnalyticsCustomModule $securityHealthAnalyticsCustomModule): self
    {
        return (new self())
            ->setParent($parent)
            ->setSecurityHealthAnalyticsCustomModule($securityHealthAnalyticsCustomModule);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $parent
     *           Required. Name of the parent organization, folder, or project of the
     *           module, in one of the following formats:
     *           * `organizations/{organization}/locations/{location}`
     *           * `folders/{folder}/locations/{location}`
     *           * `projects/{project}/locations/{location}`
     *     @type \Google\Cloud\SecurityCenterManagement\V1\SecurityHealthAnalyticsCustomModule $security_health_analytics_custom_module
     *           Required. The resource being created.
     *     @type bool $validate_only
     *           Optional. When set to `true`, the request will be validated (including IAM
     *           checks), but no module will be created. An `OK` response indicates that the
     *           request is valid, while an error response indicates that the request is
     *           invalid.
     *           If the request is valid, a subsequent request to create the module could
     *           still fail for one of the following reasons:
     *           *  The state of your cloud resources changed; for example, you lost a
     *              required IAM permission
     *           *  An error occurred during creation of the module
     *           Defaults to `false`.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Securitycentermanagement\V1\SecurityCenterManagement::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. Name of the parent organization, folder, or project of the
     * module, in one of the following formats:
     * * `organizations/{organization}/locations/{location}`
     * * `folders/{folder}/locations/{location}`
     * * `projects/{project}/locations/{location}`
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Required. Name of the parent organization, folder, or project of the
     * module, in one of the following formats:
     * * `organizations/{organization}/locations/{location}`
     * * `folders/{folder}/locations/{location}`
     * * `projects/{project}/locations/{location}`
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setParent($var)
    {
        GPBUtil::checkString($var, True);
        $this->parent = $var;

        return $this;
    }

    /**
     * Required. The resource being created.
     *
     * Generated from protobuf field <code>.google.cloud.securitycentermanagement.v1.SecurityHealthAnalyticsCustomModule security_health_analytics_custom_module = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Cloud\SecurityCenterManagement\V1\SecurityHealthAnalyticsCustomModule|null
     */
    public function getSecurityHealthAnalyticsCustomModule()
    {
        return $this->security_health_analytics_custom_module;
    }

    public function hasSecurityHealthAnalyticsCustomModule()
    {
        return isset($this->security_health_analytics_custom_module);
    }

    public function clearSecurityHealthAnalyticsCustomModule()
    {
        unset($this->security_health_analytics_custom_module);
    }

    /**
     * Required. The resource being created.
     *
     * Generated from protobuf field <code>.google.cloud.securitycentermanagement.v1.SecurityHealthAnalyticsCustomModule security_health_analytics_custom_module = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Cloud\SecurityCenterManagement\V1\SecurityHealthAnalyticsCustomModule $var
     * @return $this
     */
    public function setSecurityHealthAnalyticsCustomModule($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\SecurityCenterManagement\V1\SecurityHealthAnalyticsCustomModule::class);
        $this->security_health_analytics_custom_module = $var;

        return $this;
    }

    /**
     * Optional. When set to `true`, the request will be validated (including IAM
     * checks), but no module will be created. An `OK` response indicates that the
     * request is valid, while an error response indicates that the request is
     * invalid.
     * If the request is valid, a subsequent request to create the module could
     * still fail for one of the following reasons:
     * *  The state of your cloud resources changed; for example, you lost a
     *    required IAM permission
     * *  An error occurred during creation of the module
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
     * checks), but no module will be created. An `OK` response indicates that the
     * request is valid, while an error response indicates that the request is
     * invalid.
     * If the request is valid, a subsequent request to create the module could
     * still fail for one of the following reasons:
     * *  The state of your cloud resources changed; for example, you lost a
     *    required IAM permission
     * *  An error occurred during creation of the module
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

