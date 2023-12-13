<?php

return [
    'interfaces' => [
        'google.devtools.cloudprofiler.v2.ExportService' => [
            'ListProfiles' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*}/profiles',
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
