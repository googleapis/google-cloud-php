<?php
/*
 * Copyright 2022 Google LLC
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

// [START aiplatform_v1_generated_SpecialistPoolService_UpdateSpecialistPool_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AIPlatform\V1\SpecialistPool;
use Google\Cloud\AIPlatform\V1\SpecialistPoolServiceClient;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates a SpecialistPool.
 *
 * @param string $specialistPoolName        The resource name of the SpecialistPool.
 * @param string $specialistPoolDisplayName The user-defined name of the SpecialistPool.
 *                                          The name can be up to 128 characters long and can consist of any UTF-8
 *                                          characters.
 *                                          This field should be unique on project-level.
 */
function update_specialist_pool_sample(
    string $specialistPoolName,
    string $specialistPoolDisplayName
): void {
    // Create a client.
    $specialistPoolServiceClient = new SpecialistPoolServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $specialistPool = (new SpecialistPool())
        ->setName($specialistPoolName)
        ->setDisplayName($specialistPoolDisplayName);
    $updateMask = new FieldMask();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $specialistPoolServiceClient->updateSpecialistPool($specialistPool, $updateMask);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var SpecialistPool $result */
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
    $specialistPoolName = '[NAME]';
    $specialistPoolDisplayName = '[DISPLAY_NAME]';

    update_specialist_pool_sample($specialistPoolName, $specialistPoolDisplayName);
}
// [END aiplatform_v1_generated_SpecialistPoolService_UpdateSpecialistPool_sync]
