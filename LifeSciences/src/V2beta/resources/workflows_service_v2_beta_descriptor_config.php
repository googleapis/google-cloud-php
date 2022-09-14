<?php

return [
    'interfaces' => [
        'google.cloud.lifesciences.v2beta.WorkflowsServiceV2Beta' => [
            'RunPipeline' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\LifeSciences\V2beta\RunPipelineResponse',
                    'metadataReturnType' => '\Google\Cloud\LifeSciences\V2beta\Metadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
        ],
    ],
];
