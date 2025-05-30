<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/dataplex/v1/cmek.proto

namespace GPBMetadata\Google\Cloud\Dataplex\V1;

class Cmek
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
        \GPBMetadata\Google\Cloud\Dataplex\V1\Service::initOnce();
        \GPBMetadata\Google\Longrunning\Operations::initOnce();
        \GPBMetadata\Google\Protobuf\GPBEmpty::initOnce();
        \GPBMetadata\Google\Protobuf\FieldMask::initOnce();
        \GPBMetadata\Google\Protobuf\Timestamp::initOnce();
        $pool->internalAddGeneratedFile(
            '
�
#google/cloud/dataplex/v1/cmek.protogoogle.cloud.dataplex.v1google/api/client.protogoogle/api/field_behavior.protogoogle/api/resource.proto&google/cloud/dataplex/v1/service.proto#google/longrunning/operations.protogoogle/protobuf/empty.proto google/protobuf/field_mask.protogoogle/protobuf/timestamp.proto"�
EncryptionConfig>
name (	B0�A�A*
(dataplex.googleapis.com/EncryptionConfig
key (	B�A4
create_time (2.google.protobuf.TimestampB�A4
update_time (2.google.protobuf.TimestampB�AY
encryption_state (2:.google.cloud.dataplex.v1.EncryptionConfig.EncryptionStateB�A
etag (	W
failure_details (29.google.cloud.dataplex.v1.EncryptionConfig.FailureDetailsB�A�
FailureDetails\\

error_code (2C.google.cloud.dataplex.v1.EncryptionConfig.FailureDetails.ErrorCodeB�A
error_message (	B�A"E
	ErrorCode
UNKNOWN 
INTERNAL_ERROR
REQUIRE_USER_ACTION"^
EncryptionState 
ENCRYPTION_STATE_UNSPECIFIED 

ENCRYPTING
	COMPLETED

FAILED:��A�
(dataplex.googleapis.com/EncryptionConfigWorganizations/{organization}/locations/{location}/encryptionConfigs/{encryption_config}"�
CreateEncryptionConfigRequestD
parent (	B4�A�A.
,dataplex.googleapis.com/OrganizationLocation!
encryption_config_id (	B�AJ
encryption_config (2*.google.cloud.dataplex.v1.EncryptionConfigB�A"\\
GetEncryptionConfigRequest>
name (	B0�A�A*
(dataplex.googleapis.com/EncryptionConfig"�
UpdateEncryptionConfigRequestJ
encryption_config (2*.google.cloud.dataplex.v1.EncryptionConfigB�A4
update_mask (2.google.protobuf.FieldMaskB�A"r
DeleteEncryptionConfigRequest>
name (	B0�A�A*
(dataplex.googleapis.com/EncryptionConfig
etag (	B�A"�
ListEncryptionConfigsRequest@
parent (	B0�A�A*(dataplex.googleapis.com/EncryptionConfig
	page_size (B�A

page_token (	B�A
filter (	B�A
order_by (	B�A"�
ListEncryptionConfigsResponseF
encryption_configs (2*.google.cloud.dataplex.v1.EncryptionConfig
next_page_token (	E
unreachable_locations (	B&�A#
!locations.googleapis.com/Location2�

CmekService�
CreateEncryptionConfig7.google.cloud.dataplex.v1.CreateEncryptionConfigRequest.google.longrunning.Operation"��A%
EncryptionConfigOperationMetadata�A-parent,encryption_config,encryption_config_id���O":/v1/{parent=organizations/*/locations/*}/encryptionConfigs:encryption_config�
UpdateEncryptionConfig7.google.cloud.dataplex.v1.UpdateEncryptionConfigRequest.google.longrunning.Operation"��A%
EncryptionConfigOperationMetadata�Aencryption_config,update_mask���a2L/v1/{encryption_config.name=organizations/*/locations/*/encryptionConfigs/*}:encryption_config�
DeleteEncryptionConfig7.google.cloud.dataplex.v1.DeleteEncryptionConfigRequest.google.longrunning.Operation"v�A*
google.protobuf.EmptyOperationMetadata�Aname���<*:/v1/{name=organizations/*/locations/*/encryptionConfigs/*}�
ListEncryptionConfigs6.google.cloud.dataplex.v1.ListEncryptionConfigsRequest7.google.cloud.dataplex.v1.ListEncryptionConfigsResponse"K�Aparent���<:/v1/{parent=organizations/*/locations/*}/encryptionConfigs�
GetEncryptionConfig4.google.cloud.dataplex.v1.GetEncryptionConfigRequest*.google.cloud.dataplex.v1.EncryptionConfig"I�Aname���<:/v1/{name=organizations/*/locations/*/encryptionConfigs/*}K�Adataplex.googleapis.com�A.https://www.googleapis.com/auth/cloud-platformB�
com.google.cloud.dataplex.v1B	CmekProtoPZ8cloud.google.com/go/dataplex/apiv1/dataplexpb;dataplexpb�Google.Cloud.Dataplex.V1�Google\\Cloud\\Dataplex\\V1�Google::Cloud::Dataplex::V1�Aa
,dataplex.googleapis.com/OrganizationLocation1organizations/{organization}/locations/{location}bproto3'
        , true);

        static::$is_initialized = true;
    }
}

