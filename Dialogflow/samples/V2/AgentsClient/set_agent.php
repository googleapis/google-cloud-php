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

// [START dialogflow_v2_generated_Agents_SetAgent_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\V2\Agent;
use Google\Cloud\Dialogflow\V2\Client\AgentsClient;
use Google\Cloud\Dialogflow\V2\SetAgentRequest;

/**
 * Creates/updates the specified agent.
 *
 * Note: You should always train an agent prior to sending it queries. See the
 * [training
 * documentation](https://cloud.google.com/dialogflow/es/docs/training).
 *
 * @param string $formattedAgentParent     The project of this agent.
 *                                         Format: `projects/<Project ID>`. Please see
 *                                         {@see AgentsClient::projectName()} for help formatting this field.
 * @param string $agentDisplayName         The name of this agent.
 * @param string $agentDefaultLanguageCode The default language of the agent as a language tag. See
 *                                         [Language
 *                                         Support](https://cloud.google.com/dialogflow/docs/reference/language)
 *                                         for a list of the currently supported language codes. This field cannot be
 *                                         set by the `Update` method.
 * @param string $agentTimeZone            The time zone of this agent from the
 *                                         [time zone database](https://www.iana.org/time-zones), e.g.,
 *                                         America/New_York, Europe/Paris.
 */
function set_agent_sample(
    string $formattedAgentParent,
    string $agentDisplayName,
    string $agentDefaultLanguageCode,
    string $agentTimeZone
): void {
    // Create a client.
    $agentsClient = new AgentsClient();

    // Prepare the request message.
    $agent = (new Agent())
        ->setParent($formattedAgentParent)
        ->setDisplayName($agentDisplayName)
        ->setDefaultLanguageCode($agentDefaultLanguageCode)
        ->setTimeZone($agentTimeZone);
    $request = (new SetAgentRequest())
        ->setAgent($agent);

    // Call the API and handle any network failures.
    try {
        /** @var Agent $response */
        $response = $agentsClient->setAgent($request);
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
    $formattedAgentParent = AgentsClient::projectName('[PROJECT]');
    $agentDisplayName = '[DISPLAY_NAME]';
    $agentDefaultLanguageCode = '[DEFAULT_LANGUAGE_CODE]';
    $agentTimeZone = '[TIME_ZONE]';

    set_agent_sample(
        $formattedAgentParent,
        $agentDisplayName,
        $agentDefaultLanguageCode,
        $agentTimeZone
    );
}
// [END dialogflow_v2_generated_Agents_SetAgent_sync]
