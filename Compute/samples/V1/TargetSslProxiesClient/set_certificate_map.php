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

// [START compute_v1_generated_TargetSslProxies_SetCertificateMap_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Compute\V1\TargetSslProxiesClient;
use Google\Cloud\Compute\V1\TargetSslProxiesSetCertificateMapRequest;
use Google\Rpc\Status;

/**
 * Changes the Certificate Map for TargetSslProxy.
 *
 * @param string $project        Project ID for this request.
 * @param string $targetSslProxy Name of the TargetSslProxy resource whose CertificateMap is to be set. The name must be 1-63 characters long, and comply with RFC1035.
 */
function set_certificate_map_sample(string $project, string $targetSslProxy): void
{
    // Create a client.
    $targetSslProxiesClient = new TargetSslProxiesClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $targetSslProxiesSetCertificateMapRequestResource = new TargetSslProxiesSetCertificateMapRequest();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $targetSslProxiesClient->setCertificateMap(
            $project,
            $targetSslProxiesSetCertificateMapRequestResource,
            $targetSslProxy
        );
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            printf('Operation completed successfully.' . PHP_EOL);
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
    $project = '[PROJECT]';
    $targetSslProxy = '[TARGET_SSL_PROXY]';

    set_certificate_map_sample($project, $targetSslProxy);
}
// [END compute_v1_generated_TargetSslProxies_SetCertificateMap_sync]
