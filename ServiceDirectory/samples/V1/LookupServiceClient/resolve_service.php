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

// [START servicedirectory_v1_generated_LookupService_ResolveService_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ServiceDirectory\V1\Client\LookupServiceClient;
use Google\Cloud\ServiceDirectory\V1\ResolveServiceRequest;
use Google\Cloud\ServiceDirectory\V1\ResolveServiceResponse;

/**
 * Returns a [service][google.cloud.servicedirectory.v1.Service] and its
 * associated endpoints.
 * Resolving a service is not considered an active developer method.
 *
 * @param string $formattedName The name of the service to resolve. Please see
 *                              {@see LookupServiceClient::serviceName()} for help formatting this field.
 */
function resolve_service_sample(string $formattedName): void
{
    // Create a client.
    $lookupServiceClient = new LookupServiceClient();

    // Prepare the request message.
    $request = (new ResolveServiceRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var ResolveServiceResponse $response */
        $response = $lookupServiceClient->resolveService($request);
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
    $formattedName = LookupServiceClient::serviceName(
        '[PROJECT]',
        '[LOCATION]',
        '[NAMESPACE]',
        '[SERVICE]'
    );

    resolve_service_sample($formattedName);
}
// [END servicedirectory_v1_generated_LookupService_ResolveService_sync]
