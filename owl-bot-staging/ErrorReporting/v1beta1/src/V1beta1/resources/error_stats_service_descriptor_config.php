<?php

return [
    'interfaces' => [
        'google.devtools.clouderrorreporting.v1beta1.ErrorStatsService' => [
            'DeleteEvents' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ErrorReporting\V1beta1\DeleteEventsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project_name',
                        'fieldAccessors' => [
                            'getProjectName',
                        ],
                    ],
                ],
            ],
            'ListEvents' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getErrorEvents',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\ErrorReporting\V1beta1\ListEventsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project_name',
                        'fieldAccessors' => [
                            'getProjectName',
                        ],
                    ],
                ],
            ],
            'ListGroupStats' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getErrorGroupStats',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\ErrorReporting\V1beta1\ListGroupStatsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project_name',
                        'fieldAccessors' => [
                            'getProjectName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'project' => 'projects/{project}',
            ],
        ],
    ],
];
