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
        'google.cloud.retail.v2.GenerativeQuestionService' => [
            'BatchUpdateGenerativeQuestionConfigs' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*/catalogs/*}/generativeQuestion:batchUpdate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetGenerativeQuestionsFeatureConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{catalog=projects/*/locations/*/catalogs/*}/generativeQuestionFeature',
                'placeholders' => [
                    'catalog' => [
                        'getters' => [
                            'getCatalog',
                        ],
                    ],
                ],
            ],
            'ListGenerativeQuestionConfigs' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*/catalogs/*}/generativeQuestions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateGenerativeQuestionConfig' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{generative_question_config.catalog=projects/*/locations/*/catalogs/*}/generativeQuestion',
                'body' => 'generative_question_config',
                'placeholders' => [
                    'generative_question_config.catalog' => [
                        'getters' => [
                            'getGenerativeQuestionConfig',
                            'getCatalog',
                        ],
                    ],
                ],
            ],
            'UpdateGenerativeQuestionsFeatureConfig' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{generative_questions_feature_config.catalog=projects/*/locations/*/catalogs/*}/generativeQuestionFeature',
                'body' => 'generative_questions_feature_config',
                'placeholders' => [
                    'generative_questions_feature_config.catalog' => [
                        'getters' => [
                            'getGenerativeQuestionsFeatureConfig',
                            'getCatalog',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/operations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/catalogs/*/branches/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/catalogs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/operations/*}',
                    ],
                ],
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
                'uriTemplate' => '/v2/{name=projects/*/locations/*}/operations',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/catalogs/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*}/operations',
                    ],
                ],
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
