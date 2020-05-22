<?php

return [
    'interfaces' => [
        'google.devtools.cloudtrace.v2.TraceService' => [
            'CreateSpan' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/traces/*/spans/*}',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'BatchWriteSpans' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*}/traces:batchWrite',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
