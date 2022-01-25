<?php

return [
    'interfaces' => [
        'google.devtools.build.v1.PublishBuildEvent' => [
            'PublishBuildToolEventStream' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'BidiStreaming',
                ],
            ],
        ],
    ],
];
