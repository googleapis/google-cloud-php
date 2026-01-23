<?php
/*
 * Copyright 2026 Google LLC
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

// [START dialogflow_v3_generated_Playbooks_GetPlaybook_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\Cx\V3\Client\PlaybooksClient;
use Google\Cloud\Dialogflow\Cx\V3\GetPlaybookRequest;
use Google\Cloud\Dialogflow\Cx\V3\Playbook;

/**
 * Retrieves the specified Playbook.
 *
 * @param string $formattedName The name of the playbook.
 *                              Format:
 *                              `projects/<ProjectID>/locations/<LocationID>/agents/<AgentID>/playbooks/<PlaybookID>`. Please see
 *                              {@see PlaybooksClient::playbookName()} for help formatting this field.
 */
function get_playbook_sample(string $formattedName): void
{
    // Create a client.
    $playbooksClient = new PlaybooksClient();

    // Prepare the request message.
    $request = (new GetPlaybookRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var Playbook $response */
        $response = $playbooksClient->getPlaybook($request);
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
    $formattedName = PlaybooksClient::playbookName('[PROJECT]', '[LOCATION]', '[AGENT]', '[PLAYBOOK]');

    get_playbook_sample($formattedName);
}
// [END dialogflow_v3_generated_Playbooks_GetPlaybook_sync]
