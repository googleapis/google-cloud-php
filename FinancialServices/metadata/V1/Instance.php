<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/financialservices/v1/instance.proto

namespace GPBMetadata\Google\Cloud\Financialservices\V1;

class Instance
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Api\FieldBehavior::initOnce();
        \GPBMetadata\Google\Api\Resource::initOnce();
        \GPBMetadata\Google\Cloud\Financialservices\V1\BigqueryDestination::initOnce();
        \GPBMetadata\Google\Cloud\Financialservices\V1\LineOfBusiness::initOnce();
        \GPBMetadata\Google\Protobuf\FieldMask::initOnce();
        \GPBMetadata\Google\Protobuf\Timestamp::initOnce();
        $pool->internalAddGeneratedFile(
            '
�
0google/cloud/financialservices/v1/instance.proto!google.cloud.financialservices.v1google/api/resource.proto<google/cloud/financialservices/v1/bigquery_destination.proto8google/cloud/financialservices/v1/line_of_business.proto google/protobuf/field_mask.protogoogle/protobuf/timestamp.proto"�
Instance
name (	B�A4
create_time (2.google.protobuf.TimestampB�A4
update_time (2.google.protobuf.TimestampB�AE
state (21.google.cloud.financialservices.v1.Instance.StateB�AG
labels (27.google.cloud.financialservices.v1.Instance.LabelsEntry
kms_key (	B�A-
LabelsEntry
key (	
value (	:8"T
State
STATE_UNSPECIFIED 
CREATING

ACTIVE
UPDATING
DELETING:l�Ai
)financialservices.googleapis.com/Instance<projects/{project}/locations/{location}/instances/{instance}"�
ListInstancesRequest9
parent (	B)�A�A#
!locations.googleapis.com/Location
	page_size (

page_token (	
filter (	
order_by (	"�
ListInstancesResponse>
	instances (2+.google.cloud.financialservices.v1.Instance
next_page_token (	
unreachable (	"U
GetInstanceRequest?
name (	B1�A�A+
)financialservices.googleapis.com/Instance"�
CreateInstanceRequest9
parent (	B)�A�A#
!locations.googleapis.com/Location
instance_id (	B�AB
instance (2+.google.cloud.financialservices.v1.InstanceB�A

request_id (	B�A"�
UpdateInstanceRequest4
update_mask (2.google.protobuf.FieldMaskB�AB
instance (2+.google.cloud.financialservices.v1.InstanceB�A

request_id (	B�A"q
DeleteInstanceRequest?
name (	B1�A�A+
)financialservices.googleapis.com/Instance

request_id (	B�A"�
ImportRegisteredPartiesRequest?
name (	B1�A�A+
)financialservices.googleapis.com/Instance
party_tables (	B�A_
mode (2L.google.cloud.financialservices.v1.ImportRegisteredPartiesRequest.UpdateModeB�A
validate_only (B�AP
line_of_business (21.google.cloud.financialservices.v1.LineOfBusinessB�A"B

UpdateMode
UPDATE_MODE_UNSPECIFIED 
REPLACE

APPEND"�
ImportRegisteredPartiesResponse
parties_added (
parties_removed (
parties_total ( 
parties_failed_to_remove (
parties_uptiered (
parties_downtiered ("
parties_failed_to_downtier ("�
ExportRegisteredPartiesRequest?
name (	B1�A�A+
)financialservices.googleapis.com/InstanceL
dataset (26.google.cloud.financialservices.v1.BigQueryDestinationB�AP
line_of_business (21.google.cloud.financialservices.v1.LineOfBusinessB�A"!
ExportRegisteredPartiesResponseB�
%com.google.cloud.financialservices.v1BInstanceProtoPZScloud.google.com/go/financialservices/apiv1/financialservicespb;financialservicespb�!Google.Cloud.FinancialServices.V1�!Google\\Cloud\\FinancialServices\\V1�$Google::Cloud::FinancialServices::V1bproto3'
        , true);

        static::$is_initialized = true;
    }
}

