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
        'google.cloud.visionai.v1.AppPlatform' => [
            'AddApplicationStreamInput' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/applications/*}:addStreamInput',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateApplication' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/applications',
                'body' => 'application',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'application_id',
                ],
            ],
            'CreateApplicationInstances' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/applications/*}:createApplicationInstances',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateDraft' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/applications/*}/drafts',
                'body' => 'draft',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'draft_id',
                ],
            ],
            'CreateProcessor' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/processors',
                'body' => 'processor',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'processor_id',
                ],
            ],
            'DeleteApplication' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/applications/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteApplicationInstances' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/applications/*}:deleteApplicationInstances',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteDraft' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/applications/*/drafts/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteProcessor' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/processors/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeployApplication' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/applications/*}:deploy',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetApplication' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/applications/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDraft' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/applications/*/drafts/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetInstance' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/applications/*/instances/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetProcessor' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/processors/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListApplications' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/applications',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDrafts' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/applications/*}/drafts',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListInstances' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/applications/*}/instances',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListPrebuiltProcessors' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/processors:prebuilt',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListProcessors' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/processors',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RemoveApplicationStreamInput' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/applications/*}:removeStreamInput',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UndeployApplication' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/applications/*}:undeploy',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateApplication' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{application.name=projects/*/locations/*/applications/*}',
                'body' => 'application',
                'placeholders' => [
                    'application.name' => [
                        'getters' => [
                            'getApplication',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateApplicationInstances' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/applications/*}:updateApplicationInstances',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateApplicationStreamInput' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/applications/*}:updateStreamInput',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateDraft' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{draft.name=projects/*/locations/*/applications/*/drafts/*}',
                'body' => 'draft',
                'placeholders' => [
                    'draft.name' => [
                        'getters' => [
                            'getDraft',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateProcessor' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{processor.name=projects/*/locations/*/processors/*}',
                'body' => 'processor',
                'placeholders' => [
                    'processor.name' => [
                        'getters' => [
                            'getProcessor',
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
