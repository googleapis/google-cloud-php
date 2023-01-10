<?php

return [
    'interfaces' => [
        'google.cloud.dataform.v1beta1.Dataform' => [
            'CancelWorkflowInvocation' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/repositories/*/workflowInvocations/*}:cancel',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CommitWorkspaceChanges' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/repositories/*/workspaces/*}:commit',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateCompilationResult' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{parent=projects/*/locations/*/repositories/*}/compilationResults',
                'body' => 'compilation_result',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateRepository' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{parent=projects/*/locations/*}/repositories',
                'body' => 'repository',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'repository_id',
                ],
            ],
            'CreateWorkflowInvocation' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{parent=projects/*/locations/*/repositories/*}/workflowInvocations',
                'body' => 'workflow_invocation',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateWorkspace' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{parent=projects/*/locations/*/repositories/*}/workspaces',
                'body' => 'workspace',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'workspace_id',
                ],
            ],
            'DeleteRepository' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/repositories/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteWorkflowInvocation' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/repositories/*/workflowInvocations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteWorkspace' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/repositories/*/workspaces/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'FetchFileDiff' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{workspace=projects/*/locations/*/repositories/*/workspaces/*}:fetchFileDiff',
                'placeholders' => [
                    'workspace' => [
                        'getters' => [
                            'getWorkspace',
                        ],
                    ],
                ],
            ],
            'FetchFileGitStatuses' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/repositories/*/workspaces/*}:fetchFileGitStatuses',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'FetchGitAheadBehind' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/repositories/*/workspaces/*}:fetchGitAheadBehind',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'FetchRemoteBranches' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/repositories/*}:fetchRemoteBranches',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCompilationResult' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/repositories/*/compilationResults/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRepository' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/repositories/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetWorkflowInvocation' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/repositories/*/workflowInvocations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetWorkspace' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/repositories/*/workspaces/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'InstallNpmPackages' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{workspace=projects/*/locations/*/repositories/*/workspaces/*}:installNpmPackages',
                'body' => '*',
                'placeholders' => [
                    'workspace' => [
                        'getters' => [
                            'getWorkspace',
                        ],
                    ],
                ],
            ],
            'ListCompilationResults' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{parent=projects/*/locations/*/repositories/*}/compilationResults',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListRepositories' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{parent=projects/*/locations/*}/repositories',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListWorkflowInvocations' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{parent=projects/*/locations/*/repositories/*}/workflowInvocations',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListWorkspaces' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{parent=projects/*/locations/*/repositories/*}/workspaces',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'MakeDirectory' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{workspace=projects/*/locations/*/repositories/*/workspaces/*}:makeDirectory',
                'body' => '*',
                'placeholders' => [
                    'workspace' => [
                        'getters' => [
                            'getWorkspace',
                        ],
                    ],
                ],
            ],
            'MoveDirectory' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{workspace=projects/*/locations/*/repositories/*/workspaces/*}:moveDirectory',
                'body' => '*',
                'placeholders' => [
                    'workspace' => [
                        'getters' => [
                            'getWorkspace',
                        ],
                    ],
                ],
            ],
            'MoveFile' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{workspace=projects/*/locations/*/repositories/*/workspaces/*}:moveFile',
                'body' => '*',
                'placeholders' => [
                    'workspace' => [
                        'getters' => [
                            'getWorkspace',
                        ],
                    ],
                ],
            ],
            'PullGitCommits' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/repositories/*/workspaces/*}:pull',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'PushGitCommits' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/repositories/*/workspaces/*}:push',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'QueryCompilationResultActions' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/repositories/*/compilationResults/*}:query',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'QueryDirectoryContents' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{workspace=projects/*/locations/*/repositories/*/workspaces/*}:queryDirectoryContents',
                'placeholders' => [
                    'workspace' => [
                        'getters' => [
                            'getWorkspace',
                        ],
                    ],
                ],
            ],
            'QueryWorkflowInvocationActions' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/repositories/*/workflowInvocations/*}:query',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ReadFile' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{workspace=projects/*/locations/*/repositories/*/workspaces/*}:readFile',
                'placeholders' => [
                    'workspace' => [
                        'getters' => [
                            'getWorkspace',
                        ],
                    ],
                ],
            ],
            'RemoveDirectory' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{workspace=projects/*/locations/*/repositories/*/workspaces/*}:removeDirectory',
                'body' => '*',
                'placeholders' => [
                    'workspace' => [
                        'getters' => [
                            'getWorkspace',
                        ],
                    ],
                ],
            ],
            'RemoveFile' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{workspace=projects/*/locations/*/repositories/*/workspaces/*}:removeFile',
                'body' => '*',
                'placeholders' => [
                    'workspace' => [
                        'getters' => [
                            'getWorkspace',
                        ],
                    ],
                ],
            ],
            'ResetWorkspaceChanges' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/repositories/*/workspaces/*}:reset',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateRepository' => [
                'method' => 'patch',
                'uriTemplate' => '/v1beta1/{repository.name=projects/*/locations/*/repositories/*}',
                'body' => 'repository',
                'placeholders' => [
                    'repository.name' => [
                        'getters' => [
                            'getRepository',
                            'getName',
                        ],
                    ],
                ],
            ],
            'WriteFile' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{workspace=projects/*/locations/*/repositories/*/workspaces/*}:writeFile',
                'body' => '*',
                'placeholders' => [
                    'workspace' => [
                        'getters' => [
                            'getWorkspace',
                        ],
                    ],
                ],
            ],
        ],
        'google.cloud.location.Locations' => [
            'GetLocation' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*}',
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
                'uriTemplate' => '/v1beta1/{name=projects/*}/locations',
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
