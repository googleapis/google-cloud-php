<?php

return [
    'interfaces' => [
        'google.cloud.essentialcontacts.v1.EssentialContactsService' => [
            'ComputeContacts' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*}/contacts:compute',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=folders/*}/contacts:compute',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=organizations/*}/contacts:compute',
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
            'CreateContact' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*}/contacts',
                'body' => 'contact',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=folders/*}/contacts',
                        'body' => 'contact',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=organizations/*}/contacts',
                        'body' => 'contact',
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
            'DeleteContact' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/contacts/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=folders/*/contacts/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=organizations/*/contacts/*}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetContact' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/contacts/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=folders/*/contacts/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=organizations/*/contacts/*}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListContacts' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*}/contacts',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=folders/*}/contacts',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=organizations/*}/contacts',
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
            'SendTestMessage' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*}/contacts:sendTestMessage',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=folders/*}/contacts:sendTestMessage',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=organizations/*}/contacts:sendTestMessage',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'UpdateContact' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{contact.name=projects/*/contacts/*}',
                'body' => 'contact',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{contact.name=folders/*/contacts/*}',
                        'body' => 'contact',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{contact.name=organizations/*/contacts/*}',
                        'body' => 'contact',
                    ],
                ],
                'placeholders' => [
                    'contact.name' => [
                        'getters' => [
                            'getContact',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
