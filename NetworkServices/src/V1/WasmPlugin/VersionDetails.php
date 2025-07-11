<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/networkservices/v1/extensibility.proto

namespace Google\Cloud\NetworkServices\V1\WasmPlugin;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Details of a `WasmPluginVersion` resource to be inlined in the
 * `WasmPlugin` resource.
 *
 * Generated from protobuf message <code>google.cloud.networkservices.v1.WasmPlugin.VersionDetails</code>
 */
class VersionDetails extends \Google\Protobuf\Internal\Message
{
    /**
     * Output only. The timestamp when the resource was created.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp create_time = 1 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $create_time = null;
    /**
     * Output only. The timestamp when the resource was updated.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp update_time = 2 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $update_time = null;
    /**
     * Optional. A human-readable description of the resource.
     *
     * Generated from protobuf field <code>string description = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $description = '';
    /**
     * Optional. Set of labels associated with the `WasmPluginVersion`
     * resource.
     *
     * Generated from protobuf field <code>map<string, string> labels = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    private $labels;
    /**
     * Optional. URI of the container image containing the Wasm module, stored
     * in the Artifact Registry. The container image must contain only a single
     * file with the name `plugin.wasm`. When a new `WasmPluginVersion` resource
     * is created, the URI gets resolved to an image digest and saved in the
     * `image_digest` field.
     *
     * Generated from protobuf field <code>string image_uri = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $image_uri = '';
    /**
     * Output only. The resolved digest for the image specified in `image`.
     * The digest is resolved during the creation of a
     * `WasmPluginVersion` resource.
     * This field holds the digest value regardless of whether a tag or
     * digest was originally specified in the `image` field.
     *
     * Generated from protobuf field <code>string image_digest = 6 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $image_digest = '';
    /**
     * Output only. This field holds the digest (usually checksum) value for the
     * plugin configuration. The value is calculated based on the contents of
     * the `plugin_config_data` field or the container image defined by the
     * `plugin_config_uri` field.
     *
     * Generated from protobuf field <code>string plugin_config_digest = 11 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $plugin_config_digest = '';
    protected $plugin_config_source;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $plugin_config_data
     *           Configuration for the plugin.
     *           The configuration is provided to the plugin at runtime through
     *           the `ON_CONFIGURE` callback. When a new
     *           `WasmPluginVersion` version is created, the digest of the
     *           contents is saved in the `plugin_config_digest` field.
     *     @type string $plugin_config_uri
     *           URI of the plugin configuration stored in the Artifact Registry.
     *           The configuration is provided to the plugin at runtime through
     *           the `ON_CONFIGURE` callback. The container image must
     *           contain only a single file with the name
     *           `plugin.config`. When a new `WasmPluginVersion`
     *           resource is created, the digest of the container image is saved in the
     *           `plugin_config_digest` field.
     *     @type \Google\Protobuf\Timestamp $create_time
     *           Output only. The timestamp when the resource was created.
     *     @type \Google\Protobuf\Timestamp $update_time
     *           Output only. The timestamp when the resource was updated.
     *     @type string $description
     *           Optional. A human-readable description of the resource.
     *     @type array|\Google\Protobuf\Internal\MapField $labels
     *           Optional. Set of labels associated with the `WasmPluginVersion`
     *           resource.
     *     @type string $image_uri
     *           Optional. URI of the container image containing the Wasm module, stored
     *           in the Artifact Registry. The container image must contain only a single
     *           file with the name `plugin.wasm`. When a new `WasmPluginVersion` resource
     *           is created, the URI gets resolved to an image digest and saved in the
     *           `image_digest` field.
     *     @type string $image_digest
     *           Output only. The resolved digest for the image specified in `image`.
     *           The digest is resolved during the creation of a
     *           `WasmPluginVersion` resource.
     *           This field holds the digest value regardless of whether a tag or
     *           digest was originally specified in the `image` field.
     *     @type string $plugin_config_digest
     *           Output only. This field holds the digest (usually checksum) value for the
     *           plugin configuration. The value is calculated based on the contents of
     *           the `plugin_config_data` field or the container image defined by the
     *           `plugin_config_uri` field.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Networkservices\V1\Extensibility::initOnce();
        parent::__construct($data);
    }

    /**
     * Configuration for the plugin.
     * The configuration is provided to the plugin at runtime through
     * the `ON_CONFIGURE` callback. When a new
     * `WasmPluginVersion` version is created, the digest of the
     * contents is saved in the `plugin_config_digest` field.
     *
     * Generated from protobuf field <code>bytes plugin_config_data = 9;</code>
     * @return string
     */
    public function getPluginConfigData()
    {
        return $this->readOneof(9);
    }

    public function hasPluginConfigData()
    {
        return $this->hasOneof(9);
    }

    /**
     * Configuration for the plugin.
     * The configuration is provided to the plugin at runtime through
     * the `ON_CONFIGURE` callback. When a new
     * `WasmPluginVersion` version is created, the digest of the
     * contents is saved in the `plugin_config_digest` field.
     *
     * Generated from protobuf field <code>bytes plugin_config_data = 9;</code>
     * @param string $var
     * @return $this
     */
    public function setPluginConfigData($var)
    {
        GPBUtil::checkString($var, False);
        $this->writeOneof(9, $var);

        return $this;
    }

    /**
     * URI of the plugin configuration stored in the Artifact Registry.
     * The configuration is provided to the plugin at runtime through
     * the `ON_CONFIGURE` callback. The container image must
     * contain only a single file with the name
     * `plugin.config`. When a new `WasmPluginVersion`
     * resource is created, the digest of the container image is saved in the
     * `plugin_config_digest` field.
     *
     * Generated from protobuf field <code>string plugin_config_uri = 10;</code>
     * @return string
     */
    public function getPluginConfigUri()
    {
        return $this->readOneof(10);
    }

    public function hasPluginConfigUri()
    {
        return $this->hasOneof(10);
    }

    /**
     * URI of the plugin configuration stored in the Artifact Registry.
     * The configuration is provided to the plugin at runtime through
     * the `ON_CONFIGURE` callback. The container image must
     * contain only a single file with the name
     * `plugin.config`. When a new `WasmPluginVersion`
     * resource is created, the digest of the container image is saved in the
     * `plugin_config_digest` field.
     *
     * Generated from protobuf field <code>string plugin_config_uri = 10;</code>
     * @param string $var
     * @return $this
     */
    public function setPluginConfigUri($var)
    {
        GPBUtil::checkString($var, True);
        $this->writeOneof(10, $var);

        return $this;
    }

    /**
     * Output only. The timestamp when the resource was created.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp create_time = 1 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
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
     * Output only. The timestamp when the resource was created.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp create_time = 1 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
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
     * Output only. The timestamp when the resource was updated.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp update_time = 2 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
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
     * Output only. The timestamp when the resource was updated.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp update_time = 2 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
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
     * Optional. A human-readable description of the resource.
     *
     * Generated from protobuf field <code>string description = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Optional. A human-readable description of the resource.
     *
     * Generated from protobuf field <code>string description = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
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
     * Optional. Set of labels associated with the `WasmPluginVersion`
     * resource.
     *
     * Generated from protobuf field <code>map<string, string> labels = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Protobuf\Internal\MapField
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * Optional. Set of labels associated with the `WasmPluginVersion`
     * resource.
     *
     * Generated from protobuf field <code>map<string, string> labels = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
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
     * Optional. URI of the container image containing the Wasm module, stored
     * in the Artifact Registry. The container image must contain only a single
     * file with the name `plugin.wasm`. When a new `WasmPluginVersion` resource
     * is created, the URI gets resolved to an image digest and saved in the
     * `image_digest` field.
     *
     * Generated from protobuf field <code>string image_uri = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getImageUri()
    {
        return $this->image_uri;
    }

    /**
     * Optional. URI of the container image containing the Wasm module, stored
     * in the Artifact Registry. The container image must contain only a single
     * file with the name `plugin.wasm`. When a new `WasmPluginVersion` resource
     * is created, the URI gets resolved to an image digest and saved in the
     * `image_digest` field.
     *
     * Generated from protobuf field <code>string image_uri = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setImageUri($var)
    {
        GPBUtil::checkString($var, True);
        $this->image_uri = $var;

        return $this;
    }

    /**
     * Output only. The resolved digest for the image specified in `image`.
     * The digest is resolved during the creation of a
     * `WasmPluginVersion` resource.
     * This field holds the digest value regardless of whether a tag or
     * digest was originally specified in the `image` field.
     *
     * Generated from protobuf field <code>string image_digest = 6 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return string
     */
    public function getImageDigest()
    {
        return $this->image_digest;
    }

    /**
     * Output only. The resolved digest for the image specified in `image`.
     * The digest is resolved during the creation of a
     * `WasmPluginVersion` resource.
     * This field holds the digest value regardless of whether a tag or
     * digest was originally specified in the `image` field.
     *
     * Generated from protobuf field <code>string image_digest = 6 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param string $var
     * @return $this
     */
    public function setImageDigest($var)
    {
        GPBUtil::checkString($var, True);
        $this->image_digest = $var;

        return $this;
    }

    /**
     * Output only. This field holds the digest (usually checksum) value for the
     * plugin configuration. The value is calculated based on the contents of
     * the `plugin_config_data` field or the container image defined by the
     * `plugin_config_uri` field.
     *
     * Generated from protobuf field <code>string plugin_config_digest = 11 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return string
     */
    public function getPluginConfigDigest()
    {
        return $this->plugin_config_digest;
    }

    /**
     * Output only. This field holds the digest (usually checksum) value for the
     * plugin configuration. The value is calculated based on the contents of
     * the `plugin_config_data` field or the container image defined by the
     * `plugin_config_uri` field.
     *
     * Generated from protobuf field <code>string plugin_config_digest = 11 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param string $var
     * @return $this
     */
    public function setPluginConfigDigest($var)
    {
        GPBUtil::checkString($var, True);
        $this->plugin_config_digest = $var;

        return $this;
    }

    /**
     * @return string
     */
    public function getPluginConfigSource()
    {
        return $this->whichOneof("plugin_config_source");
    }

}


