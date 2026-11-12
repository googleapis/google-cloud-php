<?php
/*
 * Copyright 2026 Google LLC
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
        'google.cloud.saasplatform.saasservicemgmt.v1.SaasDeployments' => [
            'CreateRelease' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/releases',
                'body' => 'release',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'release_id',
                ],
            ],
            'CreateSaas' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/saas',
                'body' => 'saas',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'saas_id',
                ],
            ],
            'CreateTenant' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/tenants',
                'body' => 'tenant',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'tenant_id',
                ],
            ],
            'CreateUnit' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/units',
                'body' => 'unit',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'unit_id',
                ],
            ],
            'CreateUnitKind' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/unitKinds',
                'body' => 'unit_kind',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'unit_kind_id',
                ],
            ],
            'CreateUnitOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/unitOperations',
                'body' => 'unit_operation',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'unit_operation_id',
                ],
            ],
            'DeleteRelease' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/releases/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteSaas' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/saas/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteTenant' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/tenants/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteUnit' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/units/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteUnitKind' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/unitKinds/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteUnitOperation' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/unitOperations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRelease' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/releases/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSaas' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/saas/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetTenant' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/tenants/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetUnit' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/units/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetUnitKind' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/unitKinds/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetUnitOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/unitOperations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListReleases' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/releases',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListSaas' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/saas',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListTenants' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/tenants',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListUnitKinds' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/unitKinds',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListUnitOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/unitOperations',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListUnits' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/units',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateRelease' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{release.name=projects/*/locations/*/releases/*}',
                'body' => 'release',
                'placeholders' => [
                    'release.name' => [
                        'getters' => [
                            'getRelease',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateSaas' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{saas.name=projects/*/locations/*/saas/*}',
                'body' => 'saas',
                'placeholders' => [
                    'saas.name' => [
                        'getters' => [
                            'getSaas',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateTenant' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{tenant.name=projects/*/locations/*/tenants/*}',
                'body' => 'tenant',
                'placeholders' => [
                    'tenant.name' => [
                        'getters' => [
                            'getTenant',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateUnit' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{unit.name=projects/*/locations/*/units/*}',
                'body' => 'unit',
                'placeholders' => [
                    'unit.name' => [
                        'getters' => [
                            'getUnit',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateUnitKind' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{unit_kind.name=projects/*/locations/*/unitKinds/*}',
                'body' => 'unit_kind',
                'placeholders' => [
                    'unit_kind.name' => [
                        'getters' => [
                            'getUnitKind',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateUnitOperation' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{unit_operation.name=projects/*/locations/*/unitOperations/*}',
                'body' => 'unit_operation',
                'placeholders' => [
                    'unit_operation.name' => [
                        'getters' => [
                            'getUnitOperation',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
