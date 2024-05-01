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

// [START aiplatform_v1_generated_PersistentResourceService_CreatePersistentResource_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AIPlatform\V1\Client\PersistentResourceServiceClient;
use Google\Cloud\AIPlatform\V1\CreatePersistentResourceRequest;
use Google\Cloud\AIPlatform\V1\MachineSpec;
use Google\Cloud\AIPlatform\V1\PersistentResource;
use Google\Cloud\AIPlatform\V1\ResourcePool;
use Google\Rpc\Status;

/**
 * Creates a PersistentResource.
 *
 * @param string $formattedParent      The resource name of the Location to create the
 *                                     PersistentResource in. Format: `projects/{project}/locations/{location}`
 *                                     Please see {@see PersistentResourceServiceClient::locationName()} for help formatting this field.
 * @param string $persistentResourceId The ID to use for the PersistentResource, which become the final
 *                                     component of the PersistentResource's resource name.
 *
 *                                     The maximum length is 63 characters, and valid characters
 *                                     are `/^[a-z]([a-z0-9-]{0,61}[a-z0-9])?$/`.
 */
function create_persistent_resource_sample(
    string $formattedParent,
    string $persistentResourceId
): void {
    // Create a client.
    $persistentResourceServiceClient = new PersistentResourceServiceClient();

    // Prepare the request message.
    $persistentResourceResourcePoolsMachineSpec = new MachineSpec();
    $resourcePool = (new ResourcePool())
        ->setMachineSpec($persistentResourceResourcePoolsMachineSpec);
    $persistentResourceResourcePools = [$resourcePool,];
    $persistentResource = (new PersistentResource())
        ->setResourcePools($persistentResourceResourcePools);
    $request = (new CreatePersistentResourceRequest())
        ->setParent($formattedParent)
        ->setPersistentResource($persistentResource)
        ->setPersistentResourceId($persistentResourceId);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $persistentResourceServiceClient->createPersistentResource($request);
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

/**
 * Helper to execute the sample.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function callSample(): void
{
    $formattedParent = PersistentResourceServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $persistentResourceId = '[PERSISTENT_RESOURCE_ID]';

    create_persistent_resource_sample($formattedParent, $persistentResourceId);
}
// [END aiplatform_v1_generated_PersistentResourceService_CreatePersistentResource_sync]
