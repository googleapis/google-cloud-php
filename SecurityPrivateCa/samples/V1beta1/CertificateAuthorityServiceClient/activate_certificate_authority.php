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

// [START privateca_v1beta1_generated_CertificateAuthorityService_ActivateCertificateAuthority_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Security\PrivateCA\V1beta1\CertificateAuthority;
use Google\Cloud\Security\PrivateCA\V1beta1\CertificateAuthorityServiceClient;
use Google\Cloud\Security\PrivateCA\V1beta1\SubordinateConfig;
use Google\Rpc\Status;

/**
 * Activate a [CertificateAuthority][google.cloud.security.privateca.v1beta1.CertificateAuthority] that is in state
 * [PENDING_ACTIVATION][google.cloud.security.privateca.v1beta1.CertificateAuthority.State.PENDING_ACTIVATION] and is
 * of type [SUBORDINATE][google.cloud.security.privateca.v1beta1.CertificateAuthority.Type.SUBORDINATE]. After the
 * parent Certificate Authority signs a certificate signing request from
 * [FetchCertificateAuthorityCsr][google.cloud.security.privateca.v1beta1.CertificateAuthorityService.FetchCertificateAuthorityCsr], this method can complete the activation
 * process.
 *
 * @param string $formattedName                         The resource name for this [CertificateAuthority][google.cloud.security.privateca.v1beta1.CertificateAuthority] in the
 *                                                      format `projects/&#42;/locations/&#42;/certificateAuthorities/*`. Please see
 *                                                      {@see CertificateAuthorityServiceClient::certificateAuthorityName()} for help formatting this field.
 * @param string $pemCaCertificate                      The signed CA certificate issued from
 *                                                      [FetchCertificateAuthorityCsrResponse.pem_csr][google.cloud.security.privateca.v1beta1.FetchCertificateAuthorityCsrResponse.pem_csr].
 * @param string $subordinateConfigCertificateAuthority This can refer to a [CertificateAuthority][google.cloud.security.privateca.v1beta1.CertificateAuthority] in the same project that
 *                                                      was used to create a subordinate [CertificateAuthority][google.cloud.security.privateca.v1beta1.CertificateAuthority]. This field
 *                                                      is used for information and usability purposes only. The resource name
 *                                                      is in the format `projects/&#42;/locations/&#42;/certificateAuthorities/*`.
 */
function activate_certificate_authority_sample(
    string $formattedName,
    string $pemCaCertificate,
    string $subordinateConfigCertificateAuthority
): void {
    // Create a client.
    $certificateAuthorityServiceClient = new CertificateAuthorityServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $subordinateConfig = (new SubordinateConfig())
        ->setCertificateAuthority($subordinateConfigCertificateAuthority);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $certificateAuthorityServiceClient->activateCertificateAuthority(
            $formattedName,
            $pemCaCertificate,
            $subordinateConfig
        );
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
        '[CERTIFICATE_AUTHORITY]'
    );
    $pemCaCertificate = '[PEM_CA_CERTIFICATE]';
    $subordinateConfigCertificateAuthority = '[CERTIFICATE_AUTHORITY]';

    activate_certificate_authority_sample(
        $formattedName,
        $pemCaCertificate,
        $subordinateConfigCertificateAuthority
    );
}
// [END privateca_v1beta1_generated_CertificateAuthorityService_ActivateCertificateAuthority_sync]
