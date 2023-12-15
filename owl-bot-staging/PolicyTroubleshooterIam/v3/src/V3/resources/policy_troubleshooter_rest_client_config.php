<?php

return [
    'interfaces' => [
        'google.cloud.policytroubleshooter.iam.v3.PolicyTroubleshooter' => [
            'TroubleshootIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v3/iam:troubleshoot',
                'body' => '*',
            ],
        ],
    ],
    'numericEnums' => true,
];
