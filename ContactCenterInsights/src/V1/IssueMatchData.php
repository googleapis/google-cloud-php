<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/contactcenterinsights/v1/resources.proto

namespace Google\Cloud\ContactCenterInsights\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The data for an issue match annotation.
 *
 * Generated from protobuf message <code>google.cloud.contactcenterinsights.v1.IssueMatchData</code>
 */
class IssueMatchData extends \Google\Protobuf\Internal\Message
{
    /**
     * Information about the issue's assignment.
     *
     * Generated from protobuf field <code>.google.cloud.contactcenterinsights.v1.IssueAssignment issue_assignment = 1;</code>
     */
    protected $issue_assignment = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Cloud\ContactCenterInsights\V1\IssueAssignment $issue_assignment
     *           Information about the issue's assignment.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Contactcenterinsights\V1\Resources::initOnce();
        parent::__construct($data);
    }

    /**
     * Information about the issue's assignment.
     *
     * Generated from protobuf field <code>.google.cloud.contactcenterinsights.v1.IssueAssignment issue_assignment = 1;</code>
     * @return \Google\Cloud\ContactCenterInsights\V1\IssueAssignment|null
     */
    public function getIssueAssignment()
    {
        return $this->issue_assignment;
    }

    public function hasIssueAssignment()
    {
        return isset($this->issue_assignment);
    }

    public function clearIssueAssignment()
    {
        unset($this->issue_assignment);
    }

    /**
     * Information about the issue's assignment.
     *
     * Generated from protobuf field <code>.google.cloud.contactcenterinsights.v1.IssueAssignment issue_assignment = 1;</code>
     * @param \Google\Cloud\ContactCenterInsights\V1\IssueAssignment $var
     * @return $this
     */
    public function setIssueAssignment($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\ContactCenterInsights\V1\IssueAssignment::class);
        $this->issue_assignment = $var;

        return $this;
    }

}

