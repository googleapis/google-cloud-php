<?php

return [
    'interfaces' => [
        'google.cloud.servicedirectory.v1beta1.LookupService' => [
            'ResolveService' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/locations/*/namespaces/*/services/*}:resolve',
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
