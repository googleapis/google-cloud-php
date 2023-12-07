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

// [START dialogflow_v3_generated_Environments_ListEnvironments_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Dialogflow\Cx\V3\Environment;
use Google\Cloud\Dialogflow\Cx\V3\EnvironmentsClient;

/**
 * Returns the list of all environments in the specified
 * [Agent][google.cloud.dialogflow.cx.v3.Agent].
 *
 * @param string $formattedParent The [Agent][google.cloud.dialogflow.cx.v3.Agent] to list all
 *                                environments for. Format: `projects/<Project ID>/locations/<Location
 *                                ID>/agents/<Agent ID>`. Please see
 *                                {@see EnvironmentsClient::agentName()} for help formatting this field.
 */
function list_environments_sample(string $formattedParent): void
{
    // Create a client.
    $environmentsClient = new EnvironmentsClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $environmentsClient->listEnvironments($formattedParent);

        /** @var Environment $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
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
    $formattedParent = EnvironmentsClient::agentName('[PROJECT]', '[LOCATION]', '[AGENT]');

    list_environments_sample($formattedParent);
}
// [END dialogflow_v3_generated_Environments_ListEnvironments_sync]
