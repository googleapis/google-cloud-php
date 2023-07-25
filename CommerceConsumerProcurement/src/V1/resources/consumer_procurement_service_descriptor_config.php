<?php

return [
    'interfaces' => [
        'google.cloud.commerce.consumer.procurement.v1.ConsumerProcurementService' => [
            'PlaceOrder' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Commerce\Consumer\Procurement\V1\Order',
                    'metadataReturnType' => '\Google\Cloud\Commerce\Consumer\Procurement\V1\PlaceOrderMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetOrder' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Commerce\Consumer\Procurement\V1\Order',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListOrders' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getOrders',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Commerce\Consumer\Procurement\V1\ListOrdersResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'billingAccount' => 'billingAccounts/{billing_account}',
                'consumerBillingAccountOffer' => 'billingAccounts/{consumer_billing_account}/offers/{offer}',
                'offer' => 'services/{service}/standardOffers/{offer}',
                'serviceOffer' => 'services/{service}/standardOffers/{offer}',
            ],
        ],
    ],
];
