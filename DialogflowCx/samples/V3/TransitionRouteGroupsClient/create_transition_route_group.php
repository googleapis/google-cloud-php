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

// [START dialogflow_v3_generated_TransitionRouteGroups_CreateTransitionRouteGroup_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dialogflow\Cx\V3\Client\TransitionRouteGroupsClient;
use Google\Cloud\Dialogflow\Cx\V3\CreateTransitionRouteGroupRequest;
use Google\Cloud\Dialogflow\Cx\V3\TransitionRouteGroup;

/**
 * Creates an
 * [TransitionRouteGroup][google.cloud.dialogflow.cx.v3.TransitionRouteGroup]
 * in the specified flow.
 *
 * Note: You should always train a flow prior to sending it queries. See the
 * [training
 * documentation](https://cloud.google.com/dialogflow/cx/docs/concept/training).
 *
 * @param string $formattedParent                 The flow to create an
 *                                                [TransitionRouteGroup][google.cloud.dialogflow.cx.v3.TransitionRouteGroup]
 *                                                for. Format: `projects/<Project ID>/locations/<Location ID>/agents/<Agent
 *                                                ID>/flows/<Flow ID>`
 *                                                or `projects/<Project ID>/locations/<Location ID>/agents/<Agent ID>`
 *                                                for agent-level groups. Please see
 *                                                {@see TransitionRouteGroupsClient::flowName()} for help formatting this field.
 * @param string $transitionRouteGroupDisplayName The human-readable name of the transition route group, unique
 *                                                within the flow. The display name can be no longer than 30 characters.
 */
function create_transition_route_group_sample(
    string $formattedParent,
    string $transitionRouteGroupDisplayName
): void {
    // Create a client.
    $transitionRouteGroupsClient = new TransitionRouteGroupsClient();

    // Prepare the request message.
    $transitionRouteGroup = (new TransitionRouteGroup())
        ->setDisplayName($transitionRouteGroupDisplayName);
    $request = (new CreateTransitionRouteGroupRequest())
        ->setParent($formattedParent)
        ->setTransitionRouteGroup($transitionRouteGroup);

    // Call the API and handle any network failures.
    try {
        /** @var TransitionRouteGroup $response */
        $response = $transitionRouteGroupsClient->createTransitionRouteGroup($request);
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
    $formattedParent = TransitionRouteGroupsClient::flowName(
        '[PROJECT]',
        '[LOCATION]',
        '[AGENT]',
        '[FLOW]'
    );
    $transitionRouteGroupDisplayName = '[DISPLAY_NAME]';

    create_transition_route_group_sample($formattedParent, $transitionRouteGroupDisplayName);
}
// [END dialogflow_v3_generated_TransitionRouteGroups_CreateTransitionRouteGroup_sync]
