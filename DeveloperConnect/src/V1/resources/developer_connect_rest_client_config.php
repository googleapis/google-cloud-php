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
            'CreateAccountConnector' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/accountConnectors',
                'body' => 'account_connector',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'account_connector_id',
                ],
            ],
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
            'DeleteAccountConnector' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/accountConnectors/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
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
            'DeleteSelf' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/accountConnectors/*}/users:deleteSelf',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteUser' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/accountConnectors/*/users/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'FetchAccessToken' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{account_connector=projects/*/locations/*/accountConnectors/*}/users:fetchAccessToken',
                'body' => '*',
                'placeholders' => [
                    'account_connector' => [
                        'getters' => [
                            'getAccountConnector',
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
            'FetchSelf' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/accountConnectors/*}/users:fetchSelf',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAccountConnector' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/accountConnectors/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
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
            'ListAccountConnectors' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/accountConnectors',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
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
            'ListUsers' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/accountConnectors/*}/users',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateAccountConnector' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{account_connector.name=projects/*/locations/*/accountConnectors/*}',
                'body' => 'account_connector',
                'placeholders' => [
                    'account_connector.name' => [
                        'getters' => [
                            'getAccountConnector',
                            'getName',
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
