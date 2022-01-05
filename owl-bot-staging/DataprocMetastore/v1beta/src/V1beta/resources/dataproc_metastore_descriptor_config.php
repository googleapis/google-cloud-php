<?php

return [
    'interfaces' => [
        'google.cloud.metastore.v1beta.DataprocMetastore' => [
            'CreateBackup' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Metastore\V1beta\Backup',
                    'metadataReturnType' => '\Google\Cloud\Metastore\V1beta\OperationMetadata',
                    'initialPollDelayMillis' => '60000',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '120000',
                    'totalPollTimeoutMillis' => '4800000',
                ],
            ],
            'CreateMetadataImport' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Metastore\V1beta\MetadataImport',
                    'metadataReturnType' => '\Google\Cloud\Metastore\V1beta\OperationMetadata',
                    'initialPollDelayMillis' => '60000',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '120000',
                    'totalPollTimeoutMillis' => '4800000',
                ],
            ],
            'CreateService' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Metastore\V1beta\Service',
                    'metadataReturnType' => '\Google\Cloud\Metastore\V1beta\OperationMetadata',
                    'initialPollDelayMillis' => '60000',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '120000',
                    'totalPollTimeoutMillis' => '4800000',
                ],
            ],
            'DeleteBackup' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\Metastore\V1beta\OperationMetadata',
                    'initialPollDelayMillis' => '10000',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '60000',
                    'totalPollTimeoutMillis' => '1500000',
                ],
            ],
            'DeleteService' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\Metastore\V1beta\OperationMetadata',
                    'initialPollDelayMillis' => '10000',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '60000',
                    'totalPollTimeoutMillis' => '1500000',
                ],
            ],
            'ExportMetadata' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Metastore\V1beta\MetadataExport',
                    'metadataReturnType' => '\Google\Cloud\Metastore\V1beta\OperationMetadata',
                    'initialPollDelayMillis' => '60000',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '120000',
                    'totalPollTimeoutMillis' => '4800000',
                ],
            ],
            'RestoreService' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Metastore\V1beta\Restore',
                    'metadataReturnType' => '\Google\Cloud\Metastore\V1beta\OperationMetadata',
                    'initialPollDelayMillis' => '60000',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '120000',
                    'totalPollTimeoutMillis' => '4800000',
                ],
            ],
            'UpdateMetadataImport' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Metastore\V1beta\MetadataImport',
                    'metadataReturnType' => '\Google\Cloud\Metastore\V1beta\OperationMetadata',
                    'initialPollDelayMillis' => '60000',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '120000',
                    'totalPollTimeoutMillis' => '1200000',
                ],
            ],
            'UpdateService' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Metastore\V1beta\Service',
                    'metadataReturnType' => '\Google\Cloud\Metastore\V1beta\OperationMetadata',
                    'initialPollDelayMillis' => '60000',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '120000',
                    'totalPollTimeoutMillis' => '3000000',
                ],
            ],
            'ListBackups' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getBackups',
                ],
            ],
            'ListMetadataImports' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getMetadataImports',
                ],
            ],
            'ListServices' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getServices',
                ],
            ],
        ],
    ],
];
