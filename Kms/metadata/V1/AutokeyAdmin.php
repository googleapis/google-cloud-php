<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/kms/v1/autokey_admin.proto

namespace GPBMetadata\Google\Cloud\Kms\V1;

class AutokeyAdmin
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
        \GPBMetadata\Google\Protobuf\FieldMask::initOnce();
        $pool->internalAddGeneratedFile(
            '
�
\'google/cloud/kms/v1/autokey_admin.protogoogle.cloud.kms.v1google/api/client.protogoogle/api/field_behavior.protogoogle/api/resource.proto google/protobuf/field_mask.proto"�
UpdateAutokeyConfigRequest?
autokey_config (2".google.cloud.kms.v1.AutokeyConfigB�A4
update_mask (2.google.protobuf.FieldMaskB�A"V
GetAutokeyConfigRequest;
name (	B-�A�A\'
%cloudkms.googleapis.com/AutokeyConfig"�
AutokeyConfig
name (	B�A
key_project (	B�A<
state (2(.google.cloud.kms.v1.AutokeyConfig.StateB�A
etag (	B�A"V
State
STATE_UNSPECIFIED 

ACTIVE
KEY_PROJECT_DELETED
UNINITIALIZED:i�Af
%cloudkms.googleapis.com/AutokeyConfigfolders/{folder}/autokeyConfig*autokeyConfigs2autokeyConfig"h
!ShowEffectiveAutokeyConfigRequestC
parent (	B3�A�A-
+cloudresourcemanager.googleapis.com/Project"9
"ShowEffectiveAutokeyConfigResponse
key_project (	2�
AutokeyAdmin�
UpdateAutokeyConfig/.google.cloud.kms.v1.UpdateAutokeyConfigRequest".google.cloud.kms.v1.AutokeyConfig"f�Aautokey_config,update_mask���C21/v1/{autokey_config.name=folders/*/autokeyConfig}:autokey_config�
GetAutokeyConfig,.google.cloud.kms.v1.GetAutokeyConfigRequest".google.cloud.kms.v1.AutokeyConfig"1�Aname���$"/v1/{name=folders/*/autokeyConfig}�
ShowEffectiveAutokeyConfig6.google.cloud.kms.v1.ShowEffectiveAutokeyConfigRequest7.google.cloud.kms.v1.ShowEffectiveAutokeyConfigResponse"C�Aparent���42/v1/{parent=projects/*}:showEffectiveAutokeyConfigt�Acloudkms.googleapis.com�AWhttps://www.googleapis.com/auth/cloud-platform,https://www.googleapis.com/auth/cloudkmsBY
com.google.cloud.kms.v1BAutokeyAdminProtoPZ)cloud.google.com/go/kms/apiv1/kmspb;kmspbbproto3'
        , true);

        static::$is_initialized = true;
    }
}

