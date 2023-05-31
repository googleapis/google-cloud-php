<?php

return [
    'interfaces' => [
        'google.cloud.bigquery.analyticshub.v1.AnalyticsHubService' => [
            'CreateDataExchange' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/dataExchanges',
                'body' => 'data_exchange',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'data_exchange_id',
                ],
            ],
            'CreateListing' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/dataExchanges/*}/listings',
                'body' => 'listing',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'listing_id',
                ],
            ],
            'DeleteDataExchange' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/dataExchanges/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteListing' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/dataExchanges/*/listings/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDataExchange' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/dataExchanges/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/dataExchanges/*}:getIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/dataExchanges/*/listings/*}:getIamPolicy',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'GetListing' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/dataExchanges/*/listings/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListDataExchanges' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/dataExchanges',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListListings' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/dataExchanges/*}/listings',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListOrgDataExchanges' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{organization=organizations/*/locations/*}/dataExchanges',
                'placeholders' => [
                    'organization' => [
                        'getters' => [
                            'getOrganization',
                        ],
                    ],
                ],
            ],
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/dataExchanges/*}:setIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/dataExchanges/*/listings/*}:setIamPolicy',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'SubscribeListing' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/dataExchanges/*/listings/*}:subscribe',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'TestIamPermissions' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/dataExchanges/*}:testIamPermissions',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/dataExchanges/*/listings/*}:testIamPermissions',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'UpdateDataExchange' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{data_exchange.name=projects/*/locations/*/dataExchanges/*}',
                'body' => 'data_exchange',
                'placeholders' => [
                    'data_exchange.name' => [
                        'getters' => [
                            'getDataExchange',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateListing' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{listing.name=projects/*/locations/*/dataExchanges/*/listings/*}',
                'body' => 'listing',
                'placeholders' => [
                    'listing.name' => [
                        'getters' => [
                            'getListing',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
        ],
    ],
];
