<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/ads/admanager/v1/user_messages.proto

namespace GPBMetadata\Google\Ads\Admanager\V1;

class UserMessages
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Api\FieldBehavior::initOnce();
        \GPBMetadata\Google\Api\Resource::initOnce();
        $pool->internalAddGeneratedFile(
            '
�
+google/ads/admanager/v1/user_messages.protogoogle.ads.admanager.v1google/api/resource.proto"�
User
name (	B�A
user_id
 (B�AH �
display_name (	B�AH�
email (	B�AH�8
role (	B%�A�A
admanager.googleapis.com/RoleH�
active (B�AH�
external_id (	B�AH�!
service_account (B�AH�+
orders_ui_local_time_zone	 (	B�AH�:U�AR
admanager.googleapis.com/User$networks/{network_code}/users/{user}*users2userB

_user_idB
_display_nameB
_emailB
_roleB	
_activeB
_external_idB
_service_accountB
_orders_ui_local_time_zoneB�
com.google.ads.admanager.v1BUserMessagesProtoPZ@google.golang.org/genproto/googleapis/ads/admanager/v1;admanager�Google.Ads.AdManager.V1�Google\\Ads\\AdManager\\V1�Google::Ads::AdManager::V1bproto3'
        , true);

        static::$is_initialized = true;
    }
}

