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
        'google.cloud.chronicle.v1.SearchService' => [
            'Search' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Chronicle\V1\SearchSession',
                    'metadataReturnType' => '\Google\Cloud\Chronicle\V1\SearchOperationMetadata',
                    'initialPollDelayMillis' => '1000',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '10000',
                    'totalPollTimeoutMillis' => '600000',
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
            'ListSearchedResults' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getSearchedResults',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Chronicle\V1\ListSearchedResultsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'dataAccessScope' => 'projects/{project}/locations/{location}/instances/{instance}/dataAccessScopes/{data_access_scope}',
                'instance' => 'projects/{project}/locations/{location}/instances/{instance}',
                'searchSession' => 'projects/{project}/locations/{location}/instances/{instance}/searchSessions/{search_session}',
            ],
        ],
    ],
];
