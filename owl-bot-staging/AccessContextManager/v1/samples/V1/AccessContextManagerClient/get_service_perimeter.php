<?php
/*
 * Copyright 2023 Google LLC
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

// [START accesscontextmanager_v1_generated_AccessContextManager_GetServicePerimeter_sync]
use Google\ApiCore\ApiException;
use Google\Identity\AccessContextManager\V1\AccessContextManagerClient;
use Google\Identity\AccessContextManager\V1\ServicePerimeter;

/**
 * Gets a [service perimeter]
 * [google.identity.accesscontextmanager.v1.ServicePerimeter] based on the
 * resource name.
 *
 * @param string $formattedName Resource name for the [Service Perimeter]
 *                              [google.identity.accesscontextmanager.v1.ServicePerimeter].
 *
 *                              Format:
 *                              `accessPolicies/{policy_id}/servicePerimeters/{service_perimeters_id}`
 *                              Please see {@see AccessContextManagerClient::servicePerimeterName()} for help formatting this field.
 */
function get_service_perimeter_sample(string $formattedName): void
{
    // Create a client.
    $accessContextManagerClient = new AccessContextManagerClient();

    // Call the API and handle any network failures.
    try {
        /** @var ServicePerimeter $response */
        $response = $accessContextManagerClient->getServicePerimeter($formattedName);
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
    $formattedName = AccessContextManagerClient::servicePerimeterName(
        '[ACCESS_POLICY]',
        '[SERVICE_PERIMETER]'
    );

    get_service_perimeter_sample($formattedName);
}
// [END accesscontextmanager_v1_generated_AccessContextManager_GetServicePerimeter_sync]
