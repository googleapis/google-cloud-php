<?php

return [
    'interfaces' => [
        'google.cloud.support.v2.CaseAttachmentService' => [
            'ListAttachments' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/cases/*}/attachments',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=organizations/*/cases/*}/attachments',
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
    'numericEnums' => true,
];
