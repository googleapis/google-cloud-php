<?php

return [
    'interfaces' => [
        'google.cloud.dialogflow.cx.v3.Agents' => [
            'CreateAgent' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*}/agents',
                'body' => 'agent',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteAgent' => [
                'method' => 'delete',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/agents/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ExportAgent' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/agents/*}:export',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAgent' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/agents/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAgentValidationResult' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/agents/*/validationResult}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetGenerativeSettings' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/agents/*/generativeSettings}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'language_code',
                ],
            ],
            'ListAgents' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*}/agents',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RestoreAgent' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/agents/*}:restore',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateAgent' => [
                'method' => 'patch',
                'uriTemplate' => '/v3/{agent.name=projects/*/locations/*/agents/*}',
                'body' => 'agent',
                'placeholders' => [
                    'agent.name' => [
                        'getters' => [
                            'getAgent',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateGenerativeSettings' => [
                'method' => 'patch',
                'uriTemplate' => '/v3/{generative_settings.name=projects/*/locations/*/agents/*/generativeSettings}',
                'body' => 'generative_settings',
                'placeholders' => [
                    'generative_settings.name' => [
                        'getters' => [
                            'getGenerativeSettings',
                            'getName',
                        ],
                    ],
                ],
            ],
            'ValidateAgent' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/agents/*}:validate',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.cloud.location.Locations' => [
            'GetLocation' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/locations/*}',
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
                'uriTemplate' => '/v3/{name=projects/*}/locations',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{name=projects/*/operations/*}:cancel',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v3/{name=projects/*/locations/*/operations/*}:cancel',
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
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/operations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v3/{name=projects/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v3/{name=projects/*}/operations',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v3/{name=projects/*/locations/*}/operations',
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
