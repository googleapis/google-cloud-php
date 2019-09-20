<?php

return [
    'interfaces' => [
        'google.cloud.recaptchaenterprise.v1beta1.RecaptchaEnterpriseServiceV1Beta1' => [
            'CreateAssessment' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{parent=projects/*}/assessments',
                'body' => 'assessment',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'AnnotateAssessment' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{name=projects/*/assessments/*}:annotate',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
