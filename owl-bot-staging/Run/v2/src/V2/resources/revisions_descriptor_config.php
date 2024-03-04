<?php

return [
    'interfaces' => [
        'google.cloud.run.v2.Revisions' => [
            'DeleteRevision' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Run\V2\Revision',
                    'metadataReturnType' => '\Google\Cloud\Run\V2\Revision',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'location',
                        'fieldAccessors' => [
                            'getName',
                        ],
                        'matchers' => [],
                    ],
                ],
            ],
            'GetRevision' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Run\V2\Revision',
                'headerParams' => [
                    [
                        'keyName' => 'location',
                        'fieldAccessors' => [
                            'getName',
                        ],
                        'matchers' => [],
                    ],
                ],
            ],
            'ListRevisions' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getRevisions',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Run\V2\ListRevisionsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'location',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                        'matchers' => [],
                    ],
                ],
            ],
            'templateMap' => [
                'revision' => 'projects/{project}/locations/{location}/services/{service}/revisions/{revision}',
                'service' => 'projects/{project}/locations/{location}/services/{service}',
            ],
        ],
    ],
];
