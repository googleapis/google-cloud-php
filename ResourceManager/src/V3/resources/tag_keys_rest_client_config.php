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
        'google.cloud.resourcemanager.v3.TagKeys' => [
            'CreateTagKey' => [
                'method' => 'post',
                'uriTemplate' => '/v3/tagKeys',
                'body' => 'tag_key',
            ],
            'DeleteTagKey' => [
                'method' => 'delete',
                'uriTemplate' => '/v3/{name=tagKeys/*}',
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
                'uriTemplate' => '/v3/{resource=tagKeys/*}:getIamPolicy',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'GetNamespacedTagKey' => [
                'method' => 'get',
                'uriTemplate' => '/v3/tagKeys/namespaced',
                'queryParams' => [
                    'name',
                ],
            ],
            'GetTagKey' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=tagKeys/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListTagKeys' => [
                'method' => 'get',
                'uriTemplate' => '/v3/tagKeys',
                'queryParams' => [
                    'parent',
                ],
            ],
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{resource=tagKeys/*}:setIamPolicy',
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
                'uriTemplate' => '/v3/{resource=tagKeys/*}:testIamPermissions',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'UpdateTagKey' => [
                'method' => 'patch',
                'uriTemplate' => '/v3/{tag_key.name=tagKeys/*}',
                'body' => 'tag_key',
                'placeholders' => [
                    'tag_key.name' => [
                        'getters' => [
                            'getTagKey',
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
