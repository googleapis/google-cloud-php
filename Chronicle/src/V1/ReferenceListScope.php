<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/chronicle/v1/reference_list.proto

namespace Google\Cloud\Chronicle\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * ReferenceListScope specifies the list of scope names of the reference list.
 *
 * Generated from protobuf message <code>google.cloud.chronicle.v1.ReferenceListScope</code>
 */
class ReferenceListScope extends \Google\Protobuf\Internal\Message
{
    /**
     * Optional. The list of scope names of the reference list. The scope names
     * should be full resource names and should be of the format:
     * `projects/{project}/locations/{location}/instances/{instance}/dataAccessScopes/{scope_name}`.
     *
     * Generated from protobuf field <code>repeated string scope_names = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    private $scope_names;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<string>|\Google\Protobuf\Internal\RepeatedField $scope_names
     *           Optional. The list of scope names of the reference list. The scope names
     *           should be full resource names and should be of the format:
     *           `projects/{project}/locations/{location}/instances/{instance}/dataAccessScopes/{scope_name}`.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Chronicle\V1\ReferenceList::initOnce();
        parent::__construct($data);
    }

    /**
     * Optional. The list of scope names of the reference list. The scope names
     * should be full resource names and should be of the format:
     * `projects/{project}/locations/{location}/instances/{instance}/dataAccessScopes/{scope_name}`.
     *
     * Generated from protobuf field <code>repeated string scope_names = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getScopeNames()
    {
        return $this->scope_names;
    }

    /**
     * Optional. The list of scope names of the reference list. The scope names
     * should be full resource names and should be of the format:
     * `projects/{project}/locations/{location}/instances/{instance}/dataAccessScopes/{scope_name}`.
     *
     * Generated from protobuf field <code>repeated string scope_names = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param array<string>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setScopeNames($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->scope_names = $arr;

        return $this;
    }

}

