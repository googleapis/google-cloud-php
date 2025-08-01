<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/managedkafka/schemaregistry/v1/schema_registry.proto

namespace Google\Cloud\ManagedKafka\SchemaRegistry\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Response for CreateVersion.
 *
 * Generated from protobuf message <code>google.cloud.managedkafka.schemaregistry.v1.CreateVersionResponse</code>
 */
class CreateVersionResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * The unique identifier of the schema created.
     *
     * Generated from protobuf field <code>int32 id = 1;</code>
     */
    protected $id = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $id
     *           The unique identifier of the schema created.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Managedkafka\Schemaregistry\V1\SchemaRegistry::initOnce();
        parent::__construct($data);
    }

    /**
     * The unique identifier of the schema created.
     *
     * Generated from protobuf field <code>int32 id = 1;</code>
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * The unique identifier of the schema created.
     *
     * Generated from protobuf field <code>int32 id = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setId($var)
    {
        GPBUtil::checkInt32($var);
        $this->id = $var;

        return $this;
    }

}

