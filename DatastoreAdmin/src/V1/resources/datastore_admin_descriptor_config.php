<?php

return [
    'interfaces' => [
        'google.datastore.admin.v1.DatastoreAdmin' => [
            'CreateIndex' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Datastore\Admin\V1\Index',
                    'metadataReturnType' => '\Google\Cloud\Datastore\Admin\V1\IndexOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                ],
            ],
            'DeleteIndex' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Datastore\Admin\V1\Index',
                    'metadataReturnType' => '\Google\Cloud\Datastore\Admin\V1\IndexOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'index_id',
                        'fieldAccessors' => [
                            'getIndexId',
                        ],
                    ],
                ],
            ],
            'ExportEntities' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Datastore\Admin\V1\ExportEntitiesResponse',
                    'metadataReturnType' => '\Google\Cloud\Datastore\Admin\V1\ExportEntitiesMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                ],
            ],
            'ImportEntities' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\Datastore\Admin\V1\ImportEntitiesMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                ],
            ],
            'GetIndex' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Datastore\Admin\V1\Index',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'index_id',
                        'fieldAccessors' => [
                            'getIndexId',
                        ],
                    ],
                ],
            ],
            'ListIndexes' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getIndexes',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Datastore\Admin\V1\ListIndexesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
