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

// [START privateca_v1_generated_CertificateAuthorityService_UpdateCertificateAuthority_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Security\PrivateCA\V1\CertificateAuthority;
use Google\Cloud\Security\PrivateCA\V1\CertificateAuthorityServiceClient;
use Google\Cloud\Security\PrivateCA\V1\CertificateAuthority\KeyVersionSpec;
use Google\Cloud\Security\PrivateCA\V1\CertificateAuthority\Type;
use Google\Cloud\Security\PrivateCA\V1\CertificateConfig;
use Google\Cloud\Security\PrivateCA\V1\CertificateConfig\SubjectConfig;
use Google\Cloud\Security\PrivateCA\V1\Subject;
use Google\Cloud\Security\PrivateCA\V1\X509Parameters;
use Google\Protobuf\Duration;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Update a
 * [CertificateAuthority][google.cloud.security.privateca.v1.CertificateAuthority].
 *
 * @param int $certificateAuthorityType Immutable. The
 *                                      [Type][google.cloud.security.privateca.v1.CertificateAuthority.Type] of
 *                                      this
 *                                      [CertificateAuthority][google.cloud.security.privateca.v1.CertificateAuthority].
 */
function update_certificate_authority_sample(int $certificateAuthorityType): void
{
    // Create a client.
    $certificateAuthorityServiceClient = new CertificateAuthorityServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $certificateAuthorityConfigSubjectConfigSubject = new Subject();
    $certificateAuthorityConfigSubjectConfig = (new SubjectConfig())
        ->setSubject($certificateAuthorityConfigSubjectConfigSubject);
    $certificateAuthorityConfigX509Config = new X509Parameters();
    $certificateAuthorityConfig = (new CertificateConfig())
        ->setSubjectConfig($certificateAuthorityConfigSubjectConfig)
        ->setX509Config($certificateAuthorityConfigX509Config);
    $certificateAuthorityLifetime = new Duration();
    $certificateAuthorityKeySpec = new KeyVersionSpec();
    $certificateAuthority = (new CertificateAuthority())
        ->setType($certificateAuthorityType)
        ->setConfig($certificateAuthorityConfig)
        ->setLifetime($certificateAuthorityLifetime)
        ->setKeySpec($certificateAuthorityKeySpec);
    $updateMask = new FieldMask();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $certificateAuthorityServiceClient->updateCertificateAuthority(
            $certificateAuthority,
            $updateMask
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
    $certificateAuthorityType = Type::TYPE_UNSPECIFIED;

    update_certificate_authority_sample($certificateAuthorityType);
}
// [END privateca_v1_generated_CertificateAuthorityService_UpdateCertificateAuthority_sync]
