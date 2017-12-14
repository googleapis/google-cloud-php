<?php

return [
    'interfaces' => [
        'google.privacy.dlp.v2beta1.DlpService' => [
            'analyzeDataSourceRisk' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Dlp\V2beta1\RiskAnalysisOperationResult',
                    'metadataReturnType' => '\Google\Cloud\Dlp\V2beta1\RiskAnalysisOperationMetadata',
                ],
            ],
            'createInspectOperation' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Dlp\V2beta1\InspectOperationResult',
                    'metadataReturnType' => '\Google\Cloud\Dlp\V2beta1\InspectOperationMetadata',
                ],
            ],
        ],
    ],
];
