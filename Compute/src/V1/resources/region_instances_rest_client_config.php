<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.RegionInstances' => [
            'BulkInsert' => [
                'method' => 'post',
                'uriTemplate' => '/compute/v1/projects/{project}/regions/{region}/instances/bulkInsert',
                'body' => 'bulk_insert_instance_resource_resource',
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
