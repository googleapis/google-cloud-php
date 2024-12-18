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
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=transferOperations/**}:cancel',
                'body' => '*',
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
                'uriTemplate' => '/v1/{name=transferOperations/**}',
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
                'uriTemplate' => '/v1/{name=transferOperations}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.storagetransfer.v1.StorageTransferService' => [
            'CreateAgentPool' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id=*}/agentPools',
                'body' => 'agent_pool',
                'placeholders' => [
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                ],
                'queryParams' => [
                    'agent_pool_id',
                ],
            ],
            'CreateTransferJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/transferJobs',
                'body' => 'transfer_job',
            ],
            'DeleteAgentPool' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/agentPools/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteTransferJob' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{job_name=transferJobs/**}',
                'placeholders' => [
                    'job_name' => [
                        'getters' => [
                            'getJobName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'project_id',
                ],
            ],
            'GetAgentPool' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/agentPools/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetGoogleServiceAccount' => [
                'method' => 'get',
                'uriTemplate' => '/v1/googleServiceAccounts/{project_id}',
                'placeholders' => [
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                ],
            ],
            'GetTransferJob' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{job_name=transferJobs/**}',
                'placeholders' => [
                    'job_name' => [
                        'getters' => [
                            'getJobName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'project_id',
                ],
            ],
            'ListAgentPools' => [
                'method' => 'get',
                'uriTemplate' => '/v1/projects/{project_id=*}/agentPools',
                'placeholders' => [
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                ],
            ],
            'ListTransferJobs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/transferJobs',
                'queryParams' => [
                    'filter',
                ],
            ],
            'PauseTransferOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=transferOperations/**}:pause',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ResumeTransferOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=transferOperations/**}:resume',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RunTransferJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{job_name=transferJobs/**}:run',
                'body' => '*',
                'placeholders' => [
                    'job_name' => [
                        'getters' => [
                            'getJobName',
                        ],
                    ],
                ],
            ],
            'UpdateAgentPool' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{agent_pool.name=projects/*/agentPools/*}',
                'body' => 'agent_pool',
                'placeholders' => [
                    'agent_pool.name' => [
                        'getters' => [
                            'getAgentPool',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateTransferJob' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{job_name=transferJobs/**}',
                'body' => '*',
                'placeholders' => [
                    'job_name' => [
                        'getters' => [
                            'getJobName',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
