<?php

return [
    'interfaces' => [
        'google.cloud.retail.v2.UserEventService' => [
            'ImportUserEvents' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Retail\V2\ImportUserEventsResponse',
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
            'PurgeUserEvents' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Retail\V2\PurgeUserEventsResponse',
                    'metadataReturnType' => '\Google\Cloud\Retail\V2\PurgeMetadata',
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
            'RejoinUserEvents' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Retail\V2\RejoinUserEventsResponse',
                    'metadataReturnType' => '\Google\Cloud\Retail\V2\RejoinUserEventsMetadata',
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
            'CollectUserEvent' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Api\HttpBody',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'WriteUserEvent' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Retail\V2\UserEvent',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'catalog' => 'projects/{project}/locations/{location}/catalogs/{catalog}',
                'product' => 'projects/{project}/locations/{location}/catalogs/{catalog}/branches/{branch}/products/{product}',
            ],
        ],
    ],
];
