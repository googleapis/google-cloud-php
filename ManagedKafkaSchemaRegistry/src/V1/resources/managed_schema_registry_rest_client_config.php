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
        'google.cloud.managedkafka.schemaregistry.v1.ManagedSchemaRegistry' => [
            'CheckCompatibility' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/schemaRegistries/*/compatibility/**}',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/schemaRegistries/*/contexts/*/compatibility/**}',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateSchemaRegistry' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/schemaRegistries',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateVersion' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/schemaRegistries/*/subjects/*}/versions',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=projects/*/locations/*/schemaRegistries/*/contexts/*/subjects/*}/versions',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteSchemaConfig' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/schemaRegistries/*/config/**}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/schemaRegistries/*/contexts/*/config/**}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteSchemaMode' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/schemaRegistries/*/mode/**}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/schemaRegistries/*/contexts/*/mode/**}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteSchemaRegistry' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/schemaRegistries/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteSubject' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/schemaRegistries/*/subjects/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/schemaRegistries/*/contexts/*/subjects/*}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteVersion' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/schemaRegistries/*/subjects/*/versions/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/schemaRegistries/*/contexts/*/subjects/*/versions/*}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetContext' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/schemaRegistries/*/contexts/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRawSchema' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/schemaRegistries/*/schemas/**}/schema',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/schemaRegistries/*/contexts/*/schemas/**}/schema',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRawSchemaVersion' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/schemaRegistries/*/subjects/*/versions/*}/schema',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/schemaRegistries/*/contexts/*/subjects/*/versions/*}/schema',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSchema' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/schemaRegistries/*/schemas/**}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/schemaRegistries/*/contexts/*/schemas/**}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSchemaConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/schemaRegistries/*/config/**}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/schemaRegistries/*/contexts/*/config/**}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSchemaMode' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/schemaRegistries/*/mode/**}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/schemaRegistries/*/contexts/*/mode/**}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSchemaRegistry' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/schemaRegistries/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetVersion' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/schemaRegistries/*/subjects/*/versions/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/schemaRegistries/*/contexts/*/subjects/*/versions/*}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListContexts' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/schemaRegistries/*}/contexts',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListReferencedSchemas' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/schemaRegistries/*/subjects/*/versions/*}/referencedby',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=projects/*/locations/*/schemaRegistries/*/contexts/*/subjects/*/versions/*}/referencedby',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListSchemaRegistries' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/schemaRegistries',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListSchemaTypes' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/schemaRegistries/*}/schemas/types',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=projects/*/locations/*/schemaRegistries/*/contexts/*}/schemas/types',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListSchemaVersions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/schemaRegistries/*/schemas/**}/versions',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=projects/*/locations/*/schemaRegistries/*/contexts/*/schemas/**}/versions',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListSubjects' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/schemaRegistries/*}/subjects',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=projects/*/locations/*/schemaRegistries/*/contexts/*}/subjects',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListSubjectsBySchemaId' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/schemaRegistries/*/schemas/**}/subjects',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=projects/*/locations/*/schemaRegistries/*/contexts/*/schemas/**}/subjects',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListVersions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/schemaRegistries/*/subjects/*}/versions',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=projects/*/locations/*/schemaRegistries/*/contexts/*/subjects/*}/versions',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'LookupVersion' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/schemaRegistries/*/subjects/*}',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=projects/*/locations/*/schemaRegistries/*/contexts/*/subjects/*}',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateSchemaConfig' => [
                'method' => 'put',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/schemaRegistries/*/config/**}',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'put',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/schemaRegistries/*/contexts/*/config/**}',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateSchemaMode' => [
                'method' => 'put',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/schemaRegistries/*/mode/**}',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'put',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/schemaRegistries/*/contexts/*/mode/**}',
                        'body' => '*',
                    ],
                ],
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
