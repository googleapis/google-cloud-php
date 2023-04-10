<?php

return [
    'interfaces' => [
        'google.cloud.retail.v2.ModelService' => [
            'CreateModel' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Retail\V2\Model',
                    'metadataReturnType' => '\Google\Cloud\Retail\V2\CreateModelMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'TuneModel' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Retail\V2\TuneModelResponse',
                    'metadataReturnType' => '\Google\Cloud\Retail\V2\TuneModelMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ListModels' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getModels',
                ],
            ],
        ],
    ],
];
