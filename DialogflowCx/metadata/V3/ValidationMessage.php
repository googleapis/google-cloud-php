<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/dialogflow/cx/v3/validation_message.proto

namespace GPBMetadata\Google\Cloud\Dialogflow\Cx\V3;

class ValidationMessage
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        $pool->internalAddGeneratedFile(
            '
�
6google/cloud/dialogflow/cx/v3/validation_message.protogoogle.cloud.dialogflow.cx.v3"�
ValidationMessageT
resource_type (2=.google.cloud.dialogflow.cx.v3.ValidationMessage.ResourceType
	resources (	BC
resource_names (2+.google.cloud.dialogflow.cx.v3.ResourceNameK
severity (29.google.cloud.dialogflow.cx.v3.ValidationMessage.Severity
detail (	"�
ResourceType
RESOURCE_TYPE_UNSPECIFIED 	
AGENT

INTENT
INTENT_TRAINING_PHRASE
INTENT_PARAMETER	
INTENTS

INTENT_TRAINING_PHRASES
ENTITY_TYPE
ENTITY_TYPES
WEBHOOK
FLOW
PAGE	
PAGES
TRANSITION_ROUTE_GROUP 
AGENT_TRANSITION_ROUTE_GROUP"F
Severity
SEVERITY_UNSPECIFIED 
INFO
WARNING	
ERROR"2
ResourceName
name (	
display_name (	B�
!com.google.cloud.dialogflow.cx.v3BValidationMessageProtoPZ1cloud.google.com/go/dialogflow/cx/apiv3/cxpb;cxpb�DF�Google.Cloud.Dialogflow.Cx.V3�!Google::Cloud::Dialogflow::CX::V3bproto3'
        , true);

        static::$is_initialized = true;
    }
}

