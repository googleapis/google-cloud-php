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
        'google.cloud.discoveryengine.v1.CompletionService' => [
            'ImportCompletionSuggestions' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\DiscoveryEngine\V1\ImportCompletionSuggestionsResponse',
                    'metadataReturnType' => '\Google\Cloud\DiscoveryEngine\V1\ImportCompletionSuggestionsMetadata',
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
            'ImportSuggestionDenyListEntries' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\DiscoveryEngine\V1\ImportSuggestionDenyListEntriesResponse',
                    'metadataReturnType' => '\Google\Cloud\DiscoveryEngine\V1\ImportSuggestionDenyListEntriesMetadata',
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
            'PurgeCompletionSuggestions' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\DiscoveryEngine\V1\PurgeCompletionSuggestionsResponse',
                    'metadataReturnType' => '\Google\Cloud\DiscoveryEngine\V1\PurgeCompletionSuggestionsMetadata',
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
            'PurgeSuggestionDenyListEntries' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\DiscoveryEngine\V1\PurgeSuggestionDenyListEntriesResponse',
                    'metadataReturnType' => '\Google\Cloud\DiscoveryEngine\V1\PurgeSuggestionDenyListEntriesMetadata',
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
            'CompleteQuery' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\DiscoveryEngine\V1\CompleteQueryResponse',
                'headerParams' => [
                    [
                        'keyName' => 'data_store',
                        'fieldAccessors' => [
                            'getDataStore',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'dataStore' => 'projects/{project}/locations/{location}/dataStores/{data_store}',
                'projectLocationCollectionDataStore' => 'projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}',
                'projectLocationDataStore' => 'projects/{project}/locations/{location}/dataStores/{data_store}',
            ],
        ],
    ],
];
