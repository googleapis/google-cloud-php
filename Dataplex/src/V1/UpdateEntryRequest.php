<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/dataplex/v1/catalog.proto

namespace Google\Cloud\Dataplex\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Update Entry request.
 *
 * Generated from protobuf message <code>google.cloud.dataplex.v1.UpdateEntryRequest</code>
 */
class UpdateEntryRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. Entry resource.
     *
     * Generated from protobuf field <code>.google.cloud.dataplex.v1.Entry entry = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $entry = null;
    /**
     * Optional. Mask of fields to update. To update Aspects, the update_mask must
     * contain the value "aspects".
     * If the update_mask is empty, the service will update all modifiable fields
     * present in the request.
     *
     * Generated from protobuf field <code>.google.protobuf.FieldMask update_mask = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $update_mask = null;
    /**
     * Optional. If set to true and the entry doesn't exist, the service will
     * create it.
     *
     * Generated from protobuf field <code>bool allow_missing = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $allow_missing = false;
    /**
     * Optional. If set to true and the aspect_keys specify aspect ranges, the
     * service deletes any existing aspects from that range that weren't provided
     * in the request.
     *
     * Generated from protobuf field <code>bool delete_missing_aspects = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $delete_missing_aspects = false;
    /**
     * Optional. The map keys of the Aspects which the service should modify. It
     * supports the following syntaxes:
     * * `<aspect_type_reference>` - matches an aspect of the given type and empty
     * path.
     * * `<aspect_type_reference>&#64;path` - matches an aspect of the given type and
     * specified path. For example, to attach an aspect to a field that is
     * specified by the `schema` aspect, the path should have the format
     * `Schema.<field_name>`.
     * * `<aspect_type_reference>&#64;*` - matches aspects of the given type for all
     * paths.
     * * `*&#64;path` - matches aspects of all types on the given path.
     * The service will not remove existing aspects matching the syntax unless
     * `delete_missing_aspects` is set to true.
     * If this field is left empty, the service treats it as specifying
     * exactly those Aspects present in the request.
     *
     * Generated from protobuf field <code>repeated string aspect_keys = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    private $aspect_keys;

    /**
     * @param \Google\Cloud\Dataplex\V1\Entry $entry      Required. Entry resource.
     * @param \Google\Protobuf\FieldMask      $updateMask Optional. Mask of fields to update. To update Aspects, the update_mask must
     *                                                    contain the value "aspects".
     *
     *                                                    If the update_mask is empty, the service will update all modifiable fields
     *                                                    present in the request.
     *
     * @return \Google\Cloud\Dataplex\V1\UpdateEntryRequest
     *
     * @experimental
     */
    public static function build(\Google\Cloud\Dataplex\V1\Entry $entry, \Google\Protobuf\FieldMask $updateMask): self
    {
        return (new self())
            ->setEntry($entry)
            ->setUpdateMask($updateMask);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Cloud\Dataplex\V1\Entry $entry
     *           Required. Entry resource.
     *     @type \Google\Protobuf\FieldMask $update_mask
     *           Optional. Mask of fields to update. To update Aspects, the update_mask must
     *           contain the value "aspects".
     *           If the update_mask is empty, the service will update all modifiable fields
     *           present in the request.
     *     @type bool $allow_missing
     *           Optional. If set to true and the entry doesn't exist, the service will
     *           create it.
     *     @type bool $delete_missing_aspects
     *           Optional. If set to true and the aspect_keys specify aspect ranges, the
     *           service deletes any existing aspects from that range that weren't provided
     *           in the request.
     *     @type array<string>|\Google\Protobuf\Internal\RepeatedField $aspect_keys
     *           Optional. The map keys of the Aspects which the service should modify. It
     *           supports the following syntaxes:
     *           * `<aspect_type_reference>` - matches an aspect of the given type and empty
     *           path.
     *           * `<aspect_type_reference>&#64;path` - matches an aspect of the given type and
     *           specified path. For example, to attach an aspect to a field that is
     *           specified by the `schema` aspect, the path should have the format
     *           `Schema.<field_name>`.
     *           * `<aspect_type_reference>&#64;*` - matches aspects of the given type for all
     *           paths.
     *           * `*&#64;path` - matches aspects of all types on the given path.
     *           The service will not remove existing aspects matching the syntax unless
     *           `delete_missing_aspects` is set to true.
     *           If this field is left empty, the service treats it as specifying
     *           exactly those Aspects present in the request.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Dataplex\V1\Catalog::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. Entry resource.
     *
     * Generated from protobuf field <code>.google.cloud.dataplex.v1.Entry entry = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Cloud\Dataplex\V1\Entry|null
     */
    public function getEntry()
    {
        return $this->entry;
    }

    public function hasEntry()
    {
        return isset($this->entry);
    }

    public function clearEntry()
    {
        unset($this->entry);
    }

    /**
     * Required. Entry resource.
     *
     * Generated from protobuf field <code>.google.cloud.dataplex.v1.Entry entry = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Cloud\Dataplex\V1\Entry $var
     * @return $this
     */
    public function setEntry($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Dataplex\V1\Entry::class);
        $this->entry = $var;

        return $this;
    }

    /**
     * Optional. Mask of fields to update. To update Aspects, the update_mask must
     * contain the value "aspects".
     * If the update_mask is empty, the service will update all modifiable fields
     * present in the request.
     *
     * Generated from protobuf field <code>.google.protobuf.FieldMask update_mask = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Protobuf\FieldMask|null
     */
    public function getUpdateMask()
    {
        return $this->update_mask;
    }

    public function hasUpdateMask()
    {
        return isset($this->update_mask);
    }

    public function clearUpdateMask()
    {
        unset($this->update_mask);
    }

    /**
     * Optional. Mask of fields to update. To update Aspects, the update_mask must
     * contain the value "aspects".
     * If the update_mask is empty, the service will update all modifiable fields
     * present in the request.
     *
     * Generated from protobuf field <code>.google.protobuf.FieldMask update_mask = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param \Google\Protobuf\FieldMask $var
     * @return $this
     */
    public function setUpdateMask($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\FieldMask::class);
        $this->update_mask = $var;

        return $this;
    }

    /**
     * Optional. If set to true and the entry doesn't exist, the service will
     * create it.
     *
     * Generated from protobuf field <code>bool allow_missing = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return bool
     */
    public function getAllowMissing()
    {
        return $this->allow_missing;
    }

    /**
     * Optional. If set to true and the entry doesn't exist, the service will
     * create it.
     *
     * Generated from protobuf field <code>bool allow_missing = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param bool $var
     * @return $this
     */
    public function setAllowMissing($var)
    {
        GPBUtil::checkBool($var);
        $this->allow_missing = $var;

        return $this;
    }

    /**
     * Optional. If set to true and the aspect_keys specify aspect ranges, the
     * service deletes any existing aspects from that range that weren't provided
     * in the request.
     *
     * Generated from protobuf field <code>bool delete_missing_aspects = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return bool
     */
    public function getDeleteMissingAspects()
    {
        return $this->delete_missing_aspects;
    }

    /**
     * Optional. If set to true and the aspect_keys specify aspect ranges, the
     * service deletes any existing aspects from that range that weren't provided
     * in the request.
     *
     * Generated from protobuf field <code>bool delete_missing_aspects = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param bool $var
     * @return $this
     */
    public function setDeleteMissingAspects($var)
    {
        GPBUtil::checkBool($var);
        $this->delete_missing_aspects = $var;

        return $this;
    }

    /**
     * Optional. The map keys of the Aspects which the service should modify. It
     * supports the following syntaxes:
     * * `<aspect_type_reference>` - matches an aspect of the given type and empty
     * path.
     * * `<aspect_type_reference>&#64;path` - matches an aspect of the given type and
     * specified path. For example, to attach an aspect to a field that is
     * specified by the `schema` aspect, the path should have the format
     * `Schema.<field_name>`.
     * * `<aspect_type_reference>&#64;*` - matches aspects of the given type for all
     * paths.
     * * `*&#64;path` - matches aspects of all types on the given path.
     * The service will not remove existing aspects matching the syntax unless
     * `delete_missing_aspects` is set to true.
     * If this field is left empty, the service treats it as specifying
     * exactly those Aspects present in the request.
     *
     * Generated from protobuf field <code>repeated string aspect_keys = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getAspectKeys()
    {
        return $this->aspect_keys;
    }

    /**
     * Optional. The map keys of the Aspects which the service should modify. It
     * supports the following syntaxes:
     * * `<aspect_type_reference>` - matches an aspect of the given type and empty
     * path.
     * * `<aspect_type_reference>&#64;path` - matches an aspect of the given type and
     * specified path. For example, to attach an aspect to a field that is
     * specified by the `schema` aspect, the path should have the format
     * `Schema.<field_name>`.
     * * `<aspect_type_reference>&#64;*` - matches aspects of the given type for all
     * paths.
     * * `*&#64;path` - matches aspects of all types on the given path.
     * The service will not remove existing aspects matching the syntax unless
     * `delete_missing_aspects` is set to true.
     * If this field is left empty, the service treats it as specifying
     * exactly those Aspects present in the request.
     *
     * Generated from protobuf field <code>repeated string aspect_keys = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param array<string>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setAspectKeys($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->aspect_keys = $arr;

        return $this;
    }

}

