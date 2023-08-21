<?php

return [
    'interfaces' => [
        'google.cloud.location.Locations' => [
            'GetLocation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListLocations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*}/locations',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.cloud.video.livestream.v1.LivestreamService' => [
            'CreateAsset' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/assets',
                'body' => 'asset',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'asset_id',
                ],
            ],
            'CreateChannel' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/channels',
                'body' => 'channel',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'channel_id',
                ],
            ],
            'CreateEvent' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/channels/*}/events',
                'body' => 'event',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'event_id',
                ],
            ],
            'CreateInput' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/inputs',
                'body' => 'input',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'input_id',
                ],
            ],
            'DeleteAsset' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/assets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteChannel' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/channels/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteEvent' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/channels/*/events/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteInput' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/inputs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAsset' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/assets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetChannel' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/channels/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetEvent' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/channels/*/events/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetInput' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/inputs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetPool' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/pools/*}',
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
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/assets',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListChannels' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/channels',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListEvents' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/channels/*}/events',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListInputs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/inputs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'StartChannel' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/channels/*}:start',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'StopChannel' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/channels/*}:stop',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateChannel' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{channel.name=projects/*/locations/*/channels/*}',
                'body' => 'channel',
                'placeholders' => [
                    'channel.name' => [
                        'getters' => [
                            'getChannel',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateInput' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{input.name=projects/*/locations/*/inputs/*}',
                'body' => 'input',
                'placeholders' => [
                    'input.name' => [
                        'getters' => [
                            'getInput',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdatePool' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{pool.name=projects/*/locations/*/pools/*}',
                'body' => 'pool',
                'placeholders' => [
                    'pool.name' => [
                        'getters' => [
                            'getPool',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}:cancel',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteOperation' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*}/operations',
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
