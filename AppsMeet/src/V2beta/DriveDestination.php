<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/apps/meet/v2beta/resource.proto

namespace Google\Apps\Meet\V2beta;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Export location where a recording file is saved in Google Drive.
 *
 * Generated from protobuf message <code>google.apps.meet.v2beta.DriveDestination</code>
 */
class DriveDestination extends \Google\Protobuf\Internal\Message
{
    /**
     * Output only. The `fileId` for the underlying MP4 file. For example,
     * "1kuceFZohVoCh6FulBHxwy6I15Ogpc4hP". Use `$ GET
     * https://www.googleapis.com/drive/v3/files/{$fileId}?alt=media` to download
     * the blob. For more information, see
     * https://developers.google.com/drive/api/v3/reference/files/get.
     *
     * Generated from protobuf field <code>string file = 1 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $file = '';
    /**
     * Output only. Link used to play back the recording file in the browser. For
     * example, `https://drive.google.com/file/d/{$fileId}/view`.
     *
     * Generated from protobuf field <code>string export_uri = 2 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $export_uri = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $file
     *           Output only. The `fileId` for the underlying MP4 file. For example,
     *           "1kuceFZohVoCh6FulBHxwy6I15Ogpc4hP". Use `$ GET
     *           https://www.googleapis.com/drive/v3/files/{$fileId}?alt=media` to download
     *           the blob. For more information, see
     *           https://developers.google.com/drive/api/v3/reference/files/get.
     *     @type string $export_uri
     *           Output only. Link used to play back the recording file in the browser. For
     *           example, `https://drive.google.com/file/d/{$fileId}/view`.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Apps\Meet\V2Beta\Resource::initOnce();
        parent::__construct($data);
    }

    /**
     * Output only. The `fileId` for the underlying MP4 file. For example,
     * "1kuceFZohVoCh6FulBHxwy6I15Ogpc4hP". Use `$ GET
     * https://www.googleapis.com/drive/v3/files/{$fileId}?alt=media` to download
     * the blob. For more information, see
     * https://developers.google.com/drive/api/v3/reference/files/get.
     *
     * Generated from protobuf field <code>string file = 1 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Output only. The `fileId` for the underlying MP4 file. For example,
     * "1kuceFZohVoCh6FulBHxwy6I15Ogpc4hP". Use `$ GET
     * https://www.googleapis.com/drive/v3/files/{$fileId}?alt=media` to download
     * the blob. For more information, see
     * https://developers.google.com/drive/api/v3/reference/files/get.
     *
     * Generated from protobuf field <code>string file = 1 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param string $var
     * @return $this
     */
    public function setFile($var)
    {
        GPBUtil::checkString($var, True);
        $this->file = $var;

        return $this;
    }

    /**
     * Output only. Link used to play back the recording file in the browser. For
     * example, `https://drive.google.com/file/d/{$fileId}/view`.
     *
     * Generated from protobuf field <code>string export_uri = 2 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return string
     */
    public function getExportUri()
    {
        return $this->export_uri;
    }

    /**
     * Output only. Link used to play back the recording file in the browser. For
     * example, `https://drive.google.com/file/d/{$fileId}/view`.
     *
     * Generated from protobuf field <code>string export_uri = 2 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param string $var
     * @return $this
     */
    public function setExportUri($var)
    {
        GPBUtil::checkString($var, True);
        $this->export_uri = $var;

        return $this;
    }

}
