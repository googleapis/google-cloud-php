<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/admin/v1alpha/analytics_admin.proto

namespace Google\Analytics\Admin\V1alpha;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request message for SubmitUserDeletion RPC.
 *
 * Generated from protobuf message <code>google.analytics.admin.v1alpha.SubmitUserDeletionRequest</code>
 */
class SubmitUserDeletionRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The name of the property to submit user deletion for.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $name = '';
    protected $user;

    /**
     * @param string $name Required. The name of the property to submit user deletion for. Please see
     *                     {@see AnalyticsAdminServiceClient::propertyName()} for help formatting this field.
     *
     * @return \Google\Analytics\Admin\V1alpha\SubmitUserDeletionRequest
     *
     * @experimental
     */
    public static function build(string $name): self
    {
        return (new self())
            ->setName($name);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $user_id
     *           Google Analytics [user
     *           ID](https://firebase.google.com/docs/analytics/userid).
     *     @type string $client_id
     *           Google Analytics [client
     *           ID](https://support.google.com/analytics/answer/11593727).
     *     @type string $app_instance_id
     *           Firebase [application instance
     *           ID](https://firebase.google.com/docs/reference/android/com/google/firebase/analytics/FirebaseAnalytics.html#getAppInstanceId).
     *     @type string $user_provided_data
     *           The un-hashed, unencrypted, [user-provided
     *           data](https://support.google.com/analytics/answer/14077171).
     *     @type string $name
     *           Required. The name of the property to submit user deletion for.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Analytics\Admin\V1Alpha\AnalyticsAdmin::initOnce();
        parent::__construct($data);
    }

    /**
     * Google Analytics [user
     * ID](https://firebase.google.com/docs/analytics/userid).
     *
     * Generated from protobuf field <code>string user_id = 2;</code>
     * @return string
     */
    public function getUserId()
    {
        return $this->readOneof(2);
    }

    public function hasUserId()
    {
        return $this->hasOneof(2);
    }

    /**
     * Google Analytics [user
     * ID](https://firebase.google.com/docs/analytics/userid).
     *
     * Generated from protobuf field <code>string user_id = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setUserId($var)
    {
        GPBUtil::checkString($var, True);
        $this->writeOneof(2, $var);

        return $this;
    }

    /**
     * Google Analytics [client
     * ID](https://support.google.com/analytics/answer/11593727).
     *
     * Generated from protobuf field <code>string client_id = 3;</code>
     * @return string
     */
    public function getClientId()
    {
        return $this->readOneof(3);
    }

    public function hasClientId()
    {
        return $this->hasOneof(3);
    }

    /**
     * Google Analytics [client
     * ID](https://support.google.com/analytics/answer/11593727).
     *
     * Generated from protobuf field <code>string client_id = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setClientId($var)
    {
        GPBUtil::checkString($var, True);
        $this->writeOneof(3, $var);

        return $this;
    }

    /**
     * Firebase [application instance
     * ID](https://firebase.google.com/docs/reference/android/com/google/firebase/analytics/FirebaseAnalytics.html#getAppInstanceId).
     *
     * Generated from protobuf field <code>string app_instance_id = 4;</code>
     * @return string
     */
    public function getAppInstanceId()
    {
        return $this->readOneof(4);
    }

    public function hasAppInstanceId()
    {
        return $this->hasOneof(4);
    }

    /**
     * Firebase [application instance
     * ID](https://firebase.google.com/docs/reference/android/com/google/firebase/analytics/FirebaseAnalytics.html#getAppInstanceId).
     *
     * Generated from protobuf field <code>string app_instance_id = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setAppInstanceId($var)
    {
        GPBUtil::checkString($var, True);
        $this->writeOneof(4, $var);

        return $this;
    }

    /**
     * The un-hashed, unencrypted, [user-provided
     * data](https://support.google.com/analytics/answer/14077171).
     *
     * Generated from protobuf field <code>string user_provided_data = 5;</code>
     * @return string
     */
    public function getUserProvidedData()
    {
        return $this->readOneof(5);
    }

    public function hasUserProvidedData()
    {
        return $this->hasOneof(5);
    }

    /**
     * The un-hashed, unencrypted, [user-provided
     * data](https://support.google.com/analytics/answer/14077171).
     *
     * Generated from protobuf field <code>string user_provided_data = 5;</code>
     * @param string $var
     * @return $this
     */
    public function setUserProvidedData($var)
    {
        GPBUtil::checkString($var, True);
        $this->writeOneof(5, $var);

        return $this;
    }

    /**
     * Required. The name of the property to submit user deletion for.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Required. The name of the property to submit user deletion for.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;

        return $this;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->whichOneof("user");
    }

}

