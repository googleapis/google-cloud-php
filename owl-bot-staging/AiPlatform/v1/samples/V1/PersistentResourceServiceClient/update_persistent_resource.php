<?php
/*
 * Copyright 2024 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was automatically generated - do not edit!
 */

require_once __DIR__ . '/../../../vendor/autoload.php';

// [START aiplatform_v1_generated_PersistentResourceService_UpdatePersistentResource_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AIPlatform\V1\Client\PersistentResourceServiceClient;
use Google\Cloud\AIPlatform\V1\MachineSpec;
use Google\Cloud\AIPlatform\V1\PersistentResource;
use Google\Cloud\AIPlatform\V1\ResourcePool;
use Google\Cloud\AIPlatform\V1\UpdatePersistentResourceRequest;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates a PersistentResource.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_persistent_resource_sample(): void
{
    // Create a client.
    $persistentResourceServiceClient = new PersistentResourceServiceClient();

    // Prepare the request message.
    $persistentResourceResourcePoolsMachineSpec = new MachineSpec();
    $resourcePool = (new ResourcePool())
        ->setMachineSpec($persistentResourceResourcePoolsMachineSpec);
    $persistentResourceResourcePools = [$resourcePool,];
    $persistentResource = (new PersistentResource())
        ->setResourcePools($persistentResourceResourcePools);
    $updateMask = new FieldMask();
    $request = (new UpdatePersistentResourceRequest())
        ->setPersistentResource($persistentResource)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $persistentResourceServiceClient->updatePersistentResource($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var PersistentResource $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
        }
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END aiplatform_v1_generated_PersistentResourceService_UpdatePersistentResource_sync]
