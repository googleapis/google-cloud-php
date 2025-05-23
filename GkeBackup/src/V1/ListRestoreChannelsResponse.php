<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/gkebackup/v1/gkebackup.proto

namespace Google\Cloud\GkeBackup\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Response message for ListRestoreChannels.
 *
 * Generated from protobuf message <code>google.cloud.gkebackup.v1.ListRestoreChannelsResponse</code>
 */
class ListRestoreChannelsResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * The list of RestoreChannels matching the given criteria.
     *
     * Generated from protobuf field <code>repeated .google.cloud.gkebackup.v1.RestoreChannel restore_channels = 1;</code>
     */
    private $restore_channels;
    /**
     * A token which may be sent as
     * [page_token][google.cloud.gkebackup.v1.ListRestoreChannelsRequest.page_token]
     * in a subsequent `ListRestoreChannels` call to retrieve the next page of
     * results. If this field is omitted or empty, then there are no more results
     * to return.
     *
     * Generated from protobuf field <code>string next_page_token = 2;</code>
     */
    protected $next_page_token = '';
    /**
     * Locations that could not be reached.
     *
     * Generated from protobuf field <code>repeated string unreachable = 3;</code>
     */
    private $unreachable;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<\Google\Cloud\GkeBackup\V1\RestoreChannel>|\Google\Protobuf\Internal\RepeatedField $restore_channels
     *           The list of RestoreChannels matching the given criteria.
     *     @type string $next_page_token
     *           A token which may be sent as
     *           [page_token][google.cloud.gkebackup.v1.ListRestoreChannelsRequest.page_token]
     *           in a subsequent `ListRestoreChannels` call to retrieve the next page of
     *           results. If this field is omitted or empty, then there are no more results
     *           to return.
     *     @type array<string>|\Google\Protobuf\Internal\RepeatedField $unreachable
     *           Locations that could not be reached.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Gkebackup\V1\Gkebackup::initOnce();
        parent::__construct($data);
    }

    /**
     * The list of RestoreChannels matching the given criteria.
     *
     * Generated from protobuf field <code>repeated .google.cloud.gkebackup.v1.RestoreChannel restore_channels = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getRestoreChannels()
    {
        return $this->restore_channels;
    }

    /**
     * The list of RestoreChannels matching the given criteria.
     *
     * Generated from protobuf field <code>repeated .google.cloud.gkebackup.v1.RestoreChannel restore_channels = 1;</code>
     * @param array<\Google\Cloud\GkeBackup\V1\RestoreChannel>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setRestoreChannels($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\GkeBackup\V1\RestoreChannel::class);
        $this->restore_channels = $arr;

        return $this;
    }

    /**
     * A token which may be sent as
     * [page_token][google.cloud.gkebackup.v1.ListRestoreChannelsRequest.page_token]
     * in a subsequent `ListRestoreChannels` call to retrieve the next page of
     * results. If this field is omitted or empty, then there are no more results
     * to return.
     *
     * Generated from protobuf field <code>string next_page_token = 2;</code>
     * @return string
     */
    public function getNextPageToken()
    {
        return $this->next_page_token;
    }

    /**
     * A token which may be sent as
     * [page_token][google.cloud.gkebackup.v1.ListRestoreChannelsRequest.page_token]
     * in a subsequent `ListRestoreChannels` call to retrieve the next page of
     * results. If this field is omitted or empty, then there are no more results
     * to return.
     *
     * Generated from protobuf field <code>string next_page_token = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setNextPageToken($var)
    {
        GPBUtil::checkString($var, True);
        $this->next_page_token = $var;

        return $this;
    }

    /**
     * Locations that could not be reached.
     *
     * Generated from protobuf field <code>repeated string unreachable = 3;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getUnreachable()
    {
        return $this->unreachable;
    }

    /**
     * Locations that could not be reached.
     *
     * Generated from protobuf field <code>repeated string unreachable = 3;</code>
     * @param array<string>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setUnreachable($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->unreachable = $arr;

        return $this;
    }

}

