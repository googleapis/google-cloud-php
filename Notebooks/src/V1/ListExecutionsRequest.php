<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/notebooks/v1/service.proto

namespace Google\Cloud\Notebooks\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request for listing scheduled notebook executions.
 *
 * Generated from protobuf message <code>google.cloud.notebooks.v1.ListExecutionsRequest</code>
 */
class ListExecutionsRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. Format:
     * `parent=projects/{project_id}/locations/{location}`
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    private $parent = '';
    /**
     * Maximum return size of the list call.
     *
     * Generated from protobuf field <code>int32 page_size = 2;</code>
     */
    private $page_size = 0;
    /**
     * A previous returned page token that can be used to continue listing
     * from the last result.
     *
     * Generated from protobuf field <code>string page_token = 3;</code>
     */
    private $page_token = '';
    /**
     * Filter applied to resulting executions. Currently only supports filtering
     * executions by a specified `schedule_id`.
     * Format: `schedule_id=<Schedule_ID>`
     *
     * Generated from protobuf field <code>string filter = 4;</code>
     */
    private $filter = '';
    /**
     * Sort by field.
     *
     * Generated from protobuf field <code>string order_by = 5;</code>
     */
    private $order_by = '';

    /**
     * @param string $parent Required. Format:
     *                       `parent=projects/{project_id}/locations/{location}`
     *                       Please see {@see NotebookServiceClient::executionName()} for help formatting this field.
     *
     * @return \Google\Cloud\Notebooks\V1\ListExecutionsRequest
     *
     * @experimental
     */
    public static function build(string $parent): self
    {
        return (new self())
            ->setParent($parent);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $parent
     *           Required. Format:
     *           `parent=projects/{project_id}/locations/{location}`
     *     @type int $page_size
     *           Maximum return size of the list call.
     *     @type string $page_token
     *           A previous returned page token that can be used to continue listing
     *           from the last result.
     *     @type string $filter
     *           Filter applied to resulting executions. Currently only supports filtering
     *           executions by a specified `schedule_id`.
     *           Format: `schedule_id=<Schedule_ID>`
     *     @type string $order_by
     *           Sort by field.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Notebooks\V1\Service::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. Format:
     * `parent=projects/{project_id}/locations/{location}`
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Required. Format:
     * `parent=projects/{project_id}/locations/{location}`
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setParent($var)
    {
        GPBUtil::checkString($var, True);
        $this->parent = $var;

        return $this;
    }

    /**
     * Maximum return size of the list call.
     *
     * Generated from protobuf field <code>int32 page_size = 2;</code>
     * @return int
     */
    public function getPageSize()
    {
        return $this->page_size;
    }

    /**
     * Maximum return size of the list call.
     *
     * Generated from protobuf field <code>int32 page_size = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setPageSize($var)
    {
        GPBUtil::checkInt32($var);
        $this->page_size = $var;

        return $this;
    }

    /**
     * A previous returned page token that can be used to continue listing
     * from the last result.
     *
     * Generated from protobuf field <code>string page_token = 3;</code>
     * @return string
     */
    public function getPageToken()
    {
        return $this->page_token;
    }

    /**
     * A previous returned page token that can be used to continue listing
     * from the last result.
     *
     * Generated from protobuf field <code>string page_token = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setPageToken($var)
    {
        GPBUtil::checkString($var, True);
        $this->page_token = $var;

        return $this;
    }

    /**
     * Filter applied to resulting executions. Currently only supports filtering
     * executions by a specified `schedule_id`.
     * Format: `schedule_id=<Schedule_ID>`
     *
     * Generated from protobuf field <code>string filter = 4;</code>
     * @return string
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * Filter applied to resulting executions. Currently only supports filtering
     * executions by a specified `schedule_id`.
     * Format: `schedule_id=<Schedule_ID>`
     *
     * Generated from protobuf field <code>string filter = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setFilter($var)
    {
        GPBUtil::checkString($var, True);
        $this->filter = $var;

        return $this;
    }

    /**
     * Sort by field.
     *
     * Generated from protobuf field <code>string order_by = 5;</code>
     * @return string
     */
    public function getOrderBy()
    {
        return $this->order_by;
    }

    /**
     * Sort by field.
     *
     * Generated from protobuf field <code>string order_by = 5;</code>
     * @param string $var
     * @return $this
     */
    public function setOrderBy($var)
    {
        GPBUtil::checkString($var, True);
        $this->order_by = $var;

        return $this;
    }

}
