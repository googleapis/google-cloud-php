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

// [START compute_v1_generated_OrganizationSecurityPolicies_Move_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Compute\V1\Client\OrganizationSecurityPoliciesClient;
use Google\Cloud\Compute\V1\MoveOrganizationSecurityPolicyRequest;
use Google\Rpc\Status;

/**
 * Moves the specified security policy. Use of this API to modify firewall policies is deprecated. Use firewallPolicies.move instead.
 *
 * @param string $securityPolicy Name of the security policy to update.
 */
function move_sample(string $securityPolicy): void
{
    // Create a client.
    $organizationSecurityPoliciesClient = new OrganizationSecurityPoliciesClient();

    // Prepare the request message.
    $request = (new MoveOrganizationSecurityPolicyRequest())
        ->setSecurityPolicy($securityPolicy);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $organizationSecurityPoliciesClient->move($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            printf('Operation completed successfully.' . PHP_EOL);
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
    $securityPolicy = '[SECURITY_POLICY]';

    move_sample($securityPolicy);
}
// [END compute_v1_generated_OrganizationSecurityPolicies_Move_sync]
