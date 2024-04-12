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
        'google.devtools.cloudbuild.v2.RepositoryManager' => [
            'BatchCreateRepositories' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*/connections/*}/repositories:batchCreate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateConnection' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/connections',
                'body' => 'connection',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'connection_id',
                ],
            ],
            'CreateRepository' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*/connections/*}/repositories',
                'body' => 'repository',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'repository_id',
                ],
            ],
            'DeleteConnection' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/connections/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteRepository' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/connections/*/repositories/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'FetchGitRefs' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{repository=projects/*/locations/*/connections/*/repositories/*}:fetchGitRefs',
                'placeholders' => [
                    'repository' => [
                        'getters' => [
                            'getRepository',
                        ],
                    ],
                ],
            ],
            'FetchLinkableRepositories' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{connection=projects/*/locations/*/connections/*}:fetchLinkableRepositories',
                'placeholders' => [
                    'connection' => [
                        'getters' => [
                            'getConnection',
                        ],
                    ],
                ],
            ],
            'FetchReadToken' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{repository=projects/*/locations/*/connections/*/repositories/*}:accessReadToken',
                'body' => '*',
                'placeholders' => [
                    'repository' => [
                        'getters' => [
                            'getRepository',
                        ],
                    ],
                ],
            ],
            'FetchReadWriteToken' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{repository=projects/*/locations/*/connections/*/repositories/*}:accessReadWriteToken',
                'body' => '*',
                'placeholders' => [
                    'repository' => [
                        'getters' => [
                            'getRepository',
                        ],
                    ],
                ],
            ],
            'GetConnection' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/connections/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRepository' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/connections/*/repositories/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListConnections' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/connections',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListRepositories' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*/connections/*}/repositories',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateConnection' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{connection.name=projects/*/locations/*/connections/*}',
                'body' => 'connection',
                'placeholders' => [
                    'connection.name' => [
                        'getters' => [
                            'getConnection',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.iam.v1.IAMPolicy' => [
            'GetIamPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{resource=projects/*/locations/*/connections/*}:getIamPolicy',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{resource=projects/*/locations/*/connections/*}:setIamPolicy',
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
                'uriTemplate' => '/v2/{resource=projects/*/locations/*/connections/*}:testIamPermissions',
                'body' => '*',
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
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/operations/*}:cancel',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/operations/*}',
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
