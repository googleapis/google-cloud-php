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
        'google.cloud.securesourcemanager.v1.SecureSourceManager' => [
            'BatchCreatePullRequestComments' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/repositories/*/pullRequests/*}/pullRequestComments:batchCreate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CloseIssue' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*/issues/*}:close',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ClosePullRequest' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*/pullRequests/*}:close',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateBranchRule' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/repositories/*}/branchRules',
                'body' => 'branch_rule',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'branch_rule_id',
                ],
            ],
            'CreateHook' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/repositories/*}/hooks',
                'body' => 'hook',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'hook_id',
                ],
            ],
            'CreateInstance' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/instances',
                'body' => 'instance',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'instance_id',
                ],
            ],
            'CreateIssue' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/repositories/*}/issues',
                'body' => 'issue',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateIssueComment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/repositories/*/issues/*}/issueComments',
                'body' => 'issue_comment',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreatePullRequest' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/repositories/*}/pullRequests',
                'body' => 'pull_request',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreatePullRequestComment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/repositories/*/pullRequests/*}/pullRequestComments',
                'body' => 'pull_request_comment',
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
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/repositories',
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
            'DeleteBranchRule' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*/branchRules/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteHook' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*/hooks/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteInstance' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteIssue' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*/issues/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteIssueComment' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*/issues/*/issueComments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeletePullRequestComment' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*/pullRequests/*/pullRequestComments/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'FetchBlob' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{repository=projects/*/locations/*/repositories/*}:fetchBlob',
                'placeholders' => [
                    'repository' => [
                        'getters' => [
                            'getRepository',
                        ],
                    ],
                ],
            ],
            'FetchTree' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{repository=projects/*/locations/*/repositories/*}:fetchTree',
                'placeholders' => [
                    'repository' => [
                        'getters' => [
                            'getRepository',
                        ],
                    ],
                ],
            ],
            'GetBranchRule' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*/branchRules/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetHook' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*/hooks/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetIamPolicyRepo' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/repositories/*}:getIamPolicy',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'GetInstance' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetIssue' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*/issues/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetIssueComment' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*/issues/*/issueComments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetPullRequest' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*/pullRequests/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetPullRequestComment' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*/pullRequests/*/pullRequestComments/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListBranchRules' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/repositories/*}/branchRules',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListHooks' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/repositories/*}/hooks',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListInstances' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/instances',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListIssueComments' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/repositories/*/issues/*}/issueComments',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListIssues' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/repositories/*}/issues',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListPullRequestComments' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/repositories/*/pullRequests/*}/pullRequestComments',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListPullRequestFileDiffs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*/pullRequests/*}:listFileDiffs',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListPullRequests' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/repositories/*}/pullRequests',
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
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/repositories',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'MergePullRequest' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*/pullRequests/*}:merge',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'OpenIssue' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*/issues/*}:open',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'OpenPullRequest' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/repositories/*/pullRequests/*}:open',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ResolvePullRequestComments' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/repositories/*/pullRequests/*}/pullRequestComments:resolve',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'SetIamPolicyRepo' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/repositories/*}:setIamPolicy',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'TestIamPermissionsRepo' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/repositories/*}:testIamPermissions',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'UnresolvePullRequestComments' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/repositories/*/pullRequests/*}/pullRequestComments:unresolve',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateBranchRule' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{branch_rule.name=projects/*/locations/*/repositories/*/branchRules/*}',
                'body' => 'branch_rule',
                'placeholders' => [
                    'branch_rule.name' => [
                        'getters' => [
                            'getBranchRule',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateHook' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{hook.name=projects/*/locations/*/repositories/*/hooks/*}',
                'body' => 'hook',
                'placeholders' => [
                    'hook.name' => [
                        'getters' => [
                            'getHook',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateIssue' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{issue.name=projects/*/locations/*/repositories/*/issues/*}',
                'body' => 'issue',
                'placeholders' => [
                    'issue.name' => [
                        'getters' => [
                            'getIssue',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateIssueComment' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{issue_comment.name=projects/*/locations/*/repositories/*/issues/*/issueComments/*}',
                'body' => 'issue_comment',
                'placeholders' => [
                    'issue_comment.name' => [
                        'getters' => [
                            'getIssueComment',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdatePullRequest' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{pull_request.name=projects/*/locations/*/repositories/*/pullRequests/*}',
                'body' => 'pull_request',
                'placeholders' => [
                    'pull_request.name' => [
                        'getters' => [
                            'getPullRequest',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdatePullRequestComment' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{pull_request_comment.name=projects/*/locations/*/repositories/*/pullRequests/*/pullRequestComments/*}',
                'body' => 'pull_request_comment',
                'placeholders' => [
                    'pull_request_comment.name' => [
                        'getters' => [
                            'getPullRequestComment',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateRepository' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{repository.name=projects/*/locations/*/repositories/*}',
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
        ],
        'google.iam.v1.IAMPolicy' => [
            'GetIamPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/instances/*}:getIamPolicy',
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
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/instances/*}:setIamPolicy',
                'body' => '*',
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
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/instances/*}:testIamPermissions',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
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
