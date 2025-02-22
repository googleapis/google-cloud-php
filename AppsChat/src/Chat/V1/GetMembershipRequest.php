<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/chat/v1/membership.proto

namespace Google\Apps\Chat\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request to get a membership of a space.
 *
 * Generated from protobuf message <code>google.chat.v1.GetMembershipRequest</code>
 */
class GetMembershipRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. Resource name of the membership to retrieve.
     * To get the app's own membership [by using user
     * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-user),
     * you can optionally use `spaces/{space}/members/app`.
     * Format: `spaces/{space}/members/{member}` or `spaces/{space}/members/app`
     * You can use the user's email as an alias for `{member}`. For example,
     * `spaces/{space}/members/example&#64;gmail.com` where `example&#64;gmail.com` is the
     * email of the Google Chat user.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $name = '';
    /**
     * Optional. When `true`, the method runs using the user's Google Workspace
     * administrator privileges.
     * The calling user must be a Google Workspace administrator with the
     * [manage chat and spaces conversations
     * privilege](https://support.google.com/a/answer/13369245).
     * Requires the `chat.admin.memberships` or `chat.admin.memberships.readonly`
     * [OAuth 2.0
     * scopes](https://developers.google.com/workspace/chat/authenticate-authorize#chat-api-scopes).
     * Getting app memberships in a space isn't supported when using admin access.
     *
     * Generated from protobuf field <code>bool use_admin_access = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $use_admin_access = false;

    /**
     * @param string $name Required. Resource name of the membership to retrieve.
     *
     *                     To get the app's own membership [by using user
     *                     authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-user),
     *                     you can optionally use `spaces/{space}/members/app`.
     *
     *                     Format: `spaces/{space}/members/{member}` or `spaces/{space}/members/app`
     *
     *                     You can use the user's email as an alias for `{member}`. For example,
     *                     `spaces/{space}/members/example&#64;gmail.com` where `example&#64;gmail.com` is the
     *                     email of the Google Chat user. Please see
     *                     {@see ChatServiceClient::membershipName()} for help formatting this field.
     *
     * @return \Google\Apps\Chat\V1\GetMembershipRequest
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
     *           Required. Resource name of the membership to retrieve.
     *           To get the app's own membership [by using user
     *           authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-user),
     *           you can optionally use `spaces/{space}/members/app`.
     *           Format: `spaces/{space}/members/{member}` or `spaces/{space}/members/app`
     *           You can use the user's email as an alias for `{member}`. For example,
     *           `spaces/{space}/members/example&#64;gmail.com` where `example&#64;gmail.com` is the
     *           email of the Google Chat user.
     *     @type bool $use_admin_access
     *           Optional. When `true`, the method runs using the user's Google Workspace
     *           administrator privileges.
     *           The calling user must be a Google Workspace administrator with the
     *           [manage chat and spaces conversations
     *           privilege](https://support.google.com/a/answer/13369245).
     *           Requires the `chat.admin.memberships` or `chat.admin.memberships.readonly`
     *           [OAuth 2.0
     *           scopes](https://developers.google.com/workspace/chat/authenticate-authorize#chat-api-scopes).
     *           Getting app memberships in a space isn't supported when using admin access.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Chat\V1\Membership::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. Resource name of the membership to retrieve.
     * To get the app's own membership [by using user
     * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-user),
     * you can optionally use `spaces/{space}/members/app`.
     * Format: `spaces/{space}/members/{member}` or `spaces/{space}/members/app`
     * You can use the user's email as an alias for `{member}`. For example,
     * `spaces/{space}/members/example&#64;gmail.com` where `example&#64;gmail.com` is the
     * email of the Google Chat user.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Required. Resource name of the membership to retrieve.
     * To get the app's own membership [by using user
     * authentication](https://developers.google.com/workspace/chat/authenticate-authorize-chat-user),
     * you can optionally use `spaces/{space}/members/app`.
     * Format: `spaces/{space}/members/{member}` or `spaces/{space}/members/app`
     * You can use the user's email as an alias for `{member}`. For example,
     * `spaces/{space}/members/example&#64;gmail.com` where `example&#64;gmail.com` is the
     * email of the Google Chat user.
     *
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
     * Optional. When `true`, the method runs using the user's Google Workspace
     * administrator privileges.
     * The calling user must be a Google Workspace administrator with the
     * [manage chat and spaces conversations
     * privilege](https://support.google.com/a/answer/13369245).
     * Requires the `chat.admin.memberships` or `chat.admin.memberships.readonly`
     * [OAuth 2.0
     * scopes](https://developers.google.com/workspace/chat/authenticate-authorize#chat-api-scopes).
     * Getting app memberships in a space isn't supported when using admin access.
     *
     * Generated from protobuf field <code>bool use_admin_access = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return bool
     */
    public function getUseAdminAccess()
    {
        return $this->use_admin_access;
    }

    /**
     * Optional. When `true`, the method runs using the user's Google Workspace
     * administrator privileges.
     * The calling user must be a Google Workspace administrator with the
     * [manage chat and spaces conversations
     * privilege](https://support.google.com/a/answer/13369245).
     * Requires the `chat.admin.memberships` or `chat.admin.memberships.readonly`
     * [OAuth 2.0
     * scopes](https://developers.google.com/workspace/chat/authenticate-authorize#chat-api-scopes).
     * Getting app memberships in a space isn't supported when using admin access.
     *
     * Generated from protobuf field <code>bool use_admin_access = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param bool $var
     * @return $this
     */
    public function setUseAdminAccess($var)
    {
        GPBUtil::checkBool($var);
        $this->use_admin_access = $var;

        return $this;
    }

}

