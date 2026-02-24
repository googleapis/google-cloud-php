<?php
/*
 * Copyright 2026 Google LLC
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
        'google.cloud.gkerecommender.v1.GkeInferenceQuickstart' => [
            'FetchBenchmarkingData' => [
                'method' => 'post',
                'uriTemplate' => '/v1/benchmarkingData:fetch',
                'body' => '*',
            ],
            'FetchModelServerVersions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/modelServerVersions:fetch',
            ],
            'FetchModelServers' => [
                'method' => 'get',
                'uriTemplate' => '/v1/modelServers:fetch',
            ],
            'FetchModels' => [
                'method' => 'get',
                'uriTemplate' => '/v1/models:fetch',
            ],
            'FetchProfiles' => [
                'method' => 'post',
                'uriTemplate' => '/v1/profiles:fetch',
                'body' => '*',
            ],
            'GenerateOptimizedManifest' => [
                'method' => 'post',
                'uriTemplate' => '/v1/optimizedManifest:generate',
                'body' => '*',
            ],
        ],
    ],
    'numericEnums' => true,
];
