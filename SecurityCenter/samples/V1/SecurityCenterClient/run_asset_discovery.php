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

// [START securitycenter_v1_generated_SecurityCenter_RunAssetDiscovery_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\SecurityCenter\V1\RunAssetDiscoveryResponse;
use Google\Cloud\SecurityCenter\V1\SecurityCenterClient;
use Google\Rpc\Status;

/**
 * Runs asset discovery. The discovery is tracked with a long-running
 * operation.
 *
 * This API can only be called with limited frequency for an organization. If
 * it is called too frequently the caller will receive a TOO_MANY_REQUESTS
 * error.
 *
 * @param string $formattedParent Name of the organization to run asset discovery for. Its format
 *                                is "organizations/[organization_id]". Please see
 *                                {@see SecurityCenterClient::organizationName()} for help formatting this field.
 */
function run_asset_discovery_sample(string $formattedParent): void
{
    // Create a client.
    $securityCenterClient = new SecurityCenterClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $securityCenterClient->runAssetDiscovery($formattedParent);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var RunAssetDiscoveryResponse $result */
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
    $formattedParent = SecurityCenterClient::organizationName('[ORGANIZATION]');

    run_asset_discovery_sample($formattedParent);
}
// [END securitycenter_v1_generated_SecurityCenter_RunAssetDiscovery_sync]
