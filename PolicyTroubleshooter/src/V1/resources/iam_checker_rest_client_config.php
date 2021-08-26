<?php

return [
    'interfaces' => [
        'google.cloud.policytroubleshooter.v1.IamChecker' => [
            'TroubleshootIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/iam:troubleshoot',
                'body' => '*',
            ],
        ],
    ],
];
