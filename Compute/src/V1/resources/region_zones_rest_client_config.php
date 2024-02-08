<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.RegionZones' => [
            'List' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/zones',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'region' => [
                        'getters' => [
                            'getRegion',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
