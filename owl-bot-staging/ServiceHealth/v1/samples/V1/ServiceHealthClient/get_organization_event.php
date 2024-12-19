<?php
/*
 * Copyright 2024 Google LLC
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

// [START servicehealth_v1_generated_ServiceHealth_GetOrganizationEvent_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ServiceHealth\V1\Client\ServiceHealthClient;
use Google\Cloud\ServiceHealth\V1\GetOrganizationEventRequest;
use Google\Cloud\ServiceHealth\V1\OrganizationEvent;

/**
 * Retrieves a resource containing information about an event affecting an
 * organization .
 *
 * @param string $formattedName Unique name of the event in this scope including organization and
 *                              event ID using the form
 *                              `organizations/{organization_id}/locations/locations/global/organizationEvents/{event_id}`.
 *
 *                              `organization_id` - ID (number) of the project that contains the event. To
 *                              get your `organization_id`, see
 *                              [Getting your organization resource
 *                              ID](https://cloud.google.com/resource-manager/docs/creating-managing-organization#retrieving_your_organization_id).<br>
 *                              `event_id` - Organization event ID to retrieve. Please see
 *                              {@see ServiceHealthClient::organizationEventName()} for help formatting this field.
 */
function get_organization_event_sample(string $formattedName): void
{
    // Create a client.
    $serviceHealthClient = new ServiceHealthClient();

    // Prepare the request message.
    $request = (new GetOrganizationEventRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var OrganizationEvent $response */
        $response = $serviceHealthClient->getOrganizationEvent($request);
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
    $formattedName = ServiceHealthClient::organizationEventName(
        '[ORGANIZATION]',
        '[LOCATION]',
        '[EVENT]'
    );

    get_organization_event_sample($formattedName);
}
// [END servicehealth_v1_generated_ServiceHealth_GetOrganizationEvent_sync]
