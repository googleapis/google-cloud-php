<?php
/*
 * Copyright 2024 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was automatically generated - do not edit!
 */

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
    'numericEnums' => true,
];
