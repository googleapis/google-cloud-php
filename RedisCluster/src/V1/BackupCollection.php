<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/redis/cluster/v1/cloud_redis_cluster.proto

namespace Google\Cloud\Redis\Cluster\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * BackupCollection of a cluster.
 *
 * Generated from protobuf message <code>google.cloud.redis.cluster.v1.BackupCollection</code>
 */
class BackupCollection extends \Google\Protobuf\Internal\Message
{
    /**
     * Identifier. Full resource path of the backup collection.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = IDENTIFIER];</code>
     */
    protected $name = '';
    /**
     * Output only. The cluster uid of the backup collection.
     *
     * Generated from protobuf field <code>string cluster_uid = 3 [(.google.api.field_behavior) = OUTPUT_ONLY, (.google.api.field_info) = {</code>
     */
    protected $cluster_uid = '';
    /**
     * Output only. The full resource path of the cluster the backup collection
     * belongs to. Example:
     * projects/{project}/locations/{location}/clusters/{cluster}
     *
     * Generated from protobuf field <code>string cluster = 4 [(.google.api.field_behavior) = OUTPUT_ONLY, (.google.api.resource_reference) = {</code>
     */
    protected $cluster = '';
    /**
     * Output only. The KMS key used to encrypt the backups under this backup
     * collection.
     *
     * Generated from protobuf field <code>string kms_key = 5 [(.google.api.field_behavior) = OUTPUT_ONLY, (.google.api.resource_reference) = {</code>
     */
    protected $kms_key = '';
    /**
     * Output only. System assigned unique identifier of the backup collection.
     *
     * Generated from protobuf field <code>string uid = 6 [(.google.api.field_behavior) = OUTPUT_ONLY, (.google.api.field_info) = {</code>
     */
    protected $uid = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           Identifier. Full resource path of the backup collection.
     *     @type string $cluster_uid
     *           Output only. The cluster uid of the backup collection.
     *     @type string $cluster
     *           Output only. The full resource path of the cluster the backup collection
     *           belongs to. Example:
     *           projects/{project}/locations/{location}/clusters/{cluster}
     *     @type string $kms_key
     *           Output only. The KMS key used to encrypt the backups under this backup
     *           collection.
     *     @type string $uid
     *           Output only. System assigned unique identifier of the backup collection.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Redis\Cluster\V1\CloudRedisCluster::initOnce();
        parent::__construct($data);
    }

    /**
     * Identifier. Full resource path of the backup collection.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = IDENTIFIER];</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Identifier. Full resource path of the backup collection.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = IDENTIFIER];</code>
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
     * Output only. The cluster uid of the backup collection.
     *
     * Generated from protobuf field <code>string cluster_uid = 3 [(.google.api.field_behavior) = OUTPUT_ONLY, (.google.api.field_info) = {</code>
     * @return string
     */
    public function getClusterUid()
    {
        return $this->cluster_uid;
    }

    /**
     * Output only. The cluster uid of the backup collection.
     *
     * Generated from protobuf field <code>string cluster_uid = 3 [(.google.api.field_behavior) = OUTPUT_ONLY, (.google.api.field_info) = {</code>
     * @param string $var
     * @return $this
     */
    public function setClusterUid($var)
    {
        GPBUtil::checkString($var, True);
        $this->cluster_uid = $var;

        return $this;
    }

    /**
     * Output only. The full resource path of the cluster the backup collection
     * belongs to. Example:
     * projects/{project}/locations/{location}/clusters/{cluster}
     *
     * Generated from protobuf field <code>string cluster = 4 [(.google.api.field_behavior) = OUTPUT_ONLY, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getCluster()
    {
        return $this->cluster;
    }

    /**
     * Output only. The full resource path of the cluster the backup collection
     * belongs to. Example:
     * projects/{project}/locations/{location}/clusters/{cluster}
     *
     * Generated from protobuf field <code>string cluster = 4 [(.google.api.field_behavior) = OUTPUT_ONLY, (.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setCluster($var)
    {
        GPBUtil::checkString($var, True);
        $this->cluster = $var;

        return $this;
    }

    /**
     * Output only. The KMS key used to encrypt the backups under this backup
     * collection.
     *
     * Generated from protobuf field <code>string kms_key = 5 [(.google.api.field_behavior) = OUTPUT_ONLY, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getKmsKey()
    {
        return $this->kms_key;
    }

    /**
     * Output only. The KMS key used to encrypt the backups under this backup
     * collection.
     *
     * Generated from protobuf field <code>string kms_key = 5 [(.google.api.field_behavior) = OUTPUT_ONLY, (.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setKmsKey($var)
    {
        GPBUtil::checkString($var, True);
        $this->kms_key = $var;

        return $this;
    }

    /**
     * Output only. System assigned unique identifier of the backup collection.
     *
     * Generated from protobuf field <code>string uid = 6 [(.google.api.field_behavior) = OUTPUT_ONLY, (.google.api.field_info) = {</code>
     * @return string
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Output only. System assigned unique identifier of the backup collection.
     *
     * Generated from protobuf field <code>string uid = 6 [(.google.api.field_behavior) = OUTPUT_ONLY, (.google.api.field_info) = {</code>
     * @param string $var
     * @return $this
     */
    public function setUid($var)
    {
        GPBUtil::checkString($var, True);
        $this->uid = $var;

        return $this;
    }

}

