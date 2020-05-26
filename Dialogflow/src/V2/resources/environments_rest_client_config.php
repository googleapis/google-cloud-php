<?php

return [
    'interfaces' => [
        'google.cloud.dialogflow.v2.Environments' => [
            'ListEnvironments' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/agent}/environments',
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
