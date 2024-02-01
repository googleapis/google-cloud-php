<?php

return [
    'interfaces' => [
        'google.cloud.resourcemanager.v3.TagHolds' => [
            'CreateTagHold' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{parent=tagValues/*}/tagHolds',
                'body' => 'tag_hold',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteTagHold' => [
                'method' => 'delete',
                'uriTemplate' => '/v3/{name=tagValues/*/tagHolds/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListTagHolds' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{parent=tagValues/*}/tagHolds',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
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
    'numericEnums' => true,
];
