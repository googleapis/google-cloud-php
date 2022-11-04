<?php

return [
    'interfaces' => [
        'google.cloud.dialogflow.v2.Documents' => [
            'CreateDocument' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Dialogflow\V2\Document',
                    'metadataReturnType' => '\Google\Cloud\Dialogflow\V2\KnowledgeOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteDocument' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\Dialogflow\V2\KnowledgeOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ExportDocument' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Dialogflow\V2\Document',
                    'metadataReturnType' => '\Google\Cloud\Dialogflow\V2\KnowledgeOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ImportDocuments' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Dialogflow\V2\ImportDocumentsResponse',
                    'metadataReturnType' => '\Google\Cloud\Dialogflow\V2\KnowledgeOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ReloadDocument' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Dialogflow\V2\Document',
                    'metadataReturnType' => '\Google\Cloud\Dialogflow\V2\KnowledgeOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UpdateDocument' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Dialogflow\V2\Document',
                    'metadataReturnType' => '\Google\Cloud\Dialogflow\V2\KnowledgeOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ListDocuments' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getDocuments',
                ],
            ],
            'ListLocations' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getLocations',
                ],
            ],
        ],
    ],
];
