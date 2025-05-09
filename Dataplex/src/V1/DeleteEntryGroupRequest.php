<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/dataplex/v1/catalog.proto

namespace Google\Cloud\Dataplex\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Delete EntryGroup Request.
 *
 * Generated from protobuf message <code>google.cloud.dataplex.v1.DeleteEntryGroupRequest</code>
 */
class DeleteEntryGroupRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The resource name of the EntryGroup:
     * `projects/{project_number}/locations/{location_id}/entryGroups/{entry_group_id}`.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $name = '';
    /**
     * Optional. If the client provided etag value does not match the current etag
     * value, the DeleteEntryGroupRequest method returns an ABORTED error
     * response.
     *
     * Generated from protobuf field <code>string etag = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $etag = '';

    /**
     * @param string $name Required. The resource name of the EntryGroup:
     *                     `projects/{project_number}/locations/{location_id}/entryGroups/{entry_group_id}`. Please see
     *                     {@see CatalogServiceClient::entryGroupName()} for help formatting this field.
     *
     * @return \Google\Cloud\Dataplex\V1\DeleteEntryGroupRequest
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
     *           Required. The resource name of the EntryGroup:
     *           `projects/{project_number}/locations/{location_id}/entryGroups/{entry_group_id}`.
     *     @type string $etag
     *           Optional. If the client provided etag value does not match the current etag
     *           value, the DeleteEntryGroupRequest method returns an ABORTED error
     *           response.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Dataplex\V1\Catalog::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The resource name of the EntryGroup:
     * `projects/{project_number}/locations/{location_id}/entryGroups/{entry_group_id}`.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Required. The resource name of the EntryGroup:
     * `projects/{project_number}/locations/{location_id}/entryGroups/{entry_group_id}`.
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

    /**
     * Optional. If the client provided etag value does not match the current etag
     * value, the DeleteEntryGroupRequest method returns an ABORTED error
     * response.
     *
     * Generated from protobuf field <code>string etag = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getEtag()
    {
        return $this->etag;
    }

    /**
     * Optional. If the client provided etag value does not match the current etag
     * value, the DeleteEntryGroupRequest method returns an ABORTED error
     * response.
     *
     * Generated from protobuf field <code>string etag = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setEtag($var)
    {
        GPBUtil::checkString($var, True);
        $this->etag = $var;

        return $this;
    }

}

