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
            ],
        ],
    ],
];
