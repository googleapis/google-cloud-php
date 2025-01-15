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
                'uriTemplate' => '/v2/{name=projects/*/locations/*}',
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
                'uriTemplate' => '/v2/{name=projects/*}/locations',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.cloud.tpu.v2.Tpu' => [
            'CreateNode' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/nodes',
                'body' => 'node',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateQueuedResource' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/queuedResources',
                'body' => 'queued_resource',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteNode' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/nodes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteQueuedResource' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/queuedResources/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GenerateServiceIdentity' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}:generateServiceIdentity',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetAcceleratorType' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/acceleratorTypes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetGuestAttributes' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/nodes/*}:getGuestAttributes',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetNode' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/nodes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetQueuedResource' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/queuedResources/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRuntimeVersion' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/runtimeVersions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAcceleratorTypes' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/acceleratorTypes',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListNodes' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/nodes',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListQueuedResources' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/queuedResources',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListRuntimeVersions' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/runtimeVersions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ResetQueuedResource' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/queuedResources/*}:reset',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'StartNode' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/nodes/*}:start',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'StopNode' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/nodes/*}:stop',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateNode' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{node.name=projects/*/locations/*/nodes/*}',
                'body' => 'node',
                'placeholders' => [
                    'node.name' => [
                        'getters' => [
                            'getNode',
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
                'uriTemplate' => '/v2/{name=projects/*/locations/*/operations/*}:cancel',
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
                'uriTemplate' => '/v2/{name=projects/*/locations/*/operations/*}',
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
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*}/operations',
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
