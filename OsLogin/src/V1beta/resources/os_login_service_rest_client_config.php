<?php

return [
    'interfaces' => [
        'google.cloud.oslogin.v1beta.OsLoginService' => [
            'CreateSshPublicKey' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{parent=users/*}/sshPublicKeys',
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
                'uriTemplate' => '/v1beta/{name=users/*/projects/*}',
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
                'uriTemplate' => '/v1beta/{name=users/*/sshPublicKeys/*}',
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
                'uriTemplate' => '/v1beta/{name=users/*}/loginProfile',
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
                'uriTemplate' => '/v1beta/{name=users/*/sshPublicKeys/*}',
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
                'uriTemplate' => '/v1beta/{parent=users/*}:importSshPublicKey',
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
                'uriTemplate' => '/v1beta/{name=users/*/sshPublicKeys/*}',
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
