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

// [START privateca_v1beta1_generated_CertificateAuthorityService_RevokeCertificate_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Security\PrivateCA\V1beta1\Certificate;
use Google\Cloud\Security\PrivateCA\V1beta1\CertificateAuthorityServiceClient;
use Google\Cloud\Security\PrivateCA\V1beta1\RevocationReason;

/**
 * Revoke a [Certificate][google.cloud.security.privateca.v1beta1.Certificate].
 *
 * @param string $formattedName The resource name for this [Certificate][google.cloud.security.privateca.v1beta1.Certificate] in the
 *                              format `projects/&#42;/locations/&#42;/certificateAuthorities/&#42;/certificates/*`. Please see
 *                              {@see CertificateAuthorityServiceClient::certificateName()} for help formatting this field.
 * @param int    $reason        The [RevocationReason][google.cloud.security.privateca.v1beta1.RevocationReason] for revoking this certificate.
 */
function revoke_certificate_sample(string $formattedName, int $reason): void
{
    // Create a client.
    $certificateAuthorityServiceClient = new CertificateAuthorityServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var Certificate $response */
        $response = $certificateAuthorityServiceClient->revokeCertificate($formattedName, $reason);
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
    $formattedName = CertificateAuthorityServiceClient::certificateName(
        '[PROJECT]',
        '[LOCATION]',
        '[CERTIFICATE_AUTHORITY]',
        '[CERTIFICATE]'
    );
    $reason = RevocationReason::REVOCATION_REASON_UNSPECIFIED;

    revoke_certificate_sample($formattedName, $reason);
}
// [END privateca_v1beta1_generated_CertificateAuthorityService_RevokeCertificate_sync]
