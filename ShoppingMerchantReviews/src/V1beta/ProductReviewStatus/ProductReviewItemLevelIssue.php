<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/shopping/merchant/reviews/v1beta/productreviews_common.proto

namespace Google\Shopping\Merchant\Reviews\V1beta\ProductReviewStatus;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The ItemLevelIssue of the product review status.
 *
 * Generated from protobuf message <code>google.shopping.merchant.reviews.v1beta.ProductReviewStatus.ProductReviewItemLevelIssue</code>
 */
class ProductReviewItemLevelIssue extends \Google\Protobuf\Internal\Message
{
    /**
     * Output only. The error code of the issue.
     *
     * Generated from protobuf field <code>string code = 1 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $code = '';
    /**
     * Output only. How this issue affects serving of the product review.
     *
     * Generated from protobuf field <code>.google.shopping.merchant.reviews.v1beta.ProductReviewStatus.ProductReviewItemLevelIssue.Severity severity = 2 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $severity = 0;
    /**
     * Output only. Whether the issue can be resolved by the merchant.
     *
     * Generated from protobuf field <code>string resolution = 3 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $resolution = '';
    /**
     * Output only. The attribute's name, if the issue is caused by a single
     * attribute.
     *
     * Generated from protobuf field <code>string attribute = 4 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $attribute = '';
    /**
     * Output only. The reporting context the issue applies to.
     *
     * Generated from protobuf field <code>.google.shopping.type.ReportingContext.ReportingContextEnum reporting_context = 5 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $reporting_context = 0;
    /**
     * Output only. A short issue description in English.
     *
     * Generated from protobuf field <code>string description = 6 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $description = '';
    /**
     * Output only. A detailed issue description in English.
     *
     * Generated from protobuf field <code>string detail = 7 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $detail = '';
    /**
     * Output only. The URL of a web page to help with resolving this issue.
     *
     * Generated from protobuf field <code>string documentation = 8 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $documentation = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $code
     *           Output only. The error code of the issue.
     *     @type int $severity
     *           Output only. How this issue affects serving of the product review.
     *     @type string $resolution
     *           Output only. Whether the issue can be resolved by the merchant.
     *     @type string $attribute
     *           Output only. The attribute's name, if the issue is caused by a single
     *           attribute.
     *     @type int $reporting_context
     *           Output only. The reporting context the issue applies to.
     *     @type string $description
     *           Output only. A short issue description in English.
     *     @type string $detail
     *           Output only. A detailed issue description in English.
     *     @type string $documentation
     *           Output only. The URL of a web page to help with resolving this issue.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Shopping\Merchant\Reviews\V1Beta\ProductreviewsCommon::initOnce();
        parent::__construct($data);
    }

    /**
     * Output only. The error code of the issue.
     *
     * Generated from protobuf field <code>string code = 1 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Output only. The error code of the issue.
     *
     * Generated from protobuf field <code>string code = 1 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param string $var
     * @return $this
     */
    public function setCode($var)
    {
        GPBUtil::checkString($var, True);
        $this->code = $var;

        return $this;
    }

    /**
     * Output only. How this issue affects serving of the product review.
     *
     * Generated from protobuf field <code>.google.shopping.merchant.reviews.v1beta.ProductReviewStatus.ProductReviewItemLevelIssue.Severity severity = 2 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return int
     */
    public function getSeverity()
    {
        return $this->severity;
    }

    /**
     * Output only. How this issue affects serving of the product review.
     *
     * Generated from protobuf field <code>.google.shopping.merchant.reviews.v1beta.ProductReviewStatus.ProductReviewItemLevelIssue.Severity severity = 2 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param int $var
     * @return $this
     */
    public function setSeverity($var)
    {
        GPBUtil::checkEnum($var, \Google\Shopping\Merchant\Reviews\V1beta\ProductReviewStatus\ProductReviewItemLevelIssue\Severity::class);
        $this->severity = $var;

        return $this;
    }

    /**
     * Output only. Whether the issue can be resolved by the merchant.
     *
     * Generated from protobuf field <code>string resolution = 3 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return string
     */
    public function getResolution()
    {
        return $this->resolution;
    }

    /**
     * Output only. Whether the issue can be resolved by the merchant.
     *
     * Generated from protobuf field <code>string resolution = 3 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param string $var
     * @return $this
     */
    public function setResolution($var)
    {
        GPBUtil::checkString($var, True);
        $this->resolution = $var;

        return $this;
    }

    /**
     * Output only. The attribute's name, if the issue is caused by a single
     * attribute.
     *
     * Generated from protobuf field <code>string attribute = 4 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return string
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * Output only. The attribute's name, if the issue is caused by a single
     * attribute.
     *
     * Generated from protobuf field <code>string attribute = 4 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param string $var
     * @return $this
     */
    public function setAttribute($var)
    {
        GPBUtil::checkString($var, True);
        $this->attribute = $var;

        return $this;
    }

    /**
     * Output only. The reporting context the issue applies to.
     *
     * Generated from protobuf field <code>.google.shopping.type.ReportingContext.ReportingContextEnum reporting_context = 5 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return int
     */
    public function getReportingContext()
    {
        return $this->reporting_context;
    }

    /**
     * Output only. The reporting context the issue applies to.
     *
     * Generated from protobuf field <code>.google.shopping.type.ReportingContext.ReportingContextEnum reporting_context = 5 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param int $var
     * @return $this
     */
    public function setReportingContext($var)
    {
        GPBUtil::checkEnum($var, \Google\Shopping\Type\ReportingContext\ReportingContextEnum::class);
        $this->reporting_context = $var;

        return $this;
    }

    /**
     * Output only. A short issue description in English.
     *
     * Generated from protobuf field <code>string description = 6 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Output only. A short issue description in English.
     *
     * Generated from protobuf field <code>string description = 6 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param string $var
     * @return $this
     */
    public function setDescription($var)
    {
        GPBUtil::checkString($var, True);
        $this->description = $var;

        return $this;
    }

    /**
     * Output only. A detailed issue description in English.
     *
     * Generated from protobuf field <code>string detail = 7 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return string
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * Output only. A detailed issue description in English.
     *
     * Generated from protobuf field <code>string detail = 7 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param string $var
     * @return $this
     */
    public function setDetail($var)
    {
        GPBUtil::checkString($var, True);
        $this->detail = $var;

        return $this;
    }

    /**
     * Output only. The URL of a web page to help with resolving this issue.
     *
     * Generated from protobuf field <code>string documentation = 8 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return string
     */
    public function getDocumentation()
    {
        return $this->documentation;
    }

    /**
     * Output only. The URL of a web page to help with resolving this issue.
     *
     * Generated from protobuf field <code>string documentation = 8 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param string $var
     * @return $this
     */
    public function setDocumentation($var)
    {
        GPBUtil::checkString($var, True);
        $this->documentation = $var;

        return $this;
    }

}


