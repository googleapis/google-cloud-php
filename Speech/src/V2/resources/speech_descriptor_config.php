<?php

return [
    'interfaces' => [
        'google.cloud.speech.v2.Speech' => [
            'BatchRecognize' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Speech\V2\BatchRecognizeResponse',
                    'metadataReturnType' => '\Google\Cloud\Speech\V2\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'CreateCustomClass' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Speech\V2\CustomClass',
                    'metadataReturnType' => '\Google\Cloud\Speech\V2\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'CreatePhraseSet' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Speech\V2\PhraseSet',
                    'metadataReturnType' => '\Google\Cloud\Speech\V2\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'CreateRecognizer' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Speech\V2\Recognizer',
                    'metadataReturnType' => '\Google\Cloud\Speech\V2\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteCustomClass' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Speech\V2\CustomClass',
                    'metadataReturnType' => '\Google\Cloud\Speech\V2\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeletePhraseSet' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Speech\V2\PhraseSet',
                    'metadataReturnType' => '\Google\Cloud\Speech\V2\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteRecognizer' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Speech\V2\Recognizer',
                    'metadataReturnType' => '\Google\Cloud\Speech\V2\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UndeleteCustomClass' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Speech\V2\CustomClass',
                    'metadataReturnType' => '\Google\Cloud\Speech\V2\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UndeletePhraseSet' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Speech\V2\PhraseSet',
                    'metadataReturnType' => '\Google\Cloud\Speech\V2\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UndeleteRecognizer' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Speech\V2\Recognizer',
                    'metadataReturnType' => '\Google\Cloud\Speech\V2\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateCustomClass' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Speech\V2\CustomClass',
                    'metadataReturnType' => '\Google\Cloud\Speech\V2\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdatePhraseSet' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Speech\V2\PhraseSet',
                    'metadataReturnType' => '\Google\Cloud\Speech\V2\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateRecognizer' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Speech\V2\Recognizer',
                    'metadataReturnType' => '\Google\Cloud\Speech\V2\OperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ListCustomClasses' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getCustomClasses',
                ],
            ],
            'ListPhraseSets' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getPhraseSets',
                ],
            ],
            'ListRecognizers' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getRecognizers',
                ],
            ],
            'StreamingRecognize' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'BidiStreaming',
                ],
            ],
        ],
    ],
];
