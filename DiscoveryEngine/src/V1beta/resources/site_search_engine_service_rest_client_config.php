<?php

return [
    'interfaces' => [
        'google.cloud.discoveryengine.v1beta.SiteSearchEngineService' => [
            'BatchCreateTargetSites' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{parent=projects/*/locations/*/dataStores/*/siteSearchEngine}/targetSites:batchCreate',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta/{parent=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine}/targetSites:batchCreate',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchVerifyTargetSites' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{parent=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine}:batchVerifyTargetSites',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateTargetSite' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{parent=projects/*/locations/*/dataStores/*/siteSearchEngine}/targetSites',
                'body' => 'target_site',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta/{parent=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine}/targetSites',
                        'body' => 'target_site',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteTargetSite' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta/{name=projects/*/locations/*/dataStores/*/siteSearchEngine/targetSites/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine/targetSites/*}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DisableAdvancedSiteSearch' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{site_search_engine=projects/*/locations/*/dataStores/*/siteSearchEngine}:disableAdvancedSiteSearch',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta/{site_search_engine=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine}:disableAdvancedSiteSearch',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'site_search_engine' => [
                        'getters' => [
                            'getSiteSearchEngine',
                        ],
                    ],
                ],
            ],
            'EnableAdvancedSiteSearch' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{site_search_engine=projects/*/locations/*/dataStores/*/siteSearchEngine}:enableAdvancedSiteSearch',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta/{site_search_engine=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine}:enableAdvancedSiteSearch',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'site_search_engine' => [
                        'getters' => [
                            'getSiteSearchEngine',
                        ],
                    ],
                ],
            ],
            'FetchDomainVerificationStatus' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{site_search_engine=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine}:fetchDomainVerificationStatus',
                'placeholders' => [
                    'site_search_engine' => [
                        'getters' => [
                            'getSiteSearchEngine',
                        ],
                    ],
                ],
            ],
            'GetSiteSearchEngine' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{name=projects/*/locations/*/dataStores/*/siteSearchEngine}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetTargetSite' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{name=projects/*/locations/*/dataStores/*/siteSearchEngine/targetSites/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine/targetSites/*}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListTargetSites' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{parent=projects/*/locations/*/dataStores/*/siteSearchEngine}/targetSites',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{parent=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine}/targetSites',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RecrawlUris' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{site_search_engine=projects/*/locations/*/dataStores/*/siteSearchEngine}:recrawlUris',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta/{site_search_engine=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine}:recrawlUris',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'site_search_engine' => [
                        'getters' => [
                            'getSiteSearchEngine',
                        ],
                    ],
                ],
            ],
            'UpdateTargetSite' => [
                'method' => 'patch',
                'uriTemplate' => '/v1beta/{target_site.name=projects/*/locations/*/dataStores/*/siteSearchEngine/targetSites/*}',
                'body' => 'target_site',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1beta/{target_site.name=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine/targetSites/*}',
                        'body' => 'target_site',
                    ],
                ],
                'placeholders' => [
                    'target_site.name' => [
                        'getters' => [
                            'getTargetSite',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataConnector/operations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataStores/*/branches/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataStores/*/models/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataStores/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataStores/*/schemas/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine/targetSites/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/engines/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/dataStores/*/branches/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/dataStores/*/models/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/dataStores/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/operations/*}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataConnector}/operations',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataStores/*/branches/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataStores/*/models/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataStores/*/schemas/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine/targetSites}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/dataStores/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*/engines/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/collections/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/dataStores/*/branches/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/dataStores/*/models/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*/dataStores/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*/locations/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta/{name=projects/*}/operations',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
