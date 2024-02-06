<?php

return [
    'interfaces' => [
        'google.logging.v2.LoggingServiceV2' => [
            'DeleteLog' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'log_name',
                        'fieldAccessors' => [
                            'getLogName',
                        ],
                    ],
                ],
            ],
            'ListLogEntries' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getEntries',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Logging\V2\ListLogEntriesResponse',
            ],
            'ListLogs' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getLogNames',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Logging\V2\ListLogsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListMonitoredResourceDescriptors' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getResourceDescriptors',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Logging\V2\ListMonitoredResourceDescriptorsResponse',
            ],
            'TailLogEntries' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'BidiStreaming',
                ],
                'callType' => \Google\ApiCore\Call::BIDI_STREAMING_CALL,
                'responseType' => 'Google\Cloud\Logging\V2\TailLogEntriesResponse',
            ],
            'WriteLogEntries' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Logging\V2\WriteLogEntriesResponse',
            ],
            'templateMap' => [
                'billingAccount' => 'billingAccounts/{billing_account}',
                'billingAccountLog' => 'billingAccounts/{billing_account}/logs/{log}',
                'folder' => 'folders/{folder}',
                'folderLog' => 'folders/{folder}/logs/{log}',
                'log' => 'projects/{project}/logs/{log}',
                'organization' => 'organizations/{organization}',
                'organizationLog' => 'organizations/{organization}/logs/{log}',
                'project' => 'projects/{project}',
                'projectLog' => 'projects/{project}/logs/{log}',
            ],
        ],
    ],
];
