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
        'google.cloud.developerconnect.v1.DeveloperConnect' => [
            'CreateConnection' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/connections',
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
            'CreateGitRepositoryLink' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/connections/*}/gitRepositoryLinks',
                'body' => 'git_repository_link',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'git_repository_link_id',
                ],
            ],
            'DeleteConnection' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/connections/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteGitRepositoryLink' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/connections/*/gitRepositoryLinks/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'FetchGitHubInstallations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{connection=projects/*/locations/*/connections/*}:fetchGitHubInstallations',
                'placeholders' => [
                    'connection' => [
                        'getters' => [
                            'getConnection',
                        ],
                    ],
                ],
            ],
            'FetchGitRefs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{git_repository_link=projects/*/locations/*/connections/*/gitRepositoryLinks/*}:fetchGitRefs',
                'placeholders' => [
                    'git_repository_link' => [
                        'getters' => [
                            'getGitRepositoryLink',
                        ],
                    ],
                ],
            ],
            'FetchLinkableGitRepositories' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{connection=projects/*/locations/*/connections/*}:fetchLinkableGitRepositories',
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
                'uriTemplate' => '/v1/{git_repository_link=projects/*/locations/*/connections/*/gitRepositoryLinks/*}:fetchReadToken',
                'body' => '*',
                'placeholders' => [
                    'git_repository_link' => [
                        'getters' => [
                            'getGitRepositoryLink',
                        ],
                    ],
                ],
            ],
            'FetchReadWriteToken' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{git_repository_link=projects/*/locations/*/connections/*/gitRepositoryLinks/*}:fetchReadWriteToken',
                'body' => '*',
                'placeholders' => [
                    'git_repository_link' => [
                        'getters' => [
                            'getGitRepositoryLink',
                        ],
                    ],
                ],
            ],
            'GetConnection' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/connections/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetGitRepositoryLink' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/connections/*/gitRepositoryLinks/*}',
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
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/connections',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListGitRepositoryLinks' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/connections/*}/gitRepositoryLinks',
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
                'uriTemplate' => '/v1/{connection.name=projects/*/locations/*/connections/*}',
                'body' => 'connection',
                'placeholders' => [
                    'connection.name' => [
                        'getters' => [
                            'getConnection',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
        ],
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
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}:cancel',
                'body' => '*',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*}/operations',
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
