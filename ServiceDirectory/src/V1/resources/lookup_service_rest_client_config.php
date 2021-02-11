<?php

return [
    'interfaces' => [
        'google.cloud.servicedirectory.v1.LookupService' => [
            'ResolveService' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/namespaces/*/services/*}:resolve',
                'body' => '*',
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
