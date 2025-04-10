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

// [START dialogflow_v3_generated_Webhooks_CreateWebhook_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\Cx\V3\Client\WebhooksClient;
use Google\Cloud\Dialogflow\Cx\V3\CreateWebhookRequest;
use Google\Cloud\Dialogflow\Cx\V3\Webhook;

/**
 * Creates a webhook in the specified agent.
 *
 * @param string $formattedParent    The agent to create a webhook for.
 *                                   Format: `projects/<ProjectID>/locations/<LocationID>/agents/<AgentID>`. Please see
 *                                   {@see WebhooksClient::agentName()} for help formatting this field.
 * @param string $webhookDisplayName The human-readable name of the webhook, unique within the agent.
 */
function create_webhook_sample(string $formattedParent, string $webhookDisplayName): void
{
    // Create a client.
    $webhooksClient = new WebhooksClient();

    // Prepare the request message.
    $webhook = (new Webhook())
        ->setDisplayName($webhookDisplayName);
    $request = (new CreateWebhookRequest())
        ->setParent($formattedParent)
        ->setWebhook($webhook);

    // Call the API and handle any network failures.
    try {
        /** @var Webhook $response */
        $response = $webhooksClient->createWebhook($request);
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
    $formattedParent = WebhooksClient::agentName('[PROJECT]', '[LOCATION]', '[AGENT]');
    $webhookDisplayName = '[DISPLAY_NAME]';

    create_webhook_sample($formattedParent, $webhookDisplayName);
}
// [END dialogflow_v3_generated_Webhooks_CreateWebhook_sync]
