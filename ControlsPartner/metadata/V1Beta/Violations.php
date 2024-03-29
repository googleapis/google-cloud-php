<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/cloudcontrolspartner/v1beta/violations.proto

namespace GPBMetadata\Google\Cloud\Cloudcontrolspartner\V1Beta;

class Violations
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Api\FieldBehavior::initOnce();
        \GPBMetadata\Google\Api\Resource::initOnce();
        \GPBMetadata\Google\Protobuf\Timestamp::initOnce();
        \GPBMetadata\Google\Type\Interval::initOnce();
        $pool->internalAddGeneratedFile(
            '
�
9google/cloud/cloudcontrolspartner/v1beta/violations.proto(google.cloud.cloudcontrolspartner.v1betagoogle/api/resource.protogoogle/protobuf/timestamp.protogoogle/type/interval.proto"�
	Violation
name (	B�A
description (	B�A3

begin_time (2.google.protobuf.TimestampB�A4
update_time (2.google.protobuf.TimestampB�A5
resolve_time (2.google.protobuf.TimestampB�A
category (	B�AM
state (29.google.cloud.cloudcontrolspartner.v1beta.Violation.StateB�A(
non_compliant_org_policy (	B�A�A
	folder_id	 (Y
remediation (2?.google.cloud.cloudcontrolspartner.v1beta.Violation.RemediationB�A�
Remediationg
instructions (2L.google.cloud.cloudcontrolspartner.v1beta.Violation.Remediation.InstructionsB�A
compliant_values (	n
remediation_type (2O.google.cloud.cloudcontrolspartner.v1beta.Violation.Remediation.RemediationTypeB�A�
Instructionsp
gcloud_instructions (2S.google.cloud.cloudcontrolspartner.v1beta.Violation.Remediation.Instructions.Gcloudr
console_instructions (2T.google.cloud.cloudcontrolspartner.v1beta.Violation.Remediation.Instructions.ConsoleJ
Gcloud
gcloud_commands (	
steps (	
additional_links (	H
Console
console_uris (	
steps (	
additional_links (	"�
RemediationType 
REMEDIATION_TYPE_UNSPECIFIED ,
(REMEDIATION_BOOLEAN_ORG_POLICY_VIOLATION8
4REMEDIATION_LIST_ALLOWED_VALUES_ORG_POLICY_VIOLATION7
3REMEDIATION_LIST_DENIED_VALUES_ORG_POLICY_VIOLATIONF
BREMEDIATION_RESTRICT_CMEK_CRYPTO_KEY_PROJECTS_ORG_POLICY_VIOLATION"
REMEDIATION_RESOURCE_VIOLATION"K
State
STATE_UNSPECIFIED 
RESOLVED

UNRESOLVED
	EXCEPTION:��A�
-cloudcontrolspartner.googleapis.com/Violationrorganizations/{organization}/locations/{location}/customers/{customer}/workloads/{workload}/violations/{violation}*
violations2	violation"�
ListViolationsRequestE
parent (	B5�A�A/-cloudcontrolspartner.googleapis.com/Violation
	page_size (B�A

page_token (	B�A
filter (	B�A
order_by (	B�A,
interval (2.google.type.IntervalB�A"�
ListViolationsResponseG

violations (23.google.cloud.cloudcontrolspartner.v1beta.Violation
next_page_token (	
unreachable (	"Z
GetViolationRequestC
name (	B5�A�A/
-cloudcontrolspartner.googleapis.com/ViolationB�
,com.google.cloud.cloudcontrolspartner.v1betaBViolationsProtoPZ`cloud.google.com/go/cloudcontrolspartner/apiv1beta/cloudcontrolspartnerpb;cloudcontrolspartnerpb�(Google.Cloud.CloudControlsPartner.V1Beta�(Google\\Cloud\\CloudControlsPartner\\V1beta�+Google::Cloud::CloudControlsPartner::V1betabproto3'
        , true);

        static::$is_initialized = true;
    }
}

