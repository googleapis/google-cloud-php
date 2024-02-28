<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.ImageFamilyViews' => [
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/zones/{zone}/imageFamilyViews/{family}',
                'placeholders' => [
                    'family' => [
                        'getters' => [
                            'getFamily',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                    'zone' => [
                        'getters' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
