<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/ads/admanager/v1/custom_targeting_value_service.proto

namespace GPBMetadata\Google\Ads\Admanager\V1;

class CustomTargetingValueService
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Ads\Admanager\V1\CustomTargetingValueMessages::initOnce();
        \GPBMetadata\Google\Api\Annotations::initOnce();
        \GPBMetadata\Google\Api\Client::initOnce();
        \GPBMetadata\Google\Api\FieldBehavior::initOnce();
        \GPBMetadata\Google\Api\Resource::initOnce();
        $pool->internalAddGeneratedFile(
            '
�
<google/ads/admanager/v1/custom_targeting_value_service.protogoogle.ads.admanager.v1google/api/annotations.protogoogle/api/client.protogoogle/api/field_behavior.protogoogle/api/resource.proto"e
GetCustomTargetingValueRequestC
name (	B5�A�A/
-admanager.googleapis.com/CustomTargetingValue"�
 ListCustomTargetingValuesRequestC
parent (	B3�A�A-
+admanager.googleapis.com/CustomTargetingKey
	page_size (B�A

page_token (	B�A
filter (	B�A
order_by (	B�A
skip (B�A"�
!ListCustomTargetingValuesResponseN
custom_targeting_values (2-.google.ads.admanager.v1.CustomTargetingValue
next_page_token (	

total_size (2�
CustomTargetingValueService�
GetCustomTargetingValue7.google.ads.admanager.v1.GetCustomTargetingValueRequest-.google.ads.admanager.v1.CustomTargetingValue"R�Aname���EC/v1/{name=networks/*/customTargetingKeys/*/customTargetingValues/*}�
ListCustomTargetingValues9.google.ads.admanager.v1.ListCustomTargetingValuesRequest:.google.ads.admanager.v1.ListCustomTargetingValuesResponse"T�Aparent���EC/v1/{parent=networks/*/customTargetingKeys/*}/customTargetingValues�Aadmanager.googleapis.comB�
com.google.ads.admanager.v1B CustomTargetingValueServiceProtoPZ@google.golang.org/genproto/googleapis/ads/admanager/v1;admanager�Google.Ads.AdManager.V1�Google\\Ads\\AdManager\\V1�Google::Ads::AdManager::V1bproto3'
        , true);

        static::$is_initialized = true;
    }
}

