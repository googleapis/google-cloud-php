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
        'google.cloud.discoveryengine.v1.DataConnectorService' => [
            'SetUpDataConnector' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\DiscoveryEngine\V1\DataConnector',
                    'metadataReturnType' => '\Google\Cloud\DiscoveryEngine\V1\SetUpDataConnectorMetadata',
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
            'GetDataConnector' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\DiscoveryEngine\V1\DataConnector',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateDataConnector' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\DiscoveryEngine\V1\DataConnector',
                'headerParams' => [
                    [
                        'keyName' => 'data_connector.name',
                        'fieldAccessors' => [
                            'getDataConnector',
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'contentPolicy' => 'organizations/{organization}/locations/{location}/contentPolicies/{content_policy}',
                'dataConnector' => 'projects/{project}/locations/{location}/collections/{collection}/dataConnector',
                'dataStore' => 'projects/{project}/locations/{location}/dataStores/{data_store}',
                'location' => 'projects/{project}/locations/{location}',
                'organizationLocationContentPolicy' => 'organizations/{organization}/locations/{location}/contentPolicies/{content_policy}',
                'projectLocationCollectionDataStore' => 'projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}',
                'projectLocationCollectionDataStoreSchema' => 'projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}/schemas/{schema}',
                'projectLocationContentPolicy' => 'projects/{project}/locations/{location}/contentPolicies/{content_policy}',
                'projectLocationDataStore' => 'projects/{project}/locations/{location}/dataStores/{data_store}',
                'projectLocationDataStoreSchema' => 'projects/{project}/locations/{location}/dataStores/{data_store}/schemas/{schema}',
                'schema' => 'projects/{project}/locations/{location}/dataStores/{data_store}/schemas/{schema}',
                'service' => 'projects/{project}/locations/{location}/namespaces/{namespace}/services/{service}',
            ],
        ],
    ],
];
