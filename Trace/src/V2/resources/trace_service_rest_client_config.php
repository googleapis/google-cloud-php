<?php

return [
    'interfaces' => [
        'google.devtools.cloudtrace.v2.TraceService' => [
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
        ],
    ],
];
