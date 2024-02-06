<?php

return [
    'interfaces' => [
        'google.cloud.texttospeech.v1.TextToSpeech' => [
            'ListVoices' => [
                'method' => 'get',
                'uriTemplate' => '/v1/voices',
            ],
            'SynthesizeSpeech' => [
                'method' => 'post',
                'uriTemplate' => '/v1/text:synthesize',
                'body' => '*',
            ],
        ],
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*}/operations',
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
    'numericEnums' => true,
];
