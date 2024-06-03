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
        'google.cloud.compute.v1.Networks' => [
            'AddPeering' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/networks/{network}/addPeering',
                'body' => 'networks_add_peering_request_resource',
                'placeholders' => [
                    'network' => [
                        'getters' => [
                            'getNetwork',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/compute/v1/projects/{project}/global/networks/{network}',
                'placeholders' => [
                    'network' => [
                        'getters' => [
                            'getNetwork',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/networks/{network}',
                'placeholders' => [
                    'network' => [
                        'getters' => [
                            'getNetwork',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'GetEffectiveFirewalls' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/networks/{network}/getEffectiveFirewalls',
                'placeholders' => [
                    'network' => [
                        'getters' => [
                            'getNetwork',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Insert' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/networks',
                'body' => 'network_resource',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/networks',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'ListPeeringRoutes' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/networks/{network}/listPeeringRoutes',
                'placeholders' => [
                    'network' => [
                        'getters' => [
                            'getNetwork',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Patch' => [
                'method' => 'patch',
                'uriTemplate' => '/compute/v1/projects/{project}/global/networks/{network}',
                'body' => 'network_resource',
                'placeholders' => [
                    'network' => [
                        'getters' => [
                            'getNetwork',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'RemovePeering' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/networks/{network}/removePeering',
                'body' => 'networks_remove_peering_request_resource',
                'placeholders' => [
                    'network' => [
                        'getters' => [
                            'getNetwork',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'SwitchToCustomMode' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/global/networks/{network}/switchToCustomMode',
                'placeholders' => [
                    'network' => [
                        'getters' => [
                            'getNetwork',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'UpdatePeering' => [
                'method' => 'patch',
                'uriTemplate' => '/compute/v1/projects/{project}/global/networks/{network}/updatePeering',
                'body' => 'networks_update_peering_request_resource',
                'placeholders' => [
                    'network' => [
                        'getters' => [
                            'getNetwork',
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
