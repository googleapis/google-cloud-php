<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# NO CHECKED-IN PROTOBUF GENCODE
# source: google/bigtable/testproxy/test_proxy.proto

namespace Google\Bigtable\Testproxy;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request to test proxy service to execute a query.
 *
 * Generated from protobuf message <code>google.bigtable.testproxy.ExecuteQueryRequest</code>
 */
class ExecuteQueryRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * The ID of the target client object.
     *
     * Generated from protobuf field <code>string client_id = 1;</code>
     */
    protected $client_id = '';
    /**
     * The raw request to the Bigtable server.
     *
     * Generated from protobuf field <code>.google.bigtable.v2.ExecuteQueryRequest request = 2;</code>
     */
    protected $request = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $client_id
     *           The ID of the target client object.
     *     @type \Google\Cloud\Bigtable\V2\ExecuteQueryRequest $request
     *           The raw request to the Bigtable server.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Bigtable\Testproxy\TestProxy::initOnce();
        parent::__construct($data);
    }

    /**
     * The ID of the target client object.
     *
     * Generated from protobuf field <code>string client_id = 1;</code>
     * @return string
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * The ID of the target client object.
     *
     * Generated from protobuf field <code>string client_id = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setClientId($var)
    {
        GPBUtil::checkString($var, True);
        $this->client_id = $var;

        return $this;
    }

    /**
     * The raw request to the Bigtable server.
     *
     * Generated from protobuf field <code>.google.bigtable.v2.ExecuteQueryRequest request = 2;</code>
     * @return \Google\Cloud\Bigtable\V2\ExecuteQueryRequest|null
     */
    public function getRequest()
    {
        return $this->request;
    }

    public function hasRequest()
    {
        return isset($this->request);
    }

    public function clearRequest()
    {
        unset($this->request);
    }

    /**
     * The raw request to the Bigtable server.
     *
     * Generated from protobuf field <code>.google.bigtable.v2.ExecuteQueryRequest request = 2;</code>
     * @param \Google\Cloud\Bigtable\V2\ExecuteQueryRequest $var
     * @return $this
     */
    public function setRequest($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Bigtable\V2\ExecuteQueryRequest::class);
        $this->request = $var;

        return $this;
    }

}

