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

// [START dialogflow_v3_generated_Agents_UpdateAgent_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\Cx\V3\Agent;
use Google\Cloud\Dialogflow\Cx\V3\AgentsClient;

/**
 * Updates the specified agent.
 *
 * Note: You should always train flows prior to sending them queries. See the
 * [training
 * documentation](https://cloud.google.com/dialogflow/cx/docs/concept/training).
 *
 * @param string $agentDisplayName         The human-readable name of the agent, unique within the location.
 * @param string $agentDefaultLanguageCode Immutable. The default language of the agent as a language tag.
 *                                         See [Language
 *                                         Support](https://cloud.google.com/dialogflow/cx/docs/reference/language)
 *                                         for a list of the currently supported language codes.
 *                                         This field cannot be set by the
 *                                         [Agents.UpdateAgent][google.cloud.dialogflow.cx.v3.Agents.UpdateAgent]
 *                                         method.
 * @param string $agentTimeZone            The time zone of the agent from the [time zone
 *                                         database](https://www.iana.org/time-zones), e.g., America/New_York,
 *                                         Europe/Paris.
 */
function update_agent_sample(
    string $agentDisplayName,
    string $agentDefaultLanguageCode,
    string $agentTimeZone
): void {
    // Create a client.
    $agentsClient = new AgentsClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $agent = (new Agent())
        ->setDisplayName($agentDisplayName)
        ->setDefaultLanguageCode($agentDefaultLanguageCode)
        ->setTimeZone($agentTimeZone);

    // Call the API and handle any network failures.
    try {
        /** @var Agent $response */
        $response = $agentsClient->updateAgent($agent);
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
    $agentDisplayName = '[DISPLAY_NAME]';
    $agentDefaultLanguageCode = '[DEFAULT_LANGUAGE_CODE]';
    $agentTimeZone = '[TIME_ZONE]';

    update_agent_sample($agentDisplayName, $agentDefaultLanguageCode, $agentTimeZone);
}
// [END dialogflow_v3_generated_Agents_UpdateAgent_sync]
