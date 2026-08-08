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
        'google.cloud.visionai.v1.LiveVideoAnalytics' => [
            'BatchRunProcess' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/clusters/*}/processes:batchRun',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateAnalysis' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/clusters/*}/analyses',
                'body' => 'analysis',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'analysis_id',
                ],
            ],
            'CreateOperator' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/operators',
                'body' => 'operator',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'operator_id',
                ],
            ],
            'CreateProcess' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/clusters/*}/processes',
                'body' => 'process',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'process_id',
                ],
            ],
            'DeleteAnalysis' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*/analyses/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteOperator' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operators/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteProcess' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*/processes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAnalysis' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*/analyses/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetOperator' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operators/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetProcess' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*/processes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAnalyses' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/clusters/*}/analyses',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListOperators' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/operators',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListProcesses' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/clusters/*}/processes',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListPublicOperators' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}:listPublicOperators',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ResolveOperatorInfo' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}:resolveOperatorInfo',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateAnalysis' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{analysis.name=projects/*/locations/*/clusters/*/analyses/*}',
                'body' => 'analysis',
                'placeholders' => [
                    'analysis.name' => [
                        'getters' => [
                            'getAnalysis',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateOperator' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{operator.name=projects/*/locations/*/operators/*}',
                'body' => 'operator',
                'placeholders' => [
                    'operator.name' => [
                        'getters' => [
                            'getOperator',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateProcess' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{process.name=projects/*/locations/*/clusters/*/processes/*}',
                'body' => 'process',
                'placeholders' => [
                    'process.name' => [
                        'getters' => [
                            'getProcess',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
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
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/warehouseOperations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/corpora/*/assets/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/corpora/*/collections/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/corpora/*/imageIndexes/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/corpora/*/indexes/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/corpora/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/indexEndpoints/*/operations/*}',
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
