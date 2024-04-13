<?php
/*
 * Copyright 2024 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was automatically generated - do not edit!
 */

return [
    'interfaces' => [
        'google.cloud.discoveryengine.v1.SiteSearchEngineService' => [
            'BatchCreateTargetSites' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\DiscoveryEngine\V1\BatchCreateTargetSitesResponse',
                    'metadataReturnType' => '\Google\Cloud\DiscoveryEngine\V1\BatchCreateTargetSiteMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchVerifyTargetSites' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\DiscoveryEngine\V1\BatchVerifyTargetSitesResponse',
                    'metadataReturnType' => '\Google\Cloud\DiscoveryEngine\V1\BatchVerifyTargetSitesMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateTargetSite' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\DiscoveryEngine\V1\TargetSite',
                    'metadataReturnType' => '\Google\Cloud\DiscoveryEngine\V1\CreateTargetSiteMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteTargetSite' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\DiscoveryEngine\V1\DeleteTargetSiteMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DisableAdvancedSiteSearch' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\DiscoveryEngine\V1\DisableAdvancedSiteSearchResponse',
                    'metadataReturnType' => '\Google\Cloud\DiscoveryEngine\V1\DisableAdvancedSiteSearchMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'site_search_engine',
                        'fieldAccessors' => [
                            'getSiteSearchEngine',
                        ],
                    ],
                ],
            ],
            'EnableAdvancedSiteSearch' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\DiscoveryEngine\V1\EnableAdvancedSiteSearchResponse',
                    'metadataReturnType' => '\Google\Cloud\DiscoveryEngine\V1\EnableAdvancedSiteSearchMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'site_search_engine',
                        'fieldAccessors' => [
                            'getSiteSearchEngine',
                        ],
                    ],
                ],
            ],
            'RecrawlUris' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\DiscoveryEngine\V1\RecrawlUrisResponse',
                    'metadataReturnType' => '\Google\Cloud\DiscoveryEngine\V1\RecrawlUrisMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'site_search_engine',
                        'fieldAccessors' => [
                            'getSiteSearchEngine',
                        ],
                    ],
                ],
            ],
            'UpdateTargetSite' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\DiscoveryEngine\V1\TargetSite',
                    'metadataReturnType' => '\Google\Cloud\DiscoveryEngine\V1\UpdateTargetSiteMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'target_site.name',
                        'fieldAccessors' => [
                            'getTargetSite',
                            'getName',
                        ],
                    ],
                ],
            ],
            'FetchDomainVerificationStatus' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getTargetSites',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\DiscoveryEngine\V1\FetchDomainVerificationStatusResponse',
                'headerParams' => [
                    [
                        'keyName' => 'site_search_engine',
                        'fieldAccessors' => [
                            'getSiteSearchEngine',
                        ],
                    ],
                ],
            ],
            'GetSiteSearchEngine' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\DiscoveryEngine\V1\SiteSearchEngine',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetTargetSite' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\DiscoveryEngine\V1\TargetSite',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListTargetSites' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getTargetSites',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\DiscoveryEngine\V1\ListTargetSitesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'projectLocationCollectionDataStoreSiteSearchEngine' => 'projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}/siteSearchEngine',
                'projectLocationCollectionDataStoreTargetSite' => 'projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}/siteSearchEngine/targetSites/{target_site}',
                'projectLocationDataStoreSiteSearchEngine' => 'projects/{project}/locations/{location}/dataStores/{data_store}/siteSearchEngine',
                'projectLocationDataStoreTargetSite' => 'projects/{project}/locations/{location}/dataStores/{data_store}/siteSearchEngine/targetSites/{target_site}',
                'siteSearchEngine' => 'projects/{project}/locations/{location}/dataStores/{data_store}/siteSearchEngine',
                'targetSite' => 'projects/{project}/locations/{location}/dataStores/{data_store}/siteSearchEngine/targetSites/{target_site}',
            ],
        ],
    ],
];
