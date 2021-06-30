<?php

return [
    'interfaces' => [
        'google.cloud.resourcemanager.v3.Folders' => [
            'CreateFolder' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ResourceManager\V3\Folder',
                    'metadataReturnType' => '\Google\Cloud\ResourceManager\V3\CreateFolderMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteFolder' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ResourceManager\V3\Folder',
                    'metadataReturnType' => '\Google\Cloud\ResourceManager\V3\DeleteFolderMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'MoveFolder' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ResourceManager\V3\Folder',
                    'metadataReturnType' => '\Google\Cloud\ResourceManager\V3\MoveFolderMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UndeleteFolder' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ResourceManager\V3\Folder',
                    'metadataReturnType' => '\Google\Cloud\ResourceManager\V3\UndeleteFolderMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateFolder' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ResourceManager\V3\Folder',
                    'metadataReturnType' => '\Google\Cloud\ResourceManager\V3\UpdateFolderMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ListFolders' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getFolders',
                ],
            ],
            'SearchFolders' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getFolders',
                ],
            ],
        ],
    ],
];
