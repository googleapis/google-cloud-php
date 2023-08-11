<?php

return [
    'interfaces' => [
        'google.cloud.language.v2.LanguageService' => [
            'AnalyzeEntities' => [
                'method' => 'post',
                'uriTemplate' => '/v2/documents:analyzeEntities',
                'body' => '*',
            ],
            'AnalyzeSentiment' => [
                'method' => 'post',
                'uriTemplate' => '/v2/documents:analyzeSentiment',
                'body' => '*',
            ],
            'AnnotateText' => [
                'method' => 'post',
                'uriTemplate' => '/v2/documents:annotateText',
                'body' => '*',
            ],
            'ClassifyText' => [
                'method' => 'post',
                'uriTemplate' => '/v2/documents:classifyText',
                'body' => '*',
            ],
            'ModerateText' => [
                'method' => 'post',
                'uriTemplate' => '/v2/documents:moderateText',
                'body' => '*',
            ],
        ],
    ],
    'numericEnums' => true,
];
