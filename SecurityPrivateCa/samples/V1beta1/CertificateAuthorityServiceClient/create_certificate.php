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

// [START privateca_v1beta1_generated_CertificateAuthorityService_CreateCertificate_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Security\PrivateCA\V1beta1\Certificate;
use Google\Cloud\Security\PrivateCA\V1beta1\CertificateAuthorityServiceClient;
use Google\Protobuf\Duration;

/**
 * Create a new [Certificate][google.cloud.security.privateca.v1beta1.Certificate] in a given Project, Location from a particular
 * [CertificateAuthority][google.cloud.security.privateca.v1beta1.CertificateAuthority].
 *
 * @param string $formattedParent The resource name of the location and [CertificateAuthority][google.cloud.security.privateca.v1beta1.CertificateAuthority]
 *                                associated with the [Certificate][google.cloud.security.privateca.v1beta1.Certificate], in the format
 *                                `projects/&#42;/locations/&#42;/certificateAuthorities/*`. Please see
 *                                {@see CertificateAuthorityServiceClient::certificateAuthorityName()} for help formatting this field.
 */
function create_certificate_sample(string $formattedParent): void
{
    // Create a client.
    $certificateAuthorityServiceClient = new CertificateAuthorityServiceClient();

    // Prepare the request message.
    $certificateLifetime = new Duration();
    $certificate = (new Certificate())
        ->setLifetime($certificateLifetime);

    // Call the API and handle any network failures.
    try {
        /** @var Certificate $response */
        $response = $certificateAuthorityServiceClient->createCertificate($formattedParent, $certificate);
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
    $formattedParent = CertificateAuthorityServiceClient::certificateAuthorityName(
        '[PROJECT]',
        '[LOCATION]',
        '[CERTIFICATE_AUTHORITY]'
    );

    create_certificate_sample($formattedParent);
}
// [END privateca_v1beta1_generated_CertificateAuthorityService_CreateCertificate_sync]
