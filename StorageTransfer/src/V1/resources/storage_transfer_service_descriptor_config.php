<?php

return [
    'interfaces' => [
        'google.storagetransfer.v1.StorageTransferService' => [
            'RunTransferJob' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\StorageTransfer\V1\TransferOperation',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'job_name',
                        'fieldAccessors' => [
                            'getJobName',
                        ],
                    ],
                ],
            ],
            'CreateAgentPool' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\StorageTransfer\V1\AgentPool',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                ],
            ],
            'CreateTransferJob' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\StorageTransfer\V1\TransferJob',
            ],
            'DeleteAgentPool' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteTransferJob' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'job_name',
                        'fieldAccessors' => [
                            'getJobName',
                        ],
                    ],
                ],
            ],
            'GetAgentPool' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\StorageTransfer\V1\AgentPool',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetGoogleServiceAccount' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\StorageTransfer\V1\GoogleServiceAccount',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                ],
            ],
            'GetTransferJob' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\StorageTransfer\V1\TransferJob',
                'headerParams' => [
                    [
                        'keyName' => 'job_name',
                        'fieldAccessors' => [
                            'getJobName',
                        ],
                    ],
                ],
            ],
            'ListAgentPools' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getAgentPools',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\StorageTransfer\V1\ListAgentPoolsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                ],
            ],
            'ListTransferJobs' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getTransferJobs',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\StorageTransfer\V1\ListTransferJobsResponse',
            ],
            'PauseTransferOperation' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ResumeTransferOperation' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateAgentPool' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\StorageTransfer\V1\AgentPool',
                'headerParams' => [
                    [
                        'keyName' => 'agent_pool.name',
                        'fieldAccessors' => [
                            'getAgentPool',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateTransferJob' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\StorageTransfer\V1\TransferJob',
                'headerParams' => [
                    [
                        'keyName' => 'job_name',
                        'fieldAccessors' => [
                            'getJobName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'agentPools' => 'projects/{project_id}/agentPools/{agent_pool_id}',
            ],
        ],
    ],
];
