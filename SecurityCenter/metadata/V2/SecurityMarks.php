<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/securitycenter/v2/security_marks.proto

namespace GPBMetadata\Google\Cloud\Securitycenter\V2;

class SecurityMarks
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Api\Resource::initOnce();
        $pool->internalAddGeneratedFile(
            '
�	
3google/cloud/securitycenter/v2/security_marks.protogoogle.cloud.securitycenter.v2"�
SecurityMarks
name (	G
marks (28.google.cloud.securitycenter.v2.SecurityMarks.MarksEntry
canonical_name (	,

MarksEntry
key (	
value (	:8:��A�
+securitycenter.googleapis.com/SecurityMarks9organizations/{organization}/assets/{asset}/securityMarksNorganizations/{organization}/sources/{source}/findings/{finding}/securityMarkscorganizations/{organization}/sources/{source}/locations/{location}/findings/{finding}/securityMarks-folders/{folder}/assets/{asset}/securityMarksBfolders/{folder}/sources/{source}/findings/{finding}/securityMarksWfolders/{folder}/sources/{source}/locations/{location}/findings/{finding}/securityMarks/projects/{project}/assets/{asset}/securityMarksDprojects/{project}/sources/{source}/findings/{finding}/securityMarksYprojects/{project}/sources/{source}/locations/{location}/findings/{finding}/securityMarksB�
"com.google.cloud.securitycenter.v2BSecurityMarksProtoPZJcloud.google.com/go/securitycenter/apiv2/securitycenterpb;securitycenterpb�Google.Cloud.SecurityCenter.V2�Google\\Cloud\\SecurityCenter\\V2�!Google::Cloud::SecurityCenter::V2bproto3'
        , true);

        static::$is_initialized = true;
    }
}

