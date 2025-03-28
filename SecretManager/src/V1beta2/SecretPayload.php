<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/secretmanager/v1beta2/resources.proto

namespace Google\Cloud\SecretManager\V1beta2;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A secret payload resource in the Secret Manager API. This contains the
 * sensitive secret payload that is associated with a
 * [SecretVersion][google.cloud.secretmanager.v1beta2.SecretVersion].
 *
 * Generated from protobuf message <code>google.cloud.secretmanager.v1beta2.SecretPayload</code>
 */
class SecretPayload extends \Google\Protobuf\Internal\Message
{
    /**
     * The secret data. Must be no larger than 64KiB.
     *
     * Generated from protobuf field <code>bytes data = 1;</code>
     */
    protected $data = '';
    /**
     * Optional. If specified,
     * [SecretManagerService][google.cloud.secretmanager.v1beta2.SecretManagerService]
     * will verify the integrity of the received
     * [data][google.cloud.secretmanager.v1beta2.SecretPayload.data] on
     * [SecretManagerService.AddSecretVersion][google.cloud.secretmanager.v1beta2.SecretManagerService.AddSecretVersion]
     * calls using the crc32c checksum and store it to include in future
     * [SecretManagerService.AccessSecretVersion][google.cloud.secretmanager.v1beta2.SecretManagerService.AccessSecretVersion]
     * responses. If a checksum is not provided in the
     * [SecretManagerService.AddSecretVersion][google.cloud.secretmanager.v1beta2.SecretManagerService.AddSecretVersion]
     * request, the
     * [SecretManagerService][google.cloud.secretmanager.v1beta2.SecretManagerService]
     * will generate and store one for you.
     * The CRC32C value is encoded as a Int64 for compatibility, and can be
     * safely downconverted to uint32 in languages that support this type.
     * https://cloud.google.com/apis/design/design_patterns#integer_types
     *
     * Generated from protobuf field <code>optional int64 data_crc32c = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $data_crc32c = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $data
     *           The secret data. Must be no larger than 64KiB.
     *     @type int|string $data_crc32c
     *           Optional. If specified,
     *           [SecretManagerService][google.cloud.secretmanager.v1beta2.SecretManagerService]
     *           will verify the integrity of the received
     *           [data][google.cloud.secretmanager.v1beta2.SecretPayload.data] on
     *           [SecretManagerService.AddSecretVersion][google.cloud.secretmanager.v1beta2.SecretManagerService.AddSecretVersion]
     *           calls using the crc32c checksum and store it to include in future
     *           [SecretManagerService.AccessSecretVersion][google.cloud.secretmanager.v1beta2.SecretManagerService.AccessSecretVersion]
     *           responses. If a checksum is not provided in the
     *           [SecretManagerService.AddSecretVersion][google.cloud.secretmanager.v1beta2.SecretManagerService.AddSecretVersion]
     *           request, the
     *           [SecretManagerService][google.cloud.secretmanager.v1beta2.SecretManagerService]
     *           will generate and store one for you.
     *           The CRC32C value is encoded as a Int64 for compatibility, and can be
     *           safely downconverted to uint32 in languages that support this type.
     *           https://cloud.google.com/apis/design/design_patterns#integer_types
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Secretmanager\V1Beta2\Resources::initOnce();
        parent::__construct($data);
    }

    /**
     * The secret data. Must be no larger than 64KiB.
     *
     * Generated from protobuf field <code>bytes data = 1;</code>
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * The secret data. Must be no larger than 64KiB.
     *
     * Generated from protobuf field <code>bytes data = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setData($var)
    {
        GPBUtil::checkString($var, False);
        $this->data = $var;

        return $this;
    }

    /**
     * Optional. If specified,
     * [SecretManagerService][google.cloud.secretmanager.v1beta2.SecretManagerService]
     * will verify the integrity of the received
     * [data][google.cloud.secretmanager.v1beta2.SecretPayload.data] on
     * [SecretManagerService.AddSecretVersion][google.cloud.secretmanager.v1beta2.SecretManagerService.AddSecretVersion]
     * calls using the crc32c checksum and store it to include in future
     * [SecretManagerService.AccessSecretVersion][google.cloud.secretmanager.v1beta2.SecretManagerService.AccessSecretVersion]
     * responses. If a checksum is not provided in the
     * [SecretManagerService.AddSecretVersion][google.cloud.secretmanager.v1beta2.SecretManagerService.AddSecretVersion]
     * request, the
     * [SecretManagerService][google.cloud.secretmanager.v1beta2.SecretManagerService]
     * will generate and store one for you.
     * The CRC32C value is encoded as a Int64 for compatibility, and can be
     * safely downconverted to uint32 in languages that support this type.
     * https://cloud.google.com/apis/design/design_patterns#integer_types
     *
     * Generated from protobuf field <code>optional int64 data_crc32c = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return int|string
     */
    public function getDataCrc32C()
    {
        return isset($this->data_crc32c) ? $this->data_crc32c : 0;
    }

    public function hasDataCrc32C()
    {
        return isset($this->data_crc32c);
    }

    public function clearDataCrc32C()
    {
        unset($this->data_crc32c);
    }

    /**
     * Optional. If specified,
     * [SecretManagerService][google.cloud.secretmanager.v1beta2.SecretManagerService]
     * will verify the integrity of the received
     * [data][google.cloud.secretmanager.v1beta2.SecretPayload.data] on
     * [SecretManagerService.AddSecretVersion][google.cloud.secretmanager.v1beta2.SecretManagerService.AddSecretVersion]
     * calls using the crc32c checksum and store it to include in future
     * [SecretManagerService.AccessSecretVersion][google.cloud.secretmanager.v1beta2.SecretManagerService.AccessSecretVersion]
     * responses. If a checksum is not provided in the
     * [SecretManagerService.AddSecretVersion][google.cloud.secretmanager.v1beta2.SecretManagerService.AddSecretVersion]
     * request, the
     * [SecretManagerService][google.cloud.secretmanager.v1beta2.SecretManagerService]
     * will generate and store one for you.
     * The CRC32C value is encoded as a Int64 for compatibility, and can be
     * safely downconverted to uint32 in languages that support this type.
     * https://cloud.google.com/apis/design/design_patterns#integer_types
     *
     * Generated from protobuf field <code>optional int64 data_crc32c = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param int|string $var
     * @return $this
     */
    public function setDataCrc32C($var)
    {
        GPBUtil::checkInt64($var);
        $this->data_crc32c = $var;

        return $this;
    }

}

