<?php

return [
    'interfaces' => [
        'google.dataflow.v1beta3.TemplatesService' => [
            'CreateJobFromTemplate' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dataflow\V1beta3\Job',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'location',
                        'fieldAccessors' => [
                            'getLocation',
                        ],
                    ],
                ],
            ],
            'GetTemplate' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dataflow\V1beta3\GetTemplateResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'location',
                        'fieldAccessors' => [
                            'getLocation',
                        ],
                    ],
                ],
            ],
            'LaunchTemplate' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dataflow\V1beta3\LaunchTemplateResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'location',
                        'fieldAccessors' => [
                            'getLocation',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
