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
        'google.cloud.discoveryengine.v1beta.ServingConfigService' => [
            'GetServingConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\DiscoveryEngine\V1beta\ServingConfig',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListServingConfigs' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getServingConfigs',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\DiscoveryEngine\V1beta\ListServingConfigsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateServingConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\DiscoveryEngine\V1beta\ServingConfig',
                'headerParams' => [
                    [
                        'keyName' => 'serving_config.name',
                        'fieldAccessors' => [
                            'getServingConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'dataStore' => 'projects/{project}/locations/{location}/dataStores/{data_store}',
                'engine' => 'projects/{project}/locations/{location}/collections/{collection}/engines/{engine}',
                'projectLocationCollectionDataStore' => 'projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}',
                'projectLocationCollectionDataStoreServingConfig' => 'projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}/servingConfigs/{serving_config}',
                'projectLocationCollectionEngineServingConfig' => 'projects/{project}/locations/{location}/collections/{collection}/engines/{engine}/servingConfigs/{serving_config}',
                'projectLocationDataStore' => 'projects/{project}/locations/{location}/dataStores/{data_store}',
                'projectLocationDataStoreServingConfig' => 'projects/{project}/locations/{location}/dataStores/{data_store}/servingConfigs/{serving_config}',
                'servingConfig' => 'projects/{project}/locations/{location}/dataStores/{data_store}/servingConfigs/{serving_config}',
            ],
        ],
    ],
];
