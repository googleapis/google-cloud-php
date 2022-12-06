<?php

return [
    'interfaces' => [
        'google.cloud.language.v1beta2.LanguageService' => [
            'AnalyzeEntities' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta2/documents:analyzeEntities',
                'body' => '*',
            ],
            'AnalyzeEntitySentiment' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta2/documents:analyzeEntitySentiment',
                'body' => '*',
            ],
            'AnalyzeSentiment' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta2/documents:analyzeSentiment',
                'body' => '*',
            ],
            'AnalyzeSyntax' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta2/documents:analyzeSyntax',
                'body' => '*',
            ],
            'AnnotateText' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta2/documents:annotateText',
                'body' => '*',
            ],
            'ClassifyText' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta2/documents:classifyText',
                'body' => '*',
            ],
        ],
    ],
];
