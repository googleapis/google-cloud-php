<?php

return [
    'numericEnums' => true,
    'interfaces' => [
        'test.interface.v1.api' => [
            'MethodWithNumericEnumsQueryParam' => [
                'method' => 'get',
                'uriTemplate' => '/v1/fixedurl',
                'queryParams' => [
                    'name',
                    'number'
                ]
            ]
        ],
    ],
];
