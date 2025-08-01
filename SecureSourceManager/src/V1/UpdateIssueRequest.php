<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/securesourcemanager/v1/secure_source_manager.proto

namespace Google\Cloud\SecureSourceManager\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The request to update an issue.
 *
 * Generated from protobuf message <code>google.cloud.securesourcemanager.v1.UpdateIssueRequest</code>
 */
class UpdateIssueRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The issue to update.
     *
     * Generated from protobuf field <code>.google.cloud.securesourcemanager.v1.Issue issue = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $issue = null;
    /**
     * Optional. Field mask is used to specify the fields to be overwritten in the
     * issue resource by the update.
     * The fields specified in the update_mask are relative to the resource, not
     * the full request. A field will be overwritten if it is in the mask.
     * The special value "*" means full replacement.
     *
     * Generated from protobuf field <code>.google.protobuf.FieldMask update_mask = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $update_mask = null;

    /**
     * @param \Google\Cloud\SecureSourceManager\V1\Issue $issue      Required. The issue to update.
     * @param \Google\Protobuf\FieldMask                 $updateMask Optional. Field mask is used to specify the fields to be overwritten in the
     *                                                               issue resource by the update.
     *                                                               The fields specified in the update_mask are relative to the resource, not
     *                                                               the full request. A field will be overwritten if it is in the mask.
     *                                                               The special value "*" means full replacement.
     *
     * @return \Google\Cloud\SecureSourceManager\V1\UpdateIssueRequest
     *
     * @experimental
     */
    public static function build(\Google\Cloud\SecureSourceManager\V1\Issue $issue, \Google\Protobuf\FieldMask $updateMask): self
    {
        return (new self())
            ->setIssue($issue)
            ->setUpdateMask($updateMask);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Cloud\SecureSourceManager\V1\Issue $issue
     *           Required. The issue to update.
     *     @type \Google\Protobuf\FieldMask $update_mask
     *           Optional. Field mask is used to specify the fields to be overwritten in the
     *           issue resource by the update.
     *           The fields specified in the update_mask are relative to the resource, not
     *           the full request. A field will be overwritten if it is in the mask.
     *           The special value "*" means full replacement.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Securesourcemanager\V1\SecureSourceManager::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The issue to update.
     *
     * Generated from protobuf field <code>.google.cloud.securesourcemanager.v1.Issue issue = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Cloud\SecureSourceManager\V1\Issue|null
     */
    public function getIssue()
    {
        return $this->issue;
    }

    public function hasIssue()
    {
        return isset($this->issue);
    }

    public function clearIssue()
    {
        unset($this->issue);
    }

    /**
     * Required. The issue to update.
     *
     * Generated from protobuf field <code>.google.cloud.securesourcemanager.v1.Issue issue = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Cloud\SecureSourceManager\V1\Issue $var
     * @return $this
     */
    public function setIssue($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\SecureSourceManager\V1\Issue::class);
        $this->issue = $var;

        return $this;
    }

    /**
     * Optional. Field mask is used to specify the fields to be overwritten in the
     * issue resource by the update.
     * The fields specified in the update_mask are relative to the resource, not
     * the full request. A field will be overwritten if it is in the mask.
     * The special value "*" means full replacement.
     *
     * Generated from protobuf field <code>.google.protobuf.FieldMask update_mask = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Protobuf\FieldMask|null
     */
    public function getUpdateMask()
    {
        return $this->update_mask;
    }

    public function hasUpdateMask()
    {
        return isset($this->update_mask);
    }

    public function clearUpdateMask()
    {
        unset($this->update_mask);
    }

    /**
     * Optional. Field mask is used to specify the fields to be overwritten in the
     * issue resource by the update.
     * The fields specified in the update_mask are relative to the resource, not
     * the full request. A field will be overwritten if it is in the mask.
     * The special value "*" means full replacement.
     *
     * Generated from protobuf field <code>.google.protobuf.FieldMask update_mask = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param \Google\Protobuf\FieldMask $var
     * @return $this
     */
    public function setUpdateMask($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\FieldMask::class);
        $this->update_mask = $var;

        return $this;
    }

}

