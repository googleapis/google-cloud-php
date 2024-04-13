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
        'google.cloud.datacatalog.lineage.v1.Lineage' => [
            'BatchSearchLinkProcesses' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}:batchSearchLinkProcesses',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateLineageEvent' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/processes/*/runs/*}/lineageEvents',
                'body' => 'lineage_event',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateProcess' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/processes',
                'body' => 'process',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateRun' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/processes/*}/runs',
                'body' => 'run',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteLineageEvent' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/processes/*/runs/*/lineageEvents/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/processes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteRun' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/processes/*/runs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetLineageEvent' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/processes/*/runs/*/lineageEvents/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/processes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRun' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/processes/*/runs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListLineageEvents' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/processes/*/runs/*}/lineageEvents',
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
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/processes',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListRuns' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/processes/*}/runs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ProcessOpenLineageRunEvent' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}:processOpenLineageRunEvent',
                'body' => 'open_lineage',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'SearchLinks' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}:searchLinks',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateProcess' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{process.name=projects/*/locations/*/processes/*}',
                'body' => 'process',
                'placeholders' => [
                    'process.name' => [
                        'getters' => [
                            'getProcess',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateRun' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{run.name=projects/*/locations/*/processes/*/runs/*}',
                'body' => 'run',
                'placeholders' => [
                    'run.name' => [
                        'getters' => [
                            'getRun',
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
];
