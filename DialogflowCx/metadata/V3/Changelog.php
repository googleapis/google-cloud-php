<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/dialogflow/cx/v3/changelog.proto

namespace GPBMetadata\Google\Cloud\Dialogflow\Cx\V3;

class Changelog
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
        \GPBMetadata\Google\Protobuf\Timestamp::initOnce();
        $pool->internalAddGeneratedFile(
            '
�
-google/cloud/dialogflow/cx/v3/changelog.protogoogle.cloud.dialogflow.cx.v3google/api/client.protogoogle/api/field_behavior.protogoogle/api/resource.protogoogle/protobuf/timestamp.proto"�
ListChangelogsRequest;
parent (	B+�A�A%#dialogflow.googleapis.com/Changelog
filter (	
	page_size (

page_token (	"o
ListChangelogsResponse<

changelogs (2(.google.cloud.dialogflow.cx.v3.Changelog
next_page_token (	"P
GetChangelogRequest9
name (	B+�A�A%
#dialogflow.googleapis.com/Changelog"�
	Changelog
name (	

user_email (	
display_name (	
action (	
type (	
resource (	/
create_time (2.google.protobuf.Timestamp
language_code (	:w�At
#dialogflow.googleapis.com/ChangelogMprojects/{project}/locations/{location}/agents/{agent}/changelogs/{changelog}2�

Changelogs�
ListChangelogs4.google.cloud.dialogflow.cx.v3.ListChangelogsRequest5.google.cloud.dialogflow.cx.v3.ListChangelogsResponse"H�Aparent���97/v3/{parent=projects/*/locations/*/agents/*}/changelogs�
GetChangelog2.google.cloud.dialogflow.cx.v3.GetChangelogRequest(.google.cloud.dialogflow.cx.v3.Changelog"F�Aname���97/v3/{name=projects/*/locations/*/agents/*/changelogs/*}x�Adialogflow.googleapis.com�AYhttps://www.googleapis.com/auth/cloud-platform,https://www.googleapis.com/auth/dialogflowB�
!com.google.cloud.dialogflow.cx.v3BChangelogProtoPZ1cloud.google.com/go/dialogflow/cx/apiv3/cxpb;cxpb�DF�Google.Cloud.Dialogflow.Cx.V3�!Google::Cloud::Dialogflow::CX::V3bproto3'
        , true);

        static::$is_initialized = true;
    }
}

