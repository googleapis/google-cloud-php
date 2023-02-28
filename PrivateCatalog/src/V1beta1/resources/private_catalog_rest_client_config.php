<?php

return [
    'interfaces' => [
        'google.cloud.privatecatalog.v1beta1.PrivateCatalog' => [
            'SearchCatalogs' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{resource=projects/*}/catalogs:search',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta1/{resource=organizations/*}/catalogs:search',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta1/{resource=folders/*}/catalogs:search',
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
            'SearchProducts' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{resource=projects/*}/products:search',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta1/{resource=organizations/*}/products:search',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta1/{resource=folders/*}/products:search',
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
            'SearchVersions' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{resource=projects/*}/versions:search',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta1/{resource=organizations/*}/versions:search',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta1/{resource=folders/*}/versions:search',
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
        ],
    ],
];
