<?php

return [
    'interfaces' => [
        'google.privacy.dlp.v2.DlpService' => [
            'InspectContent' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*}/content:inspect',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RedactImage' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*}/image:redact',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeidentifyContent' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*}/content:deidentify',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ReidentifyContent' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*}/content:reidentify',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListInfoTypes' => [
                'method' => 'get',
                'uriTemplate' => '/v2/infoTypes',
            ],
            'CreateInspectTemplate' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=organizations/*}/inspectTemplates',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*}/inspectTemplates',
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
            'UpdateInspectTemplate' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{name=organizations/*/inspectTemplates/*}',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{name=projects/*/inspectTemplates/*}',
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
            'GetInspectTemplate' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=organizations/*/inspectTemplates/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/inspectTemplates/*}',
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
            'ListInspectTemplates' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=organizations/*}/inspectTemplates',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=projects/*}/inspectTemplates',
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
            'DeleteInspectTemplate' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=organizations/*/inspectTemplates/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{name=projects/*/inspectTemplates/*}',
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
            'CreateDeidentifyTemplate' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=organizations/*}/deidentifyTemplates',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*}/deidentifyTemplates',
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
            'UpdateDeidentifyTemplate' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{name=organizations/*/deidentifyTemplates/*}',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{name=projects/*/deidentifyTemplates/*}',
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
            'GetDeidentifyTemplate' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=organizations/*/deidentifyTemplates/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/deidentifyTemplates/*}',
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
            'ListDeidentifyTemplates' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=organizations/*}/deidentifyTemplates',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=projects/*}/deidentifyTemplates',
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
            'DeleteDeidentifyTemplate' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=organizations/*/deidentifyTemplates/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{name=projects/*/deidentifyTemplates/*}',
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
            'CreateDlpJob' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*}/dlpJobs',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDlpJobs' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*}/dlpJobs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetDlpJob' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/dlpJobs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteDlpJob' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/dlpJobs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CancelDlpJob' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/dlpJobs/*}:cancel',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListJobTriggers' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*}/jobTriggers',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetJobTrigger' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/jobTriggers/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteJobTrigger' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/jobTriggers/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateJobTrigger' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{name=projects/*/jobTriggers/*}',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateJobTrigger' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*}/jobTriggers',
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
    ],
];
