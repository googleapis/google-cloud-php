<?php

return [
    'interfaces' => [
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=transferOperations/**}:cancel',
                'body' => '*',
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
                'uriTemplate' => '/v1/{name=transferOperations/**}',
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
                'uriTemplate' => '/v1/{name=transferOperations}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.storagetransfer.v1.StorageTransferService' => [
            'CreateTransferJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/transferJobs',
                'body' => 'transfer_job',
            ],
            'GetGoogleServiceAccount' => [
                'method' => 'get',
                'uriTemplate' => '/v1/googleServiceAccounts/{project_id}',
                'placeholders' => [
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                ],
            ],
            'GetTransferJob' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{job_name=transferJobs/**}',
                'placeholders' => [
                    'job_name' => [
                        'getters' => [
                            'getJobName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'project_id',
                ],
            ],
            'ListTransferJobs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/transferJobs',
                'queryParams' => [
                    'filter',
                ],
            ],
            'PauseTransferOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=transferOperations/**}:pause',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ResumeTransferOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=transferOperations/**}:resume',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RunTransferJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{job_name=transferJobs/**}:run',
                'body' => '*',
                'placeholders' => [
                    'job_name' => [
                        'getters' => [
                            'getJobName',
                        ],
                    ],
                ],
            ],
            'UpdateTransferJob' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{job_name=transferJobs/**}',
                'body' => '*',
                'placeholders' => [
                    'job_name' => [
                        'getters' => [
                            'getJobName',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
