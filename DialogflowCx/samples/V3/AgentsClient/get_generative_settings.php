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

// [START dialogflow_v3_generated_Agents_GetGenerativeSettings_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\Cx\V3\Client\AgentsClient;
use Google\Cloud\Dialogflow\Cx\V3\GenerativeSettings;
use Google\Cloud\Dialogflow\Cx\V3\GetGenerativeSettingsRequest;

/**
 * Gets the generative settings for the agent.
 *
 * @param string $formattedName Format:
 *                              `projects/<ProjectID>/locations/<LocationID>/agents/<AgentID>/generativeSettings`. Please see
 *                              {@see AgentsClient::agentGenerativeSettingsName()} for help formatting this field.
 * @param string $languageCode  Language code of the generative settings.
 */
function get_generative_settings_sample(string $formattedName, string $languageCode): void
{
    // Create a client.
    $agentsClient = new AgentsClient();

    // Prepare the request message.
    $request = (new GetGenerativeSettingsRequest())
        ->setName($formattedName)
        ->setLanguageCode($languageCode);

    // Call the API and handle any network failures.
    try {
        /** @var GenerativeSettings $response */
        $response = $agentsClient->getGenerativeSettings($request);
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
    $formattedName = AgentsClient::agentGenerativeSettingsName('[PROJECT]', '[LOCATION]', '[AGENT]');
    $languageCode = '[LANGUAGE_CODE]';

    get_generative_settings_sample($formattedName, $languageCode);
}
// [END dialogflow_v3_generated_Agents_GetGenerativeSettings_sync]
