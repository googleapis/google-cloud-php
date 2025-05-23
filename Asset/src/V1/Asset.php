<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/asset/v1/assets.proto

namespace Google\Cloud\Asset\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * An asset in Google Cloud. An asset can be any resource in the Google Cloud
 * [resource
 * hierarchy](https://cloud.google.com/resource-manager/docs/cloud-platform-resource-hierarchy),
 * a resource outside the Google Cloud resource hierarchy (such as Google
 * Kubernetes Engine clusters and objects), or a policy (e.g. IAM policy),
 * or a relationship (e.g. an INSTANCE_TO_INSTANCEGROUP relationship).
 * See [Supported asset
 * types](https://cloud.google.com/asset-inventory/docs/supported-asset-types)
 * for more information.
 *
 * Generated from protobuf message <code>google.cloud.asset.v1.Asset</code>
 */
class Asset extends \Google\Protobuf\Internal\Message
{
    /**
     * The last update timestamp of an asset. update_time is updated when
     * create/update/delete operation is performed.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp update_time = 11;</code>
     */
    protected $update_time = null;
    /**
     * The full name of the asset. Example:
     * `//compute.googleapis.com/projects/my_project_123/zones/zone1/instances/instance1`
     * See [Resource
     * names](https://cloud.google.com/apis/design/resource_names#full_resource_name)
     * for more information.
     *
     * Generated from protobuf field <code>string name = 1;</code>
     */
    protected $name = '';
    /**
     * The type of the asset. Example: `compute.googleapis.com/Disk`
     * See [Supported asset
     * types](https://cloud.google.com/asset-inventory/docs/supported-asset-types)
     * for more information.
     *
     * Generated from protobuf field <code>string asset_type = 2;</code>
     */
    protected $asset_type = '';
    /**
     * A representation of the resource.
     *
     * Generated from protobuf field <code>.google.cloud.asset.v1.Resource resource = 3;</code>
     */
    protected $resource = null;
    /**
     * A representation of the IAM policy set on a Google Cloud resource.
     * There can be a maximum of one IAM policy set on any given resource.
     * In addition, IAM policies inherit their granted access scope from any
     * policies set on parent resources in the resource hierarchy. Therefore, the
     * effectively policy is the union of both the policy set on this resource
     * and each policy set on all of the resource's ancestry resource levels in
     * the hierarchy. See
     * [this topic](https://cloud.google.com/iam/help/allow-policies/inheritance)
     * for more information.
     *
     * Generated from protobuf field <code>.google.iam.v1.Policy iam_policy = 4;</code>
     */
    protected $iam_policy = null;
    /**
     * A representation of an [organization
     * policy](https://cloud.google.com/resource-manager/docs/organization-policy/overview#organization_policy).
     * There can be more than one organization policy with different constraints
     * set on a given resource.
     *
     * Generated from protobuf field <code>repeated .google.cloud.orgpolicy.v1.Policy org_policy = 6;</code>
     */
    private $org_policy;
    /**
     * A representation of runtime OS Inventory information. See [this
     * topic](https://cloud.google.com/compute/docs/instances/os-inventory-management)
     * for more information.
     *
     * Generated from protobuf field <code>.google.cloud.osconfig.v1.Inventory os_inventory = 12;</code>
     */
    protected $os_inventory = null;
    /**
     * DEPRECATED. This field only presents for the purpose of
     * backward-compatibility. The server will never generate responses with this
     * field.
     * The related assets of the asset of one relationship type. One asset
     * only represents one type of relationship.
     *
     * Generated from protobuf field <code>.google.cloud.asset.v1.RelatedAssets related_assets = 13 [deprecated = true];</code>
     * @deprecated
     */
    protected $related_assets = null;
    /**
     * One related asset of the current asset.
     *
     * Generated from protobuf field <code>.google.cloud.asset.v1.RelatedAsset related_asset = 15;</code>
     */
    protected $related_asset = null;
    /**
     * The ancestry path of an asset in Google Cloud [resource
     * hierarchy](https://cloud.google.com/resource-manager/docs/cloud-platform-resource-hierarchy),
     * represented as a list of relative resource names. An ancestry path starts
     * with the closest ancestor in the hierarchy and ends at root. If the asset
     * is a project, folder, or organization, the ancestry path starts from the
     * asset itself.
     * Example: `["projects/123456789", "folders/5432", "organizations/1234"]`
     *
     * Generated from protobuf field <code>repeated string ancestors = 10;</code>
     */
    private $ancestors;
    protected $access_context_policy;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Protobuf\Timestamp $update_time
     *           The last update timestamp of an asset. update_time is updated when
     *           create/update/delete operation is performed.
     *     @type string $name
     *           The full name of the asset. Example:
     *           `//compute.googleapis.com/projects/my_project_123/zones/zone1/instances/instance1`
     *           See [Resource
     *           names](https://cloud.google.com/apis/design/resource_names#full_resource_name)
     *           for more information.
     *     @type string $asset_type
     *           The type of the asset. Example: `compute.googleapis.com/Disk`
     *           See [Supported asset
     *           types](https://cloud.google.com/asset-inventory/docs/supported-asset-types)
     *           for more information.
     *     @type \Google\Cloud\Asset\V1\Resource $resource
     *           A representation of the resource.
     *     @type \Google\Cloud\Iam\V1\Policy $iam_policy
     *           A representation of the IAM policy set on a Google Cloud resource.
     *           There can be a maximum of one IAM policy set on any given resource.
     *           In addition, IAM policies inherit their granted access scope from any
     *           policies set on parent resources in the resource hierarchy. Therefore, the
     *           effectively policy is the union of both the policy set on this resource
     *           and each policy set on all of the resource's ancestry resource levels in
     *           the hierarchy. See
     *           [this topic](https://cloud.google.com/iam/help/allow-policies/inheritance)
     *           for more information.
     *     @type array<\Google\Cloud\OrgPolicy\V1\Policy>|\Google\Protobuf\Internal\RepeatedField $org_policy
     *           A representation of an [organization
     *           policy](https://cloud.google.com/resource-manager/docs/organization-policy/overview#organization_policy).
     *           There can be more than one organization policy with different constraints
     *           set on a given resource.
     *     @type \Google\Identity\AccessContextManager\V1\AccessPolicy $access_policy
     *           Also refer to the [access policy user
     *           guide](https://cloud.google.com/access-context-manager/docs/overview#access-policies).
     *     @type \Google\Identity\AccessContextManager\V1\AccessLevel $access_level
     *           Also refer to the [access level user
     *           guide](https://cloud.google.com/access-context-manager/docs/overview#access-levels).
     *     @type \Google\Identity\AccessContextManager\V1\ServicePerimeter $service_perimeter
     *           Also refer to the [service perimeter user
     *           guide](https://cloud.google.com/vpc-service-controls/docs/overview).
     *     @type \Google\Cloud\OsConfig\V1\Inventory $os_inventory
     *           A representation of runtime OS Inventory information. See [this
     *           topic](https://cloud.google.com/compute/docs/instances/os-inventory-management)
     *           for more information.
     *     @type \Google\Cloud\Asset\V1\RelatedAssets $related_assets
     *           DEPRECATED. This field only presents for the purpose of
     *           backward-compatibility. The server will never generate responses with this
     *           field.
     *           The related assets of the asset of one relationship type. One asset
     *           only represents one type of relationship.
     *     @type \Google\Cloud\Asset\V1\RelatedAsset $related_asset
     *           One related asset of the current asset.
     *     @type array<string>|\Google\Protobuf\Internal\RepeatedField $ancestors
     *           The ancestry path of an asset in Google Cloud [resource
     *           hierarchy](https://cloud.google.com/resource-manager/docs/cloud-platform-resource-hierarchy),
     *           represented as a list of relative resource names. An ancestry path starts
     *           with the closest ancestor in the hierarchy and ends at root. If the asset
     *           is a project, folder, or organization, the ancestry path starts from the
     *           asset itself.
     *           Example: `["projects/123456789", "folders/5432", "organizations/1234"]`
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Asset\V1\Assets::initOnce();
        parent::__construct($data);
    }

    /**
     * The last update timestamp of an asset. update_time is updated when
     * create/update/delete operation is performed.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp update_time = 11;</code>
     * @return \Google\Protobuf\Timestamp|null
     */
    public function getUpdateTime()
    {
        return $this->update_time;
    }

    public function hasUpdateTime()
    {
        return isset($this->update_time);
    }

    public function clearUpdateTime()
    {
        unset($this->update_time);
    }

    /**
     * The last update timestamp of an asset. update_time is updated when
     * create/update/delete operation is performed.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp update_time = 11;</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setUpdateTime($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->update_time = $var;

        return $this;
    }

    /**
     * The full name of the asset. Example:
     * `//compute.googleapis.com/projects/my_project_123/zones/zone1/instances/instance1`
     * See [Resource
     * names](https://cloud.google.com/apis/design/resource_names#full_resource_name)
     * for more information.
     *
     * Generated from protobuf field <code>string name = 1;</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * The full name of the asset. Example:
     * `//compute.googleapis.com/projects/my_project_123/zones/zone1/instances/instance1`
     * See [Resource
     * names](https://cloud.google.com/apis/design/resource_names#full_resource_name)
     * for more information.
     *
     * Generated from protobuf field <code>string name = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;

        return $this;
    }

    /**
     * The type of the asset. Example: `compute.googleapis.com/Disk`
     * See [Supported asset
     * types](https://cloud.google.com/asset-inventory/docs/supported-asset-types)
     * for more information.
     *
     * Generated from protobuf field <code>string asset_type = 2;</code>
     * @return string
     */
    public function getAssetType()
    {
        return $this->asset_type;
    }

    /**
     * The type of the asset. Example: `compute.googleapis.com/Disk`
     * See [Supported asset
     * types](https://cloud.google.com/asset-inventory/docs/supported-asset-types)
     * for more information.
     *
     * Generated from protobuf field <code>string asset_type = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setAssetType($var)
    {
        GPBUtil::checkString($var, True);
        $this->asset_type = $var;

        return $this;
    }

    /**
     * A representation of the resource.
     *
     * Generated from protobuf field <code>.google.cloud.asset.v1.Resource resource = 3;</code>
     * @return \Google\Cloud\Asset\V1\Resource|null
     */
    public function getResource()
    {
        return $this->resource;
    }

    public function hasResource()
    {
        return isset($this->resource);
    }

    public function clearResource()
    {
        unset($this->resource);
    }

    /**
     * A representation of the resource.
     *
     * Generated from protobuf field <code>.google.cloud.asset.v1.Resource resource = 3;</code>
     * @param \Google\Cloud\Asset\V1\Resource $var
     * @return $this
     */
    public function setResource($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Asset\V1\Resource::class);
        $this->resource = $var;

        return $this;
    }

    /**
     * A representation of the IAM policy set on a Google Cloud resource.
     * There can be a maximum of one IAM policy set on any given resource.
     * In addition, IAM policies inherit their granted access scope from any
     * policies set on parent resources in the resource hierarchy. Therefore, the
     * effectively policy is the union of both the policy set on this resource
     * and each policy set on all of the resource's ancestry resource levels in
     * the hierarchy. See
     * [this topic](https://cloud.google.com/iam/help/allow-policies/inheritance)
     * for more information.
     *
     * Generated from protobuf field <code>.google.iam.v1.Policy iam_policy = 4;</code>
     * @return \Google\Cloud\Iam\V1\Policy|null
     */
    public function getIamPolicy()
    {
        return $this->iam_policy;
    }

    public function hasIamPolicy()
    {
        return isset($this->iam_policy);
    }

    public function clearIamPolicy()
    {
        unset($this->iam_policy);
    }

    /**
     * A representation of the IAM policy set on a Google Cloud resource.
     * There can be a maximum of one IAM policy set on any given resource.
     * In addition, IAM policies inherit their granted access scope from any
     * policies set on parent resources in the resource hierarchy. Therefore, the
     * effectively policy is the union of both the policy set on this resource
     * and each policy set on all of the resource's ancestry resource levels in
     * the hierarchy. See
     * [this topic](https://cloud.google.com/iam/help/allow-policies/inheritance)
     * for more information.
     *
     * Generated from protobuf field <code>.google.iam.v1.Policy iam_policy = 4;</code>
     * @param \Google\Cloud\Iam\V1\Policy $var
     * @return $this
     */
    public function setIamPolicy($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Iam\V1\Policy::class);
        $this->iam_policy = $var;

        return $this;
    }

    /**
     * A representation of an [organization
     * policy](https://cloud.google.com/resource-manager/docs/organization-policy/overview#organization_policy).
     * There can be more than one organization policy with different constraints
     * set on a given resource.
     *
     * Generated from protobuf field <code>repeated .google.cloud.orgpolicy.v1.Policy org_policy = 6;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getOrgPolicy()
    {
        return $this->org_policy;
    }

    /**
     * A representation of an [organization
     * policy](https://cloud.google.com/resource-manager/docs/organization-policy/overview#organization_policy).
     * There can be more than one organization policy with different constraints
     * set on a given resource.
     *
     * Generated from protobuf field <code>repeated .google.cloud.orgpolicy.v1.Policy org_policy = 6;</code>
     * @param array<\Google\Cloud\OrgPolicy\V1\Policy>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setOrgPolicy($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\OrgPolicy\V1\Policy::class);
        $this->org_policy = $arr;

        return $this;
    }

    /**
     * Also refer to the [access policy user
     * guide](https://cloud.google.com/access-context-manager/docs/overview#access-policies).
     *
     * Generated from protobuf field <code>.google.identity.accesscontextmanager.v1.AccessPolicy access_policy = 7;</code>
     * @return \Google\Identity\AccessContextManager\V1\AccessPolicy|null
     */
    public function getAccessPolicy()
    {
        return $this->readOneof(7);
    }

    public function hasAccessPolicy()
    {
        return $this->hasOneof(7);
    }

    /**
     * Also refer to the [access policy user
     * guide](https://cloud.google.com/access-context-manager/docs/overview#access-policies).
     *
     * Generated from protobuf field <code>.google.identity.accesscontextmanager.v1.AccessPolicy access_policy = 7;</code>
     * @param \Google\Identity\AccessContextManager\V1\AccessPolicy $var
     * @return $this
     */
    public function setAccessPolicy($var)
    {
        GPBUtil::checkMessage($var, \Google\Identity\AccessContextManager\V1\AccessPolicy::class);
        $this->writeOneof(7, $var);

        return $this;
    }

    /**
     * Also refer to the [access level user
     * guide](https://cloud.google.com/access-context-manager/docs/overview#access-levels).
     *
     * Generated from protobuf field <code>.google.identity.accesscontextmanager.v1.AccessLevel access_level = 8;</code>
     * @return \Google\Identity\AccessContextManager\V1\AccessLevel|null
     */
    public function getAccessLevel()
    {
        return $this->readOneof(8);
    }

    public function hasAccessLevel()
    {
        return $this->hasOneof(8);
    }

    /**
     * Also refer to the [access level user
     * guide](https://cloud.google.com/access-context-manager/docs/overview#access-levels).
     *
     * Generated from protobuf field <code>.google.identity.accesscontextmanager.v1.AccessLevel access_level = 8;</code>
     * @param \Google\Identity\AccessContextManager\V1\AccessLevel $var
     * @return $this
     */
    public function setAccessLevel($var)
    {
        GPBUtil::checkMessage($var, \Google\Identity\AccessContextManager\V1\AccessLevel::class);
        $this->writeOneof(8, $var);

        return $this;
    }

    /**
     * Also refer to the [service perimeter user
     * guide](https://cloud.google.com/vpc-service-controls/docs/overview).
     *
     * Generated from protobuf field <code>.google.identity.accesscontextmanager.v1.ServicePerimeter service_perimeter = 9;</code>
     * @return \Google\Identity\AccessContextManager\V1\ServicePerimeter|null
     */
    public function getServicePerimeter()
    {
        return $this->readOneof(9);
    }

    public function hasServicePerimeter()
    {
        return $this->hasOneof(9);
    }

    /**
     * Also refer to the [service perimeter user
     * guide](https://cloud.google.com/vpc-service-controls/docs/overview).
     *
     * Generated from protobuf field <code>.google.identity.accesscontextmanager.v1.ServicePerimeter service_perimeter = 9;</code>
     * @param \Google\Identity\AccessContextManager\V1\ServicePerimeter $var
     * @return $this
     */
    public function setServicePerimeter($var)
    {
        GPBUtil::checkMessage($var, \Google\Identity\AccessContextManager\V1\ServicePerimeter::class);
        $this->writeOneof(9, $var);

        return $this;
    }

    /**
     * A representation of runtime OS Inventory information. See [this
     * topic](https://cloud.google.com/compute/docs/instances/os-inventory-management)
     * for more information.
     *
     * Generated from protobuf field <code>.google.cloud.osconfig.v1.Inventory os_inventory = 12;</code>
     * @return \Google\Cloud\OsConfig\V1\Inventory|null
     */
    public function getOsInventory()
    {
        return $this->os_inventory;
    }

    public function hasOsInventory()
    {
        return isset($this->os_inventory);
    }

    public function clearOsInventory()
    {
        unset($this->os_inventory);
    }

    /**
     * A representation of runtime OS Inventory information. See [this
     * topic](https://cloud.google.com/compute/docs/instances/os-inventory-management)
     * for more information.
     *
     * Generated from protobuf field <code>.google.cloud.osconfig.v1.Inventory os_inventory = 12;</code>
     * @param \Google\Cloud\OsConfig\V1\Inventory $var
     * @return $this
     */
    public function setOsInventory($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\OsConfig\V1\Inventory::class);
        $this->os_inventory = $var;

        return $this;
    }

    /**
     * DEPRECATED. This field only presents for the purpose of
     * backward-compatibility. The server will never generate responses with this
     * field.
     * The related assets of the asset of one relationship type. One asset
     * only represents one type of relationship.
     *
     * Generated from protobuf field <code>.google.cloud.asset.v1.RelatedAssets related_assets = 13 [deprecated = true];</code>
     * @return \Google\Cloud\Asset\V1\RelatedAssets|null
     * @deprecated
     */
    public function getRelatedAssets()
    {
        if (isset($this->related_assets)) {
            @trigger_error('related_assets is deprecated.', E_USER_DEPRECATED);
        }
        return $this->related_assets;
    }

    public function hasRelatedAssets()
    {
        if (isset($this->related_assets)) {
            @trigger_error('related_assets is deprecated.', E_USER_DEPRECATED);
        }
        return isset($this->related_assets);
    }

    public function clearRelatedAssets()
    {
        @trigger_error('related_assets is deprecated.', E_USER_DEPRECATED);
        unset($this->related_assets);
    }

    /**
     * DEPRECATED. This field only presents for the purpose of
     * backward-compatibility. The server will never generate responses with this
     * field.
     * The related assets of the asset of one relationship type. One asset
     * only represents one type of relationship.
     *
     * Generated from protobuf field <code>.google.cloud.asset.v1.RelatedAssets related_assets = 13 [deprecated = true];</code>
     * @param \Google\Cloud\Asset\V1\RelatedAssets $var
     * @return $this
     * @deprecated
     */
    public function setRelatedAssets($var)
    {
        @trigger_error('related_assets is deprecated.', E_USER_DEPRECATED);
        GPBUtil::checkMessage($var, \Google\Cloud\Asset\V1\RelatedAssets::class);
        $this->related_assets = $var;

        return $this;
    }

    /**
     * One related asset of the current asset.
     *
     * Generated from protobuf field <code>.google.cloud.asset.v1.RelatedAsset related_asset = 15;</code>
     * @return \Google\Cloud\Asset\V1\RelatedAsset|null
     */
    public function getRelatedAsset()
    {
        return $this->related_asset;
    }

    public function hasRelatedAsset()
    {
        return isset($this->related_asset);
    }

    public function clearRelatedAsset()
    {
        unset($this->related_asset);
    }

    /**
     * One related asset of the current asset.
     *
     * Generated from protobuf field <code>.google.cloud.asset.v1.RelatedAsset related_asset = 15;</code>
     * @param \Google\Cloud\Asset\V1\RelatedAsset $var
     * @return $this
     */
    public function setRelatedAsset($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Asset\V1\RelatedAsset::class);
        $this->related_asset = $var;

        return $this;
    }

    /**
     * The ancestry path of an asset in Google Cloud [resource
     * hierarchy](https://cloud.google.com/resource-manager/docs/cloud-platform-resource-hierarchy),
     * represented as a list of relative resource names. An ancestry path starts
     * with the closest ancestor in the hierarchy and ends at root. If the asset
     * is a project, folder, or organization, the ancestry path starts from the
     * asset itself.
     * Example: `["projects/123456789", "folders/5432", "organizations/1234"]`
     *
     * Generated from protobuf field <code>repeated string ancestors = 10;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getAncestors()
    {
        return $this->ancestors;
    }

    /**
     * The ancestry path of an asset in Google Cloud [resource
     * hierarchy](https://cloud.google.com/resource-manager/docs/cloud-platform-resource-hierarchy),
     * represented as a list of relative resource names. An ancestry path starts
     * with the closest ancestor in the hierarchy and ends at root. If the asset
     * is a project, folder, or organization, the ancestry path starts from the
     * asset itself.
     * Example: `["projects/123456789", "folders/5432", "organizations/1234"]`
     *
     * Generated from protobuf field <code>repeated string ancestors = 10;</code>
     * @param array<string>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setAncestors($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->ancestors = $arr;

        return $this;
    }

    /**
     * @return string
     */
    public function getAccessContextPolicy()
    {
        return $this->whichOneof("access_context_policy");
    }

}

