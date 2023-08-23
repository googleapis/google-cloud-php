<?php
/*
 * Copyright 2023 Google LLC
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

// [START alloydb_v1beta_generated_AlloyDBAdmin_GenerateClientCertificate_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AlloyDb\V1beta\AlloyDBAdminClient;
use Google\Cloud\AlloyDb\V1beta\GenerateClientCertificateResponse;

/**
 * Generate a client certificate signed by a Cluster CA.
 * The sole purpose of this endpoint is to support the Auth Proxy client and
 * the endpoint's behavior is subject to change without notice, so do not rely
 * on its behavior remaining constant. Future changes will not break the Auth
 * Proxy client.
 *
 * @param string $formattedParent The name of the parent resource. The required format is:
 *                                * projects/{project}/locations/{location}/clusters/{cluster}
 *                                Please see {@see AlloyDBAdminClient::clusterName()} for help formatting this field.
 */
function generate_client_certificate_sample(string $formattedParent): void
{
    // Create a client.
    $alloyDBAdminClient = new AlloyDBAdminClient();

    // Call the API and handle any network failures.
    try {
        /** @var GenerateClientCertificateResponse $response */
        $response = $alloyDBAdminClient->generateClientCertificate($formattedParent);
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
    $formattedParent = AlloyDBAdminClient::clusterName('[PROJECT]', '[LOCATION]', '[CLUSTER]');

    generate_client_certificate_sample($formattedParent);
}
// [END alloydb_v1beta_generated_AlloyDBAdmin_GenerateClientCertificate_sync]
