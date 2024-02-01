<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.InterconnectLocations' => [
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/interconnectLocations/{interconnect_location}',
                'placeholders' => [
                    'interconnect_location' => [
                        'getters' => [
                            'getInterconnectLocation',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'List' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/interconnectLocations',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
