<?php

return [
    'interfaces' => [
        'google.cloud.contactcenterinsights.v1.ContactCenterInsights' => [
            'CreateAnalysis' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ContactCenterInsights\V1\Analysis',
                    'metadataReturnType' => '\Google\Cloud\ContactCenterInsights\V1\CreateAnalysisOperationMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'CreateIssueModel' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ContactCenterInsights\V1\IssueModel',
                    'metadataReturnType' => '\Google\Cloud\ContactCenterInsights\V1\CreateIssueModelMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeleteIssueModel' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\ContactCenterInsights\V1\DeleteIssueModelMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'DeployIssueModel' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ContactCenterInsights\V1\DeployIssueModelResponse',
                    'metadataReturnType' => '\Google\Cloud\ContactCenterInsights\V1\DeployIssueModelMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ExportInsightsData' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ContactCenterInsights\V1\ExportInsightsDataResponse',
                    'metadataReturnType' => '\Google\Cloud\ContactCenterInsights\V1\ExportInsightsDataMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'UndeployIssueModel' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ContactCenterInsights\V1\UndeployIssueModelResponse',
                    'metadataReturnType' => '\Google\Cloud\ContactCenterInsights\V1\UndeployIssueModelMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
            'ListAnalyses' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getAnalyses',
                ],
            ],
            'ListConversations' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getConversations',
                ],
            ],
            'ListPhraseMatchers' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getPhraseMatchers',
                ],
            ],
            'ListViews' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getViews',
                ],
            ],
        ],
    ],
];
