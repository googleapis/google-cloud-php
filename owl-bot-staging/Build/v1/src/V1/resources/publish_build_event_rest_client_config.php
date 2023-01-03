<?php

return [
    'interfaces' => [
        'google.devtools.build.v1.PublishBuildEvent' => [
            'PublishLifecycleEvent' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id=*}/lifecycleEvents:publish',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/lifecycleEvents:publish',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
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
