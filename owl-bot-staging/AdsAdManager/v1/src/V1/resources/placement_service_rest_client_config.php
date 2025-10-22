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
        'google.ads.admanager.v1.PlacementService' => [
            'BatchActivatePlacements' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/placements:batchActivate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchArchivePlacements' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/placements:batchArchive',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchCreatePlacements' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/placements:batchCreate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchDeactivatePlacements' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/placements:batchDeactivate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchUpdatePlacements' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/placements:batchUpdate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreatePlacement' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=networks/*}/placements',
                'body' => 'placement',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetPlacement' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=networks/*/placements/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListPlacements' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=networks/*}/placements',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdatePlacement' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{placement.name=networks/*/placements/*}',
                'body' => 'placement',
                'placeholders' => [
                    'placement.name' => [
                        'getters' => [
                            'getPlacement',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=networks/*/operations/reports/runs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
