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
            ],
        ],
    ],
];
