<?php

return [
    'interfaces' => [
        'google.privacy.dlp.v2.DlpService' => [
            'InspectContent' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*}/content:inspect',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*}/locations/{location_id}/content:inspect',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                    'location_id' => [
                        'getters' => [
                            'getLocationId',
                        ],
                    ],
                ],
            ],
            'RedactImage' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*}/image:redact',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*}/locations/{location_id}/image:redact',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                    'location_id' => [
                        'getters' => [
                            'getLocationId',
                        ],
                    ],
                ],
            ],
            'DeidentifyContent' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*}/content:deidentify',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*}/locations/{location_id}/content:deidentify',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                    'location_id' => [
                        'getters' => [
                            'getLocationId',
                        ],
                    ],
                ],
            ],
            'ReidentifyContent' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*}/content:reidentify',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*}/locations/{location_id}/content:reidentify',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                    'location_id' => [
                        'getters' => [
                            'getLocationId',
                        ],
                    ],
                ],
            ],
            'ListInfoTypes' => [
                'method' => 'get',
                'uriTemplate' => '/v2/infoTypes',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/locations/{location_id}/infoTypes',
                    ],
                ],
                'placeholders' => [
                    'location_id' => [
                        'getters' => [
                            'getLocationId',
                        ],
                    ],
                ],
            ],
            'CreateInspectTemplate' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=organizations/*}/inspectTemplates',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=organizations/*}/locations/{location_id}/inspectTemplates',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*}/inspectTemplates',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*}/locations/{location_id}/inspectTemplates',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                    'location_id' => [
                        'getters' => [
                            'getLocationId',
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
                        'uriTemplate' => '/v2/{name=organizations/*/locations/*/inspectTemplates/*}',
                        'body' => '*',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{name=projects/*/inspectTemplates/*}',
                        'body' => '*',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/inspectTemplates/*}',
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
                        'uriTemplate' => '/v2/{name=organizations/*/locations/*/inspectTemplates/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/inspectTemplates/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/inspectTemplates/*}',
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
                        'uriTemplate' => '/v2/{parent=organizations/*}/locations/{location_id}/inspectTemplates',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=projects/*}/inspectTemplates',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=projects/*}/locations/{location_id}/inspectTemplates',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                    'location_id' => [
                        'getters' => [
                            'getLocationId',
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
                        'uriTemplate' => '/v2/{name=organizations/*/locations/*/inspectTemplates/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{name=projects/*/inspectTemplates/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/inspectTemplates/*}',
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
                        'uriTemplate' => '/v2/{parent=organizations/*}/locations/{location_id}/deidentifyTemplates',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*}/deidentifyTemplates',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*}/locations/{location_id}/deidentifyTemplates',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                    'location_id' => [
                        'getters' => [
                            'getLocationId',
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
                        'uriTemplate' => '/v2/{name=organizations/*/locations/*/deidentifyTemplates/*}',
                        'body' => '*',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{name=projects/*/deidentifyTemplates/*}',
                        'body' => '*',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/deidentifyTemplates/*}',
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
                        'uriTemplate' => '/v2/{name=organizations/*/locations/*/deidentifyTemplates/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/deidentifyTemplates/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/deidentifyTemplates/*}',
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
                        'uriTemplate' => '/v2/{parent=organizations/*}/locations/{location_id}/deidentifyTemplates',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=projects/*}/deidentifyTemplates',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=projects/*}/locations/{location_id}/deidentifyTemplates',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                    'location_id' => [
                        'getters' => [
                            'getLocationId',
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
                        'uriTemplate' => '/v2/{name=organizations/*/locations/*/deidentifyTemplates/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{name=projects/*/deidentifyTemplates/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/deidentifyTemplates/*}',
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
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*}/locations/{location_id}/dlpJobs',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                    'location_id' => [
                        'getters' => [
                            'getLocationId',
                        ],
                    ],
                ],
            ],
            'ListDlpJobs' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*}/dlpJobs',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=projects/*}/locations/{location_id}/dlpJobs',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                    'location_id' => [
                        'getters' => [
                            'getLocationId',
                        ],
                    ],
                ],
            ],
            'GetDlpJob' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/dlpJobs/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/dlpJobs/*}',
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
            'DeleteDlpJob' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/dlpJobs/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/dlpJobs/*}',
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
            'CancelDlpJob' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/dlpJobs/*}:cancel',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/dlpJobs/*}:cancel',
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
            'ListJobTriggers' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*}/jobTriggers',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=projects/*}/locations/{location_id}/jobTriggers',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                    'location_id' => [
                        'getters' => [
                            'getLocationId',
                        ],
                    ],
                ],
            ],
            'GetJobTrigger' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/jobTriggers/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/jobTriggers/*}',
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
            'DeleteJobTrigger' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/jobTriggers/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/jobTriggers/*}',
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
            'UpdateJobTrigger' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{name=projects/*/jobTriggers/*}',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/jobTriggers/*}',
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
            'CreateJobTrigger' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*}/jobTriggers',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*}/locations/{location_id}/jobTriggers',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                    'location_id' => [
                        'getters' => [
                            'getLocationId',
                        ],
                    ],
                ],
            ],
            'CreateStoredInfoType' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=organizations/*}/storedInfoTypes',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=organizations/*}/locations/{location_id}/storedInfoTypes',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*}/storedInfoTypes',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*}/locations/{location_id}/storedInfoTypes',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                    'location_id' => [
                        'getters' => [
                            'getLocationId',
                        ],
                    ],
                ],
            ],
            'UpdateStoredInfoType' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{name=organizations/*/storedInfoTypes/*}',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{name=organizations/*/locations/*/storedInfoTypes/*}',
                        'body' => '*',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{name=projects/*/storedInfoTypes/*}',
                        'body' => '*',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/storedInfoTypes/*}',
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
            'GetStoredInfoType' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=organizations/*/storedInfoTypes/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=organizations/*/locations/*/storedInfoTypes/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/storedInfoTypes/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/storedInfoTypes/*}',
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
            'ListStoredInfoTypes' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=organizations/*}/storedInfoTypes',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=organizations/*}/locations/{location_id}/storedInfoTypes',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=projects/*}/storedInfoTypes',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=projects/*}/locations/{location_id}/storedInfoTypes',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                    'location_id' => [
                        'getters' => [
                            'getLocationId',
                        ],
                    ],
                ],
            ],
            'DeleteStoredInfoType' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=organizations/*/storedInfoTypes/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{name=organizations/*/locations/*/storedInfoTypes/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{name=projects/*/storedInfoTypes/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/storedInfoTypes/*}',
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
