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

// [START privateca_v1beta1_generated_CertificateAuthorityService_UpdateCertificate_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Security\PrivateCA\V1beta1\Certificate;
use Google\Cloud\Security\PrivateCA\V1beta1\CertificateAuthorityServiceClient;
use Google\Protobuf\Duration;
use Google\Protobuf\FieldMask;

/**
 * Update a [Certificate][google.cloud.security.privateca.v1beta1.Certificate]. Currently, the only field you can update is the
 * [labels][google.cloud.security.privateca.v1beta1.Certificate.labels] field.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_certificate_sample(): void
{
    // Create a client.
    $certificateAuthorityServiceClient = new CertificateAuthorityServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $certificateLifetime = new Duration();
    $certificate = (new Certificate())
        ->setLifetime($certificateLifetime);
    $updateMask = new FieldMask();

    // Call the API and handle any network failures.
    try {
        /** @var Certificate $response */
        $response = $certificateAuthorityServiceClient->updateCertificate($certificate, $updateMask);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END privateca_v1beta1_generated_CertificateAuthorityService_UpdateCertificate_sync]
