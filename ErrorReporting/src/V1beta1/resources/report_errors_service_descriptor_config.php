<?php

return [
    'interfaces' => [
        'google.devtools.clouderrorreporting.v1beta1.ReportErrorsService' => [
            'ReportErrorEvent' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\ErrorReporting\V1beta1\ReportErrorEventResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project_name',
                        'fieldAccessors' => [
                            'getProjectName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'project' => 'projects/{project}',
            ],
        ],
    ],
];
