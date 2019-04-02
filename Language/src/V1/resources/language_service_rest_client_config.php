<?php

return [
    'interfaces' => [
        'google.cloud.language.v1.LanguageService' => [
            'AnalyzeSentiment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/documents:analyzeSentiment',
                'body' => '*',
            ],
            'AnalyzeEntities' => [
                'method' => 'post',
                'uriTemplate' => '/v1/documents:analyzeEntities',
                'body' => '*',
            ],
            'AnalyzeEntitySentiment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/documents:analyzeEntitySentiment',
                'body' => '*',
            ],
            'AnalyzeSyntax' => [
                'method' => 'post',
                'uriTemplate' => '/v1/documents:analyzeSyntax',
                'body' => '*',
            ],
            'ClassifyText' => [
                'method' => 'post',
                'uriTemplate' => '/v1/documents:classifyText',
                'body' => '*',
            ],
            'AnnotateText' => [
                'method' => 'post',
                'uriTemplate' => '/v1/documents:annotateText',
                'body' => '*',
            ],
        ],
    ],
];
