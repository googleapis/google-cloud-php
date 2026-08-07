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

// [START developerconnect_v1_generated_InsightsConfigService_ListDeploymentEvents_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\DeveloperConnect\V1\Client\InsightsConfigServiceClient;
use Google\Cloud\DeveloperConnect\V1\DeploymentEvent;
use Google\Cloud\DeveloperConnect\V1\ListDeploymentEventsRequest;

/**
 * Lists Deployment Events in a given insights config.
 *
 * @param string $formattedParent The parent insights config that owns this collection of
 *                                deployment events. Format:
 *                                projects/{project}/locations/{location}/insightsConfigs/{insights_config}
 *                                Please see {@see InsightsConfigServiceClient::insightsConfigName()} for help formatting this field.
 */
function list_deployment_events_sample(string $formattedParent): void
{
    // Create a client.
    $insightsConfigServiceClient = new InsightsConfigServiceClient();

    // Prepare the request message.
    $request = (new ListDeploymentEventsRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $insightsConfigServiceClient->listDeploymentEvents($request);

        /** @var DeploymentEvent $element */
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
    $formattedParent = InsightsConfigServiceClient::insightsConfigName(
        '[PROJECT]',
        '[LOCATION]',
        '[INSIGHTS_CONFIG]'
    );

    list_deployment_events_sample($formattedParent);
}
// [END developerconnect_v1_generated_InsightsConfigService_ListDeploymentEvents_sync]
