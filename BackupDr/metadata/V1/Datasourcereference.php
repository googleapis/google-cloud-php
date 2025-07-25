<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/backupdr/v1/datasourcereference.proto

namespace GPBMetadata\Google\Cloud\Backupdr\V1;

class Datasourcereference
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Api\FieldBehavior::initOnce();
        \GPBMetadata\Google\Api\Resource::initOnce();
        \GPBMetadata\Google\Cloud\Backupdr\V1\Backupvault::initOnce();
        \GPBMetadata\Google\Cloud\Backupdr\V1\BackupvaultCloudsql::initOnce();
        \GPBMetadata\Google\Protobuf\Timestamp::initOnce();
        $pool->internalAddGeneratedFile(
            '
�
2google/cloud/backupdr/v1/datasourcereference.protogoogle.cloud.backupdr.v1google/api/resource.proto*google/cloud/backupdr/v1/backupvault.proto3google/cloud/backupdr/v1/backupvault_cloudsql.protogoogle/protobuf/timestamp.proto"�
DataSourceReference
name (	B�A?
data_source (	B*�A�A$
"backupdr.googleapis.com/DataSource4
create_time (2.google.protobuf.TimestampB�AY
data_source_backup_config_state (2+.google.cloud.backupdr.v1.BackupConfigStateB�A%
data_source_backup_count (B�Aa
data_source_backup_config_info (24.google.cloud.backupdr.v1.DataSourceBackupConfigInfoB�A_
data_source_gcp_resource_info (23.google.cloud.backupdr.v1.DataSourceGcpResourceInfoB�A:��A�
+backupdr.googleapis.com/DataSourceReferenceTprojects/{project}/locations/{location}/dataSourceReferences/{data_source_reference}*dataSourceReferences2dataSourceReference"�
DataSourceBackupConfigInfoZ
last_backup_state (2:.google.cloud.backupdr.v1.BackupConfigInfo.LastBackupStateB�AP
\'last_successful_backup_consistency_time (2.google.protobuf.TimestampB�A"�
DataSourceGcpResourceInfo
gcp_resourcename (	B�A
type (	B�A
location (	B�Au
cloud_sql_instance_properties (2G.google.cloud.backupdr.v1.CloudSqlInstanceDataSourceReferencePropertiesB�AH B
resource_properties"b
GetDataSourceReferenceRequestA
name (	B3�A�A-
+backupdr.googleapis.com/DataSourceReference"�
/FetchDataSourceReferencesForResourceTypeRequestC
parent (	B3�A�A-+backupdr.googleapis.com/DataSourceReference
resource_type (	B�A
	page_size (B�A

page_token (	B�A
filter (	B�A
order_by (	B�A"�
0FetchDataSourceReferencesForResourceTypeResponseM
data_source_references (2-.google.cloud.backupdr.v1.DataSourceReference
next_page_token (	B�
com.google.cloud.backupdr.v1BDataSourceReferenceProtoPZ8cloud.google.com/go/backupdr/apiv1/backupdrpb;backupdrpb�Google.Cloud.BackupDR.V1�Google\\Cloud\\BackupDR\\V1�Google::Cloud::BackupDR::V1bproto3'
        , true);

        static::$is_initialized = true;
    }
}

