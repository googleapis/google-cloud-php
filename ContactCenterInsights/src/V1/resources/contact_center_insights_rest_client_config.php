<?php
/*
 * Copyright 2024 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was automatically generated - do not edit!
 */

return [
    'interfaces' => [
        'google.cloud.contactcenterinsights.v1.ContactCenterInsights' => [
            'BulkAnalyzeConversations' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/conversations:bulkAnalyze',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BulkDeleteConversations' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/conversations:bulkDelete',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BulkDownloadFeedbackLabels' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}:bulkDownloadFeedbackLabels',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BulkUploadFeedbackLabels' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}:bulkUploadFeedbackLabels',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
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
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{location=projects/*/locations/*/authorizedViewSet/*/authorizedView/*}:calculateStats',
                    ],
                ],
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
            'CreateAnalysisRule' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/analysisRules',
                'body' => 'analysis_rule',
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
            'CreateFeedbackLabel' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/conversations/*}/feedbackLabels',
                'body' => 'feedback_label',
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
            'CreateQaQuestion' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/qaScorecards/*/revisions/*}/qaQuestions',
                'body' => 'qa_question',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateQaScorecard' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/qaScorecards',
                'body' => 'qa_scorecard',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateQaScorecardRevision' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/qaScorecards/*}/revisions',
                'body' => 'qa_scorecard_revision',
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
            'DeleteAnalysisRule' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/analysisRules/*}',
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
            'DeleteFeedbackLabel' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/conversations/*/feedbackLabels/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteIssue' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/issueModels/*/issues/*}',
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
            'DeleteQaQuestion' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/qaScorecards/*/revisions/*/qaQuestions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteQaScorecard' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/qaScorecards/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteQaScorecardRevision' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/qaScorecards/*/revisions/*}',
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
            'DeployQaScorecardRevision' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/qaScorecards/*/revisions/*}:deploy',
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
            'ExportIssueModel' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/issueModels/*}:export',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
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
            'GetAnalysisRule' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/analysisRules/*}',
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
            'GetEncryptionSpec' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/encryptionSpec}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetFeedbackLabel' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/conversations/*/feedbackLabels/*}',
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
            'GetQaQuestion' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/qaScorecards/*/revisions/*/qaQuestions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetQaScorecard' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/qaScorecards/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetQaScorecardRevision' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/qaScorecards/*/revisions/*}',
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
            'ImportIssueModel' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/issueModels:import',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'IngestConversations' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/conversations:ingest',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'InitializeEncryptionSpec' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{encryption_spec.name=projects/*/locations/*/encryptionSpec}:initialize',
                'body' => '*',
                'placeholders' => [
                    'encryption_spec.name' => [
                        'getters' => [
                            'getEncryptionSpec',
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAllFeedbackLabels' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}:listAllFeedbackLabels',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
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
            'ListAnalysisRules' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/analysisRules',
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
            'ListFeedbackLabels' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/conversations/*}/feedbackLabels',
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
            'ListQaQuestions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/qaScorecards/*/revisions/*}/qaQuestions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListQaScorecardRevisions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/qaScorecards/*}/revisions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListQaScorecards' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/qaScorecards',
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
            'QueryMetrics' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{location=projects/*/locations/*}:queryMetrics',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{location=projects/*/locations/*/authorizedViewSet/*/authorizedView/*}:queryMetrics',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'location' => [
                        'getters' => [
                            'getLocation',
                        ],
                    ],
                ],
            ],
            'TuneQaScorecardRevision' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/qaScorecards/*/revisions/*}:tuneQaScorecardRevision',
                'body' => '*',
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
            'UndeployQaScorecardRevision' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/qaScorecards/*/revisions/*}:undeploy',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateAnalysisRule' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{analysis_rule.name=projects/*/locations/*/analysisRules/*}',
                'body' => 'analysis_rule',
                'placeholders' => [
                    'analysis_rule.name' => [
                        'getters' => [
                            'getAnalysisRule',
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
            'UpdateFeedbackLabel' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{feedback_label.name=projects/*/locations/*/conversations/*/feedbackLabels/*}',
                'body' => 'feedback_label',
                'placeholders' => [
                    'feedback_label.name' => [
                        'getters' => [
                            'getFeedbackLabel',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
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
            'UpdateQaQuestion' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{qa_question.name=projects/*/locations/*/qaScorecards/*/revisions/*/qaQuestions/*}',
                'body' => 'qa_question',
                'placeholders' => [
                    'qa_question.name' => [
                        'getters' => [
                            'getQaQuestion',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateQaScorecard' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{qa_scorecard.name=projects/*/locations/*/qaScorecards/*}',
                'body' => 'qa_scorecard',
                'placeholders' => [
                    'qa_scorecard.name' => [
                        'getters' => [
                            'getQaScorecard',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
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
            'UploadConversation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/conversations:upload',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
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
    'numericEnums' => true,
];
