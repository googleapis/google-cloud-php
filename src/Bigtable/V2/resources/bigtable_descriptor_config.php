<?php

return [
    'interfaces' => [
        'google.bigtable.v2.Bigtable' => [
            'ReadRows' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'ServerStreaming',
                ],
            ],
            'SampleRowKeys' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'ServerStreaming',
                ],
            ],
            'MutateRows' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'ServerStreaming',
                ],
            ],
        ],
    ],
];
