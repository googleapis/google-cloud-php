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

// [START dialogflow_v2_generated_Agents_SearchAgents_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Dialogflow\V2\Agent;
use Google\Cloud\Dialogflow\V2\AgentsClient;

/**
 * Returns the list of agents.
 *
 * Since there is at most one conversational agent per project, this method is
 * useful primarily for listing all agents across projects the caller has
 * access to. One can achieve that with a wildcard project collection id "-".
 * Refer to [List
 * Sub-Collections](https://cloud.google.com/apis/design/design_patterns#list_sub-collections).
 *
 * @param string $formattedParent The project to list agents from.
 *                                Format: `projects/<Project ID or '-'>`. Please see
 *                                {@see AgentsClient::projectName()} for help formatting this field.
 */
function search_agents_sample(string $formattedParent): void
{
    // Create a client.
    $agentsClient = new AgentsClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $agentsClient->searchAgents($formattedParent);

        /** @var Agent $element */
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
    $formattedParent = AgentsClient::projectName('[PROJECT]');

    search_agents_sample($formattedParent);
}
// [END dialogflow_v2_generated_Agents_SearchAgents_sync]