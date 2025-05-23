<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/recaptchaenterprise/v1/recaptchaenterprise.proto

namespace Google\Cloud\RecaptchaEnterprise\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Information about account verification, used for identity verification.
 *
 * Generated from protobuf message <code>google.cloud.recaptchaenterprise.v1.AccountVerificationInfo</code>
 */
class AccountVerificationInfo extends \Google\Protobuf\Internal\Message
{
    /**
     * Optional. Endpoints that can be used for identity verification.
     *
     * Generated from protobuf field <code>repeated .google.cloud.recaptchaenterprise.v1.EndpointVerificationInfo endpoints = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    private $endpoints;
    /**
     * Optional. Language code preference for the verification message, set as a
     * IETF BCP 47 language code.
     *
     * Generated from protobuf field <code>string language_code = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $language_code = '';
    /**
     * Output only. Result of the latest account verification challenge.
     *
     * Generated from protobuf field <code>.google.cloud.recaptchaenterprise.v1.AccountVerificationInfo.Result latest_verification_result = 7 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $latest_verification_result = 0;
    /**
     * Username of the account that is being verified. Deprecated. Customers
     * should now provide the `account_id` field in `event.user_info`.
     *
     * Generated from protobuf field <code>string username = 2 [deprecated = true];</code>
     * @deprecated
     */
    protected $username = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<\Google\Cloud\RecaptchaEnterprise\V1\EndpointVerificationInfo>|\Google\Protobuf\Internal\RepeatedField $endpoints
     *           Optional. Endpoints that can be used for identity verification.
     *     @type string $language_code
     *           Optional. Language code preference for the verification message, set as a
     *           IETF BCP 47 language code.
     *     @type int $latest_verification_result
     *           Output only. Result of the latest account verification challenge.
     *     @type string $username
     *           Username of the account that is being verified. Deprecated. Customers
     *           should now provide the `account_id` field in `event.user_info`.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Recaptchaenterprise\V1\Recaptchaenterprise::initOnce();
        parent::__construct($data);
    }

    /**
     * Optional. Endpoints that can be used for identity verification.
     *
     * Generated from protobuf field <code>repeated .google.cloud.recaptchaenterprise.v1.EndpointVerificationInfo endpoints = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getEndpoints()
    {
        return $this->endpoints;
    }

    /**
     * Optional. Endpoints that can be used for identity verification.
     *
     * Generated from protobuf field <code>repeated .google.cloud.recaptchaenterprise.v1.EndpointVerificationInfo endpoints = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param array<\Google\Cloud\RecaptchaEnterprise\V1\EndpointVerificationInfo>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setEndpoints($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\RecaptchaEnterprise\V1\EndpointVerificationInfo::class);
        $this->endpoints = $arr;

        return $this;
    }

    /**
     * Optional. Language code preference for the verification message, set as a
     * IETF BCP 47 language code.
     *
     * Generated from protobuf field <code>string language_code = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getLanguageCode()
    {
        return $this->language_code;
    }

    /**
     * Optional. Language code preference for the verification message, set as a
     * IETF BCP 47 language code.
     *
     * Generated from protobuf field <code>string language_code = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setLanguageCode($var)
    {
        GPBUtil::checkString($var, True);
        $this->language_code = $var;

        return $this;
    }

    /**
     * Output only. Result of the latest account verification challenge.
     *
     * Generated from protobuf field <code>.google.cloud.recaptchaenterprise.v1.AccountVerificationInfo.Result latest_verification_result = 7 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return int
     */
    public function getLatestVerificationResult()
    {
        return $this->latest_verification_result;
    }

    /**
     * Output only. Result of the latest account verification challenge.
     *
     * Generated from protobuf field <code>.google.cloud.recaptchaenterprise.v1.AccountVerificationInfo.Result latest_verification_result = 7 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param int $var
     * @return $this
     */
    public function setLatestVerificationResult($var)
    {
        GPBUtil::checkEnum($var, \Google\Cloud\RecaptchaEnterprise\V1\AccountVerificationInfo\Result::class);
        $this->latest_verification_result = $var;

        return $this;
    }

    /**
     * Username of the account that is being verified. Deprecated. Customers
     * should now provide the `account_id` field in `event.user_info`.
     *
     * Generated from protobuf field <code>string username = 2 [deprecated = true];</code>
     * @return string
     * @deprecated
     */
    public function getUsername()
    {
        if ($this->username !== '') {
            @trigger_error('username is deprecated.', E_USER_DEPRECATED);
        }
        return $this->username;
    }

    /**
     * Username of the account that is being verified. Deprecated. Customers
     * should now provide the `account_id` field in `event.user_info`.
     *
     * Generated from protobuf field <code>string username = 2 [deprecated = true];</code>
     * @param string $var
     * @return $this
     * @deprecated
     */
    public function setUsername($var)
    {
        @trigger_error('username is deprecated.', E_USER_DEPRECATED);
        GPBUtil::checkString($var, True);
        $this->username = $var;

        return $this;
    }

}

