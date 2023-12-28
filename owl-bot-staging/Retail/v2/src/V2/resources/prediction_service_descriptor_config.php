<?php

return [
    'interfaces' => [
        'google.cloud.retail.v2.PredictionService' => [
            'Predict' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Retail\V2\PredictResponse',
                'headerParams' => [
                    [
                        'keyName' => 'placement',
                        'fieldAccessors' => [
                            'getPlacement',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'product' => 'projects/{project}/locations/{location}/catalogs/{catalog}/branches/{branch}/products/{product}',
            ],
        ],
    ],
];
