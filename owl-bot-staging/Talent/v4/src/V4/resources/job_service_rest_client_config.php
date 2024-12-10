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
        'google.cloud.talent.v4.JobService' => [
            'BatchCreateJobs' => [
                'method' => 'post',
                'uriTemplate' => '/v4/{parent=projects/*/tenants/*}/jobs:batchCreate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchDeleteJobs' => [
                'method' => 'post',
                'uriTemplate' => '/v4/{parent=projects/*/tenants/*}/jobs:batchDelete',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchUpdateJobs' => [
                'method' => 'post',
                'uriTemplate' => '/v4/{parent=projects/*/tenants/*}/jobs:batchUpdate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateJob' => [
                'method' => 'post',
                'uriTemplate' => '/v4/{parent=projects/*/tenants/*}/jobs',
                'body' => 'job',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteJob' => [
                'method' => 'delete',
                'uriTemplate' => '/v4/{name=projects/*/tenants/*/jobs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetJob' => [
                'method' => 'get',
                'uriTemplate' => '/v4/{name=projects/*/tenants/*/jobs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListJobs' => [
                'method' => 'get',
                'uriTemplate' => '/v4/{parent=projects/*/tenants/*}/jobs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'filter',
                ],
            ],
            'SearchJobs' => [
                'method' => 'post',
                'uriTemplate' => '/v4/{parent=projects/*/tenants/*}/jobs:search',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'SearchJobsForAlert' => [
                'method' => 'post',
                'uriTemplate' => '/v4/{parent=projects/*/tenants/*}/jobs:searchForAlert',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateJob' => [
                'method' => 'patch',
                'uriTemplate' => '/v4/{job.name=projects/*/tenants/*/jobs/*}',
                'body' => 'job',
                'placeholders' => [
                    'job.name' => [
                        'getters' => [
                            'getJob',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v4/{name=projects/*/operations/*}',
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
