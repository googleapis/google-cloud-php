<?php

return [
    'interfaces' => [
        'google.cloud.mediatranslation.v1beta1.SpeechTranslationService' => [
            'StreamingTranslateSpeech' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'BidiStreaming',
                ],
                'callType' => \Google\ApiCore\Call::BIDI_STREAMING_CALL,
                'responseType' => 'Google\Cloud\MediaTranslation\V1beta1\StreamingTranslateSpeechResponse',
            ],
        ],
    ],
];
