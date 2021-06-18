<?php

return [
    'interfaces' => [
        'google.cloud.asset.v1.AssetService' => [
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
        ],
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha1/{name=projects/*/operations/*/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1alpha1/{name=organizations/*/operations/*/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1alpha2/{name=projects/*/operations/*/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1alpha2/{name=organizations/*/operations/*/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta1/{name=projects/*/operations/*/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta1/{name=folders/*/operations/*/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta1/{name=organizations/*/operations/*/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=*/*/operations/*/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=*/*/operations/*/**}',
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
];
