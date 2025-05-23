<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/shopping/merchant/accounts/v1beta/gbpaccounts.proto

namespace GPBMetadata\Google\Shopping\Merchant\Accounts\V1Beta;

class Gbpaccounts
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Api\Annotations::initOnce();
        \GPBMetadata\Google\Api\Client::initOnce();
        \GPBMetadata\Google\Api\FieldBehavior::initOnce();
        \GPBMetadata\Google\Api\Resource::initOnce();
        \GPBMetadata\Google\Protobuf\GPBEmpty::initOnce();
        $pool->internalAddGeneratedFile(
            '
�
:google/shopping/merchant/accounts/v1beta/gbpaccounts.proto(google.shopping.merchant.accounts.v1betagoogle/api/client.protogoogle/api/field_behavior.protogoogle/api/resource.protogoogle/protobuf/empty.proto"�

GbpAccount
name (	B�A
gbp_account_id (	G
type (29.google.shopping.merchant.accounts.v1beta.GbpAccount.Type
gbp_account_name (	
listing_count ("<
Type
TYPE_UNSPECIFIED 
USER
BUSINESS_ACCOUNT:q�An
%merchantapi.googleapis.com/GbpAccount,accounts/{account}/gbpAccounts/{gbp_account}*gbpAccounts2
gbpAccount"�
ListGbpAccountsRequest:
parent (	B*�A�A$
"merchantapi.googleapis.com/Account
	page_size (B�A

page_token (	B�A"~
ListGbpAccountsResponseJ
gbp_accounts (24.google.shopping.merchant.accounts.v1beta.GbpAccount
next_page_token (	"k
LinkGbpAccountRequest:
parent (	B*�A�A$
"merchantapi.googleapis.com/Account
	gbp_email (	B�A"B
LinkGbpAccountResponse(
response (2.google.protobuf.Empty2�
GbpAccountsService�
ListGbpAccounts@.google.shopping.merchant.accounts.v1beta.ListGbpAccountsRequestA.google.shopping.merchant.accounts.v1beta.ListGbpAccountsResponse"A�Aparent���20/accounts/v1beta/{parent=accounts/*}/gbpAccounts�
LinkGbpAccount?.google.shopping.merchant.accounts.v1beta.LinkGbpAccountRequest@.google.shopping.merchant.accounts.v1beta.LinkGbpAccountResponse"S�Aparent���D"?/accounts/v1beta/{parent=accounts/*}/gbpAccounts:linkGbpAccount:*G�Amerchantapi.googleapis.com�A\'https://www.googleapis.com/auth/contentB�
,com.google.shopping.merchant.accounts.v1betaBGbpAccountsProtoPZNcloud.google.com/go/shopping/merchant/accounts/apiv1beta/accountspb;accountspbbproto3'
        , true);

        static::$is_initialized = true;
    }
}

