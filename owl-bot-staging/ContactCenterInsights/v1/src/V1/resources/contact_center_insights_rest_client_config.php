<?php

return [
    'interfaces' => [
        'google.cloud.contactcenterinsights.v1.ContactCenterInsights' => [
            'CalculateIssueModelStats' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{issue_model=projects/*/locations/*/issueModels/*}:calculateIssueModelStats',
                'placeholders' => [
                    'issue_model' => [
                        'getters' => [
                            'getIssueModel',
                        ],
                    ],
                ],
            ],
            'CalculateStats' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{location=projects/*/locations/*}/conversations:calculateStats',
                'placeholders' => [
                    'location' => [
                        'getters' => [
                            'getLocation',
                        ],
                    ],
                ],
            ],
            'CreateAnalysis' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/conversations/*}/analyses',
                'body' => 'analysis',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateConversation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/conversations',
                'body' => 'conversation',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateIssueModel' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/issueModels',
                'body' => 'issue_model',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreatePhraseMatcher' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/phraseMatchers',
                'body' => 'phrase_matcher',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateView' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/views',
                'body' => 'view',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteAnalysis' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/conversations/*/analyses/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteConversation' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/conversations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteIssueModel' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/issueModels/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeletePhraseMatcher' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/phraseMatchers/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteView' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/views/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeployIssueModel' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/issueModels/*}:deploy',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ExportInsightsData' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/insightsdata:export',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetAnalysis' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/conversations/*/analyses/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetConversation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/conversations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetIssue' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/issueModels/*/issues/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetIssueModel' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/issueModels/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetPhraseMatcher' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/phraseMatchers/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSettings' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/settings}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetView' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/views/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAnalyses' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/conversations/*}/analyses',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListConversations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/conversations',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListIssueModels' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/issueModels',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListIssues' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/issueModels/*}/issues',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListPhraseMatchers' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/phraseMatchers',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListViews' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/views',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UndeployIssueModel' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/issueModels/*}:undeploy',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateConversation' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{conversation.name=projects/*/locations/*/conversations/*}',
                'body' => 'conversation',
                'placeholders' => [
                    'conversation.name' => [
                        'getters' => [
                            'getConversation',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateIssue' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{issue.name=projects/*/locations/*/issueModels/*/issues/*}',
                'body' => 'issue',
                'placeholders' => [
                    'issue.name' => [
                        'getters' => [
                            'getIssue',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateIssueModel' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{issue_model.name=projects/*/locations/*/issueModels/*}',
                'body' => 'issue_model',
                'placeholders' => [
                    'issue_model.name' => [
                        'getters' => [
                            'getIssueModel',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdatePhraseMatcher' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{phrase_matcher.name=projects/*/locations/*/phraseMatchers/*}',
                'body' => 'phrase_matcher',
                'placeholders' => [
                    'phrase_matcher.name' => [
                        'getters' => [
                            'getPhraseMatcher',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateSettings' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{settings.name=projects/*/locations/*/settings}',
                'body' => 'settings',
                'placeholders' => [
                    'settings.name' => [
                        'getters' => [
                            'getSettings',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateView' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{view.name=projects/*/locations/*/views/*}',
                'body' => 'view',
                'placeholders' => [
                    'view.name' => [
                        'getters' => [
                            'getView',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}:cancel',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*}/operations',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
