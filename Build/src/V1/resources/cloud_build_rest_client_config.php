<?php

return [
    'interfaces' => [
        'google.devtools.cloudbuild.v1.CloudBuild' => [
            'CancelBuild' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}/builds/{id}:cancel',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/builds/*}:cancel',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'id' => [
                        'getters' => [
                            'getId',
                        ],
                    ],
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                ],
            ],
            'CreateBuild' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}/builds',
                'body' => 'build',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=projects/*/locations/*}/builds',
                        'body' => 'build',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                ],
            ],
            'CreateBuildTrigger' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}/triggers',
                'body' => 'trigger',
                'placeholders' => [
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                ],
            ],
            'DeleteBuildTrigger' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/projects/{project_id}/triggers/{trigger_id}',
                'placeholders' => [
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'trigger_id' => [
                        'getters' => [
                            'getTriggerId',
                        ],
                    ],
                ],
            ],
            'GetBuild' => [
                'method' => 'get',
                'uriTemplate' => '/v1/projects/{project_id}/builds/{id}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/builds/*}',
                    ],
                ],
                'placeholders' => [
                    'id' => [
                        'getters' => [
                            'getId',
                        ],
                    ],
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                ],
            ],
            'GetBuildTrigger' => [
                'method' => 'get',
                'uriTemplate' => '/v1/projects/{project_id}/triggers/{trigger_id}',
                'placeholders' => [
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'trigger_id' => [
                        'getters' => [
                            'getTriggerId',
                        ],
                    ],
                ],
            ],
            'ListBuildTriggers' => [
                'method' => 'get',
                'uriTemplate' => '/v1/projects/{project_id}/triggers',
                'placeholders' => [
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                ],
            ],
            'ListBuilds' => [
                'method' => 'get',
                'uriTemplate' => '/v1/projects/{project_id}/builds',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=projects/*/locations/*}/builds',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                ],
            ],
            'ReceiveTriggerWebhook' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}/triggers/{trigger}:webhook',
                'body' => 'body',
                'placeholders' => [
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'trigger' => [
                        'getters' => [
                            'getTrigger',
                        ],
                    ],
                ],
            ],
            'RetryBuild' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}/builds/{id}:retry',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/builds/*}:retry',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'id' => [
                        'getters' => [
                            'getId',
                        ],
                    ],
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                ],
            ],
            'RunBuildTrigger' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}/triggers/{trigger_id}:run',
                'body' => 'source',
                'placeholders' => [
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'trigger_id' => [
                        'getters' => [
                            'getTriggerId',
                        ],
                    ],
                ],
            ],
            'UpdateBuildTrigger' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/projects/{project_id}/triggers/{trigger_id}',
                'body' => 'trigger',
                'placeholders' => [
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'trigger_id' => [
                        'getters' => [
                            'getTriggerId',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=operations/**}:cancel',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}:cancel',
                        'body' => '*',
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
                'uriTemplate' => '/v1/{name=operations/**}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
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
