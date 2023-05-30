<?php

return [
    'interfaces' => [
        'google.cloud.retail.v2.CompletionService' => [
            'ImportCompletionData' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Retail\V2\ImportCompletionDataResponse',
                    'metadataReturnType' => '\Google\Cloud\Retail\V2\ImportMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CompleteQuery' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Retail\V2\CompleteQueryResponse',
                'headerParams' => [
                    [
                        'keyName' => 'catalog',
                        'fieldAccessors' => [
                            'getCatalog',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'catalog' => 'projects/{project}/locations/{location}/catalogs/{catalog}',
            ],
        ],
    ],
];
