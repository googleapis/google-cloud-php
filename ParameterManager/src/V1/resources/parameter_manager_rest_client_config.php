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
        'google.cloud.parametermanager.v1.ParameterManager' => [
            'CreateParameter' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/parameters',
                'body' => 'parameter',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'parameter_id',
                ],
            ],
            'CreateParameterVersion' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/parameters/*}/versions',
                'body' => 'parameter_version',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'parameter_version_id',
                ],
            ],
            'DeleteParameter' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/parameters/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteParameterVersion' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/parameters/*/versions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetParameter' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/parameters/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetParameterVersion' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/parameters/*/versions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListParameterVersions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/parameters/*}/versions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListParameters' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/parameters',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RenderParameterVersion' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/parameters/*/versions/*}:render',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateParameter' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{parameter.name=projects/*/locations/*/parameters/*}',
                'body' => 'parameter',
                'placeholders' => [
                    'parameter.name' => [
                        'getters' => [
                            'getParameter',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateParameterVersion' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{parameter_version.name=projects/*/locations/*/parameters/*/versions/*}',
                'body' => 'parameter_version',
                'placeholders' => [
                    'parameter_version.name' => [
                        'getters' => [
                            'getParameterVersion',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
