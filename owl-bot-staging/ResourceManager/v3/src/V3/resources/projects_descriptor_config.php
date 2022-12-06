<?php

return [
    'interfaces' => [
        'google.cloud.resourcemanager.v3.Projects' => [
            'CreateProject' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ResourceManager\V3\Project',
                    'metadataReturnType' => '\Google\Cloud\ResourceManager\V3\CreateProjectMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteProject' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ResourceManager\V3\Project',
                    'metadataReturnType' => '\Google\Cloud\ResourceManager\V3\DeleteProjectMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'MoveProject' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ResourceManager\V3\Project',
                    'metadataReturnType' => '\Google\Cloud\ResourceManager\V3\MoveProjectMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UndeleteProject' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ResourceManager\V3\Project',
                    'metadataReturnType' => '\Google\Cloud\ResourceManager\V3\UndeleteProjectMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateProject' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ResourceManager\V3\Project',
                    'metadataReturnType' => '\Google\Cloud\ResourceManager\V3\UpdateProjectMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ListProjects' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getProjects',
                ],
            ],
            'SearchProjects' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getProjects',
                ],
            ],
        ],
    ],
];
