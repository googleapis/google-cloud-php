<?php

return [
    'interfaces' => [
        'google.cloud.language.v2.LanguageService' => [
            'AnalyzeEntities' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Language\V2\AnalyzeEntitiesResponse',
            ],
            'AnalyzeSentiment' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Language\V2\AnalyzeSentimentResponse',
            ],
            'AnnotateText' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Language\V2\AnnotateTextResponse',
            ],
            'ClassifyText' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Language\V2\ClassifyTextResponse',
            ],
            'ModerateText' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Language\V2\ModerateTextResponse',
            ],
        ],
    ],
];
