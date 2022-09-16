<?php

return [
    'interfaces' => [
        'google.cloud.vmmigration.v1.VmMigration' => [
            'AddGroupMigration' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\VMMigration\V1\AddGroupMigrationResponse',
                    'metadataReturnType' => '\Google\Cloud\VMMigration\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'CancelCloneJob' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\VMMigration\V1\CancelCloneJobResponse',
                    'metadataReturnType' => '\Google\Cloud\VMMigration\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'CancelCutoverJob' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\VMMigration\V1\CancelCutoverJobResponse',
                    'metadataReturnType' => '\Google\Cloud\VMMigration\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'CreateCloneJob' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\VMMigration\V1\CloneJob',
                    'metadataReturnType' => '\Google\Cloud\VMMigration\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'CreateCutoverJob' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\VMMigration\V1\CutoverJob',
                    'metadataReturnType' => '\Google\Cloud\VMMigration\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'CreateDatacenterConnector' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\VMMigration\V1\DatacenterConnector',
                    'metadataReturnType' => '\Google\Cloud\VMMigration\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'CreateGroup' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\VMMigration\V1\Group',
                    'metadataReturnType' => '\Google\Cloud\VMMigration\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'CreateMigratingVm' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\VMMigration\V1\MigratingVm',
                    'metadataReturnType' => '\Google\Cloud\VMMigration\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'CreateSource' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\VMMigration\V1\Source',
                    'metadataReturnType' => '\Google\Cloud\VMMigration\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'CreateTargetProject' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\VMMigration\V1\TargetProject',
                    'metadataReturnType' => '\Google\Cloud\VMMigration\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'CreateUtilizationReport' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\VMMigration\V1\UtilizationReport',
                    'metadataReturnType' => '\Google\Cloud\VMMigration\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteDatacenterConnector' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\VMMigration\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteGroup' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\VMMigration\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteMigratingVm' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\VMMigration\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteSource' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\VMMigration\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteTargetProject' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\VMMigration\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteUtilizationReport' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\VMMigration\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'FinalizeMigration' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\VMMigration\V1\FinalizeMigrationResponse',
                    'metadataReturnType' => '\Google\Cloud\VMMigration\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'PauseMigration' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\VMMigration\V1\PauseMigrationResponse',
                    'metadataReturnType' => '\Google\Cloud\VMMigration\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'RemoveGroupMigration' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\VMMigration\V1\RemoveGroupMigrationResponse',
                    'metadataReturnType' => '\Google\Cloud\VMMigration\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ResumeMigration' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\VMMigration\V1\ResumeMigrationResponse',
                    'metadataReturnType' => '\Google\Cloud\VMMigration\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'StartMigration' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\VMMigration\V1\StartMigrationResponse',
                    'metadataReturnType' => '\Google\Cloud\VMMigration\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateGroup' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\VMMigration\V1\Group',
                    'metadataReturnType' => '\Google\Cloud\VMMigration\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateMigratingVm' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\VMMigration\V1\MigratingVm',
                    'metadataReturnType' => '\Google\Cloud\VMMigration\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateSource' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\VMMigration\V1\Source',
                    'metadataReturnType' => '\Google\Cloud\VMMigration\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateTargetProject' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\VMMigration\V1\TargetProject',
                    'metadataReturnType' => '\Google\Cloud\VMMigration\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpgradeAppliance' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\VMMigration\V1\UpgradeApplianceResponse',
                    'metadataReturnType' => '\Google\Cloud\VMMigration\V1\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ListCloneJobs' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getCloneJobs',
                ],
            ],
            'ListCutoverJobs' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getCutoverJobs',
                ],
            ],
            'ListDatacenterConnectors' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getDatacenterConnectors',
                ],
            ],
            'ListGroups' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getGroups',
                ],
            ],
            'ListMigratingVms' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getMigratingVms',
                ],
            ],
            'ListSources' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getSources',
                ],
            ],
            'ListTargetProjects' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getTargetProjects',
                ],
            ],
            'ListUtilizationReports' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getUtilizationReports',
                ],
            ],
        ],
    ],
];
