<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/binaryauthorization/v1beta1/continuous_validation_logging.proto

namespace Google\Cloud\BinaryAuthorization\V1beta1\ContinuousValidationEvent\ContinuousValidationPodEvent\ImageDetails;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>google.cloud.binaryauthorization.v1beta1.ContinuousValidationEvent.ContinuousValidationPodEvent.ImageDetails.CheckResult</code>
 */
class CheckResult extends \Google\Protobuf\Internal\Message
{
    /**
     * The index of the check set.
     *
     * Generated from protobuf field <code>string check_set_index = 1;</code>
     */
    protected $check_set_index = '';
    /**
     * The name of the check set.
     *
     * Generated from protobuf field <code>string check_set_name = 2;</code>
     */
    protected $check_set_name = '';
    /**
     * The scope of the check set.
     *
     * Generated from protobuf field <code>.google.cloud.binaryauthorization.v1beta1.ContinuousValidationEvent.ContinuousValidationPodEvent.ImageDetails.CheckResult.CheckSetScope check_set_scope = 3;</code>
     */
    protected $check_set_scope = null;
    /**
     * The index of the check.
     *
     * Generated from protobuf field <code>string check_index = 4;</code>
     */
    protected $check_index = '';
    /**
     * The name of the check.
     *
     * Generated from protobuf field <code>string check_name = 5;</code>
     */
    protected $check_name = '';
    /**
     * The type of the check.
     *
     * Generated from protobuf field <code>string check_type = 6;</code>
     */
    protected $check_type = '';
    /**
     * The verdict of this check.
     *
     * Generated from protobuf field <code>.google.cloud.binaryauthorization.v1beta1.ContinuousValidationEvent.ContinuousValidationPodEvent.ImageDetails.CheckResult.CheckVerdict verdict = 7;</code>
     */
    protected $verdict = 0;
    /**
     * User-friendly explanation of this check result.
     *
     * Generated from protobuf field <code>string explanation = 8;</code>
     */
    protected $explanation = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $check_set_index
     *           The index of the check set.
     *     @type string $check_set_name
     *           The name of the check set.
     *     @type \Google\Cloud\BinaryAuthorization\V1beta1\ContinuousValidationEvent\ContinuousValidationPodEvent\ImageDetails\CheckResult\CheckSetScope $check_set_scope
     *           The scope of the check set.
     *     @type string $check_index
     *           The index of the check.
     *     @type string $check_name
     *           The name of the check.
     *     @type string $check_type
     *           The type of the check.
     *     @type int $verdict
     *           The verdict of this check.
     *     @type string $explanation
     *           User-friendly explanation of this check result.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Binaryauthorization\V1Beta1\ContinuousValidationLogging::initOnce();
        parent::__construct($data);
    }

    /**
     * The index of the check set.
     *
     * Generated from protobuf field <code>string check_set_index = 1;</code>
     * @return string
     */
    public function getCheckSetIndex()
    {
        return $this->check_set_index;
    }

    /**
     * The index of the check set.
     *
     * Generated from protobuf field <code>string check_set_index = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setCheckSetIndex($var)
    {
        GPBUtil::checkString($var, True);
        $this->check_set_index = $var;

        return $this;
    }

    /**
     * The name of the check set.
     *
     * Generated from protobuf field <code>string check_set_name = 2;</code>
     * @return string
     */
    public function getCheckSetName()
    {
        return $this->check_set_name;
    }

    /**
     * The name of the check set.
     *
     * Generated from protobuf field <code>string check_set_name = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setCheckSetName($var)
    {
        GPBUtil::checkString($var, True);
        $this->check_set_name = $var;

        return $this;
    }

    /**
     * The scope of the check set.
     *
     * Generated from protobuf field <code>.google.cloud.binaryauthorization.v1beta1.ContinuousValidationEvent.ContinuousValidationPodEvent.ImageDetails.CheckResult.CheckSetScope check_set_scope = 3;</code>
     * @return \Google\Cloud\BinaryAuthorization\V1beta1\ContinuousValidationEvent\ContinuousValidationPodEvent\ImageDetails\CheckResult\CheckSetScope|null
     */
    public function getCheckSetScope()
    {
        return $this->check_set_scope;
    }

    public function hasCheckSetScope()
    {
        return isset($this->check_set_scope);
    }

    public function clearCheckSetScope()
    {
        unset($this->check_set_scope);
    }

    /**
     * The scope of the check set.
     *
     * Generated from protobuf field <code>.google.cloud.binaryauthorization.v1beta1.ContinuousValidationEvent.ContinuousValidationPodEvent.ImageDetails.CheckResult.CheckSetScope check_set_scope = 3;</code>
     * @param \Google\Cloud\BinaryAuthorization\V1beta1\ContinuousValidationEvent\ContinuousValidationPodEvent\ImageDetails\CheckResult\CheckSetScope $var
     * @return $this
     */
    public function setCheckSetScope($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\BinaryAuthorization\V1beta1\ContinuousValidationEvent\ContinuousValidationPodEvent\ImageDetails\CheckResult\CheckSetScope::class);
        $this->check_set_scope = $var;

        return $this;
    }

    /**
     * The index of the check.
     *
     * Generated from protobuf field <code>string check_index = 4;</code>
     * @return string
     */
    public function getCheckIndex()
    {
        return $this->check_index;
    }

    /**
     * The index of the check.
     *
     * Generated from protobuf field <code>string check_index = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setCheckIndex($var)
    {
        GPBUtil::checkString($var, True);
        $this->check_index = $var;

        return $this;
    }

    /**
     * The name of the check.
     *
     * Generated from protobuf field <code>string check_name = 5;</code>
     * @return string
     */
    public function getCheckName()
    {
        return $this->check_name;
    }

    /**
     * The name of the check.
     *
     * Generated from protobuf field <code>string check_name = 5;</code>
     * @param string $var
     * @return $this
     */
    public function setCheckName($var)
    {
        GPBUtil::checkString($var, True);
        $this->check_name = $var;

        return $this;
    }

    /**
     * The type of the check.
     *
     * Generated from protobuf field <code>string check_type = 6;</code>
     * @return string
     */
    public function getCheckType()
    {
        return $this->check_type;
    }

    /**
     * The type of the check.
     *
     * Generated from protobuf field <code>string check_type = 6;</code>
     * @param string $var
     * @return $this
     */
    public function setCheckType($var)
    {
        GPBUtil::checkString($var, True);
        $this->check_type = $var;

        return $this;
    }

    /**
     * The verdict of this check.
     *
     * Generated from protobuf field <code>.google.cloud.binaryauthorization.v1beta1.ContinuousValidationEvent.ContinuousValidationPodEvent.ImageDetails.CheckResult.CheckVerdict verdict = 7;</code>
     * @return int
     */
    public function getVerdict()
    {
        return $this->verdict;
    }

    /**
     * The verdict of this check.
     *
     * Generated from protobuf field <code>.google.cloud.binaryauthorization.v1beta1.ContinuousValidationEvent.ContinuousValidationPodEvent.ImageDetails.CheckResult.CheckVerdict verdict = 7;</code>
     * @param int $var
     * @return $this
     */
    public function setVerdict($var)
    {
        GPBUtil::checkEnum($var, \Google\Cloud\BinaryAuthorization\V1beta1\ContinuousValidationEvent\ContinuousValidationPodEvent\ImageDetails\CheckResult\CheckVerdict::class);
        $this->verdict = $var;

        return $this;
    }

    /**
     * User-friendly explanation of this check result.
     *
     * Generated from protobuf field <code>string explanation = 8;</code>
     * @return string
     */
    public function getExplanation()
    {
        return $this->explanation;
    }

    /**
     * User-friendly explanation of this check result.
     *
     * Generated from protobuf field <code>string explanation = 8;</code>
     * @param string $var
     * @return $this
     */
    public function setExplanation($var)
    {
        GPBUtil::checkString($var, True);
        $this->explanation = $var;

        return $this;
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(CheckResult::class, \Google\Cloud\BinaryAuthorization\V1beta1\ContinuousValidationEvent_ContinuousValidationPodEvent_ImageDetails_CheckResult::class);
