<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/iap/v1/service.proto

namespace Google\Cloud\Iap\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The OAuth 2.0 Settings
 *
 * Generated from protobuf message <code>google.cloud.iap.v1.OAuth2</code>
 */
class OAuth2 extends \Google\Protobuf\Internal\Message
{
    /**
     * The OAuth 2.0 client ID registered in the workforce identity federation
     * OAuth 2.0 Server.
     *
     * Generated from protobuf field <code>string client_id = 1;</code>
     */
    protected $client_id = '';
    /**
     * Input only. The OAuth 2.0 client secret created while registering the
     * client ID.
     *
     * Generated from protobuf field <code>string client_secret = 2 [(.google.api.field_behavior) = INPUT_ONLY];</code>
     */
    protected $client_secret = '';
    /**
     * Output only. SHA256 hash value for the client secret. This field is
     * returned by IAP when the settings are retrieved.
     *
     * Generated from protobuf field <code>string client_secret_sha256 = 3 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $client_secret_sha256 = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $client_id
     *           The OAuth 2.0 client ID registered in the workforce identity federation
     *           OAuth 2.0 Server.
     *     @type string $client_secret
     *           Input only. The OAuth 2.0 client secret created while registering the
     *           client ID.
     *     @type string $client_secret_sha256
     *           Output only. SHA256 hash value for the client secret. This field is
     *           returned by IAP when the settings are retrieved.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Iap\V1\Service::initOnce();
        parent::__construct($data);
    }

    /**
     * The OAuth 2.0 client ID registered in the workforce identity federation
     * OAuth 2.0 Server.
     *
     * Generated from protobuf field <code>string client_id = 1;</code>
     * @return string
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * The OAuth 2.0 client ID registered in the workforce identity federation
     * OAuth 2.0 Server.
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
     * Input only. The OAuth 2.0 client secret created while registering the
     * client ID.
     *
     * Generated from protobuf field <code>string client_secret = 2 [(.google.api.field_behavior) = INPUT_ONLY];</code>
     * @return string
     */
    public function getClientSecret()
    {
        return $this->client_secret;
    }

    /**
     * Input only. The OAuth 2.0 client secret created while registering the
     * client ID.
     *
     * Generated from protobuf field <code>string client_secret = 2 [(.google.api.field_behavior) = INPUT_ONLY];</code>
     * @param string $var
     * @return $this
     */
    public function setClientSecret($var)
    {
        GPBUtil::checkString($var, True);
        $this->client_secret = $var;

        return $this;
    }

    /**
     * Output only. SHA256 hash value for the client secret. This field is
     * returned by IAP when the settings are retrieved.
     *
     * Generated from protobuf field <code>string client_secret_sha256 = 3 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return string
     */
    public function getClientSecretSha256()
    {
        return $this->client_secret_sha256;
    }

    /**
     * Output only. SHA256 hash value for the client secret. This field is
     * returned by IAP when the settings are retrieved.
     *
     * Generated from protobuf field <code>string client_secret_sha256 = 3 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param string $var
     * @return $this
     */
    public function setClientSecretSha256($var)
    {
        GPBUtil::checkString($var, True);
        $this->client_secret_sha256 = $var;

        return $this;
    }

}

