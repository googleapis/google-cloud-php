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
        'google.cloud.location.Locations' => [
            'GetLocation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListLocations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*}/locations',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.cloud.modelarmor.v1.ModelArmor' => [
            'CreateTemplate' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/templates',
                'body' => 'template',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'template_id',
                ],
            ],
            'DeleteTemplate' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/templates/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetFloorSetting' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/floorSetting}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=folders/*/locations/*/floorSetting}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=organizations/*/locations/*/floorSetting}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetTemplate' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/templates/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListTemplates' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/templates',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'SanitizeModelResponse' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/templates/*}:sanitizeModelResponse',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SanitizeUserPrompt' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/templates/*}:sanitizeUserPrompt',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateFloorSetting' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{floor_setting.name=projects/*/locations/*/floorSetting}',
                'body' => 'floor_setting',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{floor_setting.name=folders/*/locations/*/floorSetting}',
                        'body' => 'floor_setting',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{floor_setting.name=organizations/*/locations/*/floorSetting}',
                        'body' => 'floor_setting',
                    ],
                ],
                'placeholders' => [
                    'floor_setting.name' => [
                        'getters' => [
                            'getFloorSetting',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateTemplate' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{template.name=projects/*/locations/*/templates/*}',
                'body' => 'template',
                'placeholders' => [
                    'template.name' => [
                        'getters' => [
                            'getTemplate',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
