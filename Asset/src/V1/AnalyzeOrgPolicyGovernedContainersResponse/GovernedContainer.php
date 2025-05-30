<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/asset/v1/asset_service.proto

namespace Google\Cloud\Asset\V1\AnalyzeOrgPolicyGovernedContainersResponse;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The organization/folder/project resource governed by organization policies
 * of
 * [AnalyzeOrgPolicyGovernedContainersRequest.constraint][google.cloud.asset.v1.AnalyzeOrgPolicyGovernedContainersRequest.constraint].
 *
 * Generated from protobuf message <code>google.cloud.asset.v1.AnalyzeOrgPolicyGovernedContainersResponse.GovernedContainer</code>
 */
class GovernedContainer extends \Google\Protobuf\Internal\Message
{
    /**
     * The [full resource name]
     * (https://cloud.google.com/asset-inventory/docs/resource-name-format) of
     * an organization/folder/project resource.
     *
     * Generated from protobuf field <code>string full_resource_name = 1;</code>
     */
    protected $full_resource_name = '';
    /**
     * The [full resource name]
     * (https://cloud.google.com/asset-inventory/docs/resource-name-format) of
     * the parent of
     * [AnalyzeOrgPolicyGovernedContainersResponse.GovernedContainer.full_resource_name][google.cloud.asset.v1.AnalyzeOrgPolicyGovernedContainersResponse.GovernedContainer.full_resource_name].
     *
     * Generated from protobuf field <code>string parent = 2;</code>
     */
    protected $parent = '';
    /**
     * The consolidated organization policy for the analyzed resource. The
     * consolidated organization policy is computed by merging and evaluating
     * [AnalyzeOrgPolicyGovernedContainersResponse.GovernedContainer.policy_bundle][google.cloud.asset.v1.AnalyzeOrgPolicyGovernedContainersResponse.GovernedContainer.policy_bundle].
     * The evaluation will respect the organization policy [hierarchy
     * rules](https://cloud.google.com/resource-manager/docs/organization-policy/understanding-hierarchy).
     *
     * Generated from protobuf field <code>.google.cloud.asset.v1.AnalyzerOrgPolicy consolidated_policy = 3;</code>
     */
    protected $consolidated_policy = null;
    /**
     * The ordered list of all organization policies from the
     * [consolidated_policy.attached_resource][google.cloud.asset.v1.AnalyzerOrgPolicy.attached_resource].
     * to the scope specified in the request.
     * If the constraint is defined with default policy, it will also appear in
     * the list.
     *
     * Generated from protobuf field <code>repeated .google.cloud.asset.v1.AnalyzerOrgPolicy policy_bundle = 4;</code>
     */
    private $policy_bundle;
    /**
     * The project that this resource belongs to, in the format of
     * projects/{PROJECT_NUMBER}. This field is available when the resource
     * belongs to a project.
     *
     * Generated from protobuf field <code>string project = 5;</code>
     */
    protected $project = '';
    /**
     * The folder(s) that this resource belongs to, in the format of
     * folders/{FOLDER_NUMBER}. This field is available when the resource
     * belongs (directly or cascadingly) to one or more folders.
     *
     * Generated from protobuf field <code>repeated string folders = 6;</code>
     */
    private $folders;
    /**
     * The organization that this resource belongs to, in the format of
     * organizations/{ORGANIZATION_NUMBER}. This field is available when the
     * resource belongs (directly or cascadingly) to an organization.
     *
     * Generated from protobuf field <code>string organization = 7;</code>
     */
    protected $organization = '';
    /**
     * The effective tags on this resource.
     *
     * Generated from protobuf field <code>repeated .google.cloud.asset.v1.EffectiveTagDetails effective_tags = 8;</code>
     */
    private $effective_tags;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $full_resource_name
     *           The [full resource name]
     *           (https://cloud.google.com/asset-inventory/docs/resource-name-format) of
     *           an organization/folder/project resource.
     *     @type string $parent
     *           The [full resource name]
     *           (https://cloud.google.com/asset-inventory/docs/resource-name-format) of
     *           the parent of
     *           [AnalyzeOrgPolicyGovernedContainersResponse.GovernedContainer.full_resource_name][google.cloud.asset.v1.AnalyzeOrgPolicyGovernedContainersResponse.GovernedContainer.full_resource_name].
     *     @type \Google\Cloud\Asset\V1\AnalyzerOrgPolicy $consolidated_policy
     *           The consolidated organization policy for the analyzed resource. The
     *           consolidated organization policy is computed by merging and evaluating
     *           [AnalyzeOrgPolicyGovernedContainersResponse.GovernedContainer.policy_bundle][google.cloud.asset.v1.AnalyzeOrgPolicyGovernedContainersResponse.GovernedContainer.policy_bundle].
     *           The evaluation will respect the organization policy [hierarchy
     *           rules](https://cloud.google.com/resource-manager/docs/organization-policy/understanding-hierarchy).
     *     @type array<\Google\Cloud\Asset\V1\AnalyzerOrgPolicy>|\Google\Protobuf\Internal\RepeatedField $policy_bundle
     *           The ordered list of all organization policies from the
     *           [consolidated_policy.attached_resource][google.cloud.asset.v1.AnalyzerOrgPolicy.attached_resource].
     *           to the scope specified in the request.
     *           If the constraint is defined with default policy, it will also appear in
     *           the list.
     *     @type string $project
     *           The project that this resource belongs to, in the format of
     *           projects/{PROJECT_NUMBER}. This field is available when the resource
     *           belongs to a project.
     *     @type array<string>|\Google\Protobuf\Internal\RepeatedField $folders
     *           The folder(s) that this resource belongs to, in the format of
     *           folders/{FOLDER_NUMBER}. This field is available when the resource
     *           belongs (directly or cascadingly) to one or more folders.
     *     @type string $organization
     *           The organization that this resource belongs to, in the format of
     *           organizations/{ORGANIZATION_NUMBER}. This field is available when the
     *           resource belongs (directly or cascadingly) to an organization.
     *     @type array<\Google\Cloud\Asset\V1\EffectiveTagDetails>|\Google\Protobuf\Internal\RepeatedField $effective_tags
     *           The effective tags on this resource.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Asset\V1\AssetService::initOnce();
        parent::__construct($data);
    }

    /**
     * The [full resource name]
     * (https://cloud.google.com/asset-inventory/docs/resource-name-format) of
     * an organization/folder/project resource.
     *
     * Generated from protobuf field <code>string full_resource_name = 1;</code>
     * @return string
     */
    public function getFullResourceName()
    {
        return $this->full_resource_name;
    }

    /**
     * The [full resource name]
     * (https://cloud.google.com/asset-inventory/docs/resource-name-format) of
     * an organization/folder/project resource.
     *
     * Generated from protobuf field <code>string full_resource_name = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setFullResourceName($var)
    {
        GPBUtil::checkString($var, True);
        $this->full_resource_name = $var;

        return $this;
    }

    /**
     * The [full resource name]
     * (https://cloud.google.com/asset-inventory/docs/resource-name-format) of
     * the parent of
     * [AnalyzeOrgPolicyGovernedContainersResponse.GovernedContainer.full_resource_name][google.cloud.asset.v1.AnalyzeOrgPolicyGovernedContainersResponse.GovernedContainer.full_resource_name].
     *
     * Generated from protobuf field <code>string parent = 2;</code>
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * The [full resource name]
     * (https://cloud.google.com/asset-inventory/docs/resource-name-format) of
     * the parent of
     * [AnalyzeOrgPolicyGovernedContainersResponse.GovernedContainer.full_resource_name][google.cloud.asset.v1.AnalyzeOrgPolicyGovernedContainersResponse.GovernedContainer.full_resource_name].
     *
     * Generated from protobuf field <code>string parent = 2;</code>
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
     * The consolidated organization policy for the analyzed resource. The
     * consolidated organization policy is computed by merging and evaluating
     * [AnalyzeOrgPolicyGovernedContainersResponse.GovernedContainer.policy_bundle][google.cloud.asset.v1.AnalyzeOrgPolicyGovernedContainersResponse.GovernedContainer.policy_bundle].
     * The evaluation will respect the organization policy [hierarchy
     * rules](https://cloud.google.com/resource-manager/docs/organization-policy/understanding-hierarchy).
     *
     * Generated from protobuf field <code>.google.cloud.asset.v1.AnalyzerOrgPolicy consolidated_policy = 3;</code>
     * @return \Google\Cloud\Asset\V1\AnalyzerOrgPolicy|null
     */
    public function getConsolidatedPolicy()
    {
        return $this->consolidated_policy;
    }

    public function hasConsolidatedPolicy()
    {
        return isset($this->consolidated_policy);
    }

    public function clearConsolidatedPolicy()
    {
        unset($this->consolidated_policy);
    }

    /**
     * The consolidated organization policy for the analyzed resource. The
     * consolidated organization policy is computed by merging and evaluating
     * [AnalyzeOrgPolicyGovernedContainersResponse.GovernedContainer.policy_bundle][google.cloud.asset.v1.AnalyzeOrgPolicyGovernedContainersResponse.GovernedContainer.policy_bundle].
     * The evaluation will respect the organization policy [hierarchy
     * rules](https://cloud.google.com/resource-manager/docs/organization-policy/understanding-hierarchy).
     *
     * Generated from protobuf field <code>.google.cloud.asset.v1.AnalyzerOrgPolicy consolidated_policy = 3;</code>
     * @param \Google\Cloud\Asset\V1\AnalyzerOrgPolicy $var
     * @return $this
     */
    public function setConsolidatedPolicy($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Asset\V1\AnalyzerOrgPolicy::class);
        $this->consolidated_policy = $var;

        return $this;
    }

    /**
     * The ordered list of all organization policies from the
     * [consolidated_policy.attached_resource][google.cloud.asset.v1.AnalyzerOrgPolicy.attached_resource].
     * to the scope specified in the request.
     * If the constraint is defined with default policy, it will also appear in
     * the list.
     *
     * Generated from protobuf field <code>repeated .google.cloud.asset.v1.AnalyzerOrgPolicy policy_bundle = 4;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getPolicyBundle()
    {
        return $this->policy_bundle;
    }

    /**
     * The ordered list of all organization policies from the
     * [consolidated_policy.attached_resource][google.cloud.asset.v1.AnalyzerOrgPolicy.attached_resource].
     * to the scope specified in the request.
     * If the constraint is defined with default policy, it will also appear in
     * the list.
     *
     * Generated from protobuf field <code>repeated .google.cloud.asset.v1.AnalyzerOrgPolicy policy_bundle = 4;</code>
     * @param array<\Google\Cloud\Asset\V1\AnalyzerOrgPolicy>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setPolicyBundle($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\Asset\V1\AnalyzerOrgPolicy::class);
        $this->policy_bundle = $arr;

        return $this;
    }

    /**
     * The project that this resource belongs to, in the format of
     * projects/{PROJECT_NUMBER}. This field is available when the resource
     * belongs to a project.
     *
     * Generated from protobuf field <code>string project = 5;</code>
     * @return string
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * The project that this resource belongs to, in the format of
     * projects/{PROJECT_NUMBER}. This field is available when the resource
     * belongs to a project.
     *
     * Generated from protobuf field <code>string project = 5;</code>
     * @param string $var
     * @return $this
     */
    public function setProject($var)
    {
        GPBUtil::checkString($var, True);
        $this->project = $var;

        return $this;
    }

    /**
     * The folder(s) that this resource belongs to, in the format of
     * folders/{FOLDER_NUMBER}. This field is available when the resource
     * belongs (directly or cascadingly) to one or more folders.
     *
     * Generated from protobuf field <code>repeated string folders = 6;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getFolders()
    {
        return $this->folders;
    }

    /**
     * The folder(s) that this resource belongs to, in the format of
     * folders/{FOLDER_NUMBER}. This field is available when the resource
     * belongs (directly or cascadingly) to one or more folders.
     *
     * Generated from protobuf field <code>repeated string folders = 6;</code>
     * @param array<string>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setFolders($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->folders = $arr;

        return $this;
    }

    /**
     * The organization that this resource belongs to, in the format of
     * organizations/{ORGANIZATION_NUMBER}. This field is available when the
     * resource belongs (directly or cascadingly) to an organization.
     *
     * Generated from protobuf field <code>string organization = 7;</code>
     * @return string
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * The organization that this resource belongs to, in the format of
     * organizations/{ORGANIZATION_NUMBER}. This field is available when the
     * resource belongs (directly or cascadingly) to an organization.
     *
     * Generated from protobuf field <code>string organization = 7;</code>
     * @param string $var
     * @return $this
     */
    public function setOrganization($var)
    {
        GPBUtil::checkString($var, True);
        $this->organization = $var;

        return $this;
    }

    /**
     * The effective tags on this resource.
     *
     * Generated from protobuf field <code>repeated .google.cloud.asset.v1.EffectiveTagDetails effective_tags = 8;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getEffectiveTags()
    {
        return $this->effective_tags;
    }

    /**
     * The effective tags on this resource.
     *
     * Generated from protobuf field <code>repeated .google.cloud.asset.v1.EffectiveTagDetails effective_tags = 8;</code>
     * @param array<\Google\Cloud\Asset\V1\EffectiveTagDetails>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setEffectiveTags($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\Asset\V1\EffectiveTagDetails::class);
        $this->effective_tags = $arr;

        return $this;
    }

}


