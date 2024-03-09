<?php

return [
    'interfaces' => [
        'google.cloud.discoveryengine.v1beta.RecommendationService' => [
            'Recommend' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\DiscoveryEngine\V1beta\RecommendResponse',
                'headerParams' => [
                    [
                        'keyName' => 'serving_config',
                        'fieldAccessors' => [
                            'getServingConfig',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'document' => 'projects/{project}/locations/{location}/dataStores/{data_store}/branches/{branch}/documents/{document}',
                'projectLocationCollectionDataStoreBranchDocument' => 'projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}/branches/{branch}/documents/{document}',
                'projectLocationCollectionDataStoreServingConfig' => 'projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}/servingConfigs/{serving_config}',
                'projectLocationCollectionEngineServingConfig' => 'projects/{project}/locations/{location}/collections/{collection}/engines/{engine}/servingConfigs/{serving_config}',
                'projectLocationDataStoreBranchDocument' => 'projects/{project}/locations/{location}/dataStores/{data_store}/branches/{branch}/documents/{document}',
                'projectLocationDataStoreServingConfig' => 'projects/{project}/locations/{location}/dataStores/{data_store}/servingConfigs/{serving_config}',
                'servingConfig' => 'projects/{project}/locations/{location}/dataStores/{data_store}/servingConfigs/{serving_config}',
            ],
        ],
    ],
];
