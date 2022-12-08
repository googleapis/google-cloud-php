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

// [START privateca_v1_generated_CertificateAuthorityService_ListCertificates_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Security\PrivateCA\V1\Certificate;
use Google\Cloud\Security\PrivateCA\V1\CertificateAuthorityServiceClient;

/**
 * Lists [Certificates][google.cloud.security.privateca.v1.Certificate].
 *
 * @param string $formattedParent The resource name of the location associated with the
 *                                [Certificates][google.cloud.security.privateca.v1.Certificate], in the format
 *                                `projects/&#42;/locations/&#42;/caPools/*`. Please see
 *                                {@see CertificateAuthorityServiceClient::caPoolName()} for help formatting this field.
 */
function list_certificates_sample(string $formattedParent): void
{
    // Create a client.
    $certificateAuthorityServiceClient = new CertificateAuthorityServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $certificateAuthorityServiceClient->listCertificates($formattedParent);

        /** @var Certificate $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
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
    $formattedParent = CertificateAuthorityServiceClient::caPoolName(
        '[PROJECT]',
        '[LOCATION]',
        '[CA_POOL]'
    );

    list_certificates_sample($formattedParent);
}
// [END privateca_v1_generated_CertificateAuthorityService_ListCertificates_sync]
