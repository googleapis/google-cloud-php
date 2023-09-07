<?php

return [
    'interfaces' => [
        'google.cloud.policysimulator.v1.Simulator' => [
            'CreateReplay' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\PolicySimulator\V1\Replay',
                    'metadataReturnType' => '\Google\Cloud\PolicySimulator\V1\ReplayOperationMetadata',
                    'initialPollDelayMillis' => '1000',
                    'pollDelayMultiplier' => '2.0',
                    'maxPollDelayMillis' => '10000',
                    'totalPollTimeoutMillis' => '18000000',
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
            'GetReplay' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\PolicySimulator\V1\Replay',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListReplayResults' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getReplayResults',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\PolicySimulator\V1\ListReplayResultsResponse',
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
                'folderLocationReplay' => 'folders/{folder}/locations/{location}/replays/{replay}',
                'organizationLocationReplay' => 'organizations/{organization}/locations/{location}/replays/{replay}',
                'projectLocationReplay' => 'projects/{project}/locations/{location}/replays/{replay}',
                'replay' => 'projects/{project}/locations/{location}/replays/{replay}',
            ],
        ],
    ],
];
