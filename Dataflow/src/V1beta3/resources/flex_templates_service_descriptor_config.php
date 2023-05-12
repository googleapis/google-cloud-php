<?php

return [
    'interfaces' => [
        'google.dataflow.v1beta3.FlexTemplatesService' => [
            'LaunchFlexTemplate' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Dataflow\V1beta3\LaunchFlexTemplateResponse',
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
