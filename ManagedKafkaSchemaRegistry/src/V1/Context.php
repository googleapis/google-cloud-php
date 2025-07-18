<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/managedkafka/schemaregistry/v1/schema_registry_resources.proto

namespace Google\Cloud\ManagedKafka\SchemaRegistry\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Context represents an independent schema grouping in a schema registry
 * instance.
 *
 * Generated from protobuf message <code>google.cloud.managedkafka.schemaregistry.v1.Context</code>
 */
class Context extends \Google\Protobuf\Internal\Message
{
    /**
     * Identifier. The name of the context. Structured like:
     * `projects/{project}/locations/{location}/schemaRegistries/{schema_registry}/contexts/{context}`
     * The context name {context} can contain the following:
     * * Up to 255 characters.
     * * Allowed characters: letters (uppercase or lowercase), numbers, and the
     * following special characters: `.`, `-`, `_`, `+`, `%`, and `~`.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = IDENTIFIER];</code>
     */
    protected $name = '';
    /**
     * Optional. The subjects of the context.
     *
     * Generated from protobuf field <code>repeated string subjects = 2 [(.google.api.field_behavior) = OPTIONAL, (.google.api.resource_reference) = {</code>
     */
    private $subjects;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           Identifier. The name of the context. Structured like:
     *           `projects/{project}/locations/{location}/schemaRegistries/{schema_registry}/contexts/{context}`
     *           The context name {context} can contain the following:
     *           * Up to 255 characters.
     *           * Allowed characters: letters (uppercase or lowercase), numbers, and the
     *           following special characters: `.`, `-`, `_`, `+`, `%`, and `~`.
     *     @type array<string>|\Google\Protobuf\Internal\RepeatedField $subjects
     *           Optional. The subjects of the context.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Managedkafka\Schemaregistry\V1\SchemaRegistryResources::initOnce();
        parent::__construct($data);
    }

    /**
     * Identifier. The name of the context. Structured like:
     * `projects/{project}/locations/{location}/schemaRegistries/{schema_registry}/contexts/{context}`
     * The context name {context} can contain the following:
     * * Up to 255 characters.
     * * Allowed characters: letters (uppercase or lowercase), numbers, and the
     * following special characters: `.`, `-`, `_`, `+`, `%`, and `~`.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = IDENTIFIER];</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Identifier. The name of the context. Structured like:
     * `projects/{project}/locations/{location}/schemaRegistries/{schema_registry}/contexts/{context}`
     * The context name {context} can contain the following:
     * * Up to 255 characters.
     * * Allowed characters: letters (uppercase or lowercase), numbers, and the
     * following special characters: `.`, `-`, `_`, `+`, `%`, and `~`.
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
     * Optional. The subjects of the context.
     *
     * Generated from protobuf field <code>repeated string subjects = 2 [(.google.api.field_behavior) = OPTIONAL, (.google.api.resource_reference) = {</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getSubjects()
    {
        return $this->subjects;
    }

    /**
     * Optional. The subjects of the context.
     *
     * Generated from protobuf field <code>repeated string subjects = 2 [(.google.api.field_behavior) = OPTIONAL, (.google.api.resource_reference) = {</code>
     * @param array<string>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setSubjects($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->subjects = $arr;

        return $this;
    }

}

