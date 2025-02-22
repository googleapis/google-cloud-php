<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/dataform/v1beta1/dataform.proto

namespace Google\Cloud\Dataform\V1beta1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Represents an action identifier. If the action writes output, the output
 * will be written to the referenced database object.
 *
 * Generated from protobuf message <code>google.cloud.dataform.v1beta1.Target</code>
 */
class Target extends \Google\Protobuf\Internal\Message
{
    /**
     * The action's database (Google Cloud project ID) .
     *
     * Generated from protobuf field <code>string database = 1;</code>
     */
    protected $database = '';
    /**
     * The action's schema (BigQuery dataset ID), within `database`.
     *
     * Generated from protobuf field <code>string schema = 2;</code>
     */
    protected $schema = '';
    /**
     * The action's name, within `database` and `schema`.
     *
     * Generated from protobuf field <code>string name = 3;</code>
     */
    protected $name = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $database
     *           The action's database (Google Cloud project ID) .
     *     @type string $schema
     *           The action's schema (BigQuery dataset ID), within `database`.
     *     @type string $name
     *           The action's name, within `database` and `schema`.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Dataform\V1Beta1\Dataform::initOnce();
        parent::__construct($data);
    }

    /**
     * The action's database (Google Cloud project ID) .
     *
     * Generated from protobuf field <code>string database = 1;</code>
     * @return string
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * The action's database (Google Cloud project ID) .
     *
     * Generated from protobuf field <code>string database = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setDatabase($var)
    {
        GPBUtil::checkString($var, True);
        $this->database = $var;

        return $this;
    }

    /**
     * The action's schema (BigQuery dataset ID), within `database`.
     *
     * Generated from protobuf field <code>string schema = 2;</code>
     * @return string
     */
    public function getSchema()
    {
        return $this->schema;
    }

    /**
     * The action's schema (BigQuery dataset ID), within `database`.
     *
     * Generated from protobuf field <code>string schema = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setSchema($var)
    {
        GPBUtil::checkString($var, True);
        $this->schema = $var;

        return $this;
    }

    /**
     * The action's name, within `database` and `schema`.
     *
     * Generated from protobuf field <code>string name = 3;</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * The action's name, within `database` and `schema`.
     *
     * Generated from protobuf field <code>string name = 3;</code>
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

