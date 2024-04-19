<?php
/*
 * Copyright 2024 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was automatically generated - do not edit!
 */

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
            'CommitRepositoryChanges' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/repositories/*}:commit',
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
            'ComputeRepositoryAccessTokenStatus' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/repositories/*}:computeAccessTokenStatus',
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
            'CreateReleaseConfig' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{parent=projects/*/locations/*/repositories/*}/releaseConfigs',
                'body' => 'release_config',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'release_config_id',
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
            'CreateWorkflowConfig' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{parent=projects/*/locations/*/repositories/*}/workflowConfigs',
                'body' => 'workflow_config',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'workflow_config_id',
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
            'DeleteReleaseConfig' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/repositories/*/releaseConfigs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
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
            'DeleteWorkflowConfig' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/repositories/*/workflowConfigs/*}',
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
            'FetchRepositoryHistory' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/repositories/*}:fetchHistory',
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
            'GetReleaseConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/repositories/*/releaseConfigs/*}',
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
            'GetWorkflowConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/repositories/*/workflowConfigs/*}',
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
            'ListReleaseConfigs' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{parent=projects/*/locations/*/repositories/*}/releaseConfigs',
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
            'ListWorkflowConfigs' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{parent=projects/*/locations/*/repositories/*}/workflowConfigs',
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
            'QueryRepositoryDirectoryContents' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/repositories/*}:queryDirectoryContents',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
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
            'ReadRepositoryFile' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/repositories/*}:readFile',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
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
            'UpdateReleaseConfig' => [
                'method' => 'patch',
                'uriTemplate' => '/v1beta1/{release_config.name=projects/*/locations/*/repositories/*/releaseConfigs/*}',
                'body' => 'release_config',
                'placeholders' => [
                    'release_config.name' => [
                        'getters' => [
                            'getReleaseConfig',
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
            'UpdateWorkflowConfig' => [
                'method' => 'patch',
                'uriTemplate' => '/v1beta1/{workflow_config.name=projects/*/locations/*/repositories/*/workflowConfigs/*}',
                'body' => 'workflow_config',
                'placeholders' => [
                    'workflow_config.name' => [
                        'getters' => [
                            'getWorkflowConfig',
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
        'google.iam.v1.IAMPolicy' => [
            'GetIamPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{resource=projects/*/locations/*/repositories/*}:getIamPolicy',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta1/{resource=projects/*/locations/*/collections/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta1/{resource=projects/*/locations/*/repositories/*/workspaces/*}:getIamPolicy',
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
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{resource=projects/*/locations/*/repositories/*}:setIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta1/{resource=projects/*/locations/*/repositories/*/workspaces/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta1/{resource=projects/*/locations/*/collections/*}:setIamPolicy',
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
            'TestIamPermissions' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{resource=projects/*/locations/*/repositories/*}:testIamPermissions',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta1/{resource=projects/*/locations/*/collections/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta1/{resource=projects/*/locations/*/repositories/*/workspaces/*}:testIamPermissions',
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
        ],
    ],
    'numericEnums' => true,
];
