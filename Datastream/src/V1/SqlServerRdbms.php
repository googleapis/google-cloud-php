<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/datastream/v1/datastream_resources.proto

namespace Google\Cloud\Datastream\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * SQLServer database structure.
 *
 * Generated from protobuf message <code>google.cloud.datastream.v1.SqlServerRdbms</code>
 */
class SqlServerRdbms extends \Google\Protobuf\Internal\Message
{
    /**
     * SQLServer schemas in the database server.
     *
     * Generated from protobuf field <code>repeated .google.cloud.datastream.v1.SqlServerSchema schemas = 1;</code>
     */
    private $schemas;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<\Google\Cloud\Datastream\V1\SqlServerSchema>|\Google\Protobuf\Internal\RepeatedField $schemas
     *           SQLServer schemas in the database server.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Datastream\V1\DatastreamResources::initOnce();
        parent::__construct($data);
    }

    /**
     * SQLServer schemas in the database server.
     *
     * Generated from protobuf field <code>repeated .google.cloud.datastream.v1.SqlServerSchema schemas = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getSchemas()
    {
        return $this->schemas;
    }

    /**
     * SQLServer schemas in the database server.
     *
     * Generated from protobuf field <code>repeated .google.cloud.datastream.v1.SqlServerSchema schemas = 1;</code>
     * @param array<\Google\Cloud\Datastream\V1\SqlServerSchema>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setSchemas($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\Datastream\V1\SqlServerSchema::class);
        $this->schemas = $arr;

        return $this;
    }

}

