<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/dialogflow/v2/document.proto

namespace Google\Cloud\Dialogflow\V2;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Response message for
 * [Documents.ListDocuments][google.cloud.dialogflow.v2.Documents.ListDocuments].
 *
 * Generated from protobuf message <code>google.cloud.dialogflow.v2.ListDocumentsResponse</code>
 */
class ListDocumentsResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * The list of documents.
     *
     * Generated from protobuf field <code>repeated .google.cloud.dialogflow.v2.Document documents = 1;</code>
     */
    private $documents;
    /**
     * Token to retrieve the next page of results, or empty if there are no
     * more results in the list.
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
     *     @type array<\Google\Cloud\Dialogflow\V2\Document>|\Google\Protobuf\Internal\RepeatedField $documents
     *           The list of documents.
     *     @type string $next_page_token
     *           Token to retrieve the next page of results, or empty if there are no
     *           more results in the list.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Dialogflow\V2\Document::initOnce();
        parent::__construct($data);
    }

    /**
     * The list of documents.
     *
     * Generated from protobuf field <code>repeated .google.cloud.dialogflow.v2.Document documents = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * The list of documents.
     *
     * Generated from protobuf field <code>repeated .google.cloud.dialogflow.v2.Document documents = 1;</code>
     * @param array<\Google\Cloud\Dialogflow\V2\Document>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setDocuments($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\Dialogflow\V2\Document::class);
        $this->documents = $arr;

        return $this;
    }

    /**
     * Token to retrieve the next page of results, or empty if there are no
     * more results in the list.
     *
     * Generated from protobuf field <code>string next_page_token = 2;</code>
     * @return string
     */
    public function getNextPageToken()
    {
        return $this->next_page_token;
    }

    /**
     * Token to retrieve the next page of results, or empty if there are no
     * more results in the list.
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

