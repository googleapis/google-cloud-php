<?php

return [
    'interfaces' => [
        'google.cloud.binaryauthorization.v1.ValidationHelperV1' => [
            'ValidateAttestationOccurrence' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\BinaryAuthorization\V1\ValidateAttestationOccurrenceResponse',
                'headerParams' => [
                    [
                        'keyName' => 'attestor',
                        'fieldAccessors' => [
                            'getAttestor',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
