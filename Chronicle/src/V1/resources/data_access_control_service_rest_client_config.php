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
        'google.cloud.chronicle.v1.DataAccessControlService' => [
            'CreateDataAccessLabel' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/instances/*}/dataAccessLabels',
                'body' => 'data_access_label',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'data_access_label_id',
                ],
            ],
            'CreateDataAccessScope' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/instances/*}/dataAccessScopes',
                'body' => 'data_access_scope',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'data_access_scope_id',
                ],
            ],
            'DeleteDataAccessLabel' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*/dataAccessLabels/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteDataAccessScope' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*/dataAccessScopes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDataAccessLabel' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*/dataAccessLabels/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDataAccessScope' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*/dataAccessScopes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListDataAccessLabels' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/instances/*}/dataAccessLabels',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDataAccessScopes' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/instances/*}/dataAccessScopes',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateDataAccessLabel' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{data_access_label.name=projects/*/locations/*/instances/*/dataAccessLabels/*}',
                'body' => 'data_access_label',
                'placeholders' => [
                    'data_access_label.name' => [
                        'getters' => [
                            'getDataAccessLabel',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateDataAccessScope' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{data_access_scope.name=projects/*/locations/*/instances/*/dataAccessScopes/*}',
                'body' => 'data_access_scope',
                'placeholders' => [
                    'data_access_scope.name' => [
                        'getters' => [
                            'getDataAccessScope',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*/operations/*}:cancel',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*/operations/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*/operations/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/instances/*}/operations',
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
