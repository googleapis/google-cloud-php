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
            'ComputeThreatListDiff' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\WebRisk\V1\ComputeThreatListDiffResponse',
            ],
            'CreateSubmission' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\WebRisk\V1\Submission',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'SearchHashes' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\WebRisk\V1\SearchHashesResponse',
            ],
            'SearchUris' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\WebRisk\V1\SearchUrisResponse',
            ],
            'templateMap' => [
                'project' => 'projects/{project}',
            ],
        ],
    ],
];
