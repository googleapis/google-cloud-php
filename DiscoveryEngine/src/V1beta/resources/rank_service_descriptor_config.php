<?php

return [
    'interfaces' => [
        'google.cloud.discoveryengine.v1beta.RankService' => [
            'Rank' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\DiscoveryEngine\V1beta\RankResponse',
                'headerParams' => [
                    [
                        'keyName' => 'ranking_config',
                        'fieldAccessors' => [
                            'getRankingConfig',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'rankingConfig' => 'projects/{project}/locations/{location}/rankingConfigs/{ranking_config}',
            ],
        ],
    ],
];
