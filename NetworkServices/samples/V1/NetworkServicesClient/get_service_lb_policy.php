<?php
/*
 * Copyright 2025 Google LLC
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

// [START networkservices_v1_generated_NetworkServices_GetServiceLbPolicy_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\NetworkServices\V1\Client\NetworkServicesClient;
use Google\Cloud\NetworkServices\V1\GetServiceLbPolicyRequest;
use Google\Cloud\NetworkServices\V1\ServiceLbPolicy;

/**
 * Gets details of a single ServiceLbPolicy.
 *
 * @param string $formattedName A name of the ServiceLbPolicy to get. Must be in the format
 *                              `projects/{project}/locations/{location}/serviceLbPolicies/*`. Please see
 *                              {@see NetworkServicesClient::serviceLbPolicyName()} for help formatting this field.
 */
function get_service_lb_policy_sample(string $formattedName): void
{
    // Create a client.
    $networkServicesClient = new NetworkServicesClient();

    // Prepare the request message.
    $request = (new GetServiceLbPolicyRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var ServiceLbPolicy $response */
        $response = $networkServicesClient->getServiceLbPolicy($request);
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
    $formattedName = NetworkServicesClient::serviceLbPolicyName(
        '[PROJECT]',
        '[LOCATION]',
        '[SERVICE_LB_POLICY]'
    );

    get_service_lb_policy_sample($formattedName);
}
// [END networkservices_v1_generated_NetworkServices_GetServiceLbPolicy_sync]
