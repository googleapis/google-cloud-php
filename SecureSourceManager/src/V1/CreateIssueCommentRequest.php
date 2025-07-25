<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/securesourcemanager/v1/secure_source_manager.proto

namespace Google\Cloud\SecureSourceManager\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The request to create an issue comment.
 *
 * Generated from protobuf message <code>google.cloud.securesourcemanager.v1.CreateIssueCommentRequest</code>
 */
class CreateIssueCommentRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The issue in which to create the issue comment. Format:
     * `projects/{project_number}/locations/{location_id}/repositories/{repository_id}/issues/{issue_id}`
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $parent = '';
    /**
     * Required. The issue comment to create.
     *
     * Generated from protobuf field <code>.google.cloud.securesourcemanager.v1.IssueComment issue_comment = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $issue_comment = null;

    /**
     * @param string                                            $parent       Required. The issue in which to create the issue comment. Format:
     *                                                                        `projects/{project_number}/locations/{location_id}/repositories/{repository_id}/issues/{issue_id}`
     *                                                                        Please see {@see SecureSourceManagerClient::issueName()} for help formatting this field.
     * @param \Google\Cloud\SecureSourceManager\V1\IssueComment $issueComment Required. The issue comment to create.
     *
     * @return \Google\Cloud\SecureSourceManager\V1\CreateIssueCommentRequest
     *
     * @experimental
     */
    public static function build(string $parent, \Google\Cloud\SecureSourceManager\V1\IssueComment $issueComment): self
    {
        return (new self())
            ->setParent($parent)
            ->setIssueComment($issueComment);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $parent
     *           Required. The issue in which to create the issue comment. Format:
     *           `projects/{project_number}/locations/{location_id}/repositories/{repository_id}/issues/{issue_id}`
     *     @type \Google\Cloud\SecureSourceManager\V1\IssueComment $issue_comment
     *           Required. The issue comment to create.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Securesourcemanager\V1\SecureSourceManager::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The issue in which to create the issue comment. Format:
     * `projects/{project_number}/locations/{location_id}/repositories/{repository_id}/issues/{issue_id}`
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Required. The issue in which to create the issue comment. Format:
     * `projects/{project_number}/locations/{location_id}/repositories/{repository_id}/issues/{issue_id}`
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setParent($var)
    {
        GPBUtil::checkString($var, True);
        $this->parent = $var;

        return $this;
    }

    /**
     * Required. The issue comment to create.
     *
     * Generated from protobuf field <code>.google.cloud.securesourcemanager.v1.IssueComment issue_comment = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Cloud\SecureSourceManager\V1\IssueComment|null
     */
    public function getIssueComment()
    {
        return $this->issue_comment;
    }

    public function hasIssueComment()
    {
        return isset($this->issue_comment);
    }

    public function clearIssueComment()
    {
        unset($this->issue_comment);
    }

    /**
     * Required. The issue comment to create.
     *
     * Generated from protobuf field <code>.google.cloud.securesourcemanager.v1.IssueComment issue_comment = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Cloud\SecureSourceManager\V1\IssueComment $var
     * @return $this
     */
    public function setIssueComment($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\SecureSourceManager\V1\IssueComment::class);
        $this->issue_comment = $var;

        return $this;
    }

}

