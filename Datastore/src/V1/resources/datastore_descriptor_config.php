<?php

return [
    'interfaces' => [
        'google.datastore.v1.Datastore' => [
            'AllocateIds' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Datastore\V1\AllocateIdsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'database_id',
                        'fieldAccessors' => [
                            'getDatabaseId',
                        ],
                    ],
                ],
            ],
            'BeginTransaction' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Datastore\V1\BeginTransactionResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'database_id',
                        'fieldAccessors' => [
                            'getDatabaseId',
                        ],
                    ],
                ],
            ],
            'Commit' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Datastore\V1\CommitResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'database_id',
                        'fieldAccessors' => [
                            'getDatabaseId',
                        ],
                    ],
                ],
            ],
            'Lookup' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Datastore\V1\LookupResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'database_id',
                        'fieldAccessors' => [
                            'getDatabaseId',
                        ],
                    ],
                ],
            ],
            'ReserveIds' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Datastore\V1\ReserveIdsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'database_id',
                        'fieldAccessors' => [
                            'getDatabaseId',
                        ],
                    ],
                ],
            ],
            'Rollback' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Datastore\V1\RollbackResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'database_id',
                        'fieldAccessors' => [
                            'getDatabaseId',
                        ],
                    ],
                ],
            ],
            'RunAggregationQuery' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Datastore\V1\RunAggregationQueryResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'database_id',
                        'fieldAccessors' => [
                            'getDatabaseId',
                        ],
                    ],
                ],
            ],
            'RunQuery' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Datastore\V1\RunQueryResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'database_id',
                        'fieldAccessors' => [
                            'getDatabaseId',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
