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

// [START dialogflow_v2_generated_SipTrunks_CreateSipTrunk_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\V2\Client\SipTrunksClient;
use Google\Cloud\Dialogflow\V2\CreateSipTrunkRequest;
use Google\Cloud\Dialogflow\V2\SipTrunk;

/**
 * Creates a SipTrunk for a specified location.
 *
 * @param string $formattedParent                 The location to create a SIP trunk for.
 *                                                Format: `projects/<Project ID>/locations/<Location ID>`. Please see
 *                                                {@see SipTrunksClient::locationName()} for help formatting this field.
 * @param string $sipTrunkExpectedHostnameElement The expected hostnames in the peer certificate from partner that
 *                                                is used for TLS authentication.
 */
function create_sip_trunk_sample(
    string $formattedParent,
    string $sipTrunkExpectedHostnameElement
): void {
    // Create a client.
    $sipTrunksClient = new SipTrunksClient();

    // Prepare the request message.
    $sipTrunkExpectedHostname = [$sipTrunkExpectedHostnameElement,];
    $sipTrunk = (new SipTrunk())
        ->setExpectedHostname($sipTrunkExpectedHostname);
    $request = (new CreateSipTrunkRequest())
        ->setParent($formattedParent)
        ->setSipTrunk($sipTrunk);

    // Call the API and handle any network failures.
    try {
        /** @var SipTrunk $response */
        $response = $sipTrunksClient->createSipTrunk($request);
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
    $formattedParent = SipTrunksClient::locationName('[PROJECT]', '[LOCATION]');
    $sipTrunkExpectedHostnameElement = '[EXPECTED_HOSTNAME]';

    create_sip_trunk_sample($formattedParent, $sipTrunkExpectedHostnameElement);
}
// [END dialogflow_v2_generated_SipTrunks_CreateSipTrunk_sync]
