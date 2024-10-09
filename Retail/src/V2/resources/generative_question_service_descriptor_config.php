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
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Retail\V2\BatchUpdateGenerativeQuestionConfigsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetGenerativeQuestionsFeatureConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Retail\V2\GenerativeQuestionsFeatureConfig',
                'headerParams' => [
                    [
                        'keyName' => 'catalog',
                        'fieldAccessors' => [
                            'getCatalog',
                        ],
                    ],
                ],
            ],
            'ListGenerativeQuestionConfigs' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Retail\V2\ListGenerativeQuestionConfigsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateGenerativeQuestionConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Retail\V2\GenerativeQuestionConfig',
                'headerParams' => [
                    [
                        'keyName' => 'generative_question_config.catalog',
                        'fieldAccessors' => [
                            'getGenerativeQuestionConfig',
                            'getCatalog',
                        ],
                    ],
                ],
            ],
            'UpdateGenerativeQuestionsFeatureConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Retail\V2\GenerativeQuestionsFeatureConfig',
                'headerParams' => [
                    [
                        'keyName' => 'generative_questions_feature_config.catalog',
                        'fieldAccessors' => [
                            'getGenerativeQuestionsFeatureConfig',
                            'getCatalog',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'catalog' => 'projects/{project}/locations/{location}/catalogs/{catalog}',
            ],
        ],
    ],
];
