<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/discoveryengine/v1/serving_config.proto

namespace GPBMetadata\Google\Cloud\Discoveryengine\V1;

class ServingConfig
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Google\Api\FieldBehavior::initOnce();
        \GPBMetadata\Google\Api\Resource::initOnce();
        \GPBMetadata\Google\Cloud\Discoveryengine\V1\Common::initOnce();
        \GPBMetadata\Google\Cloud\Discoveryengine\V1\SearchService::initOnce();
        \GPBMetadata\Google\Protobuf\Timestamp::initOnce();
        $pool->internalAddGeneratedFile(
            '
�
4google/cloud/discoveryengine/v1/serving_config.protogoogle.cloud.discoveryengine.v1google/api/resource.proto,google/cloud/discoveryengine/v1/common.proto4google/cloud/discoveryengine/v1/search_service.protogoogle/protobuf/timestamp.proto"�
ServingConfigR
media_config (2:.google.cloud.discoveryengine.v1.ServingConfig.MediaConfigH V
generic_config
 (2<.google.cloud.discoveryengine.v1.ServingConfig.GenericConfigH 
name (	B�A
display_name (	B�AL
solution_type (2-.google.cloud.discoveryengine.v1.SolutionTypeB�A�A
model_id (	
diversity_level (	
ranking_expression (	4
create_time (2.google.protobuf.TimestampB�A4
update_time	 (2.google.protobuf.TimestampB�A
filter_control_ids (	
boost_control_ids (	
redirect_control_ids (	
synonyms_control_ids (	#
oneway_synonyms_control_ids (	
dissociate_control_ids (	
replacement_control_ids (	
ignore_control_ids (	
promote_control_ids (	�
MediaConfig.
$content_watched_percentage_threshold (H +
!content_watched_seconds_threshold (H 
demotion_event_type (	-
 demote_content_watched_past_days% (B�A%
content_freshness_cutoff_days (B
demote_content_watchedn
GenericConfig]
content_search_spec (2@.google.cloud.discoveryengine.v1.SearchRequest.ContentSearchSpec:��A�
,discoveryengine.googleapis.com/ServingConfig_projects/{project}/locations/{location}/dataStores/{data_store}/servingConfigs/{serving_config}xprojects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}/servingConfigs/{serving_config}qprojects/{project}/locations/{location}/collections/{collection}/engines/{engine}/servingConfigs/{serving_config}B
vertical_configB�
#com.google.cloud.discoveryengine.v1BServingConfigProtoPZMcloud.google.com/go/discoveryengine/apiv1/discoveryenginepb;discoveryenginepb�DISCOVERYENGINE�Google.Cloud.DiscoveryEngine.V1�Google\\Cloud\\DiscoveryEngine\\V1�"Google::Cloud::DiscoveryEngine::V1bproto3'
        , true);

        static::$is_initialized = true;
    }
}

