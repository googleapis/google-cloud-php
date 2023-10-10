<?php

return [
    'interfaces' => [
        'google.cloud.language.v1.LanguageService' => [
            'AnalyzeEntities' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Language\V1\AnalyzeEntitiesResponse',
            ],
            'AnalyzeEntitySentiment' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Language\V1\AnalyzeEntitySentimentResponse',
            ],
            'AnalyzeSentiment' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Language\V1\AnalyzeSentimentResponse',
            ],
            'AnalyzeSyntax' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Language\V1\AnalyzeSyntaxResponse',
            ],
            'AnnotateText' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Language\V1\AnnotateTextResponse',
            ],
            'ClassifyText' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Language\V1\ClassifyTextResponse',
            ],
            'ModerateText' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Language\V1\ModerateTextResponse',
            ],
        ],
    ],
];
