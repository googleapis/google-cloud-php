<?php

return [
    'interfaces' => [
        'google.cloud.language.v1.LanguageService' => [
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
            'AnalyzeSentiment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/documents:analyzeSentiment',
                'body' => '*',
            ],
            'AnalyzeSyntax' => [
                'method' => 'post',
                'uriTemplate' => '/v1/documents:analyzeSyntax',
                'body' => '*',
            ],
            'AnnotateText' => [
                'method' => 'post',
                'uriTemplate' => '/v1/documents:annotateText',
                'body' => '*',
            ],
            'ClassifyText' => [
                'method' => 'post',
                'uriTemplate' => '/v1/documents:classifyText',
                'body' => '*',
            ],
        ],
    ],
];
