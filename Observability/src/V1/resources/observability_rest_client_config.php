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
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=folders/*/locations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=organizations/*/locations/*}',
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
            'ListLocations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*}/locations',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=folders/*}/locations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=organizations/*}/locations',
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
        'google.cloud.observability.v1.Observability' => [
            'CreateBucket' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/buckets',
                'body' => 'bucket',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'bucket_id',
                ],
            ],
            'CreateLink' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/buckets/*/datasets/*}/links',
                'body' => 'link',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'link_id',
                ],
            ],
            'CreateTraceScope' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/traceScopes',
                'body' => 'trace_scope',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'trace_scope_id',
                ],
            ],
            'DeleteLink' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/buckets/*/datasets/*/links/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteTraceScope' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/traceScopes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetBucket' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/buckets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDataset' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/buckets/*/datasets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetLink' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/buckets/*/datasets/*/links/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetScope' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/scopes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSettings' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/settings}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=folders/*/locations/*/settings}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=organizations/*/locations/*/settings}',
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
            'GetTraceScope' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/traceScopes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetView' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/buckets/*/datasets/*/views/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListBuckets' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/buckets',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDatasets' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/buckets/*}/datasets',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListLinks' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/buckets/*/datasets/*}/links',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListTraceScopes' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/traceScopes',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListViews' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/buckets/*/datasets/*}/views',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateBucket' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{bucket.name=projects/*/locations/*/buckets/*}',
                'body' => 'bucket',
                'placeholders' => [
                    'bucket.name' => [
                        'getters' => [
                            'getBucket',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateLink' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{link.name=projects/*/locations/*/buckets/*/datasets/*/links/*}',
                'body' => 'link',
                'placeholders' => [
                    'link.name' => [
                        'getters' => [
                            'getLink',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateScope' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{scope.name=projects/*/locations/*/scopes/*}',
                'body' => 'scope',
                'placeholders' => [
                    'scope.name' => [
                        'getters' => [
                            'getScope',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateSettings' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{settings.name=projects/*/locations/*/settings}',
                'body' => 'settings',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{settings.name=folders/*/locations/*/settings}',
                        'body' => 'settings',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{settings.name=organizations/*/locations/*/settings}',
                        'body' => 'settings',
                    ],
                ],
                'placeholders' => [
                    'settings.name' => [
                        'getters' => [
                            'getSettings',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateTraceScope' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{trace_scope.name=projects/*/locations/*/traceScopes/*}',
                'body' => 'trace_scope',
                'placeholders' => [
                    'trace_scope.name' => [
                        'getters' => [
                            'getTraceScope',
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
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=folders/*/locations/*/operations/*}:cancel',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=organizations/*/locations/*/operations/*}:cancel',
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
            'DeleteOperation' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=folders/*/locations/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=organizations/*/locations/*/operations/*}',
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
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=folders/*/locations/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=organizations/*/locations/*/operations/*}',
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
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=folders/*/locations/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=organizations/*/locations/*}/operations',
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
    ],
    'numericEnums' => true,
];
