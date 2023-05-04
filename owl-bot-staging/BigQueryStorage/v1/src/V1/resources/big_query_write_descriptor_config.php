<?php

return [
    'interfaces' => [
        'google.cloud.bigquery.storage.v1.BigQueryWrite' => [
            'AppendRows' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'BidiStreaming',
                ],
            ],
        ],
    ],
];
