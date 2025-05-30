<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/financialservices/v1/backtest_result.proto

namespace Google\Cloud\FinancialServices\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request for updating a BacktestResult
 *
 * Generated from protobuf message <code>google.cloud.financialservices.v1.UpdateBacktestResultRequest</code>
 */
class UpdateBacktestResultRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Optional. Field mask is used to specify the fields to be overwritten in the
     * BacktestResult resource by the update.
     * The fields specified in the update_mask are relative to the resource, not
     * the full request. A field will be overwritten if it is in the mask. If the
     * user does not provide a mask then all fields will be overwritten.
     *
     * Generated from protobuf field <code>.google.protobuf.FieldMask update_mask = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $update_mask = null;
    /**
     * Required. The new value of the BacktestResult fields that will be updated
     * according to the update_mask.
     *
     * Generated from protobuf field <code>.google.cloud.financialservices.v1.BacktestResult backtest_result = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $backtest_result = null;
    /**
     * Optional. An optional request ID to identify requests. Specify a unique
     * request ID so that if you must retry your request, the server will know to
     * ignore the request if it has already been completed. The server will
     * guarantee that for at least 60 minutes since the first request.
     * For example, consider a situation where you make an initial request and the
     * request times out. If you make the request again with the same request
     * ID, the server can check if original operation with the same request ID
     * was received, and if so, will ignore the second request. This prevents
     * clients from accidentally creating duplicate commitments.
     * The request ID must be a valid UUID with the exception that zero UUID is
     * not supported (00000000-0000-0000-0000-000000000000).
     *
     * Generated from protobuf field <code>string request_id = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $request_id = '';

    /**
     * @param \Google\Cloud\FinancialServices\V1\BacktestResult $backtestResult Required. The new value of the BacktestResult fields that will be updated
     *                                                                          according to the update_mask.
     * @param \Google\Protobuf\FieldMask                        $updateMask     Optional. Field mask is used to specify the fields to be overwritten in the
     *                                                                          BacktestResult resource by the update.
     *                                                                          The fields specified in the update_mask are relative to the resource, not
     *                                                                          the full request. A field will be overwritten if it is in the mask. If the
     *                                                                          user does not provide a mask then all fields will be overwritten.
     *
     * @return \Google\Cloud\FinancialServices\V1\UpdateBacktestResultRequest
     *
     * @experimental
     */
    public static function build(\Google\Cloud\FinancialServices\V1\BacktestResult $backtestResult, \Google\Protobuf\FieldMask $updateMask): self
    {
        return (new self())
            ->setBacktestResult($backtestResult)
            ->setUpdateMask($updateMask);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Protobuf\FieldMask $update_mask
     *           Optional. Field mask is used to specify the fields to be overwritten in the
     *           BacktestResult resource by the update.
     *           The fields specified in the update_mask are relative to the resource, not
     *           the full request. A field will be overwritten if it is in the mask. If the
     *           user does not provide a mask then all fields will be overwritten.
     *     @type \Google\Cloud\FinancialServices\V1\BacktestResult $backtest_result
     *           Required. The new value of the BacktestResult fields that will be updated
     *           according to the update_mask.
     *     @type string $request_id
     *           Optional. An optional request ID to identify requests. Specify a unique
     *           request ID so that if you must retry your request, the server will know to
     *           ignore the request if it has already been completed. The server will
     *           guarantee that for at least 60 minutes since the first request.
     *           For example, consider a situation where you make an initial request and the
     *           request times out. If you make the request again with the same request
     *           ID, the server can check if original operation with the same request ID
     *           was received, and if so, will ignore the second request. This prevents
     *           clients from accidentally creating duplicate commitments.
     *           The request ID must be a valid UUID with the exception that zero UUID is
     *           not supported (00000000-0000-0000-0000-000000000000).
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Financialservices\V1\BacktestResult::initOnce();
        parent::__construct($data);
    }

    /**
     * Optional. Field mask is used to specify the fields to be overwritten in the
     * BacktestResult resource by the update.
     * The fields specified in the update_mask are relative to the resource, not
     * the full request. A field will be overwritten if it is in the mask. If the
     * user does not provide a mask then all fields will be overwritten.
     *
     * Generated from protobuf field <code>.google.protobuf.FieldMask update_mask = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Protobuf\FieldMask|null
     */
    public function getUpdateMask()
    {
        return $this->update_mask;
    }

    public function hasUpdateMask()
    {
        return isset($this->update_mask);
    }

    public function clearUpdateMask()
    {
        unset($this->update_mask);
    }

    /**
     * Optional. Field mask is used to specify the fields to be overwritten in the
     * BacktestResult resource by the update.
     * The fields specified in the update_mask are relative to the resource, not
     * the full request. A field will be overwritten if it is in the mask. If the
     * user does not provide a mask then all fields will be overwritten.
     *
     * Generated from protobuf field <code>.google.protobuf.FieldMask update_mask = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param \Google\Protobuf\FieldMask $var
     * @return $this
     */
    public function setUpdateMask($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\FieldMask::class);
        $this->update_mask = $var;

        return $this;
    }

    /**
     * Required. The new value of the BacktestResult fields that will be updated
     * according to the update_mask.
     *
     * Generated from protobuf field <code>.google.cloud.financialservices.v1.BacktestResult backtest_result = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Cloud\FinancialServices\V1\BacktestResult|null
     */
    public function getBacktestResult()
    {
        return $this->backtest_result;
    }

    public function hasBacktestResult()
    {
        return isset($this->backtest_result);
    }

    public function clearBacktestResult()
    {
        unset($this->backtest_result);
    }

    /**
     * Required. The new value of the BacktestResult fields that will be updated
     * according to the update_mask.
     *
     * Generated from protobuf field <code>.google.cloud.financialservices.v1.BacktestResult backtest_result = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Cloud\FinancialServices\V1\BacktestResult $var
     * @return $this
     */
    public function setBacktestResult($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\FinancialServices\V1\BacktestResult::class);
        $this->backtest_result = $var;

        return $this;
    }

    /**
     * Optional. An optional request ID to identify requests. Specify a unique
     * request ID so that if you must retry your request, the server will know to
     * ignore the request if it has already been completed. The server will
     * guarantee that for at least 60 minutes since the first request.
     * For example, consider a situation where you make an initial request and the
     * request times out. If you make the request again with the same request
     * ID, the server can check if original operation with the same request ID
     * was received, and if so, will ignore the second request. This prevents
     * clients from accidentally creating duplicate commitments.
     * The request ID must be a valid UUID with the exception that zero UUID is
     * not supported (00000000-0000-0000-0000-000000000000).
     *
     * Generated from protobuf field <code>string request_id = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
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
     * For example, consider a situation where you make an initial request and the
     * request times out. If you make the request again with the same request
     * ID, the server can check if original operation with the same request ID
     * was received, and if so, will ignore the second request. This prevents
     * clients from accidentally creating duplicate commitments.
     * The request ID must be a valid UUID with the exception that zero UUID is
     * not supported (00000000-0000-0000-0000-000000000000).
     *
     * Generated from protobuf field <code>string request_id = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
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

