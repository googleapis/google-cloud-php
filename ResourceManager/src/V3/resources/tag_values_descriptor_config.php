<?php

return [
    'interfaces' => [
        'google.cloud.resourcemanager.v3.TagValues' => [
            'CreateTagValue' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ResourceManager\V3\TagValue',
                    'metadataReturnType' => '\Google\Cloud\ResourceManager\V3\CreateTagValueMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteTagValue' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ResourceManager\V3\TagValue',
                    'metadataReturnType' => '\Google\Cloud\ResourceManager\V3\DeleteTagValueMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateTagValue' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ResourceManager\V3\TagValue',
                    'metadataReturnType' => '\Google\Cloud\ResourceManager\V3\UpdateTagValueMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ListTagValues' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getTagValues',
                ],
            ],
        ],
    ],
];
