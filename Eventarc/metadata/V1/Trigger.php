<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/eventarc/v1/trigger.proto

namespace GPBMetadata\Google\Cloud\Eventarc\V1;

class Trigger
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Api\FieldBehavior::initOnce();
        \GPBMetadata\Google\Api\Resource::initOnce();
        \GPBMetadata\Google\Cloud\Eventarc\V1\NetworkConfig::initOnce();
        \GPBMetadata\Google\Protobuf\Timestamp::initOnce();
        \GPBMetadata\Google\Rpc\Code::initOnce();
        $pool->internalAddGeneratedFile(
            '
�
&google/cloud/eventarc/v1/trigger.protogoogle.cloud.eventarc.v1google/api/resource.proto-google/cloud/eventarc/v1/network_config.protogoogle/protobuf/timestamp.protogoogle/rpc/code.proto"�
Trigger
name (	B�A
uid (	B�A4
create_time (2.google.protobuf.TimestampB�A4
update_time (2.google.protobuf.TimestampB�AD
event_filters (2%.google.cloud.eventarc.v1.EventFilterB�A�AB
service_account	 (	B)�A�A#
!iam.googleapis.com/ServiceAccount?
destination
 (2%.google.cloud.eventarc.v1.DestinationB�A;
	transport (2#.google.cloud.eventarc.v1.TransportB�AB
labels (2-.google.cloud.eventarc.v1.Trigger.LabelsEntryB�A
channel (	B�AJ

conditions (21.google.cloud.eventarc.v1.Trigger.ConditionsEntryB�A$
event_data_content_type (	B�A
satisfies_pzs (B�A
etagc (	B�A-
LabelsEntry
key (	
value (	:8[
ConditionsEntry
key (	7
value (2(.google.cloud.eventarc.v1.StateCondition:8:s�Ap
eventarc.googleapis.com/Trigger:projects/{project}/locations/{location}/triggers/{trigger}*triggers2trigger"P
EventFilter
	attribute (	B�A
value (	B�A
operator (	B�A"A
StateCondition
code (2.google.rpc.Code
message (	"�
Destination7
	cloud_run (2".google.cloud.eventarc.v1.CloudRunH J
cloud_function (	B0�A-
+cloudfunctions.googleapis.com/CloudFunctionH ,
gke (2.google.cloud.eventarc.v1.GKEH :
workflow (	B&�A#
!workflows.googleapis.com/WorkflowH ?
http_endpoint (2&.google.cloud.eventarc.v1.HttpEndpointH D
network_config (2\'.google.cloud.eventarc.v1.NetworkConfigB�AB

descriptor"O
	Transport2
pubsub (2 .google.cloud.eventarc.v1.PubsubH B
intermediary"g
CloudRun3
service (	B"�A�A
run.googleapis.com/Service
path (	B�A
region (	B�A"s
GKE
cluster (	B�A
location (	B�A
	namespace (	B�A
service (	B�A
path (	B�A"7
Pubsub
topic (	B�A
subscription (	B�A" 
HttpEndpoint
uri (	B�AB�
com.google.cloud.eventarc.v1BTriggerProtoPZ8cloud.google.com/go/eventarc/apiv1/eventarcpb;eventarcpb�Ak
+cloudfunctions.googleapis.com/CloudFunction<projects/{project}/locations/{location}/functions/{function}�AY
!iam.googleapis.com/ServiceAccount4projects/{project}/serviceAccounts/{service_account}�A
run.googleapis.com/Service*�Aa
!workflows.googleapis.com/Workflow<projects/{project}/locations/{location}/workflows/{workflow}�Av
(compute.googleapis.com/NetworkAttachmentJprojects/{project}/regions/{region}/networkAttachments/{networkattachment}bproto3'
        , true);

        static::$is_initialized = true;
    }
}

