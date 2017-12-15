<?php

return [
    'interfaces' => [
        'google.devtools.clouderrorreporting.v1beta1.ReportErrorsService' => [
            'ReportErrorEvent' => [
                'method' => 'post',
                'uri' => '/v1beta1/{project_name=projects/*}/events:report',
                'body' => 'event',
                'placeholders' => [
                    'project_name' => [
                        'getProjectName',
                    ],
                ],
            ],
        ],
    ],
];
