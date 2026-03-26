<?php
/*
 * Copyright 2026 Google LLC
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

// [START networksecurity_v1_generated_Mirroring_UpdateMirroringDeployment_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkSecurity\V1\Client\MirroringClient;
use Google\Cloud\NetworkSecurity\V1\MirroringDeployment;
use Google\Cloud\NetworkSecurity\V1\UpdateMirroringDeploymentRequest;
use Google\Rpc\Status;

/**
 * Updates a deployment.
 * See https://google.aip.dev/134.
 *
 * @param string $formattedMirroringDeploymentForwardingRule           Immutable. The regional forwarding rule that fronts the mirroring
 *                                                                     collectors, for example:
 *                                                                     `projects/123456789/regions/us-central1/forwardingRules/my-rule`. See
 *                                                                     https://google.aip.dev/124. Please see
 *                                                                     {@see MirroringClient::forwardingRuleName()} for help formatting this field.
 * @param string $formattedMirroringDeploymentMirroringDeploymentGroup Immutable. The deployment group that this deployment is a part
 *                                                                     of, for example:
 *                                                                     `projects/123456789/locations/global/mirroringDeploymentGroups/my-dg`.
 *                                                                     See https://google.aip.dev/124. Please see
 *                                                                     {@see MirroringClient::mirroringDeploymentGroupName()} for help formatting this field.
 */
function update_mirroring_deployment_sample(
    string $formattedMirroringDeploymentForwardingRule,
    string $formattedMirroringDeploymentMirroringDeploymentGroup
): void {
    // Create a client.
    $mirroringClient = new MirroringClient();

    // Prepare the request message.
    $mirroringDeployment = (new MirroringDeployment())
        ->setForwardingRule($formattedMirroringDeploymentForwardingRule)
        ->setMirroringDeploymentGroup($formattedMirroringDeploymentMirroringDeploymentGroup);
    $request = (new UpdateMirroringDeploymentRequest())
        ->setMirroringDeployment($mirroringDeployment);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $mirroringClient->updateMirroringDeployment($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var MirroringDeployment $result */
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
    $formattedMirroringDeploymentForwardingRule = MirroringClient::forwardingRuleName(
        '[PROJECT]',
        '[FORWARDING_RULE]'
    );
    $formattedMirroringDeploymentMirroringDeploymentGroup = MirroringClient::mirroringDeploymentGroupName(
        '[PROJECT]',
        '[LOCATION]',
        '[MIRRORING_DEPLOYMENT_GROUP]'
    );

    update_mirroring_deployment_sample(
        $formattedMirroringDeploymentForwardingRule,
        $formattedMirroringDeploymentMirroringDeploymentGroup
    );
}
// [END networksecurity_v1_generated_Mirroring_UpdateMirroringDeployment_sync]
