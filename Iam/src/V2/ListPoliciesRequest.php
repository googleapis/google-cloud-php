<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/iam/v2/policy.proto

namespace Google\Cloud\Iam\V2;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request message for `ListPolicies`.
 *
 * Generated from protobuf message <code>google.iam.v2.ListPoliciesRequest</code>
 */
class ListPoliciesRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The resource that the policy is attached to, along with the kind of policy
     * to list. Format:
     * `policies/{attachment_point}/denypolicies`
     * The attachment point is identified by its URL-encoded full resource name,
     * which means that the forward-slash character, `/`, must be written as
     * `%2F`. For example,
     * `policies/cloudresourcemanager.googleapis.com%2Fprojects%2Fmy-project/denypolicies`.
     * For organizations and folders, use the numeric ID in the full resource
     * name. For projects, you can use the alphanumeric or the numeric ID.
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $parent = '';
    /**
     * The maximum number of policies to return. IAM ignores this value and uses
     * the value 1000.
     *
     * Generated from protobuf field <code>int32 page_size = 2;</code>
     */
    protected $page_size = 0;
    /**
     * A page token received in a [ListPoliciesResponse][google.iam.v2.ListPoliciesResponse]. Provide this token to
     * retrieve the next page.
     *
     * Generated from protobuf field <code>string page_token = 3;</code>
     */
    protected $page_token = '';

    /**
     * @param string $parent Required. The resource that the policy is attached to, along with the kind of policy
     *                       to list. Format:
     *                       `policies/{attachment_point}/denypolicies`
     *
     *
     *                       The attachment point is identified by its URL-encoded full resource name,
     *                       which means that the forward-slash character, `/`, must be written as
     *                       `%2F`. For example,
     *                       `policies/cloudresourcemanager.googleapis.com%2Fprojects%2Fmy-project/denypolicies`.
     *
     *                       For organizations and folders, use the numeric ID in the full resource
     *                       name. For projects, you can use the alphanumeric or the numeric ID.
     *
     * @return \Google\Cloud\Iam\V2\ListPoliciesRequest
     *
     * @experimental
     */
    public static function build(string $parent): self
    {
        return (new self())
            ->setParent($parent);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $parent
     *           Required. The resource that the policy is attached to, along with the kind of policy
     *           to list. Format:
     *           `policies/{attachment_point}/denypolicies`
     *           The attachment point is identified by its URL-encoded full resource name,
     *           which means that the forward-slash character, `/`, must be written as
     *           `%2F`. For example,
     *           `policies/cloudresourcemanager.googleapis.com%2Fprojects%2Fmy-project/denypolicies`.
     *           For organizations and folders, use the numeric ID in the full resource
     *           name. For projects, you can use the alphanumeric or the numeric ID.
     *     @type int $page_size
     *           The maximum number of policies to return. IAM ignores this value and uses
     *           the value 1000.
     *     @type string $page_token
     *           A page token received in a [ListPoliciesResponse][google.iam.v2.ListPoliciesResponse]. Provide this token to
     *           retrieve the next page.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Iam\V2\Policy::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The resource that the policy is attached to, along with the kind of policy
     * to list. Format:
     * `policies/{attachment_point}/denypolicies`
     * The attachment point is identified by its URL-encoded full resource name,
     * which means that the forward-slash character, `/`, must be written as
     * `%2F`. For example,
     * `policies/cloudresourcemanager.googleapis.com%2Fprojects%2Fmy-project/denypolicies`.
     * For organizations and folders, use the numeric ID in the full resource
     * name. For projects, you can use the alphanumeric or the numeric ID.
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Required. The resource that the policy is attached to, along with the kind of policy
     * to list. Format:
     * `policies/{attachment_point}/denypolicies`
     * The attachment point is identified by its URL-encoded full resource name,
     * which means that the forward-slash character, `/`, must be written as
     * `%2F`. For example,
     * `policies/cloudresourcemanager.googleapis.com%2Fprojects%2Fmy-project/denypolicies`.
     * For organizations and folders, use the numeric ID in the full resource
     * name. For projects, you can use the alphanumeric or the numeric ID.
     *
     * Generated from protobuf field <code>string parent = 1 [(.google.api.field_behavior) = REQUIRED];</code>
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
     * The maximum number of policies to return. IAM ignores this value and uses
     * the value 1000.
     *
     * Generated from protobuf field <code>int32 page_size = 2;</code>
     * @return int
     */
    public function getPageSize()
    {
        return $this->page_size;
    }

    /**
     * The maximum number of policies to return. IAM ignores this value and uses
     * the value 1000.
     *
     * Generated from protobuf field <code>int32 page_size = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setPageSize($var)
    {
        GPBUtil::checkInt32($var);
        $this->page_size = $var;

        return $this;
    }

    /**
     * A page token received in a [ListPoliciesResponse][google.iam.v2.ListPoliciesResponse]. Provide this token to
     * retrieve the next page.
     *
     * Generated from protobuf field <code>string page_token = 3;</code>
     * @return string
     */
    public function getPageToken()
    {
        return $this->page_token;
    }

    /**
     * A page token received in a [ListPoliciesResponse][google.iam.v2.ListPoliciesResponse]. Provide this token to
     * retrieve the next page.
     *
     * Generated from protobuf field <code>string page_token = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setPageToken($var)
    {
        GPBUtil::checkString($var, True);
        $this->page_token = $var;

        return $this;
    }

}

