<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/devtools/cloudbuild/v1/cloudbuild.proto

namespace Google\Cloud\Build\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Pairs a set of secret environment variables containing encrypted
 * values with the Cloud KMS key to use to decrypt the value.
 * Note: Use `kmsKeyName` with  `available_secrets` instead of using
 * `kmsKeyName` with `secret`. For instructions see:
 * https://cloud.google.com/cloud-build/docs/securing-builds/use-encrypted-credentials.
 *
 * Generated from protobuf message <code>google.devtools.cloudbuild.v1.Secret</code>
 */
class Secret extends \Google\Protobuf\Internal\Message
{
    /**
     * Cloud KMS key name to use to decrypt these envs.
     *
     * Generated from protobuf field <code>string kms_key_name = 1;</code>
     */
    protected $kms_key_name = '';
    /**
     * Map of environment variable name to its encrypted value.
     * Secret environment variables must be unique across all of a build's
     * secrets, and must be used by at least one build step. Values can be at most
     * 64 KB in size. There can be at most 100 secret values across all of a
     * build's secrets.
     *
     * Generated from protobuf field <code>map<string, bytes> secret_env = 3;</code>
     */
    private $secret_env;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $kms_key_name
     *           Cloud KMS key name to use to decrypt these envs.
     *     @type array|\Google\Protobuf\Internal\MapField $secret_env
     *           Map of environment variable name to its encrypted value.
     *           Secret environment variables must be unique across all of a build's
     *           secrets, and must be used by at least one build step. Values can be at most
     *           64 KB in size. There can be at most 100 secret values across all of a
     *           build's secrets.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Devtools\Cloudbuild\V1\Cloudbuild::initOnce();
        parent::__construct($data);
    }

    /**
     * Cloud KMS key name to use to decrypt these envs.
     *
     * Generated from protobuf field <code>string kms_key_name = 1;</code>
     * @return string
     */
    public function getKmsKeyName()
    {
        return $this->kms_key_name;
    }

    /**
     * Cloud KMS key name to use to decrypt these envs.
     *
     * Generated from protobuf field <code>string kms_key_name = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setKmsKeyName($var)
    {
        GPBUtil::checkString($var, True);
        $this->kms_key_name = $var;

        return $this;
    }

    /**
     * Map of environment variable name to its encrypted value.
     * Secret environment variables must be unique across all of a build's
     * secrets, and must be used by at least one build step. Values can be at most
     * 64 KB in size. There can be at most 100 secret values across all of a
     * build's secrets.
     *
     * Generated from protobuf field <code>map<string, bytes> secret_env = 3;</code>
     * @return \Google\Protobuf\Internal\MapField
     */
    public function getSecretEnv()
    {
        return $this->secret_env;
    }

    /**
     * Map of environment variable name to its encrypted value.
     * Secret environment variables must be unique across all of a build's
     * secrets, and must be used by at least one build step. Values can be at most
     * 64 KB in size. There can be at most 100 secret values across all of a
     * build's secrets.
     *
     * Generated from protobuf field <code>map<string, bytes> secret_env = 3;</code>
     * @param array|\Google\Protobuf\Internal\MapField $var
     * @return $this
     */
    public function setSecretEnv($var)
    {
        $arr = GPBUtil::checkMapField($var, \Google\Protobuf\Internal\GPBType::STRING, \Google\Protobuf\Internal\GPBType::BYTES);
        $this->secret_env = $arr;

        return $this;
    }

}
