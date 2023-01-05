<?php

return [
    'interfaces' => [
        'google.cloud.channel.v1.CloudChannelReportsService' => [
            'FetchReportResults' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{report_job=accounts/*/reportJobs/*}:fetchReportResults',
                'body' => '*',
                'placeholders' => [
                    'report_job' => [
                        'getters' => [
                            'getReportJob',
                        ],
                    ],
                ],
            ],
            'ListReports' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=accounts/*}/reports',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RunReportJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=accounts/*/reports/*}:run',
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
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=operations/**}:cancel',
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
                'uriTemplate' => '/v1/{name=operations/**}',
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
                'uriTemplate' => '/v1/{name=operations/**}',
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
                'uriTemplate' => '/v1/{name=operations}',
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
