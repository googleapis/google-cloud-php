<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/telcoautomation/v1/telcoautomation.proto

namespace Google\Cloud\TelcoAutomation\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Message for creating a EdgeSlm.
 *
 * Generated from protobuf message <code>google.cloud.telcoautomation.v1.CreateEdgeSlmRequest</code>
 */
class CreateEdgeSlmRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. Value for parent.
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $parent = '';
    /**
     * Required. Id of the requesting object
     * If auto-generating Id server-side, remove this field and
     * edge_slm_id from the method_signature of Create RPC
     *
     * Generated from protobuf field <code>string edge_slm_id = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $edge_slm_id = '';
    /**
     * Required. The resource being created
     *
     * Generated from protobuf field <code>.google.cloud.telcoautomation.v1.EdgeSlm edge_slm = 3 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $edge_slm = null;
    /**
     * Optional. An optional request ID to identify requests. Specify a unique
     * request ID so that if you must retry your request, the server will know to
     * ignore the request if it has already been completed. The server will
     * guarantee that for at least 60 minutes since the first request.
     * For example, consider a situation where you make an initial request and
     * the request times out. If you make the request again with the same request
     * ID, the server can check if original operation with the same request ID
     * was received, and if so, will ignore the second request. This prevents
     * clients from accidentally creating duplicate commitments.
     * The request ID must be a valid UUID with the exception that zero UUID is
     * not supported (00000000-0000-0000-0000-000000000000).
     *
     * Generated from protobuf field <code>string request_id = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $request_id = '';

    /**
     * @param string                                   $parent    Required. Value for parent. Please see
     *                                                            {@see TelcoAutomationClient::locationName()} for help formatting this field.
     * @param \Google\Cloud\TelcoAutomation\V1\EdgeSlm $edgeSlm   Required. The resource being created
     * @param string                                   $edgeSlmId Required. Id of the requesting object
     *                                                            If auto-generating Id server-side, remove this field and
     *                                                            edge_slm_id from the method_signature of Create RPC
     *
     * @return \Google\Cloud\TelcoAutomation\V1\CreateEdgeSlmRequest
     *
     * @experimental
     */
    public static function build(string $parent, \Google\Cloud\TelcoAutomation\V1\EdgeSlm $edgeSlm, string $edgeSlmId): self
    {
        return (new self())
            ->setParent($parent)
            ->setEdgeSlm($edgeSlm)
            ->setEdgeSlmId($edgeSlmId);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $parent
     *           Required. Value for parent.
     *     @type string $edge_slm_id
     *           Required. Id of the requesting object
     *           If auto-generating Id server-side, remove this field and
     *           edge_slm_id from the method_signature of Create RPC
     *     @type \Google\Cloud\TelcoAutomation\V1\EdgeSlm $edge_slm
     *           Required. The resource being created
     *     @type string $request_id
     *           Optional. An optional request ID to identify requests. Specify a unique
     *           request ID so that if you must retry your request, the server will know to
     *           ignore the request if it has already been completed. The server will
     *           guarantee that for at least 60 minutes since the first request.
     *           For example, consider a situation where you make an initial request and
     *           the request times out. If you make the request again with the same request
     *           ID, the server can check if original operation with the same request ID
     *           was received, and if so, will ignore the second request. This prevents
     *           clients from accidentally creating duplicate commitments.
     *           The request ID must be a valid UUID with the exception that zero UUID is
     *           not supported (00000000-0000-0000-0000-000000000000).
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Telcoautomation\V1\Telcoautomation::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. Value for parent.
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Required. Value for parent.
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
     * Required. Id of the requesting object
     * If auto-generating Id server-side, remove this field and
     * edge_slm_id from the method_signature of Create RPC
     *
     * Generated from protobuf field <code>string edge_slm_id = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getEdgeSlmId()
    {
        return $this->edge_slm_id;
    }

    /**
     * Required. Id of the requesting object
     * If auto-generating Id server-side, remove this field and
     * edge_slm_id from the method_signature of Create RPC
     *
     * Generated from protobuf field <code>string edge_slm_id = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setEdgeSlmId($var)
    {
        GPBUtil::checkString($var, True);
        $this->edge_slm_id = $var;

        return $this;
    }

    /**
     * Required. The resource being created
     *
     * Generated from protobuf field <code>.google.cloud.telcoautomation.v1.EdgeSlm edge_slm = 3 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Cloud\TelcoAutomation\V1\EdgeSlm|null
     */
    public function getEdgeSlm()
    {
        return $this->edge_slm;
    }

    public function hasEdgeSlm()
    {
        return isset($this->edge_slm);
    }

    public function clearEdgeSlm()
    {
        unset($this->edge_slm);
    }

    /**
     * Required. The resource being created
     *
     * Generated from protobuf field <code>.google.cloud.telcoautomation.v1.EdgeSlm edge_slm = 3 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Cloud\TelcoAutomation\V1\EdgeSlm $var
     * @return $this
     */
    public function setEdgeSlm($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\TelcoAutomation\V1\EdgeSlm::class);
        $this->edge_slm = $var;

        return $this;
    }

    /**
     * Optional. An optional request ID to identify requests. Specify a unique
     * request ID so that if you must retry your request, the server will know to
     * ignore the request if it has already been completed. The server will
     * guarantee that for at least 60 minutes since the first request.
     * For example, consider a situation where you make an initial request and
     * the request times out. If you make the request again with the same request
     * ID, the server can check if original operation with the same request ID
     * was received, and if so, will ignore the second request. This prevents
     * clients from accidentally creating duplicate commitments.
     * The request ID must be a valid UUID with the exception that zero UUID is
     * not supported (00000000-0000-0000-0000-000000000000).
     *
     * Generated from protobuf field <code>string request_id = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getRequestId()
    {
        return $this->request_id;
    }

    /**
     * Optional. An optional request ID to identify requests. Specify a unique
     * request ID so that if you must retry your request, the server will know to
     * ignore the request if it has already been completed. The server will
     * guarantee that for at least 60 minutes since the first request.
     * For example, consider a situation where you make an initial request and
     * the request times out. If you make the request again with the same request
     * ID, the server can check if original operation with the same request ID
     * was received, and if so, will ignore the second request. This prevents
     * clients from accidentally creating duplicate commitments.
     * The request ID must be a valid UUID with the exception that zero UUID is
     * not supported (00000000-0000-0000-0000-000000000000).
     *
     * Generated from protobuf field <code>string request_id = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setRequestId($var)
    {
        GPBUtil::checkString($var, True);
        $this->request_id = $var;

        return $this;
    }

}
