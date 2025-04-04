<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/networkconnectivity/v1/hub.proto

namespace Google\Cloud\NetworkConnectivity\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A Network Connectivity Center hub is a global management resource to which
 * you attach spokes. A single hub can contain spokes from multiple regions.
 * However, if any of a hub's spokes use the site-to-site data transfer feature,
 * the resources associated with those spokes must all be in the same VPC
 * network. Spokes that do not use site-to-site data transfer can be associated
 * with any VPC network in your project.
 *
 * Generated from protobuf message <code>google.cloud.networkconnectivity.v1.Hub</code>
 */
class Hub extends \Google\Protobuf\Internal\Message
{
    /**
     * Immutable. The name of the hub. Hub names must be unique. They use the
     * following form:
     *     `projects/{project_number}/locations/global/hubs/{hub_id}`
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = IMMUTABLE];</code>
     */
    protected $name = '';
    /**
     * Output only. The time the hub was created.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp create_time = 2 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $create_time = null;
    /**
     * Output only. The time the hub was last updated.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp update_time = 3 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $update_time = null;
    /**
     * Optional labels in key-value pair format. For more information about
     * labels, see [Requirements for
     * labels](https://cloud.google.com/resource-manager/docs/creating-managing-labels#requirements).
     *
     * Generated from protobuf field <code>map<string, string> labels = 4;</code>
     */
    private $labels;
    /**
     * Optional. An optional description of the hub.
     *
     * Generated from protobuf field <code>string description = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $description = '';
    /**
     * Output only. The Google-generated UUID for the hub. This value is unique
     * across all hub resources. If a hub is deleted and another with the same
     * name is created, the new hub is assigned a different unique_id.
     *
     * Generated from protobuf field <code>string unique_id = 8 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $unique_id = '';
    /**
     * Output only. The current lifecycle state of this hub.
     *
     * Generated from protobuf field <code>.google.cloud.networkconnectivity.v1.State state = 9 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $state = 0;
    /**
     * The VPC networks associated with this hub's spokes.
     * This field is read-only. Network Connectivity Center automatically
     * populates it based on the set of spokes attached to the hub.
     *
     * Generated from protobuf field <code>repeated .google.cloud.networkconnectivity.v1.RoutingVPC routing_vpcs = 10;</code>
     */
    private $routing_vpcs;
    /**
     * Output only. The route tables that belong to this hub. They use the
     * following form:
     *    `projects/{project_number}/locations/global/hubs/{hub_id}/routeTables/{route_table_id}`
     * This field is read-only. Network Connectivity Center automatically
     * populates it based on the route tables nested under the hub.
     *
     * Generated from protobuf field <code>repeated string route_tables = 11 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    private $route_tables;
    /**
     * Output only. A summary of the spokes associated with a hub. The
     * summary includes a count of spokes according to type
     * and according to state. If any spokes are inactive,
     * the summary also lists the reasons they are inactive,
     * including a count for each reason.
     *
     * Generated from protobuf field <code>.google.cloud.networkconnectivity.v1.SpokeSummary spoke_summary = 12 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $spoke_summary = null;
    /**
     * Optional. The policy mode of this hub. This field can be either
     * PRESET or CUSTOM. If unspecified, the
     * policy_mode defaults to PRESET.
     *
     * Generated from protobuf field <code>.google.cloud.networkconnectivity.v1.PolicyMode policy_mode = 13 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $policy_mode = 0;
    /**
     * Optional. The topology implemented in this hub. Currently, this field is
     * only used when policy_mode = PRESET. The available preset topologies are
     * MESH and STAR. If preset_topology is unspecified and policy_mode = PRESET,
     * the preset_topology defaults to MESH. When policy_mode = CUSTOM,
     * the preset_topology is set to PRESET_TOPOLOGY_UNSPECIFIED.
     *
     * Generated from protobuf field <code>.google.cloud.networkconnectivity.v1.PresetTopology preset_topology = 14 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $preset_topology = 0;
    /**
     * Optional. Whether Private Service Connect connection propagation is enabled
     * for the hub. If true, Private Service Connect endpoints in VPC spokes
     * attached to the hub are made accessible to other VPC spokes attached to the
     * hub. The default value is false.
     *
     * Generated from protobuf field <code>optional bool export_psc = 15 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $export_psc = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           Immutable. The name of the hub. Hub names must be unique. They use the
     *           following form:
     *               `projects/{project_number}/locations/global/hubs/{hub_id}`
     *     @type \Google\Protobuf\Timestamp $create_time
     *           Output only. The time the hub was created.
     *     @type \Google\Protobuf\Timestamp $update_time
     *           Output only. The time the hub was last updated.
     *     @type array|\Google\Protobuf\Internal\MapField $labels
     *           Optional labels in key-value pair format. For more information about
     *           labels, see [Requirements for
     *           labels](https://cloud.google.com/resource-manager/docs/creating-managing-labels#requirements).
     *     @type string $description
     *           Optional. An optional description of the hub.
     *     @type string $unique_id
     *           Output only. The Google-generated UUID for the hub. This value is unique
     *           across all hub resources. If a hub is deleted and another with the same
     *           name is created, the new hub is assigned a different unique_id.
     *     @type int $state
     *           Output only. The current lifecycle state of this hub.
     *     @type array<\Google\Cloud\NetworkConnectivity\V1\RoutingVPC>|\Google\Protobuf\Internal\RepeatedField $routing_vpcs
     *           The VPC networks associated with this hub's spokes.
     *           This field is read-only. Network Connectivity Center automatically
     *           populates it based on the set of spokes attached to the hub.
     *     @type array<string>|\Google\Protobuf\Internal\RepeatedField $route_tables
     *           Output only. The route tables that belong to this hub. They use the
     *           following form:
     *              `projects/{project_number}/locations/global/hubs/{hub_id}/routeTables/{route_table_id}`
     *           This field is read-only. Network Connectivity Center automatically
     *           populates it based on the route tables nested under the hub.
     *     @type \Google\Cloud\NetworkConnectivity\V1\SpokeSummary $spoke_summary
     *           Output only. A summary of the spokes associated with a hub. The
     *           summary includes a count of spokes according to type
     *           and according to state. If any spokes are inactive,
     *           the summary also lists the reasons they are inactive,
     *           including a count for each reason.
     *     @type int $policy_mode
     *           Optional. The policy mode of this hub. This field can be either
     *           PRESET or CUSTOM. If unspecified, the
     *           policy_mode defaults to PRESET.
     *     @type int $preset_topology
     *           Optional. The topology implemented in this hub. Currently, this field is
     *           only used when policy_mode = PRESET. The available preset topologies are
     *           MESH and STAR. If preset_topology is unspecified and policy_mode = PRESET,
     *           the preset_topology defaults to MESH. When policy_mode = CUSTOM,
     *           the preset_topology is set to PRESET_TOPOLOGY_UNSPECIFIED.
     *     @type bool $export_psc
     *           Optional. Whether Private Service Connect connection propagation is enabled
     *           for the hub. If true, Private Service Connect endpoints in VPC spokes
     *           attached to the hub are made accessible to other VPC spokes attached to the
     *           hub. The default value is false.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Networkconnectivity\V1\Hub::initOnce();
        parent::__construct($data);
    }

    /**
     * Immutable. The name of the hub. Hub names must be unique. They use the
     * following form:
     *     `projects/{project_number}/locations/global/hubs/{hub_id}`
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = IMMUTABLE];</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Immutable. The name of the hub. Hub names must be unique. They use the
     * following form:
     *     `projects/{project_number}/locations/global/hubs/{hub_id}`
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = IMMUTABLE];</code>
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
     * Output only. The time the hub was created.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp create_time = 2 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return \Google\Protobuf\Timestamp|null
     */
    public function getCreateTime()
    {
        return $this->create_time;
    }

    public function hasCreateTime()
    {
        return isset($this->create_time);
    }

    public function clearCreateTime()
    {
        unset($this->create_time);
    }

    /**
     * Output only. The time the hub was created.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp create_time = 2 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setCreateTime($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->create_time = $var;

        return $this;
    }

    /**
     * Output only. The time the hub was last updated.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp update_time = 3 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
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
     * Output only. The time the hub was last updated.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp update_time = 3 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
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
     * Optional labels in key-value pair format. For more information about
     * labels, see [Requirements for
     * labels](https://cloud.google.com/resource-manager/docs/creating-managing-labels#requirements).
     *
     * Generated from protobuf field <code>map<string, string> labels = 4;</code>
     * @return \Google\Protobuf\Internal\MapField
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * Optional labels in key-value pair format. For more information about
     * labels, see [Requirements for
     * labels](https://cloud.google.com/resource-manager/docs/creating-managing-labels#requirements).
     *
     * Generated from protobuf field <code>map<string, string> labels = 4;</code>
     * @param array|\Google\Protobuf\Internal\MapField $var
     * @return $this
     */
    public function setLabels($var)
    {
        $arr = GPBUtil::checkMapField($var, \Google\Protobuf\Internal\GPBType::STRING, \Google\Protobuf\Internal\GPBType::STRING);
        $this->labels = $arr;

        return $this;
    }

    /**
     * Optional. An optional description of the hub.
     *
     * Generated from protobuf field <code>string description = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Optional. An optional description of the hub.
     *
     * Generated from protobuf field <code>string description = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setDescription($var)
    {
        GPBUtil::checkString($var, True);
        $this->description = $var;

        return $this;
    }

    /**
     * Output only. The Google-generated UUID for the hub. This value is unique
     * across all hub resources. If a hub is deleted and another with the same
     * name is created, the new hub is assigned a different unique_id.
     *
     * Generated from protobuf field <code>string unique_id = 8 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return string
     */
    public function getUniqueId()
    {
        return $this->unique_id;
    }

    /**
     * Output only. The Google-generated UUID for the hub. This value is unique
     * across all hub resources. If a hub is deleted and another with the same
     * name is created, the new hub is assigned a different unique_id.
     *
     * Generated from protobuf field <code>string unique_id = 8 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param string $var
     * @return $this
     */
    public function setUniqueId($var)
    {
        GPBUtil::checkString($var, True);
        $this->unique_id = $var;

        return $this;
    }

    /**
     * Output only. The current lifecycle state of this hub.
     *
     * Generated from protobuf field <code>.google.cloud.networkconnectivity.v1.State state = 9 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Output only. The current lifecycle state of this hub.
     *
     * Generated from protobuf field <code>.google.cloud.networkconnectivity.v1.State state = 9 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param int $var
     * @return $this
     */
    public function setState($var)
    {
        GPBUtil::checkEnum($var, \Google\Cloud\NetworkConnectivity\V1\State::class);
        $this->state = $var;

        return $this;
    }

    /**
     * The VPC networks associated with this hub's spokes.
     * This field is read-only. Network Connectivity Center automatically
     * populates it based on the set of spokes attached to the hub.
     *
     * Generated from protobuf field <code>repeated .google.cloud.networkconnectivity.v1.RoutingVPC routing_vpcs = 10;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getRoutingVpcs()
    {
        return $this->routing_vpcs;
    }

    /**
     * The VPC networks associated with this hub's spokes.
     * This field is read-only. Network Connectivity Center automatically
     * populates it based on the set of spokes attached to the hub.
     *
     * Generated from protobuf field <code>repeated .google.cloud.networkconnectivity.v1.RoutingVPC routing_vpcs = 10;</code>
     * @param array<\Google\Cloud\NetworkConnectivity\V1\RoutingVPC>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setRoutingVpcs($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\NetworkConnectivity\V1\RoutingVPC::class);
        $this->routing_vpcs = $arr;

        return $this;
    }

    /**
     * Output only. The route tables that belong to this hub. They use the
     * following form:
     *    `projects/{project_number}/locations/global/hubs/{hub_id}/routeTables/{route_table_id}`
     * This field is read-only. Network Connectivity Center automatically
     * populates it based on the route tables nested under the hub.
     *
     * Generated from protobuf field <code>repeated string route_tables = 11 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getRouteTables()
    {
        return $this->route_tables;
    }

    /**
     * Output only. The route tables that belong to this hub. They use the
     * following form:
     *    `projects/{project_number}/locations/global/hubs/{hub_id}/routeTables/{route_table_id}`
     * This field is read-only. Network Connectivity Center automatically
     * populates it based on the route tables nested under the hub.
     *
     * Generated from protobuf field <code>repeated string route_tables = 11 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param array<string>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setRouteTables($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->route_tables = $arr;

        return $this;
    }

    /**
     * Output only. A summary of the spokes associated with a hub. The
     * summary includes a count of spokes according to type
     * and according to state. If any spokes are inactive,
     * the summary also lists the reasons they are inactive,
     * including a count for each reason.
     *
     * Generated from protobuf field <code>.google.cloud.networkconnectivity.v1.SpokeSummary spoke_summary = 12 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return \Google\Cloud\NetworkConnectivity\V1\SpokeSummary|null
     */
    public function getSpokeSummary()
    {
        return $this->spoke_summary;
    }

    public function hasSpokeSummary()
    {
        return isset($this->spoke_summary);
    }

    public function clearSpokeSummary()
    {
        unset($this->spoke_summary);
    }

    /**
     * Output only. A summary of the spokes associated with a hub. The
     * summary includes a count of spokes according to type
     * and according to state. If any spokes are inactive,
     * the summary also lists the reasons they are inactive,
     * including a count for each reason.
     *
     * Generated from protobuf field <code>.google.cloud.networkconnectivity.v1.SpokeSummary spoke_summary = 12 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param \Google\Cloud\NetworkConnectivity\V1\SpokeSummary $var
     * @return $this
     */
    public function setSpokeSummary($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\NetworkConnectivity\V1\SpokeSummary::class);
        $this->spoke_summary = $var;

        return $this;
    }

    /**
     * Optional. The policy mode of this hub. This field can be either
     * PRESET or CUSTOM. If unspecified, the
     * policy_mode defaults to PRESET.
     *
     * Generated from protobuf field <code>.google.cloud.networkconnectivity.v1.PolicyMode policy_mode = 13 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return int
     */
    public function getPolicyMode()
    {
        return $this->policy_mode;
    }

    /**
     * Optional. The policy mode of this hub. This field can be either
     * PRESET or CUSTOM. If unspecified, the
     * policy_mode defaults to PRESET.
     *
     * Generated from protobuf field <code>.google.cloud.networkconnectivity.v1.PolicyMode policy_mode = 13 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param int $var
     * @return $this
     */
    public function setPolicyMode($var)
    {
        GPBUtil::checkEnum($var, \Google\Cloud\NetworkConnectivity\V1\PolicyMode::class);
        $this->policy_mode = $var;

        return $this;
    }

    /**
     * Optional. The topology implemented in this hub. Currently, this field is
     * only used when policy_mode = PRESET. The available preset topologies are
     * MESH and STAR. If preset_topology is unspecified and policy_mode = PRESET,
     * the preset_topology defaults to MESH. When policy_mode = CUSTOM,
     * the preset_topology is set to PRESET_TOPOLOGY_UNSPECIFIED.
     *
     * Generated from protobuf field <code>.google.cloud.networkconnectivity.v1.PresetTopology preset_topology = 14 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return int
     */
    public function getPresetTopology()
    {
        return $this->preset_topology;
    }

    /**
     * Optional. The topology implemented in this hub. Currently, this field is
     * only used when policy_mode = PRESET. The available preset topologies are
     * MESH and STAR. If preset_topology is unspecified and policy_mode = PRESET,
     * the preset_topology defaults to MESH. When policy_mode = CUSTOM,
     * the preset_topology is set to PRESET_TOPOLOGY_UNSPECIFIED.
     *
     * Generated from protobuf field <code>.google.cloud.networkconnectivity.v1.PresetTopology preset_topology = 14 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param int $var
     * @return $this
     */
    public function setPresetTopology($var)
    {
        GPBUtil::checkEnum($var, \Google\Cloud\NetworkConnectivity\V1\PresetTopology::class);
        $this->preset_topology = $var;

        return $this;
    }

    /**
     * Optional. Whether Private Service Connect connection propagation is enabled
     * for the hub. If true, Private Service Connect endpoints in VPC spokes
     * attached to the hub are made accessible to other VPC spokes attached to the
     * hub. The default value is false.
     *
     * Generated from protobuf field <code>optional bool export_psc = 15 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return bool
     */
    public function getExportPsc()
    {
        return isset($this->export_psc) ? $this->export_psc : false;
    }

    public function hasExportPsc()
    {
        return isset($this->export_psc);
    }

    public function clearExportPsc()
    {
        unset($this->export_psc);
    }

    /**
     * Optional. Whether Private Service Connect connection propagation is enabled
     * for the hub. If true, Private Service Connect endpoints in VPC spokes
     * attached to the hub are made accessible to other VPC spokes attached to the
     * hub. The default value is false.
     *
     * Generated from protobuf field <code>optional bool export_psc = 15 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param bool $var
     * @return $this
     */
    public function setExportPsc($var)
    {
        GPBUtil::checkBool($var);
        $this->export_psc = $var;

        return $this;
    }

}

