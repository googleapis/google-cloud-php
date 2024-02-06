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

// [START binaryauthorization_v1_generated_ValidationHelperV1_ValidateAttestationOccurrence_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\BinaryAuthorization\V1\Client\ValidationHelperV1Client;
use Google\Cloud\BinaryAuthorization\V1\ValidateAttestationOccurrenceRequest;
use Google\Cloud\BinaryAuthorization\V1\ValidateAttestationOccurrenceResponse;
use Grafeas\V1\AttestationOccurrence;

/**
 * Returns whether the given Attestation for the given image URI
 * was signed by the given Attestor
 *
 * @param string $attestor              The resource name of the [Attestor][google.cloud.binaryauthorization.v1.Attestor] of the
 *                                      [occurrence][grafeas.v1.Occurrence], in the format
 *                                      `projects/&#42;/attestors/*`.
 * @param string $occurrenceNote        The resource name of the [Note][grafeas.v1.Note] to which the
 *                                      containing [Occurrence][grafeas.v1.Occurrence] is associated.
 * @param string $occurrenceResourceUri The URI of the artifact (e.g. container image) that is the
 *                                      subject of the containing [Occurrence][grafeas.v1.Occurrence].
 */
function validate_attestation_occurrence_sample(
    string $attestor,
    string $occurrenceNote,
    string $occurrenceResourceUri
): void {
    // Create a client.
    $validationHelperV1Client = new ValidationHelperV1Client();

    // Prepare the request message.
    $attestation = new AttestationOccurrence();
    $request = (new ValidateAttestationOccurrenceRequest())
        ->setAttestor($attestor)
        ->setAttestation($attestation)
        ->setOccurrenceNote($occurrenceNote)
        ->setOccurrenceResourceUri($occurrenceResourceUri);

    // Call the API and handle any network failures.
    try {
        /** @var ValidateAttestationOccurrenceResponse $response */
        $response = $validationHelperV1Client->validateAttestationOccurrence($request);
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
    $attestor = '[ATTESTOR]';
    $occurrenceNote = '[OCCURRENCE_NOTE]';
    $occurrenceResourceUri = '[OCCURRENCE_RESOURCE_URI]';

    validate_attestation_occurrence_sample($attestor, $occurrenceNote, $occurrenceResourceUri);
}
// [END binaryauthorization_v1_generated_ValidationHelperV1_ValidateAttestationOccurrence_sync]
