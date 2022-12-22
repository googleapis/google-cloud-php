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

// [START privateca_v1_generated_CertificateAuthorityService_DisableCertificateAuthority_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Security\PrivateCA\V1\CertificateAuthority;
use Google\Cloud\Security\PrivateCA\V1\CertificateAuthorityServiceClient;
use Google\Rpc\Status;

/**
 * Disable a [CertificateAuthority][google.cloud.security.privateca.v1.CertificateAuthority].
 *
 * @param string $formattedName The resource name for this [CertificateAuthority][google.cloud.security.privateca.v1.CertificateAuthority] in the
 *                              format `projects/&#42;/locations/&#42;/caPools/&#42;/certificateAuthorities/*`. Please see
 *                              {@see CertificateAuthorityServiceClient::certificateAuthorityName()} for help formatting this field.
 */
function disable_certificate_authority_sample(string $formattedName): void
{
    // Create a client.
    $certificateAuthorityServiceClient = new CertificateAuthorityServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $certificateAuthorityServiceClient->disableCertificateAuthority($formattedName);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var CertificateAuthority $result */
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
    $formattedName = CertificateAuthorityServiceClient::certificateAuthorityName(
        '[PROJECT]',
        '[LOCATION]',
        '[CA_POOL]',
        '[CERTIFICATE_AUTHORITY]'
    );

    disable_certificate_authority_sample($formattedName);
}
// [END privateca_v1_generated_CertificateAuthorityService_DisableCertificateAuthority_sync]
