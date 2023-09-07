<?php

return [
    'interfaces' => [
        'google.cloud.contactcenterinsights.v1.ContactCenterInsights' => [
            'BulkAnalyzeConversations' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ContactCenterInsights\V1\BulkAnalyzeConversationsResponse',
                    'metadataReturnType' => '\Google\Cloud\ContactCenterInsights\V1\BulkAnalyzeConversationsMetadata',
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
            'CreateAnalysis' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ContactCenterInsights\V1\Analysis',
                    'metadataReturnType' => '\Google\Cloud\ContactCenterInsights\V1\CreateAnalysisOperationMetadata',
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
            'CreateIssueModel' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ContactCenterInsights\V1\IssueModel',
                    'metadataReturnType' => '\Google\Cloud\ContactCenterInsights\V1\CreateIssueModelMetadata',
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
            'DeleteIssueModel' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Cloud\ContactCenterInsights\V1\DeleteIssueModelMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
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
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
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
            'IngestConversations' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ContactCenterInsights\V1\IngestConversationsResponse',
                    'metadataReturnType' => '\Google\Cloud\ContactCenterInsights\V1\IngestConversationsMetadata',
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
            'UndeployIssueModel' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ContactCenterInsights\V1\UndeployIssueModelResponse',
                    'metadataReturnType' => '\Google\Cloud\ContactCenterInsights\V1\UndeployIssueModelMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UploadConversation' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\ContactCenterInsights\V1\Conversation',
                    'metadataReturnType' => '\Google\Cloud\ContactCenterInsights\V1\UploadConversationMetadata',
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
            'CalculateIssueModelStats' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ContactCenterInsights\V1\CalculateIssueModelStatsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'issue_model',
                        'fieldAccessors' => [
                            'getIssueModel',
                        ],
                    ],
                ],
            ],
            'CalculateStats' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ContactCenterInsights\V1\CalculateStatsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'location',
                        'fieldAccessors' => [
                            'getLocation',
                        ],
                    ],
                ],
            ],
            'CreateConversation' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ContactCenterInsights\V1\Conversation',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreatePhraseMatcher' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ContactCenterInsights\V1\PhraseMatcher',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateView' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ContactCenterInsights\V1\View',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteAnalysis' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteConversation' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteIssue' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeletePhraseMatcher' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteView' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAnalysis' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ContactCenterInsights\V1\Analysis',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetConversation' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ContactCenterInsights\V1\Conversation',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetIssue' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ContactCenterInsights\V1\Issue',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetIssueModel' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ContactCenterInsights\V1\IssueModel',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetPhraseMatcher' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ContactCenterInsights\V1\PhraseMatcher',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSettings' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ContactCenterInsights\V1\Settings',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetView' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ContactCenterInsights\V1\View',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
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
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\ContactCenterInsights\V1\ListAnalysesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
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
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\ContactCenterInsights\V1\ListConversationsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListIssueModels' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ContactCenterInsights\V1\ListIssueModelsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListIssues' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ContactCenterInsights\V1\ListIssuesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
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
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\ContactCenterInsights\V1\ListPhraseMatchersResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
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
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\ContactCenterInsights\V1\ListViewsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateConversation' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ContactCenterInsights\V1\Conversation',
                'headerParams' => [
                    [
                        'keyName' => 'conversation.name',
                        'fieldAccessors' => [
                            'getConversation',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateIssue' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ContactCenterInsights\V1\Issue',
                'headerParams' => [
                    [
                        'keyName' => 'issue.name',
                        'fieldAccessors' => [
                            'getIssue',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateIssueModel' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ContactCenterInsights\V1\IssueModel',
                'headerParams' => [
                    [
                        'keyName' => 'issue_model.name',
                        'fieldAccessors' => [
                            'getIssueModel',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdatePhraseMatcher' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ContactCenterInsights\V1\PhraseMatcher',
                'headerParams' => [
                    [
                        'keyName' => 'phrase_matcher.name',
                        'fieldAccessors' => [
                            'getPhraseMatcher',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateSettings' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ContactCenterInsights\V1\Settings',
                'headerParams' => [
                    [
                        'keyName' => 'settings.name',
                        'fieldAccessors' => [
                            'getSettings',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateView' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ContactCenterInsights\V1\View',
                'headerParams' => [
                    [
                        'keyName' => 'view.name',
                        'fieldAccessors' => [
                            'getView',
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'analysis' => 'projects/{project}/locations/{location}/conversations/{conversation}/analyses/{analysis}',
                'conversation' => 'projects/{project}/locations/{location}/conversations/{conversation}',
                'conversationProfile' => 'projects/{project}/locations/{location}/conversationProfiles/{conversation_profile}',
                'issue' => 'projects/{project}/locations/{location}/issueModels/{issue_model}/issues/{issue}',
                'issueModel' => 'projects/{project}/locations/{location}/issueModels/{issue_model}',
                'location' => 'projects/{project}/locations/{location}',
                'participant' => 'projects/{project}/conversations/{conversation}/participants/{participant}',
                'phraseMatcher' => 'projects/{project}/locations/{location}/phraseMatchers/{phrase_matcher}',
                'projectConversationParticipant' => 'projects/{project}/conversations/{conversation}/participants/{participant}',
                'projectLocationConversationParticipant' => 'projects/{project}/locations/{location}/conversations/{conversation}/participants/{participant}',
                'settings' => 'projects/{project}/locations/{location}/settings',
                'view' => 'projects/{project}/locations/{location}/views/{view}',
            ],
        ],
    ],
];
