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

// [START privateca_v1_generated_CertificateAuthorityService_GetCertificateRevocationList_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Security\PrivateCA\V1\CertificateRevocationList;
use Google\Cloud\Security\PrivateCA\V1\Client\CertificateAuthorityServiceClient;
use Google\Cloud\Security\PrivateCA\V1\GetCertificateRevocationListRequest;

/**
 * Returns a
 * [CertificateRevocationList][google.cloud.security.privateca.v1.CertificateRevocationList].
 *
 * @param string $formattedName The
 *                              [name][google.cloud.security.privateca.v1.CertificateRevocationList.name]
 *                              of the
 *                              [CertificateRevocationList][google.cloud.security.privateca.v1.CertificateRevocationList]
 *                              to get. Please see
 *                              {@see CertificateAuthorityServiceClient::certificateRevocationListName()} for help formatting this field.
 */
function get_certificate_revocation_list_sample(string $formattedName): void
{
    // Create a client.
    $certificateAuthorityServiceClient = new CertificateAuthorityServiceClient();

    // Prepare the request message.
    $request = (new GetCertificateRevocationListRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var CertificateRevocationList $response */
        $response = $certificateAuthorityServiceClient->getCertificateRevocationList($request);
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
    $formattedName = CertificateAuthorityServiceClient::certificateRevocationListName(
        '[PROJECT]',
        '[LOCATION]',
        '[CA_POOL]',
        '[CERTIFICATE_AUTHORITY]',
        '[CERTIFICATE_REVOCATION_LIST]'
    );

    get_certificate_revocation_list_sample($formattedName);
}
// [END privateca_v1_generated_CertificateAuthorityService_GetCertificateRevocationList_sync]
