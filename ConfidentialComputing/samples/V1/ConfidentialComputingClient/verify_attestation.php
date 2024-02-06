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

// [START confidentialcomputing_v1_generated_ConfidentialComputing_VerifyAttestation_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ConfidentialComputing\V1\Client\ConfidentialComputingClient;
use Google\Cloud\ConfidentialComputing\V1\TpmAttestation;
use Google\Cloud\ConfidentialComputing\V1\VerifyAttestationRequest;
use Google\Cloud\ConfidentialComputing\V1\VerifyAttestationResponse;

/**
 * Verifies the provided attestation info, returning a signed OIDC token.
 *
 * @param string $formattedChallenge The name of the Challenge whose nonce was used to generate the
 *                                   attestation, in the format `projects/&#42;/locations/&#42;/challenges/*`. The
 *                                   provided Challenge will be consumed, and cannot be used again. Please see
 *                                   {@see ConfidentialComputingClient::challengeName()} for help formatting this field.
 */
function verify_attestation_sample(string $formattedChallenge): void
{
    // Create a client.
    $confidentialComputingClient = new ConfidentialComputingClient();

    // Prepare the request message.
    $tpmAttestation = new TpmAttestation();
    $request = (new VerifyAttestationRequest())
        ->setChallenge($formattedChallenge)
        ->setTpmAttestation($tpmAttestation);

    // Call the API and handle any network failures.
    try {
        /** @var VerifyAttestationResponse $response */
        $response = $confidentialComputingClient->verifyAttestation($request);
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
    $formattedChallenge = ConfidentialComputingClient::challengeName(
        '[PROJECT]',
        '[LOCATION]',
        '[UUID]'
    );

    verify_attestation_sample($formattedChallenge);
}
// [END confidentialcomputing_v1_generated_ConfidentialComputing_VerifyAttestation_sync]
