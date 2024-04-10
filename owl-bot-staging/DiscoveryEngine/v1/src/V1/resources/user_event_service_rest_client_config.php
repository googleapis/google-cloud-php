<?php

return [
    'interfaces' => [
        'google.cloud.discoveryengine.v1.UserEventService' => [
            'CollectUserEvent' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/dataStores/*}/userEvents:collect',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=projects/*/locations/*/collections/*/dataStores/*}/userEvents:collect',
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
            'ImportUserEvents' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/dataStores/*}/userEvents:import',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=projects/*/locations/*/collections/*/dataStores/*}/userEvents:import',
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
            'WriteUserEvent' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/dataStores/*}/userEvents:write',
                'body' => 'user_event',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=projects/*/locations/*/collections/*/dataStores/*}/userEvents:write',
                        'body' => 'user_event',
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
        ],
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/operations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/collections/*/dataConnector/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/collections/*/dataStores/*/branches/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/collections/*/dataStores/*/models/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/collections/*/dataStores/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/collections/*/dataStores/*/schemas/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine/targetSites/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/collections/*/engines/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/collections/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/dataStores/*/branches/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/dataStores/*/models/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/dataStores/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/operations/*}',
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
                'uriTemplate' => '/v1/{name=projects/*}/operations',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/collections/*/dataConnector}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/collections/*/dataStores/*/branches/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/collections/*/dataStores/*/models/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/collections/*/dataStores/*/schemas/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine/targetSites}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/collections/*/dataStores/*/siteSearchEngine}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/collections/*/dataStores/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/collections/*/engines/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/collections/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/dataStores/*/branches/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/dataStores/*/models/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/dataStores/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*}/operations',
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
