<?php

return [
    'interfaces' => [
        'google.cloud.language.v1beta2.LanguageService' => [
            'AnalyzeSentiment' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta2/documents:analyzeSentiment',
                'body' => '*',
            ],
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
            'AnalyzeSyntax' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta2/documents:analyzeSyntax',
                'body' => '*',
            ],
            'ClassifyText' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta2/documents:classifyText',
                'body' => '*',
            ],
            'AnnotateText' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta2/documents:annotateText',
                'body' => '*',
            ],
        ],
    ],
];
