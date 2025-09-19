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
        'google.cloud.dialogflow.v2.Documents' => [
            'CreateDocument' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/knowledgeBases/*}/documents',
                'body' => 'document',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*/locations/*/knowledgeBases/*}/documents',
                        'body' => 'document',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*/agent/knowledgeBases/*}/documents',
                        'body' => 'document',
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
            'DeleteDocument' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/knowledgeBases/*/documents/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/knowledgeBases/*/documents/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{name=projects/*/agent/knowledgeBases/*/documents/*}',
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
            'ExportDocument' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/knowledgeBases/*/documents/*}:export',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/knowledgeBases/*/documents/*}:export',
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
            'GetDocument' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/knowledgeBases/*/documents/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/knowledgeBases/*/documents/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/agent/knowledgeBases/*/documents/*}',
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
            'ImportDocuments' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/knowledgeBases/*}/documents:import',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*/locations/*/knowledgeBases/*}/documents:import',
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
            'ListDocuments' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/knowledgeBases/*}/documents',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=projects/*/locations/*/knowledgeBases/*}/documents',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=projects/*/agent/knowledgeBases/*}/documents',
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
            'ReloadDocument' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/knowledgeBases/*/documents/*}:reload',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/knowledgeBases/*/documents/*}:reload',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{name=projects/*/agent/knowledgeBases/*/documents/*}:reload',
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
            'UpdateDocument' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{document.name=projects/*/knowledgeBases/*/documents/*}',
                'body' => 'document',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{document.name=projects/*/locations/*/knowledgeBases/*/documents/*}',
                        'body' => 'document',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{document.name=projects/*/agent/knowledgeBases/*/documents/*}',
                        'body' => 'document',
                    ],
                ],
                'placeholders' => [
                    'document.name' => [
                        'getters' => [
                            'getDocument',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
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
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/operations/*}:cancel',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/operations/*}:cancel',
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
                'uriTemplate' => '/v2/{name=projects/*/operations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v2/{name=projects/*}/operations',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*}/operations',
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
