<?php

return [
    'interfaces' => [
        'google.cloud.talent.v4beta1.Completion' => [
            'CompleteQuery' => [
                'method' => 'get',
                'uriTemplate' => '/v4beta1/{parent=projects/*/tenants/*}:complete',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v4beta1/{parent=projects/*}:complete',
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
        ],
    ],
];
