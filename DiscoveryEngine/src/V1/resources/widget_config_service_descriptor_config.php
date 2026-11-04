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
        'google.cloud.discoveryengine.v1.WidgetConfigService' => [
            'GetWidgetConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\DiscoveryEngine\V1\WidgetConfig',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateWidgetConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\DiscoveryEngine\V1\WidgetConfig',
                'headerParams' => [
                    [
                        'keyName' => 'widget_config.name',
                        'fieldAccessors' => [
                            'getWidgetConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'projectLocationCollectionDataStoreWidgetConfig' => 'projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}/widgetConfigs/{widget_config}',
                'projectLocationCollectionEngineWidgetConfig' => 'projects/{project}/locations/{location}/collections/{collection}/engines/{engine}/widgetConfigs/{widget_config}',
                'projectLocationDataStoreWidgetConfig' => 'projects/{project}/locations/{location}/dataStores/{data_store}/widgetConfigs/{widget_config}',
                'widgetConfig' => 'projects/{project}/locations/{location}/dataStores/{data_store}/widgetConfigs/{widget_config}',
            ],
        ],
    ],
];
