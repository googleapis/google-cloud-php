<?php

return [
    'interfaces' => [
        'google.cloud.talent.v4beta1.JobService' => [
            'CreateJob' => [
                'method' => 'post',
                'uriTemplate' => '/v4beta1/{parent=projects/*}/jobs',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetJob' => [
                'method' => 'get',
                'uriTemplate' => '/v4beta1/{name=projects/*/jobs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateJob' => [
                'method' => 'patch',
                'uriTemplate' => '/v4beta1/{job.name=projects/*/jobs/*}',
                'body' => '*',
                'placeholders' => [
                    'job.name' => [
                        'getters' => [
                            'getJob',
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteJob' => [
                'method' => 'delete',
                'uriTemplate' => '/v4beta1/{name=projects/*/jobs/*}',
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
                'uriTemplate' => '/v4beta1/{parent=projects/*}/jobs',
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
                'uriTemplate' => '/v4beta1/{parent=projects/*}/jobs:batchDelete',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'SearchJobs' => [
                'method' => 'post',
                'uriTemplate' => '/v4beta1/{parent=projects/*}/jobs:search',
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
                'uriTemplate' => '/v4beta1/{parent=projects/*}/jobs:searchForAlert',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v3p1beta1/{name=projects/*/operations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v4beta1/{name=projects/*/operations/*}',
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
];
