<?php

return [
    'interfaces' => [
        'google.cloud.webrisk.v1.WebRiskService' => [
            'SubmitUri' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\WebRisk\V1\Submission',
                    'metadataReturnType' => '\Google\Cloud\WebRisk\V1\SubmitUriMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
        ],
    ],
];
