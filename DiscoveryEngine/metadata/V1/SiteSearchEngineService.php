<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/discoveryengine/v1/site_search_engine_service.proto

namespace GPBMetadata\Google\Cloud\Discoveryengine\V1;

class SiteSearchEngineService
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
        \GPBMetadata\Google\Cloud\Discoveryengine\V1\SiteSearchEngine::initOnce();
        \GPBMetadata\Google\Longrunning\Operations::initOnce();
        \GPBMetadata\Google\Protobuf\GPBEmpty::initOnce();
        \GPBMetadata\Google\Protobuf\Timestamp::initOnce();
        $pool->internalAddGeneratedFile(
            '
�Z
@google/cloud/discoveryengine/v1/site_search_engine_service.protogoogle.cloud.discoveryengine.v1google/api/client.protogoogle/api/field_behavior.protogoogle/api/resource.proto8google/cloud/discoveryengine/v1/site_search_engine.proto#google/longrunning/operations.protogoogle/protobuf/empty.protogoogle/protobuf/timestamp.proto"c
GetSiteSearchEngineRequestE
name (	B7�A�A1
/discoveryengine.googleapis.com/SiteSearchEngine"�
CreateTargetSiteRequestG
parent (	B7�A�A1
/discoveryengine.googleapis.com/SiteSearchEngineE
target_site (2+.google.cloud.discoveryengine.v1.TargetSiteB�A"|
CreateTargetSiteMetadata/
create_time (2.google.protobuf.Timestamp/
update_time (2.google.protobuf.Timestamp"�
BatchCreateTargetSitesRequestG
parent (	B7�A�A1
/discoveryengine.googleapis.com/SiteSearchEngineO
requests (28.google.cloud.discoveryengine.v1.CreateTargetSiteRequestB�A"W
GetTargetSiteRequest?
name (	B1�A�A+
)discoveryengine.googleapis.com/TargetSite"`
UpdateTargetSiteRequestE
target_site (2+.google.cloud.discoveryengine.v1.TargetSiteB�A"|
UpdateTargetSiteMetadata/
create_time (2.google.protobuf.Timestamp/
update_time (2.google.protobuf.Timestamp"Z
DeleteTargetSiteRequest?
name (	B1�A�A+
)discoveryengine.googleapis.com/TargetSite"|
DeleteTargetSiteMetadata/
create_time (2.google.protobuf.Timestamp/
update_time (2.google.protobuf.Timestamp"�
ListTargetSitesRequestG
parent (	B7�A�A1
/discoveryengine.googleapis.com/SiteSearchEngine
	page_size (

page_token (	"�
ListTargetSitesResponseA
target_sites (2+.google.cloud.discoveryengine.v1.TargetSite
next_page_token (	

total_size ("�
BatchCreateTargetSiteMetadata/
create_time (2.google.protobuf.Timestamp/
update_time (2.google.protobuf.Timestamp"c
BatchCreateTargetSitesResponseA
target_sites (2+.google.cloud.discoveryengine.v1.TargetSite"�
CreateSitemapRequestG
parent (	B7�A�A1
/discoveryengine.googleapis.com/SiteSearchEngine>
sitemap (2(.google.cloud.discoveryengine.v1.SitemapB�A"T
DeleteSitemapRequest<
name (	B.�A�A(
&discoveryengine.googleapis.com/Sitemap"�
FetchSitemapsRequestG
parent (	B7�A�A1
/discoveryengine.googleapis.com/SiteSearchEngineS
matcher (2=.google.cloud.discoveryengine.v1.FetchSitemapsRequest.MatcherB�A
UrisMatcher
uris (	o
MatcherY
uris_matcher (2A.google.cloud.discoveryengine.v1.FetchSitemapsRequest.UrisMatcherH B	
matcher"y
CreateSitemapMetadata/
create_time (2.google.protobuf.Timestamp/
update_time (2.google.protobuf.Timestamp"y
DeleteSitemapMetadata/
create_time (2.google.protobuf.Timestamp/
update_time (2.google.protobuf.Timestamp"�
FetchSitemapsResponsea
sitemaps_metadata (2F.google.cloud.discoveryengine.v1.FetchSitemapsResponse.SitemapMetadataL
SitemapMetadata9
sitemap (2(.google.cloud.discoveryengine.v1.Sitemap"v
EnableAdvancedSiteSearchRequestS
site_search_engine (	B7�A�A1
/discoveryengine.googleapis.com/SiteSearchEngine""
 EnableAdvancedSiteSearchResponse"�
 EnableAdvancedSiteSearchMetadata/
create_time (2.google.protobuf.Timestamp/
update_time (2.google.protobuf.Timestamp"w
 DisableAdvancedSiteSearchRequestS
site_search_engine (	B7�A�A1
/discoveryengine.googleapis.com/SiteSearchEngine"#
!DisableAdvancedSiteSearchResponse"�
!DisableAdvancedSiteSearchMetadata/
create_time (2.google.protobuf.Timestamp/
update_time (2.google.protobuf.Timestamp"�
RecrawlUrisRequestS
site_search_engine (	B7�A�A1
/discoveryengine.googleapis.com/SiteSearchEngine
uris (	B�A
site_credential (	B�A"�
RecrawlUrisResponseY
failure_samples (2@.google.cloud.discoveryengine.v1.RecrawlUrisResponse.FailureInfo
failed_uris (	�
FailureInfo
uri (	g
failure_reasons (2N.google.cloud.discoveryengine.v1.RecrawlUrisResponse.FailureInfo.FailureReason�
FailureReasonn
corpus_type (2Y.google.cloud.discoveryengine.v1.RecrawlUrisResponse.FailureInfo.FailureReason.CorpusType
error_message (	"B

CorpusType
CORPUS_TYPE_UNSPECIFIED 
DESKTOP

MOBILE"�
RecrawlUrisMetadata/
create_time (2.google.protobuf.Timestamp/
update_time (2.google.protobuf.Timestamp
invalid_uris (	
invalid_uris_count (
noindex_uris (	
noindex_uris_count (&
uris_not_matching_target_sites	 (	,
$uris_not_matching_target_sites_count
 (
valid_uris_count (
success_count (
pending_count (
quota_exceeded_count ("h
BatchVerifyTargetSitesRequestG
parent (	B7�A�A1
/discoveryengine.googleapis.com/SiteSearchEngine" 
BatchVerifyTargetSitesResponse"�
BatchVerifyTargetSitesMetadata/
create_time (2.google.protobuf.Timestamp/
update_time (2.google.protobuf.Timestamp"�
$FetchDomainVerificationStatusRequestS
site_search_engine (	B7�A�A1
/discoveryengine.googleapis.com/SiteSearchEngine
	page_size (

page_token (	"�
%FetchDomainVerificationStatusResponseA
target_sites (2+.google.cloud.discoveryengine.v1.TargetSite
next_page_token (	

total_size (2�/
SiteSearchEngineService�
GetSiteSearchEngine;.google.cloud.discoveryengine.v1.GetSiteSearchEngineRequest1.google.cloud.discoveryengine.v1.SiteSearchEngine"��Aname����?/v1/{name=projects/*/locations/*/dataStores/*/siteSearchEngine}ZOM/v1/{name=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine}�
CreateTargetSite8.google.cloud.discoveryengine.v1.CreateTargetSiteRequest.google.longrunning.Operation"��Af
*google.cloud.discoveryengine.v1.TargetSite8google.cloud.discoveryengine.v1.CreateTargetSiteMetadata�Aparent,target_site����"M/v1/{parent=projects/*/locations/*/dataStores/*/siteSearchEngine}/targetSites:target_siteZj"[/v1/{parent=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine}/targetSites:target_site�
BatchCreateTargetSites>.google.cloud.discoveryengine.v1.BatchCreateTargetSitesRequest.google.longrunning.Operation"��A
>google.cloud.discoveryengine.v1.BatchCreateTargetSitesResponse=google.cloud.discoveryengine.v1.BatchCreateTargetSiteMetadata����"Y/v1/{parent=projects/*/locations/*/dataStores/*/siteSearchEngine}/targetSites:batchCreate:*Zl"g/v1/{parent=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine}/targetSites:batchCreate:*�
GetTargetSite5.google.cloud.discoveryengine.v1.GetTargetSiteRequest+.google.cloud.discoveryengine.v1.TargetSite"��Aname����M/v1/{name=projects/*/locations/*/dataStores/*/siteSearchEngine/targetSites/*}Z][/v1/{name=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine/targetSites/*}�
UpdateTargetSite8.google.cloud.discoveryengine.v1.UpdateTargetSiteRequest.google.longrunning.Operation"��Af
*google.cloud.discoveryengine.v1.TargetSite8google.cloud.discoveryengine.v1.UpdateTargetSiteMetadata�Atarget_site����2Y/v1/{target_site.name=projects/*/locations/*/dataStores/*/siteSearchEngine/targetSites/*}:target_siteZv2g/v1/{target_site.name=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine/targetSites/*}:target_site�
DeleteTargetSite8.google.cloud.discoveryengine.v1.DeleteTargetSiteRequest.google.longrunning.Operation"��AQ
google.protobuf.Empty8google.cloud.discoveryengine.v1.DeleteTargetSiteMetadata�Aname����*M/v1/{name=projects/*/locations/*/dataStores/*/siteSearchEngine/targetSites/*}Z]*[/v1/{name=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine/targetSites/*}�
ListTargetSites7.google.cloud.discoveryengine.v1.ListTargetSitesRequest8.google.cloud.discoveryengine.v1.ListTargetSitesResponse"��Aparent����M/v1/{parent=projects/*/locations/*/dataStores/*/siteSearchEngine}/targetSitesZ][/v1/{parent=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine}/targetSites�
CreateSitemap5.google.cloud.discoveryengine.v1.CreateSitemapRequest.google.longrunning.Operation"��A`
\'google.cloud.discoveryengine.v1.Sitemap5google.cloud.discoveryengine.v1.CreateSitemapMetadata�Aparent,sitemap����"J/v1/{parent=projects/*/locations/*/dataStores/*/siteSearchEngine}/sitemaps:sitemapZc"X/v1/{parent=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine}/sitemaps:sitemap�
DeleteSitemap5.google.cloud.discoveryengine.v1.DeleteSitemapRequest.google.longrunning.Operation"��AN
google.protobuf.Empty5google.cloud.discoveryengine.v1.DeleteSitemapMetadata�Aname����*J/v1/{name=projects/*/locations/*/dataStores/*/siteSearchEngine/sitemaps/*}ZZ*X/v1/{name=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine/sitemaps/*}�
FetchSitemaps5.google.cloud.discoveryengine.v1.FetchSitemapsRequest6.google.cloud.discoveryengine.v1.FetchSitemapsResponse"��Aparent����P/v1/{parent=projects/*/locations/*/dataStores/*/siteSearchEngine}/sitemaps:fetchZ`^/v1/{parent=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine}/sitemaps:fetch�
EnableAdvancedSiteSearch@.google.cloud.discoveryengine.v1.EnableAdvancedSiteSearchRequest.google.longrunning.Operation"��A�
@google.cloud.discoveryengine.v1.EnableAdvancedSiteSearchResponse@google.cloud.discoveryengine.v1.EnableAdvancedSiteSearchMetadata����"f/v1/{site_search_engine=projects/*/locations/*/dataStores/*/siteSearchEngine}:enableAdvancedSiteSearch:*Zy"t/v1/{site_search_engine=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine}:enableAdvancedSiteSearch:*�
DisableAdvancedSiteSearchA.google.cloud.discoveryengine.v1.DisableAdvancedSiteSearchRequest.google.longrunning.Operation"��A�
Agoogle.cloud.discoveryengine.v1.DisableAdvancedSiteSearchResponseAgoogle.cloud.discoveryengine.v1.DisableAdvancedSiteSearchMetadata����"g/v1/{site_search_engine=projects/*/locations/*/dataStores/*/siteSearchEngine}:disableAdvancedSiteSearch:*Zz"u/v1/{site_search_engine=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine}:disableAdvancedSiteSearch:*�
RecrawlUris3.google.cloud.discoveryengine.v1.RecrawlUrisRequest.google.longrunning.Operation"��Aj
3google.cloud.discoveryengine.v1.RecrawlUrisResponse3google.cloud.discoveryengine.v1.RecrawlUrisMetadata����"Y/v1/{site_search_engine=projects/*/locations/*/dataStores/*/siteSearchEngine}:recrawlUris:*Zl"g/v1/{site_search_engine=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine}:recrawlUris:*�
BatchVerifyTargetSites>.google.cloud.discoveryengine.v1.BatchVerifyTargetSitesRequest.google.longrunning.Operation"��A�
>google.cloud.discoveryengine.v1.BatchVerifyTargetSitesResponse>google.cloud.discoveryengine.v1.BatchVerifyTargetSitesMetadata���k"f/v1/{parent=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine}:batchVerifyTargetSites:*�
FetchDomainVerificationStatusE.google.cloud.discoveryengine.v1.FetchDomainVerificationStatusRequestF.google.cloud.discoveryengine.v1.FetchDomainVerificationStatusResponse"����{y/v1/{site_search_engine=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine}:fetchDomainVerificationStatusR�Adiscoveryengine.googleapis.com�A.https://www.googleapis.com/auth/cloud-platformB�
#com.google.cloud.discoveryengine.v1BSiteSearchEngineServiceProtoPZMcloud.google.com/go/discoveryengine/apiv1/discoveryenginepb;discoveryenginepb�DISCOVERYENGINE�Google.Cloud.DiscoveryEngine.V1�Google\\Cloud\\DiscoveryEngine\\V1�"Google::Cloud::DiscoveryEngine::V1bproto3'
        , true);

        static::$is_initialized = true;
    }
}

