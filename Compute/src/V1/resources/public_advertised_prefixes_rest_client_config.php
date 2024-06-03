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
        'google.cloud.compute.v1.PublicAdvertisedPrefixes' => [
            'Announce' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/publicAdvertisedPrefixes/{public_advertised_prefix}/announce',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'public_advertised_prefix' => [
                        'getters' => [
                            'getPublicAdvertisedPrefix',
                        ],
                    ],
                ],
            ],
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/compute/v1/projects/{project}/global/publicAdvertisedPrefixes/{public_advertised_prefix}',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'public_advertised_prefix' => [
                        'getters' => [
                            'getPublicAdvertisedPrefix',
                        ],
                    ],
                ],
            ],
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/publicAdvertisedPrefixes/{public_advertised_prefix}',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'public_advertised_prefix' => [
                        'getters' => [
                            'getPublicAdvertisedPrefix',
                        ],
                    ],
                ],
            ],
            'Insert' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/publicAdvertisedPrefixes',
                'body' => 'public_advertised_prefix_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'List' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/publicAdvertisedPrefixes',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Patch' => [
                'method' => 'patch',
                'uriTemplate' => '/compute/v1/projects/{project}/global/publicAdvertisedPrefixes/{public_advertised_prefix}',
                'body' => 'public_advertised_prefix_resource',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'public_advertised_prefix' => [
                        'getters' => [
                            'getPublicAdvertisedPrefix',
                        ],
                    ],
                ],
            ],
            'Withdraw' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/publicAdvertisedPrefixes/{public_advertised_prefix}/withdraw',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'public_advertised_prefix' => [
                        'getters' => [
                            'getPublicAdvertisedPrefix',
                        ],
                    ],
                ],
            ],
        ],
        'google.cloud.compute.v1.GlobalOperations' => [
            'AggregatedList' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/aggregated/operations',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/compute/v1/projects/{project}/global/operations/{operation}',
                'placeholders' => [
                    'operation' => [
                        'getters' => [
                            'getOperation',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/operations/{operation}',
                'placeholders' => [
                    'operation' => [
                        'getters' => [
                            'getOperation',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'List' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/operations',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Wait' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/operations/{operation}/wait',
                'placeholders' => [
                    'operation' => [
                        'getters' => [
                            'getOperation',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
