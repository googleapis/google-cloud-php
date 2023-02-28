<?php

return [
    'interfaces' => [
        'google.cloud.oslogin.v1.OsLoginService' => [
            'CreateSshPublicKey' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=users/*}/sshPublicKeys',
                'body' => 'ssh_public_key',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeletePosixAccount' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=users/*/projects/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteSshPublicKey' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=users/*/sshPublicKeys/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetLoginProfile' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=users/*}/loginProfile',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSshPublicKey' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=users/*/sshPublicKeys/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ImportSshPublicKey' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=users/*}:importSshPublicKey',
                'body' => 'ssh_public_key',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateSshPublicKey' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{name=users/*/sshPublicKeys/*}',
                'body' => 'ssh_public_key',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
