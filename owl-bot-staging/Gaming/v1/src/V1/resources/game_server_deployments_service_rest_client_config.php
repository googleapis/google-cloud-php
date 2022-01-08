<?php

return [
    'interfaces' => [
        'google.cloud.gaming.v1.GameServerDeploymentsService' => [
            'CreateGameServerDeployment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/gameServerDeployments',
                'body' => 'game_server_deployment',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'deployment_id',
                ],
            ],
            'DeleteGameServerDeployment' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/gameServerDeployments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'FetchDeploymentState' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/gameServerDeployments/*}:fetchDeploymentState',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetGameServerDeployment' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/gameServerDeployments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetGameServerDeploymentRollout' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/gameServerDeployments/*}/rollout',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListGameServerDeployments' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/gameServerDeployments',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'PreviewGameServerDeploymentRollout' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{rollout.name=projects/*/locations/*/gameServerDeployments/*}/rollout:preview',
                'body' => 'rollout',
                'placeholders' => [
                    'rollout.name' => [
                        'getters' => [
                            'getRollout',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateGameServerDeployment' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{game_server_deployment.name=projects/*/locations/*/gameServerDeployments/*}',
                'body' => 'game_server_deployment',
                'placeholders' => [
                    'game_server_deployment.name' => [
                        'getters' => [
                            'getGameServerDeployment',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateGameServerDeploymentRollout' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{rollout.name=projects/*/locations/*/gameServerDeployments/*}/rollout',
                'body' => 'rollout',
                'placeholders' => [
                    'rollout.name' => [
                        'getters' => [
                            'getRollout',
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
