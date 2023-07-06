<?php

return [
    'interfaces' => [
        'google.devtools.cloudprofiler.v2.ProfilerService' => [
            'CreateOfflineProfile' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Profiler\V2\Profile',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateProfile' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Profiler\V2\Profile',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateProfile' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Profiler\V2\Profile',
                'headerParams' => [
                    [
                        'keyName' => 'profile.name',
                        'fieldAccessors' => [
                            'getProfile',
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'profile' => 'projects/{project}/profiles/{profile}',
                'project' => 'projects/{project}',
            ],
        ],
    ],
];
