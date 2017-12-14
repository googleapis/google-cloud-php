<?php

return [
    'interfaces' => [
        'google.cloud.language.v1beta2.LanguageService' => [
            'AnalyzeSentiment' => [
                'method' => 'post',
                'uri' => '/v1beta2/documents:analyzeSentiment',
                'body' => '*',
            ],
            'AnalyzeEntities' => [
                'method' => 'post',
                'uri' => '/v1beta2/documents:analyzeEntities',
                'body' => '*',
            ],
            'AnalyzeEntitySentiment' => [
                'method' => 'post',
                'uri' => '/v1beta2/documents:analyzeEntitySentiment',
                'body' => '*',
            ],
            'AnalyzeSyntax' => [
                'method' => 'post',
                'uri' => '/v1beta2/documents:analyzeSyntax',
                'body' => '*',
            ],
            'ClassifyText' => [
                'method' => 'post',
                'uri' => '/v1beta2/documents:classifyText',
                'body' => '*',
            ],
            'AnnotateText' => [
                'method' => 'post',
                'uri' => '/v1beta2/documents:annotateText',
                'body' => '*',
            ],
        ],
    ],
];
