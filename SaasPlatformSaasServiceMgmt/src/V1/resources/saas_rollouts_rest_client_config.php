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
        'google.cloud.saasplatform.saasservicemgmt.v1.SaasRollouts' => [
            'CreateRollout' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/rollouts',
                'body' => 'rollout',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'rollout_id',
                ],
            ],
            'CreateRolloutKind' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/rolloutKinds',
                'body' => 'rollout_kind',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'rollout_kind_id',
                ],
            ],
            'DeleteRollout' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/rollouts/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteRolloutKind' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/rolloutKinds/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRollout' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/rollouts/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRolloutKind' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/rolloutKinds/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListRolloutKinds' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/rolloutKinds',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListRollouts' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/rollouts',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateRollout' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{rollout.name=projects/*/locations/*/rollouts/*}',
                'body' => 'rollout',
                'placeholders' => [
                    'rollout.name' => [
                        'getters' => [
                            'getRollout',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateRolloutKind' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{rollout_kind.name=projects/*/locations/*/rolloutKinds/*}',
                'body' => 'rollout_kind',
                'placeholders' => [
                    'rollout_kind.name' => [
                        'getters' => [
                            'getRolloutKind',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
