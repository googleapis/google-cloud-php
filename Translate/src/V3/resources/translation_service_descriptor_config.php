<?php

return [
    'interfaces' => [
        'google.cloud.translation.v3.TranslationService' => [
            'BatchTranslateText' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Translate\V3\BatchTranslateResponse',
                    'metadataReturnType' => '\Google\Cloud\Translate\V3\BatchTranslateMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'CreateGlossary' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Translate\V3\Glossary',
                    'metadataReturnType' => '\Google\Cloud\Translate\V3\CreateGlossaryMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteGlossary' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Translate\V3\DeleteGlossaryResponse',
                    'metadataReturnType' => '\Google\Cloud\Translate\V3\DeleteGlossaryMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ListGlossaries' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getGlossaries',
                ],
            ],
        ],
    ],
];
