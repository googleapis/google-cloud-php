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

// [START certificatemanager_v1_generated_CertificateManager_CreateCertificateIssuanceConfig_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\CertificateManager\V1\CertificateIssuanceConfig;
use Google\Cloud\CertificateManager\V1\CertificateIssuanceConfig\CertificateAuthorityConfig;
use Google\Cloud\CertificateManager\V1\CertificateIssuanceConfig\KeyAlgorithm;
use Google\Cloud\CertificateManager\V1\Client\CertificateManagerClient;
use Google\Cloud\CertificateManager\V1\CreateCertificateIssuanceConfigRequest;
use Google\Protobuf\Duration;
use Google\Rpc\Status;

/**
 * Creates a new CertificateIssuanceConfig in a given project and location.
 *
 * @param string $formattedParent                                   The parent resource of the certificate issuance config. Must be
 *                                                                  in the format `projects/&#42;/locations/*`. Please see
 *                                                                  {@see CertificateManagerClient::locationName()} for help formatting this field.
 * @param string $certificateIssuanceConfigId                       A user-provided name of the certificate config.
 * @param int    $certificateIssuanceConfigRotationWindowPercentage Specifies the percentage of elapsed time of the certificate
 *                                                                  lifetime to wait before renewing the certificate. Must be a number between
 *                                                                  1-99, inclusive.
 * @param int    $certificateIssuanceConfigKeyAlgorithm             The key algorithm to use when generating the private key.
 */
function create_certificate_issuance_config_sample(
    string $formattedParent,
    string $certificateIssuanceConfigId,
    int $certificateIssuanceConfigRotationWindowPercentage,
    int $certificateIssuanceConfigKeyAlgorithm
): void {
    // Create a client.
    $certificateManagerClient = new CertificateManagerClient();

    // Prepare the request message.
    $certificateIssuanceConfigCertificateAuthorityConfig = new CertificateAuthorityConfig();
    $certificateIssuanceConfigLifetime = new Duration();
    $certificateIssuanceConfig = (new CertificateIssuanceConfig())
        ->setCertificateAuthorityConfig($certificateIssuanceConfigCertificateAuthorityConfig)
        ->setLifetime($certificateIssuanceConfigLifetime)
        ->setRotationWindowPercentage($certificateIssuanceConfigRotationWindowPercentage)
        ->setKeyAlgorithm($certificateIssuanceConfigKeyAlgorithm);
    $request = (new CreateCertificateIssuanceConfigRequest())
        ->setParent($formattedParent)
        ->setCertificateIssuanceConfigId($certificateIssuanceConfigId)
        ->setCertificateIssuanceConfig($certificateIssuanceConfig);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $certificateManagerClient->createCertificateIssuanceConfig($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var CertificateIssuanceConfig $result */
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
    $formattedParent = CertificateManagerClient::locationName('[PROJECT]', '[LOCATION]');
    $certificateIssuanceConfigId = '[CERTIFICATE_ISSUANCE_CONFIG_ID]';
    $certificateIssuanceConfigRotationWindowPercentage = 0;
    $certificateIssuanceConfigKeyAlgorithm = KeyAlgorithm::KEY_ALGORITHM_UNSPECIFIED;

    create_certificate_issuance_config_sample(
        $formattedParent,
        $certificateIssuanceConfigId,
        $certificateIssuanceConfigRotationWindowPercentage,
        $certificateIssuanceConfigKeyAlgorithm
    );
}
// [END certificatemanager_v1_generated_CertificateManager_CreateCertificateIssuanceConfig_sync]
