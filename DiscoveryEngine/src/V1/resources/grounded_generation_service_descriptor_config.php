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
        'google.cloud.discoveryengine.v1.GroundedGenerationService' => [
            'CheckGrounding' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\DiscoveryEngine\V1\CheckGroundingResponse',
                'headerParams' => [
                    [
                        'keyName' => 'grounding_config',
                        'fieldAccessors' => [
                            'getGroundingConfig',
                        ],
                    ],
                ],
            ],
            'GenerateGroundedContent' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\DiscoveryEngine\V1\GenerateGroundedContentResponse',
                'headerParams' => [
                    [
                        'keyName' => 'location',
                        'fieldAccessors' => [
                            'getLocation',
                        ],
                    ],
                ],
            ],
            'StreamGenerateGroundedContent' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'BidiStreaming',
                ],
                'callType' => \Google\ApiCore\Call::BIDI_STREAMING_CALL,
                'responseType' => 'Google\Cloud\DiscoveryEngine\V1\GenerateGroundedContentResponse',
                'headerParams' => [
                    [
                        'keyName' => 'location',
                        'fieldAccessors' => [
                            'getLocation',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'groundingConfig' => 'projects/{project}/locations/{location}/groundingConfigs/{grounding_config}',
                'location' => 'projects/{project}/locations/{location}',
                'projectLocationCollectionDataStoreServingConfig' => 'projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}/servingConfigs/{serving_config}',
                'projectLocationCollectionEngineServingConfig' => 'projects/{project}/locations/{location}/collections/{collection}/engines/{engine}/servingConfigs/{serving_config}',
                'projectLocationDataStoreServingConfig' => 'projects/{project}/locations/{location}/dataStores/{data_store}/servingConfigs/{serving_config}',
                'servingConfig' => 'projects/{project}/locations/{location}/dataStores/{data_store}/servingConfigs/{serving_config}',
            ],
        ],
    ],
];
