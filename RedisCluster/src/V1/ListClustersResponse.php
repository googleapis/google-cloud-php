<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/redis/cluster/v1/cloud_redis_cluster.proto

namespace Google\Cloud\Redis\Cluster\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Response for [ListClusters][CloudRedis.ListClusters].
 *
 * Generated from protobuf message <code>google.cloud.redis.cluster.v1.ListClustersResponse</code>
 */
class ListClustersResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * A list of Redis clusters in the project in the specified location,
     * or across all locations.
     * If the `location_id` in the parent field of the request is "-", all regions
     * available to the project are queried, and the results aggregated.
     * If in such an aggregated query a location is unavailable, a placeholder
     * Redis entry is included in the response with the `name` field set to a
     * value of the form
     * `projects/{project_id}/locations/{location_id}/clusters/`- and the
     * `status` field set to ERROR and `status_message` field set to "location not
     * available for ListClusters".
     *
     * Generated from protobuf field <code>repeated .google.cloud.redis.cluster.v1.Cluster clusters = 1;</code>
     */
    private $clusters;
    /**
     * Token to retrieve the next page of results, or empty if there are no more
     * results in the list.
     *
     * Generated from protobuf field <code>string next_page_token = 2;</code>
     */
    protected $next_page_token = '';
    /**
     * Locations that could not be reached.
     *
     * Generated from protobuf field <code>repeated string unreachable = 3;</code>
     */
    private $unreachable;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<\Google\Cloud\Redis\Cluster\V1\Cluster>|\Google\Protobuf\Internal\RepeatedField $clusters
     *           A list of Redis clusters in the project in the specified location,
     *           or across all locations.
     *           If the `location_id` in the parent field of the request is "-", all regions
     *           available to the project are queried, and the results aggregated.
     *           If in such an aggregated query a location is unavailable, a placeholder
     *           Redis entry is included in the response with the `name` field set to a
     *           value of the form
     *           `projects/{project_id}/locations/{location_id}/clusters/`- and the
     *           `status` field set to ERROR and `status_message` field set to "location not
     *           available for ListClusters".
     *     @type string $next_page_token
     *           Token to retrieve the next page of results, or empty if there are no more
     *           results in the list.
     *     @type array<string>|\Google\Protobuf\Internal\RepeatedField $unreachable
     *           Locations that could not be reached.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Redis\Cluster\V1\CloudRedisCluster::initOnce();
        parent::__construct($data);
    }

    /**
     * A list of Redis clusters in the project in the specified location,
     * or across all locations.
     * If the `location_id` in the parent field of the request is "-", all regions
     * available to the project are queried, and the results aggregated.
     * If in such an aggregated query a location is unavailable, a placeholder
     * Redis entry is included in the response with the `name` field set to a
     * value of the form
     * `projects/{project_id}/locations/{location_id}/clusters/`- and the
     * `status` field set to ERROR and `status_message` field set to "location not
     * available for ListClusters".
     *
     * Generated from protobuf field <code>repeated .google.cloud.redis.cluster.v1.Cluster clusters = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getClusters()
    {
        return $this->clusters;
    }

    /**
     * A list of Redis clusters in the project in the specified location,
     * or across all locations.
     * If the `location_id` in the parent field of the request is "-", all regions
     * available to the project are queried, and the results aggregated.
     * If in such an aggregated query a location is unavailable, a placeholder
     * Redis entry is included in the response with the `name` field set to a
     * value of the form
     * `projects/{project_id}/locations/{location_id}/clusters/`- and the
     * `status` field set to ERROR and `status_message` field set to "location not
     * available for ListClusters".
     *
     * Generated from protobuf field <code>repeated .google.cloud.redis.cluster.v1.Cluster clusters = 1;</code>
     * @param array<\Google\Cloud\Redis\Cluster\V1\Cluster>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setClusters($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\Redis\Cluster\V1\Cluster::class);
        $this->clusters = $arr;

        return $this;
    }

    /**
     * Token to retrieve the next page of results, or empty if there are no more
     * results in the list.
     *
     * Generated from protobuf field <code>string next_page_token = 2;</code>
     * @return string
     */
    public function getNextPageToken()
    {
        return $this->next_page_token;
    }

    /**
     * Token to retrieve the next page of results, or empty if there are no more
     * results in the list.
     *
     * Generated from protobuf field <code>string next_page_token = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setNextPageToken($var)
    {
        GPBUtil::checkString($var, True);
        $this->next_page_token = $var;

        return $this;
    }

    /**
     * Locations that could not be reached.
     *
     * Generated from protobuf field <code>repeated string unreachable = 3;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getUnreachable()
    {
        return $this->unreachable;
    }

    /**
     * Locations that could not be reached.
     *
     * Generated from protobuf field <code>repeated string unreachable = 3;</code>
     * @param array<string>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setUnreachable($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->unreachable = $arr;

        return $this;
    }

}
