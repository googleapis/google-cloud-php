<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/securesourcemanager/v1/secure_source_manager.proto

namespace Google\Cloud\SecureSourceManager\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * DeleteBranchRuleRequest is the request to delete a branch rule.
 *
 * Generated from protobuf message <code>google.cloud.securesourcemanager.v1.DeleteBranchRuleRequest</code>
 */
class DeleteBranchRuleRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $name = '';
    /**
     * Optional. If set to true, and the branch rule is not found, the request
     * will succeed but no action will be taken on the server.
     *
     * Generated from protobuf field <code>bool allow_missing = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $allow_missing = false;

    /**
     * @param string $name Please see {@see SecureSourceManagerClient::branchRuleName()} for help formatting this field.
     *
     * @return \Google\Cloud\SecureSourceManager\V1\DeleteBranchRuleRequest
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
     *     @type string $name
     *     @type bool $allow_missing
     *           Optional. If set to true, and the branch rule is not found, the request
     *           will succeed but no action will be taken on the server.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Securesourcemanager\V1\SecureSourceManager::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
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
     * Optional. If set to true, and the branch rule is not found, the request
     * will succeed but no action will be taken on the server.
     *
     * Generated from protobuf field <code>bool allow_missing = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return bool
     */
    public function getAllowMissing()
    {
        return $this->allow_missing;
    }

    /**
     * Optional. If set to true, and the branch rule is not found, the request
     * will succeed but no action will be taken on the server.
     *
     * Generated from protobuf field <code>bool allow_missing = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param bool $var
     * @return $this
     */
    public function setAllowMissing($var)
    {
        GPBUtil::checkBool($var);
        $this->allow_missing = $var;

        return $this;
    }

}

