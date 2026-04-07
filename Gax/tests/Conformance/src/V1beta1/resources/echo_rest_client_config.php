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
            'ListLocations' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*}/locations',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetLocation' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.iam.v1.IAMPolicy' => [
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{resource=users/*}:setIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta1/{resource=rooms/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta1/{resource=rooms/*/blurbs/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta1/{resource=sequences/*}:setIamPolicy',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'GetIamPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{resource=users/*}:getIamPolicy',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta1/{resource=rooms/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta1/{resource=rooms/*/blurbs/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta1/{resource=sequences/*}:getIamPolicy',
                    ],
                ],
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'TestIamPermissions' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{resource=users/*}:testIamPermissions',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta1/{resource=rooms/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta1/{resource=rooms/*/blurbs/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta1/{resource=sequences/*}:testIamPermissions',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/operations',
            ],
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{name=operations/**}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteOperation' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta1/{name=operations/**}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=operations/**}:cancel',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.showcase.v1beta1.Echo' => [
            'Block' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/echo:block',
                'body' => '*',
            ],
            'Echo' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/echo:echo',
                'body' => '*',
            ],
            'EchoErrorDetails' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/echo:error-details',
                'body' => '*',
            ],
            'Expand' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/echo:expand',
                'body' => '*',
            ],
            'FailEchoWithDetails' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/echo:failWithDetails',
                'body' => '*',
            ],
            'PagedExpand' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/echo:pagedExpand',
                'body' => '*',
            ],
            'PagedExpandLegacy' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/echo:pagedExpandLegacy',
                'body' => '*',
            ],
            'PagedExpandLegacyMapped' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/echo:pagedExpandLegacyMapped',
                'body' => '*',
            ],
            'Wait' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/echo:wait',
                'body' => '*',
            ],
        ],
    ],
    'numericEnums' => true,
];
