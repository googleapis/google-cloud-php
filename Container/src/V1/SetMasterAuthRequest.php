<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/container/v1/cluster_service.proto

namespace Google\Cloud\Container\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * SetMasterAuthRequest updates the admin password of a cluster.
 *
 * Generated from protobuf message <code>google.container.v1.SetMasterAuthRequest</code>
 */
class SetMasterAuthRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Deprecated. The Google Developers Console [project ID or project
     * number](https://cloud.google.com/resource-manager/docs/creating-managing-projects).
     * This field has been deprecated and replaced by the name field.
     *
     * Generated from protobuf field <code>string project_id = 1 [deprecated = true];</code>
     * @deprecated
     */
    protected $project_id = '';
    /**
     * Deprecated. The name of the Google Compute Engine
     * [zone](https://cloud.google.com/compute/docs/zones#available)
     * in which the cluster resides. This field has been deprecated and replaced
     * by the name field.
     *
     * Generated from protobuf field <code>string zone = 2 [deprecated = true];</code>
     * @deprecated
     */
    protected $zone = '';
    /**
     * Deprecated. The name of the cluster to upgrade.
     * This field has been deprecated and replaced by the name field.
     *
     * Generated from protobuf field <code>string cluster_id = 3 [deprecated = true];</code>
     * @deprecated
     */
    protected $cluster_id = '';
    /**
     * Required. The exact form of action to be taken on the master auth.
     *
     * Generated from protobuf field <code>.google.container.v1.SetMasterAuthRequest.Action action = 4 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $action = 0;
    /**
     * Required. A description of the update.
     *
     * Generated from protobuf field <code>.google.container.v1.MasterAuth update = 5 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $update = null;
    /**
     * The name (project, location, cluster) of the cluster to set auth.
     * Specified in the format `projects/&#42;&#47;locations/&#42;&#47;clusters/&#42;`.
     *
     * Generated from protobuf field <code>string name = 7;</code>
     */
    protected $name = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $project_id
     *           Deprecated. The Google Developers Console [project ID or project
     *           number](https://cloud.google.com/resource-manager/docs/creating-managing-projects).
     *           This field has been deprecated and replaced by the name field.
     *     @type string $zone
     *           Deprecated. The name of the Google Compute Engine
     *           [zone](https://cloud.google.com/compute/docs/zones#available)
     *           in which the cluster resides. This field has been deprecated and replaced
     *           by the name field.
     *     @type string $cluster_id
     *           Deprecated. The name of the cluster to upgrade.
     *           This field has been deprecated and replaced by the name field.
     *     @type int $action
     *           Required. The exact form of action to be taken on the master auth.
     *     @type \Google\Cloud\Container\V1\MasterAuth $update
     *           Required. A description of the update.
     *     @type string $name
     *           The name (project, location, cluster) of the cluster to set auth.
     *           Specified in the format `projects/&#42;&#47;locations/&#42;&#47;clusters/&#42;`.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Container\V1\ClusterService::initOnce();
        parent::__construct($data);
    }

    /**
     * Deprecated. The Google Developers Console [project ID or project
     * number](https://cloud.google.com/resource-manager/docs/creating-managing-projects).
     * This field has been deprecated and replaced by the name field.
     *
     * Generated from protobuf field <code>string project_id = 1 [deprecated = true];</code>
     * @return string
     * @deprecated
     */
    public function getProjectId()
    {
        if ($this->project_id !== '') {
            @trigger_error('project_id is deprecated.', E_USER_DEPRECATED);
        }
        return $this->project_id;
    }

    /**
     * Deprecated. The Google Developers Console [project ID or project
     * number](https://cloud.google.com/resource-manager/docs/creating-managing-projects).
     * This field has been deprecated and replaced by the name field.
     *
     * Generated from protobuf field <code>string project_id = 1 [deprecated = true];</code>
     * @param string $var
     * @return $this
     * @deprecated
     */
    public function setProjectId($var)
    {
        @trigger_error('project_id is deprecated.', E_USER_DEPRECATED);
        GPBUtil::checkString($var, True);
        $this->project_id = $var;

        return $this;
    }

    /**
     * Deprecated. The name of the Google Compute Engine
     * [zone](https://cloud.google.com/compute/docs/zones#available)
     * in which the cluster resides. This field has been deprecated and replaced
     * by the name field.
     *
     * Generated from protobuf field <code>string zone = 2 [deprecated = true];</code>
     * @return string
     * @deprecated
     */
    public function getZone()
    {
        if ($this->zone !== '') {
            @trigger_error('zone is deprecated.', E_USER_DEPRECATED);
        }
        return $this->zone;
    }

    /**
     * Deprecated. The name of the Google Compute Engine
     * [zone](https://cloud.google.com/compute/docs/zones#available)
     * in which the cluster resides. This field has been deprecated and replaced
     * by the name field.
     *
     * Generated from protobuf field <code>string zone = 2 [deprecated = true];</code>
     * @param string $var
     * @return $this
     * @deprecated
     */
    public function setZone($var)
    {
        @trigger_error('zone is deprecated.', E_USER_DEPRECATED);
        GPBUtil::checkString($var, True);
        $this->zone = $var;

        return $this;
    }

    /**
     * Deprecated. The name of the cluster to upgrade.
     * This field has been deprecated and replaced by the name field.
     *
     * Generated from protobuf field <code>string cluster_id = 3 [deprecated = true];</code>
     * @return string
     * @deprecated
     */
    public function getClusterId()
    {
        if ($this->cluster_id !== '') {
            @trigger_error('cluster_id is deprecated.', E_USER_DEPRECATED);
        }
        return $this->cluster_id;
    }

    /**
     * Deprecated. The name of the cluster to upgrade.
     * This field has been deprecated and replaced by the name field.
     *
     * Generated from protobuf field <code>string cluster_id = 3 [deprecated = true];</code>
     * @param string $var
     * @return $this
     * @deprecated
     */
    public function setClusterId($var)
    {
        @trigger_error('cluster_id is deprecated.', E_USER_DEPRECATED);
        GPBUtil::checkString($var, True);
        $this->cluster_id = $var;

        return $this;
    }

    /**
     * Required. The exact form of action to be taken on the master auth.
     *
     * Generated from protobuf field <code>.google.container.v1.SetMasterAuthRequest.Action action = 4 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return int
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Required. The exact form of action to be taken on the master auth.
     *
     * Generated from protobuf field <code>.google.container.v1.SetMasterAuthRequest.Action action = 4 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param int $var
     * @return $this
     */
    public function setAction($var)
    {
        GPBUtil::checkEnum($var, \Google\Cloud\Container\V1\SetMasterAuthRequest\Action::class);
        $this->action = $var;

        return $this;
    }

    /**
     * Required. A description of the update.
     *
     * Generated from protobuf field <code>.google.container.v1.MasterAuth update = 5 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Cloud\Container\V1\MasterAuth|null
     */
    public function getUpdate()
    {
        return $this->update;
    }

    public function hasUpdate()
    {
        return isset($this->update);
    }

    public function clearUpdate()
    {
        unset($this->update);
    }

    /**
     * Required. A description of the update.
     *
     * Generated from protobuf field <code>.google.container.v1.MasterAuth update = 5 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Cloud\Container\V1\MasterAuth $var
     * @return $this
     */
    public function setUpdate($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Container\V1\MasterAuth::class);
        $this->update = $var;

        return $this;
    }

    /**
     * The name (project, location, cluster) of the cluster to set auth.
     * Specified in the format `projects/&#42;&#47;locations/&#42;&#47;clusters/&#42;`.
     *
     * Generated from protobuf field <code>string name = 7;</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * The name (project, location, cluster) of the cluster to set auth.
     * Specified in the format `projects/&#42;&#47;locations/&#42;&#47;clusters/&#42;`.
     *
     * Generated from protobuf field <code>string name = 7;</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;

        return $this;
    }

}

