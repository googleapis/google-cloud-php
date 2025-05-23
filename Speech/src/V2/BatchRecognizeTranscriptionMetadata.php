<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/speech/v2/cloud_speech.proto

namespace Google\Cloud\Speech\V2;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Metadata about transcription for a single file (for example, progress
 * percent).
 *
 * Generated from protobuf message <code>google.cloud.speech.v2.BatchRecognizeTranscriptionMetadata</code>
 */
class BatchRecognizeTranscriptionMetadata extends \Google\Protobuf\Internal\Message
{
    /**
     * How much of the file has been transcribed so far.
     *
     * Generated from protobuf field <code>int32 progress_percent = 1;</code>
     */
    protected $progress_percent = 0;
    /**
     * Error if one was encountered.
     *
     * Generated from protobuf field <code>.google.rpc.Status error = 2;</code>
     */
    protected $error = null;
    /**
     * The Cloud Storage URI to which recognition results will be written.
     *
     * Generated from protobuf field <code>string uri = 3;</code>
     */
    protected $uri = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $progress_percent
     *           How much of the file has been transcribed so far.
     *     @type \Google\Rpc\Status $error
     *           Error if one was encountered.
     *     @type string $uri
     *           The Cloud Storage URI to which recognition results will be written.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Speech\V2\CloudSpeech::initOnce();
        parent::__construct($data);
    }

    /**
     * How much of the file has been transcribed so far.
     *
     * Generated from protobuf field <code>int32 progress_percent = 1;</code>
     * @return int
     */
    public function getProgressPercent()
    {
        return $this->progress_percent;
    }

    /**
     * How much of the file has been transcribed so far.
     *
     * Generated from protobuf field <code>int32 progress_percent = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setProgressPercent($var)
    {
        GPBUtil::checkInt32($var);
        $this->progress_percent = $var;

        return $this;
    }

    /**
     * Error if one was encountered.
     *
     * Generated from protobuf field <code>.google.rpc.Status error = 2;</code>
     * @return \Google\Rpc\Status|null
     */
    public function getError()
    {
        return $this->error;
    }

    public function hasError()
    {
        return isset($this->error);
    }

    public function clearError()
    {
        unset($this->error);
    }

    /**
     * Error if one was encountered.
     *
     * Generated from protobuf field <code>.google.rpc.Status error = 2;</code>
     * @param \Google\Rpc\Status $var
     * @return $this
     */
    public function setError($var)
    {
        GPBUtil::checkMessage($var, \Google\Rpc\Status::class);
        $this->error = $var;

        return $this;
    }

    /**
     * The Cloud Storage URI to which recognition results will be written.
     *
     * Generated from protobuf field <code>string uri = 3;</code>
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * The Cloud Storage URI to which recognition results will be written.
     *
     * Generated from protobuf field <code>string uri = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setUri($var)
    {
        GPBUtil::checkString($var, True);
        $this->uri = $var;

        return $this;
    }

}

