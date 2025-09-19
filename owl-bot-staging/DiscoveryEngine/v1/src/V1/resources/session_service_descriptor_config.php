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
        'google.cloud.discoveryengine.v1.SessionService' => [
            'CreateSession' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\DiscoveryEngine\V1\Session',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteSession' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSession' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\DiscoveryEngine\V1\Session',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListSessions' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getSessions',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\DiscoveryEngine\V1\ListSessionsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateSession' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\DiscoveryEngine\V1\Session',
                'headerParams' => [
                    [
                        'keyName' => 'session.name',
                        'fieldAccessors' => [
                            'getSession',
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'answer' => 'projects/{project}/locations/{location}/dataStores/{data_store}/sessions/{session}/answers/{answer}',
                'chunk' => 'projects/{project}/locations/{location}/dataStores/{data_store}/branches/{branch}/documents/{document}/chunks/{chunk}',
                'dataStore' => 'projects/{project}/locations/{location}/dataStores/{data_store}',
                'document' => 'projects/{project}/locations/{location}/dataStores/{data_store}/branches/{branch}/documents/{document}',
                'projectLocationCollectionDataStore' => 'projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}',
                'projectLocationCollectionDataStoreBranchDocument' => 'projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}/branches/{branch}/documents/{document}',
                'projectLocationCollectionDataStoreBranchDocumentChunk' => 'projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}/branches/{branch}/documents/{document}/chunks/{chunk}',
                'projectLocationCollectionDataStoreSession' => 'projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}/sessions/{session}',
                'projectLocationCollectionDataStoreSessionAnswer' => 'projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}/sessions/{session}/answers/{answer}',
                'projectLocationCollectionEngineSession' => 'projects/{project}/locations/{location}/collections/{collection}/engines/{engine}/sessions/{session}',
                'projectLocationCollectionEngineSessionAnswer' => 'projects/{project}/locations/{location}/collections/{collection}/engines/{engine}/sessions/{session}/answers/{answer}',
                'projectLocationDataStore' => 'projects/{project}/locations/{location}/dataStores/{data_store}',
                'projectLocationDataStoreBranchDocument' => 'projects/{project}/locations/{location}/dataStores/{data_store}/branches/{branch}/documents/{document}',
                'projectLocationDataStoreBranchDocumentChunk' => 'projects/{project}/locations/{location}/dataStores/{data_store}/branches/{branch}/documents/{document}/chunks/{chunk}',
                'projectLocationDataStoreSession' => 'projects/{project}/locations/{location}/dataStores/{data_store}/sessions/{session}',
                'projectLocationDataStoreSessionAnswer' => 'projects/{project}/locations/{location}/dataStores/{data_store}/sessions/{session}/answers/{answer}',
                'session' => 'projects/{project}/locations/{location}/dataStores/{data_store}/sessions/{session}',
            ],
        ],
    ],
];
