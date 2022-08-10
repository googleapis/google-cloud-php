<?php

return [
    'interfaces' => [
        'google.cloud.asset.v1.AssetService' => [
            'AnalyzeIamPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{analysis_query.scope=*/*}:analyzeIamPolicy',
                'placeholders' => [
                    'analysis_query.scope' => [
                        'getters' => [
                            'getAnalysisQuery',
                            'getScope',
                        ],
                    ],
                ],
            ],
            'AnalyzeIamPolicyLongrunning' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{analysis_query.scope=*/*}:analyzeIamPolicyLongrunning',
                'body' => '*',
                'placeholders' => [
                    'analysis_query.scope' => [
                        'getters' => [
                            'getAnalysisQuery',
                            'getScope',
                        ],
                    ],
                ],
            ],
            'AnalyzeMove' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{resource=*/*}:analyzeMove',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'BatchGetAssetsHistory' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=*/*}:batchGetAssetsHistory',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchGetEffectiveIamPolicies' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{scope=*/*}/effectiveIamPolicies:batchGet',
                'placeholders' => [
                    'scope' => [
                        'getters' => [
                            'getScope',
                        ],
                    ],
                ],
            ],
            'CreateFeed' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=*/*}/feeds',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateSavedQuery' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=*/*}/savedQueries',
                'body' => 'saved_query',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'saved_query_id',
                ],
            ],
            'DeleteFeed' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=*/*/feeds/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteSavedQuery' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=*/*/savedQueries/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ExportAssets' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=*/*}:exportAssets',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetFeed' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=*/*/feeds/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSavedQuery' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=*/*/savedQueries/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAssets' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=*/*}/assets',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListFeeds' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=*/*}/feeds',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListSavedQueries' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=*/*}/savedQueries',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'QueryAssets' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=*/*}:queryAssets',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'SearchAllIamPolicies' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{scope=*/*}:searchAllIamPolicies',
                'placeholders' => [
                    'scope' => [
                        'getters' => [
                            'getScope',
                        ],
                    ],
                ],
            ],
            'SearchAllResources' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{scope=*/*}:searchAllResources',
                'placeholders' => [
                    'scope' => [
                        'getters' => [
                            'getScope',
                        ],
                    ],
                ],
            ],
            'UpdateFeed' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{feed.name=*/*/feeds/*}',
                'body' => '*',
                'placeholders' => [
                    'feed.name' => [
                        'getters' => [
                            'getFeed',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateSavedQuery' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{saved_query.name=*/*/savedQueries/*}',
                'body' => 'saved_query',
                'placeholders' => [
                    'saved_query.name' => [
                        'getters' => [
                            'getSavedQuery',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=*/*/operations/*/**}',
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
];
