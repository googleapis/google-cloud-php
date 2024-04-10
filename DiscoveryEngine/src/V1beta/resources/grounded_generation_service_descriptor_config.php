<?php

return [
    'interfaces' => [
        'google.cloud.discoveryengine.v1beta.GroundedGenerationService' => [
            'CheckGrounding' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\DiscoveryEngine\V1beta\CheckGroundingResponse',
                'headerParams' => [
                    [
                        'keyName' => 'grounding_config',
                        'fieldAccessors' => [
                            'getGroundingConfig',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'groundingConfig' => 'projects/{project}/locations/{location}/groundingConfigs/{grounding_config}',
            ],
        ],
    ],
];
