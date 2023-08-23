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

// [START certificatemanager_v1_generated_CertificateManager_CreateCertificateMapEntry_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\CertificateManager\V1\CertificateMapEntry;
use Google\Cloud\CertificateManager\V1\Client\CertificateManagerClient;
use Google\Cloud\CertificateManager\V1\CreateCertificateMapEntryRequest;
use Google\Rpc\Status;

/**
 * Creates a new CertificateMapEntry in a given project and location.
 *
 * @param string $formattedParent       The parent resource of the certificate map entry. Must be in the
 *                                      format `projects/&#42;/locations/&#42;/certificateMaps/*`. Please see
 *                                      {@see CertificateManagerClient::certificateMapName()} for help formatting this field.
 * @param string $certificateMapEntryId A user-provided name of the certificate map entry.
 */
function create_certificate_map_entry_sample(
    string $formattedParent,
    string $certificateMapEntryId
): void {
    // Create a client.
    $certificateManagerClient = new CertificateManagerClient();

    // Prepare the request message.
    $certificateMapEntry = new CertificateMapEntry();
    $request = (new CreateCertificateMapEntryRequest())
        ->setParent($formattedParent)
        ->setCertificateMapEntryId($certificateMapEntryId)
        ->setCertificateMapEntry($certificateMapEntry);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $certificateManagerClient->createCertificateMapEntry($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var CertificateMapEntry $result */
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
    $formattedParent = CertificateManagerClient::certificateMapName(
        '[PROJECT]',
        '[LOCATION]',
        '[CERTIFICATE_MAP]'
    );
    $certificateMapEntryId = '[CERTIFICATE_MAP_ENTRY_ID]';

    create_certificate_map_entry_sample($formattedParent, $certificateMapEntryId);
}
// [END certificatemanager_v1_generated_CertificateManager_CreateCertificateMapEntry_sync]
