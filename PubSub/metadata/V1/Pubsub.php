<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/pubsub/v1/pubsub.proto

namespace GPBMetadata\Google\Pubsub\V1;

class Pubsub
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
        \GPBMetadata\Google\Protobuf\Duration::initOnce();
        \GPBMetadata\Google\Protobuf\GPBEmpty::initOnce();
        \GPBMetadata\Google\Protobuf\FieldMask::initOnce();
        \GPBMetadata\Google\Protobuf\Timestamp::initOnce();
        \GPBMetadata\Google\Pubsub\V1\Schema::initOnce();
        $pool->internalAddGeneratedFile(
            '
��
google/pubsub/v1/pubsub.protogoogle.pubsub.v1google/api/client.protogoogle/api/field_behavior.protogoogle/api/resource.protogoogle/protobuf/duration.protogoogle/protobuf/empty.proto google/protobuf/field_mask.protogoogle/protobuf/timestamp.protogoogle/pubsub/v1/schema.proto"a
MessageStoragePolicy(
allowed_persistence_regions (	B�A
enforce_in_transit (B�A"�
SchemaSettings4
schema (	B$�A�A
pubsub.googleapis.com/Schema1
encoding (2.google.pubsub.v1.EncodingB�A
first_revision_id (	B�A
last_revision_id (	B�A"�
IngestionDataSourceSettingsT
aws_kinesis (28.google.pubsub.v1.IngestionDataSourceSettings.AwsKinesisB�AH X
cloud_storage (2:.google.pubsub.v1.IngestionDataSourceSettings.CloudStorageB�AH ]
azure_event_hubs (2<.google.pubsub.v1.IngestionDataSourceSettings.AzureEventHubsB�AH L
aws_msk (24.google.pubsub.v1.IngestionDataSourceSettings.AwsMskB�AH \\
confluent_cloud (2<.google.pubsub.v1.IngestionDataSourceSettings.ConfluentCloudB�AH K
platform_logs_settings (2&.google.pubsub.v1.PlatformLogsSettingsB�A�

AwsKinesisR
state (2>.google.pubsub.v1.IngestionDataSourceSettings.AwsKinesis.StateB�A

stream_arn (	B�A
consumer_arn (	B�A
aws_role_arn (	B�A 
gcp_service_account (	B�A"�
State
STATE_UNSPECIFIED 

ACTIVE
KINESIS_PERMISSION_DENIED
PUBLISH_PERMISSION_DENIED
STREAM_NOT_FOUND
CONSUMER_NOT_FOUND�
CloudStorageT
state (2@.google.pubsub.v1.IngestionDataSourceSettings.CloudStorage.StateB�A
bucket (	B�Aa
text_format (2E.google.pubsub.v1.IngestionDataSourceSettings.CloudStorage.TextFormatB�AH a
avro_format (2E.google.pubsub.v1.IngestionDataSourceSettings.CloudStorage.AvroFormatB�AH n
pubsub_avro_format (2K.google.pubsub.v1.IngestionDataSourceSettings.CloudStorage.PubSubAvroFormatB�AH C
minimum_object_create_time (2.google.protobuf.TimestampB�A

match_glob	 (	B�A7

TextFormat
	delimiter (	B�AH �B

_delimiter

AvroFormat
PubSubAvroFormat"�
State
STATE_UNSPECIFIED 

ACTIVE#
CLOUD_STORAGE_PERMISSION_DENIED
PUBLISH_PERMISSION_DENIED
BUCKET_NOT_FOUND
TOO_MANY_OBJECTSB
input_format�
AzureEventHubsV
state (2B.google.pubsub.v1.IngestionDataSourceSettings.AzureEventHubs.StateB�A
resource_group (	B�A
	namespace (	B�A
	event_hub (	B�A
	client_id (	B�A
	tenant_id (	B�A
subscription_id (	B�A 
gcp_service_account (	B�A"�
State
STATE_UNSPECIFIED 

ACTIVE 
EVENT_HUBS_PERMISSION_DENIED
PUBLISH_PERMISSION_DENIED
NAMESPACE_NOT_FOUND
EVENT_HUB_NOT_FOUND
SUBSCRIPTION_NOT_FOUND
RESOURCE_GROUP_NOT_FOUND�
AwsMskN
state (2:.google.pubsub.v1.IngestionDataSourceSettings.AwsMsk.StateB�A
cluster_arn (	B�A
topic (	B�A
aws_role_arn (	B�A 
gcp_service_account (	B�A"�
State
STATE_UNSPECIFIED 

ACTIVE
MSK_PERMISSION_DENIED
PUBLISH_PERMISSION_DENIED
CLUSTER_NOT_FOUND
TOPIC_NOT_FOUND�
ConfluentCloudV
state (2B.google.pubsub.v1.IngestionDataSourceSettings.ConfluentCloud.StateB�A
bootstrap_server (	B�A

cluster_id (	B�A
topic (	B�A
identity_pool_id (	B�A 
gcp_service_account (	B�A"�
State
STATE_UNSPECIFIED 

ACTIVE%
!CONFLUENT_CLOUD_PERMISSION_DENIED
PUBLISH_PERMISSION_DENIED 
UNREACHABLE_BOOTSTRAP_SERVER
CLUSTER_NOT_FOUND
TOPIC_NOT_FOUNDB
source"�
PlatformLogsSettingsF
severity (2/.google.pubsub.v1.PlatformLogsSettings.SeverityB�A"_
Severity
SEVERITY_UNSPECIFIED 
DISABLED	
DEBUG
INFO
WARNING	
ERROR"�
IngestionFailureEvent
topic (	B�A
error_message (	B�Aa
cloud_storage_failure (2;.google.pubsub.v1.IngestionFailureEvent.CloudStorageFailureB�AH [
aws_msk_failure (2;.google.pubsub.v1.IngestionFailureEvent.AwsMskFailureReasonB�AH l
azure_event_hubs_failure (2C.google.pubsub.v1.IngestionFailureEvent.AzureEventHubsFailureReasonB�AH k
confluent_cloud_failure (2C.google.pubsub.v1.IngestionFailureEvent.ConfluentCloudFailureReasonB�AH c
aws_kinesis_failure (2?.google.pubsub.v1.IngestionFailureEvent.AwsKinesisFailureReasonB�AH 
ApiViolationReason
AvroFailureReason
SchemaViolationReason$
"MessageTransformationFailureReason�
CloudStorageFailure
bucket (	B�A
object_name (	B�A
object_generation (B�A]
avro_failure_reason (29.google.pubsub.v1.IngestionFailureEvent.AvroFailureReasonB�AH _
api_violation_reason (2:.google.pubsub.v1.IngestionFailureEvent.ApiViolationReasonB�AH e
schema_violation_reason (2=.google.pubsub.v1.IngestionFailureEvent.SchemaViolationReasonB�AH �
%message_transformation_failure_reason (2J.google.pubsub.v1.IngestionFailureEvent.MessageTransformationFailureReasonB�AH B
reason�
AwsMskFailureReason
cluster_arn (	B�A
kafka_topic (	B�A
partition_id (B�A
offset (B�A_
api_violation_reason (2:.google.pubsub.v1.IngestionFailureEvent.ApiViolationReasonB�AH e
schema_violation_reason (2=.google.pubsub.v1.IngestionFailureEvent.SchemaViolationReasonB�AH �
%message_transformation_failure_reason (2J.google.pubsub.v1.IngestionFailureEvent.MessageTransformationFailureReasonB�AH B
reason�
AzureEventHubsFailureReason
	namespace (	B�A
	event_hub (	B�A
partition_id (B�A
offset (B�A_
api_violation_reason (2:.google.pubsub.v1.IngestionFailureEvent.ApiViolationReasonB�AH e
schema_violation_reason (2=.google.pubsub.v1.IngestionFailureEvent.SchemaViolationReasonB�AH �
%message_transformation_failure_reason (2J.google.pubsub.v1.IngestionFailureEvent.MessageTransformationFailureReasonB�AH B
reason�
ConfluentCloudFailureReason

cluster_id (	B�A
kafka_topic (	B�A
partition_id (B�A
offset (B�A_
api_violation_reason (2:.google.pubsub.v1.IngestionFailureEvent.ApiViolationReasonB�AH e
schema_violation_reason (2=.google.pubsub.v1.IngestionFailureEvent.SchemaViolationReasonB�AH �
%message_transformation_failure_reason (2J.google.pubsub.v1.IngestionFailureEvent.MessageTransformationFailureReasonB�AH B
reason�
AwsKinesisFailureReason

stream_arn (	B�A
partition_key (	B�A
sequence_number (	B�Ae
schema_violation_reason (2=.google.pubsub.v1.IngestionFailureEvent.SchemaViolationReasonB�AH �
%message_transformation_failure_reason (2J.google.pubsub.v1.IngestionFailureEvent.MessageTransformationFailureReasonB�AH B
reasonB	
failure">
JavaScriptUDF
function_name (	B�A
code (	B�A"�
MessageTransform>
javascript_udf (2.google.pubsub.v1.JavaScriptUDFB�AH 
enabled (B�A
disabled (B�AB
	transform"�
Topic
name (	B�A8
labels (2#.google.pubsub.v1.Topic.LabelsEntryB�AK
message_storage_policy (2&.google.pubsub.v1.MessageStoragePolicyB�A
kms_key_name (	B�A>
schema_settings (2 .google.pubsub.v1.SchemaSettingsB�A
satisfies_pzs (B�AB
message_retention_duration (2.google.protobuf.DurationB�A1
state	 (2.google.pubsub.v1.Topic.StateB�AZ
ingestion_data_source_settings
 (2-.google.pubsub.v1.IngestionDataSourceSettingsB�AC
message_transforms (2".google.pubsub.v1.MessageTransformB�A-
LabelsEntry
key (	
value (	:8"H
State
STATE_UNSPECIFIED 

ACTIVE
INGESTION_RESOURCE_ERROR:c�A`
pubsub.googleapis.com/Topic!projects/{project}/topics/{topic}_deleted-topic_*topics2topic"�
PubsubMessage
data (B�AH

attributes (2/.google.pubsub.v1.PubsubMessage.AttributesEntryB�A

message_id (	0
publish_time (2.google.protobuf.Timestamp
ordering_key (	B�A1
AttributesEntry
key (	
value (	:8"E
GetTopicRequest2
topic (	B#�A�A
pubsub.googleapis.com/Topic"w
UpdateTopicRequest+
topic (2.google.pubsub.v1.TopicB�A4
update_mask (2.google.protobuf.FieldMaskB�A"|
PublishRequest2
topic (	B#�A�A
pubsub.googleapis.com/Topic6
messages (2.google.pubsub.v1.PubsubMessageB�A"+
PublishResponse
message_ids (	B�A"�
ListTopicsRequestD
project (	B3�A�A-
+cloudresourcemanager.googleapis.com/Project
	page_size (B�A

page_token (	B�A"`
ListTopicsResponse,
topics (2.google.pubsub.v1.TopicB�A
next_page_token (	B�A"�
ListTopicSubscriptionsRequest2
topic (	B#�A�A
pubsub.googleapis.com/Topic
	page_size (B�A

page_token (	B�A"�
ListTopicSubscriptionsResponseA
subscriptions (	B*�A�A$
"pubsub.googleapis.com/Subscription
next_page_token (	B�A"�
ListTopicSnapshotsRequest2
topic (	B#�A�A
pubsub.googleapis.com/Topic
	page_size (B�A

page_token (	B�A"R
ListTopicSnapshotsResponse
	snapshots (	B�A
next_page_token (	B�A"H
DeleteTopicRequest2
topic (	B#�A�A
pubsub.googleapis.com/Topic"]
DetachSubscriptionRequest@
subscription (	B*�A�A$
"pubsub.googleapis.com/Subscription"
DetachSubscriptionResponse"�
Subscription
name (	B�A2
topic (	B#�A�A
pubsub.googleapis.com/Topic6
push_config (2.google.pubsub.v1.PushConfigB�A>
bigquery_config (2 .google.pubsub.v1.BigQueryConfigB�AG
cloud_storage_config (2$.google.pubsub.v1.CloudStorageConfigB�A!
ack_deadline_seconds (B�A"
retain_acked_messages (B�AB
message_retention_duration (2.google.protobuf.DurationB�A?
labels	 (2*.google.pubsub.v1.Subscription.LabelsEntryB�A$
enable_message_ordering
 (B�AB
expiration_policy (2".google.pubsub.v1.ExpirationPolicyB�A
filter (	B�AC
dead_letter_policy (2".google.pubsub.v1.DeadLetterPolicyB�A8
retry_policy (2.google.pubsub.v1.RetryPolicyB�A
detached (B�A)
enable_exactly_once_delivery (B�AH
 topic_message_retention_duration (2.google.protobuf.DurationB�A8
state (2$.google.pubsub.v1.Subscription.StateB�Ai
analytics_hub_subscription_info (2;.google.pubsub.v1.Subscription.AnalyticsHubSubscriptionInfoB�AC
message_transforms (2".google.pubsub.v1.MessageTransformB�AO
AnalyticsHubSubscriptionInfo
listing (	B�A
subscription (	B�A-
LabelsEntry
key (	
value (	:8">
State
STATE_UNSPECIFIED 

ACTIVE
RESOURCE_ERROR:u�Ar
"pubsub.googleapis.com/Subscription/projects/{project}/subscriptions/{subscription}*subscriptions2subscription"
RetryPolicy7
minimum_backoff (2.google.protobuf.DurationB�A7
maximum_backoff (2.google.protobuf.DurationB�A"V
DeadLetterPolicy
dead_letter_topic (	B�A"
max_delivery_attempts (B�A"?
ExpirationPolicy+
ttl (2.google.protobuf.DurationB�A"�

PushConfig
push_endpoint (	B�AE

attributes (2,.google.pubsub.v1.PushConfig.AttributesEntryB�AA

oidc_token (2&.google.pubsub.v1.PushConfig.OidcTokenB�AH I
pubsub_wrapper (2*.google.pubsub.v1.PushConfig.PubsubWrapperB�AHA

no_wrapper (2&.google.pubsub.v1.PushConfig.NoWrapperB�AHF
	OidcToken"
service_account_email (	B�A
audience (	B�A
PubsubWrapper(
	NoWrapper
write_metadata (B�A1
AttributesEntry
key (	
value (	:8B
authentication_methodB	
wrapper"�
BigQueryConfig
table (	B�A
use_topic_schema (B�A
write_metadata (B�A 
drop_unknown_fields (B�A:
state (2&.google.pubsub.v1.BigQueryConfig.StateB�A
use_table_schema (B�A"
service_account_email (	B�A"�
State
STATE_UNSPECIFIED 

ACTIVE
PERMISSION_DENIED
	NOT_FOUND
SCHEMA_MISMATCH#
IN_TRANSIT_LOCATION_RESTRICTION"�
CloudStorageConfig
bucket (	B�A
filename_prefix (	B�A
filename_suffix (	B�A%
filename_datetime_format
 (	B�AK
text_config (2/.google.pubsub.v1.CloudStorageConfig.TextConfigB�AH K
avro_config (2/.google.pubsub.v1.CloudStorageConfig.AvroConfigB�AH 4
max_duration (2.google.protobuf.DurationB�A
	max_bytes (B�A
max_messages (B�A>
state	 (2*.google.pubsub.v1.CloudStorageConfig.StateB�A"
service_account_email (	B�A

TextConfigH

AvroConfig
write_metadata (B�A
use_topic_schema (B�A"�
State
STATE_UNSPECIFIED 

ACTIVE
PERMISSION_DENIED
	NOT_FOUND#
IN_TRANSIT_LOCATION_RESTRICTION
SCHEMA_MISMATCHB
output_format"|
ReceivedMessage
ack_id (	B�A5
message (2.google.pubsub.v1.PubsubMessageB�A
delivery_attempt (B�A"Z
GetSubscriptionRequest@
subscription (	B*�A�A$
"pubsub.googleapis.com/Subscription"�
UpdateSubscriptionRequest9
subscription (2.google.pubsub.v1.SubscriptionB�A4
update_mask (2.google.protobuf.FieldMaskB�A"�
ListSubscriptionsRequestD
project (	B3�A�A-
+cloudresourcemanager.googleapis.com/Project
	page_size (B�A

page_token (	B�A"u
ListSubscriptionsResponse:
subscriptions (2.google.pubsub.v1.SubscriptionB�A
next_page_token (	B�A"]
DeleteSubscriptionRequest@
subscription (	B*�A�A$
"pubsub.googleapis.com/Subscription"�
ModifyPushConfigRequest@
subscription (	B*�A�A$
"pubsub.googleapis.com/Subscription6
push_config (2.google.pubsub.v1.PushConfigB�A"�
PullRequest@
subscription (	B*�A�A$
"pubsub.googleapis.com/Subscription!
return_immediately (B�A
max_messages (B�A"Q
PullResponseA
received_messages (2!.google.pubsub.v1.ReceivedMessageB�A"�
ModifyAckDeadlineRequest@
subscription (	B*�A�A$
"pubsub.googleapis.com/Subscription
ack_ids (	B�A!
ack_deadline_seconds (B�A"l
AcknowledgeRequest@
subscription (	B*�A�A$
"pubsub.googleapis.com/Subscription
ack_ids (	B�A"�
StreamingPullRequest@
subscription (	B*�A�A$
"pubsub.googleapis.com/Subscription
ack_ids (	B�A$
modify_deadline_seconds (B�A$
modify_deadline_ack_ids (	B�A(
stream_ack_deadline_seconds (B�A
	client_id (	B�A%
max_outstanding_messages (B�A"
max_outstanding_bytes (B�A"�
StreamingPullResponseA
received_messages (2!.google.pubsub.v1.ReceivedMessageB�Af
acknowledge_confirmation (2?.google.pubsub.v1.StreamingPullResponse.AcknowledgeConfirmationB�At
 modify_ack_deadline_confirmation (2E.google.pubsub.v1.StreamingPullResponse.ModifyAckDeadlineConfirmationB�Ad
subscription_properties (2>.google.pubsub.v1.StreamingPullResponse.SubscriptionPropertiesB�A�
AcknowledgeConfirmation
ack_ids (	B�A
invalid_ack_ids (	B�A
unordered_ack_ids (	B�A%
temporary_failed_ack_ids (	B�Az
ModifyAckDeadlineConfirmation
ack_ids (	B�A
invalid_ack_ids (	B�A%
temporary_failed_ack_ids (	B�Ak
SubscriptionProperties*
exactly_once_delivery_enabled (B�A%
message_ordering_enabled (B�A"�
CreateSnapshotRequest4
name (	B&�A�A 
pubsub.googleapis.com/Snapshot@
subscription (	B*�A�A$
"pubsub.googleapis.com/SubscriptionH
labels (23.google.pubsub.v1.CreateSnapshotRequest.LabelsEntryB�A-
LabelsEntry
key (	
value (	:8"�
UpdateSnapshotRequest1
snapshot (2.google.pubsub.v1.SnapshotB�A4
update_mask (2.google.protobuf.FieldMaskB�A"�
Snapshot
name (	B�A2
topic (	B#�A�A
pubsub.googleapis.com/Topic4
expire_time (2.google.protobuf.TimestampB�A;
labels (2&.google.pubsub.v1.Snapshot.LabelsEntryB�A-
LabelsEntry
key (	
value (	:8:a�A^
pubsub.googleapis.com/Snapshot\'projects/{project}/snapshots/{snapshot}*	snapshots2snapshot"N
GetSnapshotRequest8
snapshot (	B&�A�A 
pubsub.googleapis.com/Snapshot"�
ListSnapshotsRequestD
project (	B3�A�A-
+cloudresourcemanager.googleapis.com/Project
	page_size (B�A

page_token (	B�A"i
ListSnapshotsResponse2
	snapshots (2.google.pubsub.v1.SnapshotB�A
next_page_token (	B�A"Q
DeleteSnapshotRequest8
snapshot (	B&�A�A 
pubsub.googleapis.com/Snapshot"�
SeekRequest@
subscription (	B*�A�A$
"pubsub.googleapis.com/Subscription/
time (2.google.protobuf.TimestampB�AH :
snapshot (	B&�A�A 
pubsub.googleapis.com/SnapshotH B
target"
SeekResponse2�
	Publisherq
CreateTopic.google.pubsub.v1.Topic.google.pubsub.v1.Topic"0�Aname���#/v1/{name=projects/*/topics/*}:*�
UpdateTopic$.google.pubsub.v1.UpdateTopicRequest.google.pubsub.v1.Topic"C�Atopic,update_mask���)2$/v1/{topic.name=projects/*/topics/*}:*�
Publish .google.pubsub.v1.PublishRequest!.google.pubsub.v1.PublishResponse"C�Atopic,messages���,"\'/v1/{topic=projects/*/topics/*}:publish:*w
GetTopic!.google.pubsub.v1.GetTopicRequest.google.pubsub.v1.Topic"/�Atopic���!/v1/{topic=projects/*/topics/*}�

ListTopics#.google.pubsub.v1.ListTopicsRequest$.google.pubsub.v1.ListTopicsResponse"1�Aproject���!/v1/{project=projects/*}/topics�
ListTopicSubscriptions/.google.pubsub.v1.ListTopicSubscriptionsRequest0.google.pubsub.v1.ListTopicSubscriptionsResponse"=�Atopic���/-/v1/{topic=projects/*/topics/*}/subscriptions�
ListTopicSnapshots+.google.pubsub.v1.ListTopicSnapshotsRequest,.google.pubsub.v1.ListTopicSnapshotsResponse"9�Atopic���+)/v1/{topic=projects/*/topics/*}/snapshots|
DeleteTopic$.google.pubsub.v1.DeleteTopicRequest.google.protobuf.Empty"/�Atopic���!*/v1/{topic=projects/*/topics/*}�
DetachSubscription+.google.pubsub.v1.DetachSubscriptionRequest,.google.pubsub.v1.DetachSubscriptionResponse"<���6"4/v1/{subscription=projects/*/subscriptions/*}:detachp�Apubsub.googleapis.com�AUhttps://www.googleapis.com/auth/cloud-platform,https://www.googleapis.com/auth/pubsub2�

Subscriber�
CreateSubscription.google.pubsub.v1.Subscription.google.pubsub.v1.Subscription"^�A+name,topic,push_config,ack_deadline_seconds���*%/v1/{name=projects/*/subscriptions/*}:*�
GetSubscription(.google.pubsub.v1.GetSubscriptionRequest.google.pubsub.v1.Subscription"D�Asubscription���/-/v1/{subscription=projects/*/subscriptions/*}�
UpdateSubscription+.google.pubsub.v1.UpdateSubscriptionRequest.google.pubsub.v1.Subscription"X�Asubscription,update_mask���722/v1/{subscription.name=projects/*/subscriptions/*}:*�
ListSubscriptions*.google.pubsub.v1.ListSubscriptionsRequest+.google.pubsub.v1.ListSubscriptionsResponse"8�Aproject���(&/v1/{project=projects/*}/subscriptions�
DeleteSubscription+.google.pubsub.v1.DeleteSubscriptionRequest.google.protobuf.Empty"D�Asubscription���/*-/v1/{subscription=projects/*/subscriptions/*}�
ModifyAckDeadline*.google.pubsub.v1.ModifyAckDeadlineRequest.google.protobuf.Empty"v�A)subscription,ack_ids,ack_deadline_seconds���D"?/v1/{subscription=projects/*/subscriptions/*}:modifyAckDeadline:*�
Acknowledge$.google.pubsub.v1.AcknowledgeRequest.google.protobuf.Empty"[�Asubscription,ack_ids���>"9/v1/{subscription=projects/*/subscriptions/*}:acknowledge:*�
Pull.google.pubsub.v1.PullRequest.google.pubsub.v1.PullResponse"��A,subscription,return_immediately,max_messages�Asubscription,max_messages���7"2/v1/{subscription=projects/*/subscriptions/*}:pull:*f
StreamingPull&.google.pubsub.v1.StreamingPullRequest\'.google.pubsub.v1.StreamingPullResponse" (0�
ModifyPushConfig).google.pubsub.v1.ModifyPushConfigRequest.google.protobuf.Empty"d�Asubscription,push_config���C">/v1/{subscription=projects/*/subscriptions/*}:modifyPushConfig:*�
GetSnapshot$.google.pubsub.v1.GetSnapshotRequest.google.pubsub.v1.Snapshot"8�Asnapshot���\'%/v1/{snapshot=projects/*/snapshots/*}�
ListSnapshots&.google.pubsub.v1.ListSnapshotsRequest\'.google.pubsub.v1.ListSnapshotsResponse"4�Aproject���$"/v1/{project=projects/*}/snapshots�
CreateSnapshot\'.google.pubsub.v1.CreateSnapshotRequest.google.pubsub.v1.Snapshot"@�Aname,subscription���&!/v1/{name=projects/*/snapshots/*}:*�
UpdateSnapshot\'.google.pubsub.v1.UpdateSnapshotRequest.google.pubsub.v1.Snapshot"L�Asnapshot,update_mask���/2*/v1/{snapshot.name=projects/*/snapshots/*}:*�
DeleteSnapshot\'.google.pubsub.v1.DeleteSnapshotRequest.google.protobuf.Empty"8�Asnapshot���\'*%/v1/{snapshot=projects/*/snapshots/*}�
Seek.google.pubsub.v1.SeekRequest.google.pubsub.v1.SeekResponse"=���7"2/v1/{subscription=projects/*/subscriptions/*}:seek:*p�Apubsub.googleapis.com�AUhttps://www.googleapis.com/auth/cloud-platform,https://www.googleapis.com/auth/pubsubB�
com.google.pubsub.v1BPubsubProtoPZ5cloud.google.com/go/pubsub/v2/apiv1/pubsubpb;pubsubpb�Google.Cloud.PubSub.V1�Google\\Cloud\\PubSub\\V1�Google::Cloud::PubSub::V1bproto3'
        , true);

        static::$is_initialized = true;
    }
}

