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
        'google.cloud.resourcemanager.v3.TagValues' => [
            'CreateTagValue' => [
                'method' => 'post',
                'uriTemplate' => '/v3/tagValues',
                'body' => 'tag_value',
            ],
            'DeleteTagValue' => [
                'method' => 'delete',
                'uriTemplate' => '/v3/{name=tagValues/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{resource=tagValues/*}:getIamPolicy',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'GetNamespacedTagValue' => [
                'method' => 'get',
                'uriTemplate' => '/v3/tagValues/namespaced',
                'queryParams' => [
                    'name',
                ],
            ],
            'GetTagValue' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=tagValues/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListTagValues' => [
                'method' => 'get',
                'uriTemplate' => '/v3/tagValues',
                'queryParams' => [
                    'parent',
                ],
            ],
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{resource=tagValues/*}:setIamPolicy',
                'body' => '*',
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
                'uriTemplate' => '/v3/{resource=tagValues/*}:testIamPermissions',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'UpdateTagValue' => [
                'method' => 'patch',
                'uriTemplate' => '/v3/{tag_value.name=tagValues/*}',
                'body' => 'tag_value',
                'placeholders' => [
                    'tag_value.name' => [
                        'getters' => [
                            'getTagValue',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=operations/**}',
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
