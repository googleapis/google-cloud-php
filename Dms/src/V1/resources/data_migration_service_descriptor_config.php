<?php

return [
    'interfaces' => [
        'google.cloud.clouddms.v1.DataMigrationService' => [
            'ApplyConversionWorkspace' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\CloudDms\V1\ConversionWorkspace',
                    'metadataReturnType' => '\Google\Cloud\CloudDms\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'CommitConversionWorkspace' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\CloudDms\V1\ConversionWorkspace',
                    'metadataReturnType' => '\Google\Cloud\CloudDms\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ConvertConversionWorkspace' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\CloudDms\V1\ConversionWorkspace',
                    'metadataReturnType' => '\Google\Cloud\CloudDms\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'CreateConnectionProfile' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\CloudDms\V1\ConnectionProfile',
                    'metadataReturnType' => '\Google\Cloud\CloudDms\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'CreateConversionWorkspace' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\CloudDms\V1\ConversionWorkspace',
                    'metadataReturnType' => '\Google\Cloud\CloudDms\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'CreateMigrationJob' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\CloudDms\V1\MigrationJob',
                    'metadataReturnType' => '\Google\Cloud\CloudDms\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'CreatePrivateConnection' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\CloudDms\V1\PrivateConnection',
                    'metadataReturnType' => '\Google\Cloud\CloudDms\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteConnectionProfile' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\CloudDms\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteConversionWorkspace' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\CloudDms\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteMigrationJob' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\CloudDms\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeletePrivateConnection' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\CloudDms\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ImportMappingRules' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\CloudDms\V1\ConversionWorkspace',
                    'metadataReturnType' => '\Google\Cloud\CloudDms\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'PromoteMigrationJob' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\CloudDms\V1\MigrationJob',
                    'metadataReturnType' => '\Google\Cloud\CloudDms\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'RestartMigrationJob' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\CloudDms\V1\MigrationJob',
                    'metadataReturnType' => '\Google\Cloud\CloudDms\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ResumeMigrationJob' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\CloudDms\V1\MigrationJob',
                    'metadataReturnType' => '\Google\Cloud\CloudDms\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'RollbackConversionWorkspace' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\CloudDms\V1\ConversionWorkspace',
                    'metadataReturnType' => '\Google\Cloud\CloudDms\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'SeedConversionWorkspace' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\CloudDms\V1\ConversionWorkspace',
                    'metadataReturnType' => '\Google\Cloud\CloudDms\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'StartMigrationJob' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\CloudDms\V1\MigrationJob',
                    'metadataReturnType' => '\Google\Cloud\CloudDms\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'StopMigrationJob' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\CloudDms\V1\MigrationJob',
                    'metadataReturnType' => '\Google\Cloud\CloudDms\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateConnectionProfile' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\CloudDms\V1\ConnectionProfile',
                    'metadataReturnType' => '\Google\Cloud\CloudDms\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateConversionWorkspace' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\CloudDms\V1\ConversionWorkspace',
                    'metadataReturnType' => '\Google\Cloud\CloudDms\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateMigrationJob' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\CloudDms\V1\MigrationJob',
                    'metadataReturnType' => '\Google\Cloud\CloudDms\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'VerifyMigrationJob' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\CloudDms\V1\MigrationJob',
                    'metadataReturnType' => '\Google\Cloud\CloudDms\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DescribeDatabaseEntities' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getDatabaseEntities',
                ],
            ],
            'FetchStaticIps' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getStaticIps',
                ],
            ],
            'ListConnectionProfiles' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getConnectionProfiles',
                ],
            ],
            'ListConversionWorkspaces' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getConversionWorkspaces',
                ],
            ],
            'ListMigrationJobs' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getMigrationJobs',
                ],
            ],
            'ListPrivateConnections' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getPrivateConnections',
                ],
            ],
        ],
    ],
];
