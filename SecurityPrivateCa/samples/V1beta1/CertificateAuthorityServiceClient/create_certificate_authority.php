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

// [START privateca_v1beta1_generated_CertificateAuthorityService_CreateCertificateAuthority_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Security\PrivateCA\V1beta1\CertificateAuthority;
use Google\Cloud\Security\PrivateCA\V1beta1\CertificateAuthorityServiceClient;
use Google\Cloud\Security\PrivateCA\V1beta1\CertificateAuthority\KeyVersionSpec;
use Google\Cloud\Security\PrivateCA\V1beta1\CertificateAuthority\Tier;
use Google\Cloud\Security\PrivateCA\V1beta1\CertificateAuthority\Type;
use Google\Cloud\Security\PrivateCA\V1beta1\CertificateConfig;
use Google\Cloud\Security\PrivateCA\V1beta1\CertificateConfig\SubjectConfig;
use Google\Cloud\Security\PrivateCA\V1beta1\ReusableConfigWrapper;
use Google\Cloud\Security\PrivateCA\V1beta1\Subject;
use Google\Protobuf\Duration;
use Google\Rpc\Status;

/**
 * Create a new [CertificateAuthority][google.cloud.security.privateca.v1beta1.CertificateAuthority] in a given Project and Location.
 *
 * @param string $formattedParent                                        The resource name of the location associated with the
 *                                                                       [CertificateAuthorities][google.cloud.security.privateca.v1beta1.CertificateAuthority], in the format
 *                                                                       `projects/&#42;/locations/*`. Please see
 *                                                                       {@see CertificateAuthorityServiceClient::locationName()} for help formatting this field.
 * @param string $certificateAuthorityId                                 It must be unique within a location and match the regular
 *                                                                       expression `[a-zA-Z0-9_-]{1,63}`
 * @param int    $certificateAuthorityType                               Immutable. The [Type][google.cloud.security.privateca.v1beta1.CertificateAuthority.Type] of this [CertificateAuthority][google.cloud.security.privateca.v1beta1.CertificateAuthority].
 * @param int    $certificateAuthorityTier                               Immutable. The [Tier][google.cloud.security.privateca.v1beta1.CertificateAuthority.Tier] of this [CertificateAuthority][google.cloud.security.privateca.v1beta1.CertificateAuthority].
 * @param string $certificateAuthorityConfigReusableConfigReusableConfig A resource path to a [ReusableConfig][google.cloud.security.privateca.v1beta1.ReusableConfig] in the format
 *                                                                       `projects/&#42;/locations/&#42;/reusableConfigs/*`.
 * @param string $certificateAuthorityKeySpecCloudKmsKeyVersion          The resource name for an existing Cloud KMS CryptoKeyVersion in the
 *                                                                       format
 *                                                                       `projects/&#42;/locations/&#42;/keyRings/&#42;/cryptoKeys/&#42;/cryptoKeyVersions/*`.
 *                                                                       This option enables full flexibility in the key's capabilities and
 *                                                                       properties.
 */
function create_certificate_authority_sample(
    string $formattedParent,
    string $certificateAuthorityId,
    int $certificateAuthorityType,
    int $certificateAuthorityTier,
    string $certificateAuthorityConfigReusableConfigReusableConfig,
    string $certificateAuthorityKeySpecCloudKmsKeyVersion
): void {
    // Create a client.
    $certificateAuthorityServiceClient = new CertificateAuthorityServiceClient();

    // Prepare the request message.
    $certificateAuthorityConfigSubjectConfigSubject = new Subject();
    $certificateAuthorityConfigSubjectConfig = (new SubjectConfig())
        ->setSubject($certificateAuthorityConfigSubjectConfigSubject);
    $certificateAuthorityConfigReusableConfig = (new ReusableConfigWrapper())
        ->setReusableConfig($certificateAuthorityConfigReusableConfigReusableConfig);
    $certificateAuthorityConfig = (new CertificateConfig())
        ->setSubjectConfig($certificateAuthorityConfigSubjectConfig)
        ->setReusableConfig($certificateAuthorityConfigReusableConfig);
    $certificateAuthorityLifetime = new Duration();
    $certificateAuthorityKeySpec = (new KeyVersionSpec())
        ->setCloudKmsKeyVersion($certificateAuthorityKeySpecCloudKmsKeyVersion);
    $certificateAuthority = (new CertificateAuthority())
        ->setType($certificateAuthorityType)
        ->setTier($certificateAuthorityTier)
        ->setConfig($certificateAuthorityConfig)
        ->setLifetime($certificateAuthorityLifetime)
        ->setKeySpec($certificateAuthorityKeySpec);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $certificateAuthorityServiceClient->createCertificateAuthority(
            $formattedParent,
            $certificateAuthorityId,
            $certificateAuthority
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
    $formattedParent = CertificateAuthorityServiceClient::locationName('[PROJECT]', '[LOCATION]');
    $certificateAuthorityId = '[CERTIFICATE_AUTHORITY_ID]';
    $certificateAuthorityType = Type::TYPE_UNSPECIFIED;
    $certificateAuthorityTier = Tier::TIER_UNSPECIFIED;
    $certificateAuthorityConfigReusableConfigReusableConfig = '[REUSABLE_CONFIG]';
    $certificateAuthorityKeySpecCloudKmsKeyVersion = '[CLOUD_KMS_KEY_VERSION]';

    create_certificate_authority_sample(
        $formattedParent,
        $certificateAuthorityId,
        $certificateAuthorityType,
        $certificateAuthorityTier,
        $certificateAuthorityConfigReusableConfigReusableConfig,
        $certificateAuthorityKeySpecCloudKmsKeyVersion
    );
}
// [END privateca_v1beta1_generated_CertificateAuthorityService_CreateCertificateAuthority_sync]
