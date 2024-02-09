<?php

return [
    'interfaces' => [
        'google.cloud.compute.v1.Instances' => [
            'AddAccessConfig' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getZone',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'AddResourcePolicies' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getZone',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'AttachDisk' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getZone',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'BulkInsert' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getZone',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'Delete' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getZone',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'DeleteAccessConfig' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getZone',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'DetachDisk' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getZone',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'Insert' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getZone',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'PerformMaintenance' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getZone',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'RemoveResourcePolicies' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getZone',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'Reset' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getZone',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'Resume' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getZone',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'SetDeletionProtection' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getZone',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'resource',
                        'fieldAccessors' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'SetDiskAutoDelete' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getZone',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'SetLabels' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getZone',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'SetMachineResources' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getZone',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'SetMachineType' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getZone',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'SetMetadata' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getZone',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'SetMinCpuPlatform' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getZone',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'SetName' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getZone',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'SetScheduling' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getZone',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'SetSecurityPolicy' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getZone',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'SetServiceAccount' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getZone',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'SetShieldedInstanceIntegrityPolicy' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getZone',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'SetTags' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getZone',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'SimulateMaintenanceEvent' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getZone',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'Start' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getZone',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'StartWithEncryptionKey' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getZone',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'Stop' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getZone',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'Suspend' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getZone',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'Update' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getZone',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'UpdateAccessConfig' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getZone',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'UpdateDisplayDevice' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getZone',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'UpdateNetworkInterface' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getZone',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'UpdateShieldedInstanceConfig' => [
                'longRunning' => [
                    'additionalArgumentMethods' => [
                        'getProject',
                        'getZone',
                    ],
                    'getOperationMethod' => 'get',
                    'cancelOperationMethod' => null,
                    'deleteOperationMethod' => 'delete',
                    'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
                    'operationErrorMessageMethod' => 'getHttpErrorMessage',
                    'operationNameMethod' => 'getName',
                    'operationStatusMethod' => 'getStatus',
                    'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
                ],
                'responseType' => 'Google\Cloud\Compute\V1\Operation',
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'AggregatedList' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getMaxResults',
                    'requestPageSizeSetMethod' => 'setMaxResults',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getItems',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Compute\V1\InstanceAggregatedList',
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Get' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Compute\V1\Instance',
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'GetEffectiveFirewalls' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Compute\V1\InstancesGetEffectiveFirewallsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'GetGuestAttributes' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Compute\V1\GuestAttributes',
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'GetIamPolicy' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Compute\V1\Policy',
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'resource',
                        'fieldAccessors' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'GetScreenshot' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Compute\V1\Screenshot',
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'GetSerialPortOutput' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Compute\V1\SerialPortOutput',
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'GetShieldedInstanceIdentity' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Compute\V1\ShieldedInstanceIdentity',
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'List' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getMaxResults',
                    'requestPageSizeSetMethod' => 'setMaxResults',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getItems',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Compute\V1\InstanceList',
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                ],
            ],
            'ListReferrers' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getMaxResults',
                    'requestPageSizeSetMethod' => 'setMaxResults',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getItems',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Compute\V1\InstanceListReferrers',
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'SendDiagnosticInterrupt' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Compute\V1\SendDiagnosticInterruptInstanceResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'instance',
                        'fieldAccessors' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'SetIamPolicy' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Compute\V1\Policy',
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'resource',
                        'fieldAccessors' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'TestIamPermissions' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Compute\V1\TestPermissionsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                    [
                        'keyName' => 'zone',
                        'fieldAccessors' => [
                            'getZone',
                        ],
                    ],
                    [
                        'keyName' => 'resource',
                        'fieldAccessors' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
