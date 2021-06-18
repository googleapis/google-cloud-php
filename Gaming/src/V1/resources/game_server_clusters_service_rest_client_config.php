<?php

return [
    'interfaces' => [
        'google.cloud.gaming.v1.GameServerClustersService' => [
            'CreateGameServerCluster' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/realms/*}/gameServerClusters',
                'body' => 'game_server_cluster',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteGameServerCluster' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/realms/*/gameServerClusters/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetGameServerCluster' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/realms/*/gameServerClusters/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListGameServerClusters' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/realms/*}/gameServerClusters',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'PreviewCreateGameServerCluster' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/realms/*}/gameServerClusters:previewCreate',
                'body' => 'game_server_cluster',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'PreviewDeleteGameServerCluster' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/realms/*/gameServerClusters/*}:previewDelete',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'PreviewUpdateGameServerCluster' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{game_server_cluster.name=projects/*/locations/*/realms/*/gameServerClusters/*}:previewUpdate',
                'body' => 'game_server_cluster',
                'placeholders' => [
                    'game_server_cluster.name' => [
                        'getters' => [
                            'getGameServerCluster',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateGameServerCluster' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{game_server_cluster.name=projects/*/locations/*/realms/*/gameServerClusters/*}',
                'body' => 'game_server_cluster',
                'placeholders' => [
                    'game_server_cluster.name' => [
                        'getters' => [
                            'getGameServerCluster',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
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
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}:cancel',
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
