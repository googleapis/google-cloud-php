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
        'google.cloud.apihub.v1.ApiHub' => [
            'CreateApi' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/apis',
                'body' => 'api',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateAttribute' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/attributes',
                'body' => 'attribute',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateDeployment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/deployments',
                'body' => 'deployment',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateExternalApi' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/externalApis',
                'body' => 'external_api',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateSpec' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/apis/*/versions/*}/specs',
                'body' => 'spec',
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
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/apis/*}/versions',
                'body' => 'version',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteApi' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteAttribute' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/attributes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteDeployment' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/deployments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteExternalApi' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/externalApis/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteSpec' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*/versions/*/specs/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*/versions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetApi' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetApiOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*/versions/*/operations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAttribute' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/attributes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDefinition' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*/versions/*/definitions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDeployment' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/deployments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetExternalApi' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/externalApis/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSpec' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*/versions/*/specs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSpecContents' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*/versions/*/specs/*}:contents',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*/versions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListApiOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/apis/*/versions/*}/operations',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListApis' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/apis',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListAttributes' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/attributes',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDeployments' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/deployments',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListExternalApis' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/externalApis',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListSpecs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/apis/*/versions/*}/specs',
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
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/apis/*}/versions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'SearchResources' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{location=projects/*/locations/*}:searchResources',
                'body' => '*',
                'placeholders' => [
                    'location' => [
                        'getters' => [
                            'getLocation',
                        ],
                    ],
                ],
            ],
            'UpdateApi' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{api.name=projects/*/locations/*/apis/*}',
                'body' => 'api',
                'placeholders' => [
                    'api.name' => [
                        'getters' => [
                            'getApi',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateAttribute' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{attribute.name=projects/*/locations/*/attributes/*}',
                'body' => 'attribute',
                'placeholders' => [
                    'attribute.name' => [
                        'getters' => [
                            'getAttribute',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateDeployment' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{deployment.name=projects/*/locations/*/deployments/*}',
                'body' => 'deployment',
                'placeholders' => [
                    'deployment.name' => [
                        'getters' => [
                            'getDeployment',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateExternalApi' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{external_api.name=projects/*/locations/*/externalApis/*}',
                'body' => 'external_api',
                'placeholders' => [
                    'external_api.name' => [
                        'getters' => [
                            'getExternalApi',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateSpec' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{spec.name=projects/*/locations/*/apis/*/versions/*/specs/*}',
                'body' => 'spec',
                'placeholders' => [
                    'spec.name' => [
                        'getters' => [
                            'getSpec',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateVersion' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{version.name=projects/*/locations/*/apis/*/versions/*}',
                'body' => 'version',
                'placeholders' => [
                    'version.name' => [
                        'getters' => [
                            'getVersion',
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
