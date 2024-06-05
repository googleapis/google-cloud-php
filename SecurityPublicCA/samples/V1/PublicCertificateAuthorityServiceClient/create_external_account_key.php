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

// [START publicca_v1_generated_PublicCertificateAuthorityService_CreateExternalAccountKey_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Security\PublicCA\V1\Client\PublicCertificateAuthorityServiceClient;
use Google\Cloud\Security\PublicCA\V1\CreateExternalAccountKeyRequest;
use Google\Cloud\Security\PublicCA\V1\ExternalAccountKey;

/**
 * Creates a new
 * [ExternalAccountKey][google.cloud.security.publicca.v1.ExternalAccountKey]
 * bound to the project.
 *
 * @param string $formattedParent The parent resource where this external_account_key will be
 *                                created. Format: projects/[project_id]/locations/[location]. At present
 *                                only the "global" location is supported. Please see
 *                                {@see PublicCertificateAuthorityServiceClient::locationName()} for help formatting this field.
 */
function create_external_account_key_sample(string $formattedParent): void
{
    // Create a client.
    $publicCertificateAuthorityServiceClient = new PublicCertificateAuthorityServiceClient();

    // Prepare the request message.
    $externalAccountKey = new ExternalAccountKey();
    $request = (new CreateExternalAccountKeyRequest())
        ->setParent($formattedParent)
        ->setExternalAccountKey($externalAccountKey);

    // Call the API and handle any network failures.
    try {
        /** @var ExternalAccountKey $response */
        $response = $publicCertificateAuthorityServiceClient->createExternalAccountKey($request);
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
    $formattedParent = PublicCertificateAuthorityServiceClient::locationName('[PROJECT]', '[LOCATION]');

    create_external_account_key_sample($formattedParent);
}
// [END publicca_v1_generated_PublicCertificateAuthorityService_CreateExternalAccountKey_sync]
