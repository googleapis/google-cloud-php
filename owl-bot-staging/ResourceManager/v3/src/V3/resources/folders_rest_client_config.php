<?php

return [
    'interfaces' => [
        'google.cloud.resourcemanager.v3.Folders' => [
            'CreateFolder' => [
                'method' => 'post',
                'uriTemplate' => '/v3/folders',
                'body' => 'folder',
            ],
            'DeleteFolder' => [
                'method' => 'delete',
                'uriTemplate' => '/v3/{name=folders/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetFolder' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=folders/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{resource=folders/*}:getIamPolicy',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'ListFolders' => [
                'method' => 'get',
                'uriTemplate' => '/v3/folders',
                'queryParams' => [
                    'parent',
                ],
            ],
            'MoveFolder' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{name=folders/*}:move',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SearchFolders' => [
                'method' => 'get',
                'uriTemplate' => '/v3/folders:search',
            ],
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{resource=folders/*}:setIamPolicy',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'TestIamPermissions' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{resource=folders/*}:testIamPermissions',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'UndeleteFolder' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{name=folders/*}:undelete',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateFolder' => [
                'method' => 'patch',
                'uriTemplate' => '/v3/{folder.name=folders/*}',
                'body' => 'folder',
                'placeholders' => [
                    'folder.name' => [
                        'getters' => [
                            'getFolder',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=operations/**}',
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
