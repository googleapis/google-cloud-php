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
        'google.cloud.language.v1.LanguageService' => [
            'AnalyzeEntities' => [
                'method' => 'post',
                'uriTemplate' => '/v1/documents:analyzeEntities',
                'body' => '*',
            ],
            'AnalyzeEntitySentiment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/documents:analyzeEntitySentiment',
                'body' => '*',
            ],
            'AnalyzeSentiment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/documents:analyzeSentiment',
                'body' => '*',
            ],
            'AnalyzeSyntax' => [
                'method' => 'post',
                'uriTemplate' => '/v1/documents:analyzeSyntax',
                'body' => '*',
            ],
            'AnnotateText' => [
                'method' => 'post',
                'uriTemplate' => '/v1/documents:annotateText',
                'body' => '*',
            ],
            'ClassifyText' => [
                'method' => 'post',
                'uriTemplate' => '/v1/documents:classifyText',
                'body' => '*',
            ],
            'ModerateText' => [
                'method' => 'post',
                'uriTemplate' => '/v1/documents:moderateText',
                'body' => '*',
            ],
        ],
    ],
    'numericEnums' => true,
];
