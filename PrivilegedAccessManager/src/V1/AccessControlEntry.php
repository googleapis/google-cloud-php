<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/privilegedaccessmanager/v1/privilegedaccessmanager.proto

namespace Google\Cloud\PrivilegedAccessManager\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * `AccessControlEntry` is used to control who can do some operation.
 *
 * Generated from protobuf message <code>google.cloud.privilegedaccessmanager.v1.AccessControlEntry</code>
 */
class AccessControlEntry extends \Google\Protobuf\Internal\Message
{
    /**
     * Optional. Users who are allowed for the operation. Each entry should be a
     * valid v1 IAM principal identifier. The format for these is documented at:
     * https://cloud.google.com/iam/docs/principal-identifiers#v1
     *
     * Generated from protobuf field <code>repeated string principals = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    private $principals;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<string>|\Google\Protobuf\Internal\RepeatedField $principals
     *           Optional. Users who are allowed for the operation. Each entry should be a
     *           valid v1 IAM principal identifier. The format for these is documented at:
     *           https://cloud.google.com/iam/docs/principal-identifiers#v1
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Privilegedaccessmanager\V1\Privilegedaccessmanager::initOnce();
        parent::__construct($data);
    }

    /**
     * Optional. Users who are allowed for the operation. Each entry should be a
     * valid v1 IAM principal identifier. The format for these is documented at:
     * https://cloud.google.com/iam/docs/principal-identifiers#v1
     *
     * Generated from protobuf field <code>repeated string principals = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getPrincipals()
    {
        return $this->principals;
    }

    /**
     * Optional. Users who are allowed for the operation. Each entry should be a
     * valid v1 IAM principal identifier. The format for these is documented at:
     * https://cloud.google.com/iam/docs/principal-identifiers#v1
     *
     * Generated from protobuf field <code>repeated string principals = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param array<string>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setPrincipals($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->principals = $arr;

        return $this;
    }

}

