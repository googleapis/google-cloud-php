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
        'google.cloud.resourcemanager.v3.Projects' => [
            'CreateProject' => [
                'method' => 'post',
                'uriTemplate' => '/v3/projects',
                'body' => 'project',
            ],
            'DeleteProject' => [
                'method' => 'delete',
                'uriTemplate' => '/v3/{name=projects/*}',
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
                'uriTemplate' => '/v3/{resource=projects/*}:getIamPolicy',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'GetProject' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListProjects' => [
                'method' => 'get',
                'uriTemplate' => '/v3/projects',
                'queryParams' => [
                    'parent',
                ],
            ],
            'MoveProject' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{name=projects/*}:move',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SearchProjects' => [
                'method' => 'get',
                'uriTemplate' => '/v3/projects:search',
            ],
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{resource=projects/*}:setIamPolicy',
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
                'uriTemplate' => '/v3/{resource=projects/*}:testIamPermissions',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'UndeleteProject' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{name=projects/*}:undelete',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateProject' => [
                'method' => 'patch',
                'uriTemplate' => '/v3/{project.name=projects/*}',
                'body' => 'project',
                'placeholders' => [
                    'project.name' => [
                        'getters' => [
                            'getProject',
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
