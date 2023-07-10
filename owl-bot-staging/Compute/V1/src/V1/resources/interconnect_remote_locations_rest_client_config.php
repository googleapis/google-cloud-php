<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.InterconnectRemoteLocations' => [
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/compute/v1/projects/{project}/global/interconnectRemoteLocations/{interconnect_remote_location}',
                'placeholders' => [
                    'interconnect_remote_location' => [
                        'getters' => [
                            'getInterconnectRemoteLocation',
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
                'uriTemplate' => '/compute/v1/projects/{project}/global/interconnectRemoteLocations',
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
