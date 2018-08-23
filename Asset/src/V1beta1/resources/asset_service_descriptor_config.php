<?php

return [
    'interfaces' => [
        'google.cloud.asset.v1beta1.AssetService' => [
            'ExportAssets' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Asset\V1beta1\ExportAssetsResponse',
                    'metadataReturnType' => '\Google\Cloud\Asset\V1beta1\ExportAssetsRequest',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
        ],
    ],
];
