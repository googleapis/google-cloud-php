<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/dataplex/v1/catalog.proto

namespace Google\Cloud\Dataplex\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Get EntryType request.
 *
 * Generated from protobuf message <code>google.cloud.dataplex.v1.GetEntryTypeRequest</code>
 */
class GetEntryTypeRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The resource name of the EntryType:
     * `projects/{project_number}/locations/{location_id}/entryTypes/{entry_type_id}`.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $name = '';

    /**
     * @param string $name Required. The resource name of the EntryType:
     *                     `projects/{project_number}/locations/{location_id}/entryTypes/{entry_type_id}`. Please see
     *                     {@see CatalogServiceClient::entryTypeName()} for help formatting this field.
     *
     * @return \Google\Cloud\Dataplex\V1\GetEntryTypeRequest
     *
     * @experimental
     */
    public static function build(string $name): self
    {
        return (new self())
            ->setName($name);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           Required. The resource name of the EntryType:
     *           `projects/{project_number}/locations/{location_id}/entryTypes/{entry_type_id}`.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Dataplex\V1\Catalog::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The resource name of the EntryType:
     * `projects/{project_number}/locations/{location_id}/entryTypes/{entry_type_id}`.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Required. The resource name of the EntryType:
     * `projects/{project_number}/locations/{location_id}/entryTypes/{entry_type_id}`.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
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

