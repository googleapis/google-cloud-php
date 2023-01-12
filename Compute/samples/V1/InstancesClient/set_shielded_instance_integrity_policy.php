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

// [START compute_v1_generated_Instances_SetShieldedInstanceIntegrityPolicy_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Compute\V1\InstancesClient;
use Google\Cloud\Compute\V1\ShieldedInstanceIntegrityPolicy;
use Google\Rpc\Status;

/**
 * Sets the Shielded Instance integrity policy for an instance. You can only use this method on a running instance. This method supports PATCH semantics and uses the JSON merge patch format and processing rules.
 *
 * @param string $instance Name or id of the instance scoping this request.
 * @param string $project  Project ID for this request.
 * @param string $zone     The name of the zone for this request.
 */
function set_shielded_instance_integrity_policy_sample(
    string $instance,
    string $project,
    string $zone
): void {
    // Create a client.
    $instancesClient = new InstancesClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $shieldedInstanceIntegrityPolicyResource = new ShieldedInstanceIntegrityPolicy();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $instancesClient->setShieldedInstanceIntegrityPolicy(
            $instance,
            $project,
            $shieldedInstanceIntegrityPolicyResource,
            $zone
        );
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
    $instance = '[INSTANCE]';
    $project = '[PROJECT]';
    $zone = '[ZONE]';

    set_shielded_instance_integrity_policy_sample($instance, $project, $zone);
}
// [END compute_v1_generated_Instances_SetShieldedInstanceIntegrityPolicy_sync]
