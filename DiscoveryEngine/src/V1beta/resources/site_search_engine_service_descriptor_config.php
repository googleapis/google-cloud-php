<?php

return [
    'interfaces' => [
        'google.cloud.discoveryengine.v1beta.SiteSearchEngineService' => [
            'BatchCreateTargetSites' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\DiscoveryEngine\V1beta\BatchCreateTargetSitesResponse',
                    'metadataReturnType' => '\Google\Cloud\DiscoveryEngine\V1beta\BatchCreateTargetSiteMetadata',
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
                    'operationReturnType' => '\Google\Cloud\DiscoveryEngine\V1beta\BatchVerifyTargetSitesResponse',
                    'metadataReturnType' => '\Google\Cloud\DiscoveryEngine\V1beta\BatchVerifyTargetSitesMetadata',
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
                    'operationReturnType' => '\Google\Cloud\DiscoveryEngine\V1beta\TargetSite',
                    'metadataReturnType' => '\Google\Cloud\DiscoveryEngine\V1beta\CreateTargetSiteMetadata',
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
                    'metadataReturnType' => '\Google\Cloud\DiscoveryEngine\V1beta\DeleteTargetSiteMetadata',
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
                    'operationReturnType' => '\Google\Cloud\DiscoveryEngine\V1beta\DisableAdvancedSiteSearchResponse',
                    'metadataReturnType' => '\Google\Cloud\DiscoveryEngine\V1beta\DisableAdvancedSiteSearchMetadata',
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
                    'operationReturnType' => '\Google\Cloud\DiscoveryEngine\V1beta\EnableAdvancedSiteSearchResponse',
                    'metadataReturnType' => '\Google\Cloud\DiscoveryEngine\V1beta\EnableAdvancedSiteSearchMetadata',
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
                    'operationReturnType' => '\Google\Cloud\DiscoveryEngine\V1beta\RecrawlUrisResponse',
                    'metadataReturnType' => '\Google\Cloud\DiscoveryEngine\V1beta\RecrawlUrisMetadata',
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
                    'operationReturnType' => '\Google\Cloud\DiscoveryEngine\V1beta\TargetSite',
                    'metadataReturnType' => '\Google\Cloud\DiscoveryEngine\V1beta\UpdateTargetSiteMetadata',
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
                'responseType' => 'Google\Cloud\DiscoveryEngine\V1beta\FetchDomainVerificationStatusResponse',
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
                'responseType' => 'Google\Cloud\DiscoveryEngine\V1beta\SiteSearchEngine',
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
                'responseType' => 'Google\Cloud\DiscoveryEngine\V1beta\TargetSite',
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
                'responseType' => 'Google\Cloud\DiscoveryEngine\V1beta\ListTargetSitesResponse',
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
