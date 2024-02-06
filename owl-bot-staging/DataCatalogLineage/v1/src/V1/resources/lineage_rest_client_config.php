<?php

return [
    'interfaces' => [
        'google.cloud.datacatalog.lineage.v1.Lineage' => [
            'BatchSearchLinkProcesses' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}:batchSearchLinkProcesses',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateLineageEvent' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/processes/*/runs/*}/lineageEvents',
                'body' => 'lineage_event',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateProcess' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/processes',
                'body' => 'process',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateRun' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/processes/*}/runs',
                'body' => 'run',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteLineageEvent' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/processes/*/runs/*/lineageEvents/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteProcess' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/processes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteRun' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/processes/*/runs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetLineageEvent' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/processes/*/runs/*/lineageEvents/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetProcess' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/processes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRun' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/processes/*/runs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListLineageEvents' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/processes/*/runs/*}/lineageEvents',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListProcesses' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/processes',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListRuns' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/processes/*}/runs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ProcessOpenLineageRunEvent' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}:processOpenLineageRunEvent',
                'body' => 'open_lineage',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'SearchLinks' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}:searchLinks',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateProcess' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{process.name=projects/*/locations/*/processes/*}',
                'body' => 'process',
                'placeholders' => [
                    'process.name' => [
                        'getters' => [
                            'getProcess',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateRun' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{run.name=projects/*/locations/*/processes/*/runs/*}',
                'body' => 'run',
                'placeholders' => [
                    'run.name' => [
                        'getters' => [
                            'getRun',
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
];
