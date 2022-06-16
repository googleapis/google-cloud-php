<?php

return [
    'interfaces' => [
        'google.cloud.resourcemanager.v3.TagKeys' => [
            'CreateTagKey' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ResourceManager\V3\TagKey',
                    'metadataReturnType' => '\Google\Cloud\ResourceManager\V3\CreateTagKeyMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteTagKey' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ResourceManager\V3\TagKey',
                    'metadataReturnType' => '\Google\Cloud\ResourceManager\V3\DeleteTagKeyMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateTagKey' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ResourceManager\V3\TagKey',
                    'metadataReturnType' => '\Google\Cloud\ResourceManager\V3\UpdateTagKeyMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ListTagKeys' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getTagKeys',
                ],
            ],
        ],
    ],
];
