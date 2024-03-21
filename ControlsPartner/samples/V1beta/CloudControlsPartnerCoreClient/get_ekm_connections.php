<?php
/*
 * Copyright 2024 Google LLC
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

// [START cloudcontrolspartner_v1beta_generated_CloudControlsPartnerCore_GetEkmConnections_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\CloudControlsPartner\V1beta\Client\CloudControlsPartnerCoreClient;
use Google\Cloud\CloudControlsPartner\V1beta\EkmConnections;
use Google\Cloud\CloudControlsPartner\V1beta\GetEkmConnectionsRequest;

/**
 * Gets the EKM connections associated with a workload
 *
 * @param string $formattedName Format:
 *                              organizations/{organization}/locations/{location}/customers/{customer}/workloads/{workload}/ekmConnections
 *                              Please see {@see CloudControlsPartnerCoreClient::ekmConnectionsName()} for help formatting this field.
 */
function get_ekm_connections_sample(string $formattedName): void
{
    // Create a client.
    $cloudControlsPartnerCoreClient = new CloudControlsPartnerCoreClient();

    // Prepare the request message.
    $request = (new GetEkmConnectionsRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var EkmConnections $response */
        $response = $cloudControlsPartnerCoreClient->getEkmConnections($request);
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
    $formattedName = CloudControlsPartnerCoreClient::ekmConnectionsName(
        '[ORGANIZATION]',
        '[LOCATION]',
        '[CUSTOMER]',
        '[WORKLOAD]'
    );

    get_ekm_connections_sample($formattedName);
}
// [END cloudcontrolspartner_v1beta_generated_CloudControlsPartnerCore_GetEkmConnections_sync]
