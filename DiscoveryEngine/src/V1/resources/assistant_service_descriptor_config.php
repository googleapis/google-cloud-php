<?php
/*
 * Copyright 2025 Google LLC
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
        'google.cloud.discoveryengine.v1.AssistantService' => [
            'StreamAssist' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'ServerStreaming',
                ],
                'callType' => \Google\ApiCore\Call::SERVER_STREAMING_CALL,
                'responseType' => 'Google\Cloud\DiscoveryEngine\V1\StreamAssistResponse',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'assistant' => 'projects/{project}/locations/{location}/collections/{collection}/engines/{engine}/assistants/{assistant}',
                'dataStore' => 'projects/{project}/locations/{location}/dataStores/{data_store}',
                'projectLocationCollectionDataStore' => 'projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}',
                'projectLocationCollectionDataStoreSession' => 'projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}/sessions/{session}',
                'projectLocationCollectionEngineSession' => 'projects/{project}/locations/{location}/collections/{collection}/engines/{engine}/sessions/{session}',
                'projectLocationDataStore' => 'projects/{project}/locations/{location}/dataStores/{data_store}',
                'projectLocationDataStoreSession' => 'projects/{project}/locations/{location}/dataStores/{data_store}/sessions/{session}',
                'session' => 'projects/{project}/locations/{location}/dataStores/{data_store}/sessions/{session}',
            ],
        ],
    ],
];
