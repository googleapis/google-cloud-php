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
        'google.cloud.documentai.v1.DocumentProcessorService' => [
            'BatchProcessDocuments' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/processors/*}:batchProcess',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/processors/*/processorVersions/*}:batchProcess',
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
            'DeleteProcessorVersion' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/processors/*/processorVersions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeployProcessorVersion' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/processors/*/processorVersions/*}:deploy',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DisableProcessor' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/processors/*}:disable',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'EnableProcessor' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/processors/*}:enable',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'EvaluateProcessorVersion' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{processor_version=projects/*/locations/*/processors/*/processorVersions/*}:evaluateProcessorVersion',
                'body' => '*',
                'placeholders' => [
                    'processor_version' => [
                        'getters' => [
                            'getProcessorVersion',
                        ],
                    ],
                ],
            ],
            'FetchProcessorTypes' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}:fetchProcessorTypes',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetEvaluation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/processors/*/processorVersions/*/evaluations/*}',
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
            'GetProcessorType' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/processorTypes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetProcessorVersion' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/processors/*/processorVersions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListEvaluations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/processors/*/processorVersions/*}/evaluations',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListProcessorTypes' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/processorTypes',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListProcessorVersions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/processors/*}/processorVersions',
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
            'ProcessDocument' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/processors/*}:process',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/processors/*/processorVersions/*}:process',
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
            'ReviewDocument' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{human_review_config=projects/*/locations/*/processors/*/humanReviewConfig}:reviewDocument',
                'body' => '*',
                'placeholders' => [
                    'human_review_config' => [
                        'getters' => [
                            'getHumanReviewConfig',
                        ],
                    ],
                ],
            ],
            'SetDefaultProcessorVersion' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{processor=projects/*/locations/*/processors/*}:setDefaultProcessorVersion',
                'body' => '*',
                'placeholders' => [
                    'processor' => [
                        'getters' => [
                            'getProcessor',
                        ],
                    ],
                ],
            ],
            'TrainProcessorVersion' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/processors/*}/processorVersions:train',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UndeployProcessorVersion' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/processors/*/processorVersions/*}:undeploy',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.cloud.location.Locations' => [
            'GetLocation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/uiv1beta3/{name=projects/*/locations/*}',
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
                        'uriTemplate' => '/uiv1beta3/{name=projects/*}/locations',
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
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/uiv1beta3/{name=projects/*/locations/*/operations/*}:cancel',
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
                'uriTemplate' => '/v1/{name=projects/*/operations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/uiv1beta3/{name=projects/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/uiv1beta3/{name=projects/*/locations/*/operations}',
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
