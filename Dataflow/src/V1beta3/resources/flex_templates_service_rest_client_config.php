<?php

return [
    'interfaces' => [
        'google.dataflow.v1beta3.FlexTemplatesService' => [
            'LaunchFlexTemplate' => [
                'method' => 'post',
                'uriTemplate' => '/v1b3/projects/{project_id}/locations/{location}/flexTemplates:launch',
                'body' => '*',
                'placeholders' => [
                    'location' => [
                        'getters' => [
                            'getLocation',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
