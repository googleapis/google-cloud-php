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

// [START networkservices_v1_generated_NetworkServices_CreateServiceLbPolicy_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkServices\V1\Client\NetworkServicesClient;
use Google\Cloud\NetworkServices\V1\CreateServiceLbPolicyRequest;
use Google\Cloud\NetworkServices\V1\ServiceLbPolicy;
use Google\Rpc\Status;

/**
 * Creates a new ServiceLbPolicy in a given project and location.
 *
 * @param string $formattedParent   The parent resource of the ServiceLbPolicy. Must be in the
 *                                  format `projects/{project}/locations/{location}`. Please see
 *                                  {@see NetworkServicesClient::locationName()} for help formatting this field.
 * @param string $serviceLbPolicyId Short name of the ServiceLbPolicy resource to be created.
 *                                  E.g. for resource name
 *                                  `projects/{project}/locations/{location}/serviceLbPolicies/{service_lb_policy_name}`.
 *                                  the id is value of {service_lb_policy_name}
 */
function create_service_lb_policy_sample(string $formattedParent, string $serviceLbPolicyId): void
{
    // Create a client.
    $networkServicesClient = new NetworkServicesClient();

    // Prepare the request message.
    $serviceLbPolicy = new ServiceLbPolicy();
    $request = (new CreateServiceLbPolicyRequest())
        ->setParent($formattedParent)
        ->setServiceLbPolicyId($serviceLbPolicyId)
        ->setServiceLbPolicy($serviceLbPolicy);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $networkServicesClient->createServiceLbPolicy($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ServiceLbPolicy $result */
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
    $formattedParent = NetworkServicesClient::locationName('[PROJECT]', '[LOCATION]');
    $serviceLbPolicyId = '[SERVICE_LB_POLICY_ID]';

    create_service_lb_policy_sample($formattedParent, $serviceLbPolicyId);
}
// [END networkservices_v1_generated_NetworkServices_CreateServiceLbPolicy_sync]
