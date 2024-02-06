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

// [START bigquerydatapolicy_v1beta1_generated_DataPolicyService_CreateDataPolicy_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\BigQuery\DataPolicies\V1beta1\DataPolicy;
use Google\Cloud\BigQuery\DataPolicies\V1beta1\DataPolicyServiceClient;

/**
 * Creates a new data policy under a project with the given `dataPolicyId`
 * (used as the display name), policy tag, and data policy type.
 *
 * @param string $formattedParent Resource name of the project that the data policy will belong to. The
 *                                format is `projects/{project_number}/locations/{location_id}`. Please see
 *                                {@see DataPolicyServiceClient::locationName()} for help formatting this field.
 */
function create_data_policy_sample(string $formattedParent): void
{
    // Create a client.
    $dataPolicyServiceClient = new DataPolicyServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $dataPolicy = new DataPolicy();

    // Call the API and handle any network failures.
    try {
        /** @var DataPolicy $response */
        $response = $dataPolicyServiceClient->createDataPolicy($formattedParent, $dataPolicy);
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
    $formattedParent = DataPolicyServiceClient::locationName('[PROJECT]', '[LOCATION]');

    create_data_policy_sample($formattedParent);
}
// [END bigquerydatapolicy_v1beta1_generated_DataPolicyService_CreateDataPolicy_sync]
