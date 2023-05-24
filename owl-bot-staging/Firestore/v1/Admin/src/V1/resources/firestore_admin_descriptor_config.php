<?php

return [
    'interfaces' => [
        'google.firestore.admin.v1.FirestoreAdmin' => [
            'CreateIndex' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Firestore\Admin\V1\Index',
                    'metadataReturnType' => '\Google\Cloud\Firestore\Admin\V1\IndexOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ExportDocuments' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Firestore\Admin\V1\ExportDocumentsResponse',
                    'metadataReturnType' => '\Google\Cloud\Firestore\Admin\V1\ExportDocumentsMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ImportDocuments' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\Firestore\Admin\V1\ImportDocumentsMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateDatabase' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Firestore\Admin\V1\Database',
                    'metadataReturnType' => '\Google\Cloud\Firestore\Admin\V1\UpdateDatabaseMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateField' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Firestore\Admin\V1\Field',
                    'metadataReturnType' => '\Google\Cloud\Firestore\Admin\V1\FieldOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ListFields' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getFields',
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
