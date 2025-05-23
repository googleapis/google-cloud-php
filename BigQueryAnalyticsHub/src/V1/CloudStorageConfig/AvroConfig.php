<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/bigquery/analyticshub/v1/pubsub.proto

namespace Google\Cloud\BigQuery\AnalyticsHub\V1\CloudStorageConfig;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Configuration for writing message data in Avro format.
 * Message payloads and metadata will be written to files as an Avro binary.
 *
 * Generated from protobuf message <code>google.cloud.bigquery.analyticshub.v1.CloudStorageConfig.AvroConfig</code>
 */
class AvroConfig extends \Google\Protobuf\Internal\Message
{
    /**
     * Optional. When true, write the subscription name, message_id,
     * publish_time, attributes, and ordering_key as additional fields in the
     * output. The subscription name, message_id, and publish_time fields are
     * put in their own fields while all other message properties other than
     * data (for example, an ordering_key, if present) are added as entries in
     * the attributes map.
     *
     * Generated from protobuf field <code>bool write_metadata = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $write_metadata = false;
    /**
     * Optional. When true, the output Cloud Storage file will be serialized
     * using the topic schema, if it exists.
     *
     * Generated from protobuf field <code>bool use_topic_schema = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $use_topic_schema = false;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type bool $write_metadata
     *           Optional. When true, write the subscription name, message_id,
     *           publish_time, attributes, and ordering_key as additional fields in the
     *           output. The subscription name, message_id, and publish_time fields are
     *           put in their own fields while all other message properties other than
     *           data (for example, an ordering_key, if present) are added as entries in
     *           the attributes map.
     *     @type bool $use_topic_schema
     *           Optional. When true, the output Cloud Storage file will be serialized
     *           using the topic schema, if it exists.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Bigquery\Analyticshub\V1\Pubsub::initOnce();
        parent::__construct($data);
    }

    /**
     * Optional. When true, write the subscription name, message_id,
     * publish_time, attributes, and ordering_key as additional fields in the
     * output. The subscription name, message_id, and publish_time fields are
     * put in their own fields while all other message properties other than
     * data (for example, an ordering_key, if present) are added as entries in
     * the attributes map.
     *
     * Generated from protobuf field <code>bool write_metadata = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return bool
     */
    public function getWriteMetadata()
    {
        return $this->write_metadata;
    }

    /**
     * Optional. When true, write the subscription name, message_id,
     * publish_time, attributes, and ordering_key as additional fields in the
     * output. The subscription name, message_id, and publish_time fields are
     * put in their own fields while all other message properties other than
     * data (for example, an ordering_key, if present) are added as entries in
     * the attributes map.
     *
     * Generated from protobuf field <code>bool write_metadata = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param bool $var
     * @return $this
     */
    public function setWriteMetadata($var)
    {
        GPBUtil::checkBool($var);
        $this->write_metadata = $var;

        return $this;
    }

    /**
     * Optional. When true, the output Cloud Storage file will be serialized
     * using the topic schema, if it exists.
     *
     * Generated from protobuf field <code>bool use_topic_schema = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return bool
     */
    public function getUseTopicSchema()
    {
        return $this->use_topic_schema;
    }

    /**
     * Optional. When true, the output Cloud Storage file will be serialized
     * using the topic schema, if it exists.
     *
     * Generated from protobuf field <code>bool use_topic_schema = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param bool $var
     * @return $this
     */
    public function setUseTopicSchema($var)
    {
        GPBUtil::checkBool($var);
        $this->use_topic_schema = $var;

        return $this;
    }

}


