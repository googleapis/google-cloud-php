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

// [START metastore_v1beta_generated_DataprocMetastoreFederation_GetFederation_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Metastore\V1beta\DataprocMetastoreFederationClient;
use Google\Cloud\Metastore\V1beta\Federation;

/**
 * Gets the details of a single federation.
 *
 * @param string $formattedName The relative resource name of the metastore federation to
 *                              retrieve, in the following form:
 *
 *                              `projects/{project_number}/locations/{location_id}/federations/{federation_id}`. Please see
 *                              {@see DataprocMetastoreFederationClient::federationName()} for help formatting this field.
 */
function get_federation_sample(string $formattedName): void
{
    // Create a client.
    $dataprocMetastoreFederationClient = new DataprocMetastoreFederationClient();

    // Call the API and handle any network failures.
    try {
        /** @var Federation $response */
        $response = $dataprocMetastoreFederationClient->getFederation($formattedName);
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
    $formattedName = DataprocMetastoreFederationClient::federationName(
        '[PROJECT]',
        '[LOCATION]',
        '[FEDERATION]'
    );

    get_federation_sample($formattedName);
}
// [END metastore_v1beta_generated_DataprocMetastoreFederation_GetFederation_sync]
