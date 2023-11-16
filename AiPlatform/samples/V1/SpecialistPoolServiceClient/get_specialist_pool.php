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

// [START aiplatform_v1_generated_SpecialistPoolService_GetSpecialistPool_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AIPlatform\V1\Client\SpecialistPoolServiceClient;
use Google\Cloud\AIPlatform\V1\GetSpecialistPoolRequest;
use Google\Cloud\AIPlatform\V1\SpecialistPool;

/**
 * Gets a SpecialistPool.
 *
 * @param string $formattedName The name of the SpecialistPool resource.
 *                              The form is
 *                              `projects/{project}/locations/{location}/specialistPools/{specialist_pool}`. Please see
 *                              {@see SpecialistPoolServiceClient::specialistPoolName()} for help formatting this field.
 */
function get_specialist_pool_sample(string $formattedName): void
{
    // Create a client.
    $specialistPoolServiceClient = new SpecialistPoolServiceClient();

    // Prepare the request message.
    $request = (new GetSpecialistPoolRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var SpecialistPool $response */
        $response = $specialistPoolServiceClient->getSpecialistPool($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
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
    $formattedName = SpecialistPoolServiceClient::specialistPoolName(
        '[PROJECT]',
        '[LOCATION]',
        '[SPECIALIST_POOL]'
    );

    get_specialist_pool_sample($formattedName);
}
// [END aiplatform_v1_generated_SpecialistPoolService_GetSpecialistPool_sync]
