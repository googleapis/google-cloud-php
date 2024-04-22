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
        'google.devtools.cloudbuild.v1.CloudBuild' => [
            'ApproveBuild' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/builds/*}:approve',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/builds/*}:approve',
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
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=projects/*/locations/*}/triggers',
                        'body' => 'trigger',
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
            'CreateWorkerPool' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/workerPools',
                'body' => 'worker_pool',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'worker_pool_id',
                ],
            ],
            'DeleteBuildTrigger' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/projects/{project_id}/triggers/{trigger_id}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/triggers/*}',
                    ],
                ],
                'placeholders' => [
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
                    'trigger_id' => [
                        'getters' => [
                            'getTriggerId',
                        ],
                    ],
                ],
            ],
            'DeleteWorkerPool' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/workerPools/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
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
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/triggers/*}',
                    ],
                ],
                'placeholders' => [
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
                    'trigger_id' => [
                        'getters' => [
                            'getTriggerId',
                        ],
                    ],
                ],
            ],
            'GetWorkerPool' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/workerPools/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListBuildTriggers' => [
                'method' => 'get',
                'uriTemplate' => '/v1/projects/{project_id}/triggers',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=projects/*/locations/*}/triggers',
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
            'ListWorkerPools' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/workerPools',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ReceiveTriggerWebhook' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}/triggers/{trigger}:webhook',
                'body' => 'body',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/triggers/*}:webhook',
                        'body' => 'body',
                    ],
                ],
                'placeholders' => [
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
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/triggers/*}:run',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
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
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{trigger.resource_name=projects/*/locations/*/triggers/*}',
                        'body' => 'trigger',
                    ],
                ],
                'placeholders' => [
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                    'trigger.resource_name' => [
                        'getters' => [
                            'getTrigger',
                            'getResourceName',
                        ],
                    ],
                    'trigger_id' => [
                        'getters' => [
                            'getTriggerId',
                        ],
                    ],
                ],
            ],
            'UpdateWorkerPool' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{worker_pool.name=projects/*/locations/*/workerPools/*}',
                'body' => 'worker_pool',
                'placeholders' => [
                    'worker_pool.name' => [
                        'getters' => [
                            'getWorkerPool',
                            'getName',
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
