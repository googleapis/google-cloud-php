<?php

return [
    'interfaces' => [
        'google.devtools.cloudprofiler.v2.ProfilerService' => [
            'CreateOfflineProfile' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*}/profiles:createOffline',
                'body' => 'profile',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateProfile' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*}/profiles',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateProfile' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{profile.name=projects/*/profiles/*}',
                'body' => 'profile',
                'placeholders' => [
                    'profile.name' => [
                        'getters' => [
                            'getProfile',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
