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
        'google.cloud.recommender.v1.Recommender' => [
            'GetInsight' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Recommender\V1\Insight',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetInsightTypeConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Recommender\V1\InsightTypeConfig',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRecommendation' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Recommender\V1\Recommendation',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRecommenderConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Recommender\V1\RecommenderConfig',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListInsights' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getInsights',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Recommender\V1\ListInsightsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListRecommendations' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getRecommendations',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Recommender\V1\ListRecommendationsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'MarkInsightAccepted' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Recommender\V1\Insight',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'MarkRecommendationClaimed' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Recommender\V1\Recommendation',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'MarkRecommendationDismissed' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Recommender\V1\Recommendation',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'MarkRecommendationFailed' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Recommender\V1\Recommendation',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'MarkRecommendationSucceeded' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Recommender\V1\Recommendation',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateInsightTypeConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Recommender\V1\InsightTypeConfig',
                'headerParams' => [
                    [
                        'keyName' => 'insight_type_config.name',
                        'fieldAccessors' => [
                            'getInsightTypeConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateRecommenderConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Recommender\V1\RecommenderConfig',
                'headerParams' => [
                    [
                        'keyName' => 'recommender_config.name',
                        'fieldAccessors' => [
                            'getRecommenderConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'billingAccountLocationInsightType' => 'billingAccounts/{billing_account}/locations/{location}/insightTypes/{insight_type}',
                'billingAccountLocationInsightTypeConfig' => 'billingAccounts/{billing_account}/locations/{location}/insightTypes/{insight_type}/config',
                'billingAccountLocationInsightTypeInsight' => 'billingAccounts/{billing_account}/locations/{location}/insightTypes/{insight_type}/insights/{insight}',
                'billingAccountLocationRecommender' => 'billingAccounts/{billing_account}/locations/{location}/recommenders/{recommender}',
                'billingAccountLocationRecommenderConfig' => 'billingAccounts/{billing_account}/locations/{location}/recommenders/{recommender}/config',
                'billingAccountLocationRecommenderRecommendation' => 'billingAccounts/{billing_account}/locations/{location}/recommenders/{recommender}/recommendations/{recommendation}',
                'folderLocationInsightType' => 'folders/{folder}/locations/{location}/insightTypes/{insight_type}',
                'folderLocationInsightTypeInsight' => 'folders/{folder}/locations/{location}/insightTypes/{insight_type}/insights/{insight}',
                'folderLocationRecommender' => 'folders/{folder}/locations/{location}/recommenders/{recommender}',
                'folderLocationRecommenderRecommendation' => 'folders/{folder}/locations/{location}/recommenders/{recommender}/recommendations/{recommendation}',
                'insight' => 'projects/{project}/locations/{location}/insightTypes/{insight_type}/insights/{insight}',
                'insightType' => 'projects/{project}/locations/{location}/insightTypes/{insight_type}',
                'insightTypeConfig' => 'projects/{project}/locations/{location}/insightTypes/{insight_type}/config',
                'organizationLocationInsightType' => 'organizations/{organization}/locations/{location}/insightTypes/{insight_type}',
                'organizationLocationInsightTypeConfig' => 'organizations/{organization}/locations/{location}/insightTypes/{insight_type}/config',
                'organizationLocationInsightTypeInsight' => 'organizations/{organization}/locations/{location}/insightTypes/{insight_type}/insights/{insight}',
                'organizationLocationRecommender' => 'organizations/{organization}/locations/{location}/recommenders/{recommender}',
                'organizationLocationRecommenderConfig' => 'organizations/{organization}/locations/{location}/recommenders/{recommender}/config',
                'organizationLocationRecommenderRecommendation' => 'organizations/{organization}/locations/{location}/recommenders/{recommender}/recommendations/{recommendation}',
                'projectLocationInsightType' => 'projects/{project}/locations/{location}/insightTypes/{insight_type}',
                'projectLocationInsightTypeConfig' => 'projects/{project}/locations/{location}/insightTypes/{insight_type}/config',
                'projectLocationInsightTypeInsight' => 'projects/{project}/locations/{location}/insightTypes/{insight_type}/insights/{insight}',
                'projectLocationRecommender' => 'projects/{project}/locations/{location}/recommenders/{recommender}',
                'projectLocationRecommenderConfig' => 'projects/{project}/locations/{location}/recommenders/{recommender}/config',
                'projectLocationRecommenderRecommendation' => 'projects/{project}/locations/{location}/recommenders/{recommender}/recommendations/{recommendation}',
                'recommendation' => 'projects/{project}/locations/{location}/recommenders/{recommender}/recommendations/{recommendation}',
                'recommender' => 'projects/{project}/locations/{location}/recommenders/{recommender}',
                'recommenderConfig' => 'projects/{project}/locations/{location}/recommenders/{recommender}/config',
            ],
        ],
    ],
];
