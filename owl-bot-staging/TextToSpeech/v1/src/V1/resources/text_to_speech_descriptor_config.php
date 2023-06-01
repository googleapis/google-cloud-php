<?php

return [
    'interfaces' => [
        'google.cloud.texttospeech.v1.TextToSpeech' => [
            'ListVoices' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\TextToSpeech\V1\ListVoicesResponse',
            ],
            'SynthesizeSpeech' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\TextToSpeech\V1\SynthesizeSpeechResponse',
            ],
            'templateMap' => [
                'model' => 'projects/{project}/locations/{location}/models/{model}',
            ],
        ],
    ],
];
