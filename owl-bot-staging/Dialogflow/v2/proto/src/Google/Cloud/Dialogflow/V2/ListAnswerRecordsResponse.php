<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/dialogflow/v2/answer_record.proto

namespace Google\Cloud\Dialogflow\V2;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Response message for
 * [AnswerRecords.ListAnswerRecords][google.cloud.dialogflow.v2.AnswerRecords.ListAnswerRecords].
 *
 * Generated from protobuf message <code>google.cloud.dialogflow.v2.ListAnswerRecordsResponse</code>
 */
class ListAnswerRecordsResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * The list of answer records.
     *
     * Generated from protobuf field <code>repeated .google.cloud.dialogflow.v2.AnswerRecord answer_records = 1;</code>
     */
    private $answer_records;
    /**
     * A token to retrieve next page of results. Or empty if there are no more
     * results.
     * Pass this value in the
     * [ListAnswerRecordsRequest.page_token][google.cloud.dialogflow.v2.ListAnswerRecordsRequest.page_token]
     * field in the subsequent call to `ListAnswerRecords` method to retrieve the
     * next page of results.
     *
     * Generated from protobuf field <code>string next_page_token = 2;</code>
     */
    protected $next_page_token = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<\Google\Cloud\Dialogflow\V2\AnswerRecord>|\Google\Protobuf\Internal\RepeatedField $answer_records
     *           The list of answer records.
     *     @type string $next_page_token
     *           A token to retrieve next page of results. Or empty if there are no more
     *           results.
     *           Pass this value in the
     *           [ListAnswerRecordsRequest.page_token][google.cloud.dialogflow.v2.ListAnswerRecordsRequest.page_token]
     *           field in the subsequent call to `ListAnswerRecords` method to retrieve the
     *           next page of results.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Dialogflow\V2\AnswerRecord::initOnce();
        parent::__construct($data);
    }

    /**
     * The list of answer records.
     *
     * Generated from protobuf field <code>repeated .google.cloud.dialogflow.v2.AnswerRecord answer_records = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getAnswerRecords()
    {
        return $this->answer_records;
    }

    /**
     * The list of answer records.
     *
     * Generated from protobuf field <code>repeated .google.cloud.dialogflow.v2.AnswerRecord answer_records = 1;</code>
     * @param array<\Google\Cloud\Dialogflow\V2\AnswerRecord>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setAnswerRecords($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\Dialogflow\V2\AnswerRecord::class);
        $this->answer_records = $arr;

        return $this;
    }

    /**
     * A token to retrieve next page of results. Or empty if there are no more
     * results.
     * Pass this value in the
     * [ListAnswerRecordsRequest.page_token][google.cloud.dialogflow.v2.ListAnswerRecordsRequest.page_token]
     * field in the subsequent call to `ListAnswerRecords` method to retrieve the
     * next page of results.
     *
     * Generated from protobuf field <code>string next_page_token = 2;</code>
     * @return string
     */
    public function getNextPageToken()
    {
        return $this->next_page_token;
    }

    /**
     * A token to retrieve next page of results. Or empty if there are no more
     * results.
     * Pass this value in the
     * [ListAnswerRecordsRequest.page_token][google.cloud.dialogflow.v2.ListAnswerRecordsRequest.page_token]
     * field in the subsequent call to `ListAnswerRecords` method to retrieve the
     * next page of results.
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

}
