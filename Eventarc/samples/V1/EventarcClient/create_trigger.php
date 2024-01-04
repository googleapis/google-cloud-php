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

// [START eventarc_v1_generated_Eventarc_CreateTrigger_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Eventarc\V1\Client\EventarcClient;
use Google\Cloud\Eventarc\V1\CreateTriggerRequest;
use Google\Cloud\Eventarc\V1\Destination;
use Google\Cloud\Eventarc\V1\EventFilter;
use Google\Cloud\Eventarc\V1\Trigger;
use Google\Rpc\Status;

/**
 * Create a new trigger in a particular project and location.
 *
 * @param string $formattedParent              The parent collection in which to add this trigger. Please see
 *                                             {@see EventarcClient::locationName()} for help formatting this field.
 * @param string $triggerName                  The resource name of the trigger. Must be unique within the location of the
 *                                             project and must be in
 *                                             `projects/{project}/locations/{location}/triggers/{trigger}` format.
 * @param string $triggerEventFiltersAttribute The name of a CloudEvents attribute. Currently, only a subset of attributes
 *                                             are supported for filtering.
 *
 *                                             All triggers MUST provide a filter for the 'type' attribute.
 * @param string $triggerEventFiltersValue     The value for the attribute.
 * @param string $triggerId                    The user-provided ID to be assigned to the trigger.
 * @param bool   $validateOnly                 If set, validate the request and preview the review, but do not
 *                                             post it.
 */
function create_trigger_sample(
    string $formattedParent,
    string $triggerName,
    string $triggerEventFiltersAttribute,
    string $triggerEventFiltersValue,
    string $triggerId,
    bool $validateOnly
): void {
    // Create a client.
    $eventarcClient = new EventarcClient();

    // Prepare the request message.
    $eventFilter = (new EventFilter())
        ->setAttribute($triggerEventFiltersAttribute)
        ->setValue($triggerEventFiltersValue);
    $triggerEventFilters = [$eventFilter,];
    $triggerDestination = new Destination();
    $trigger = (new Trigger())
        ->setName($triggerName)
        ->setEventFilters($triggerEventFilters)
        ->setDestination($triggerDestination);
    $request = (new CreateTriggerRequest())
        ->setParent($formattedParent)
        ->setTrigger($trigger)
        ->setTriggerId($triggerId)
        ->setValidateOnly($validateOnly);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $eventarcClient->createTrigger($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Trigger $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
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
    $formattedParent = EventarcClient::locationName('[PROJECT]', '[LOCATION]');
    $triggerName = '[NAME]';
    $triggerEventFiltersAttribute = '[ATTRIBUTE]';
    $triggerEventFiltersValue = '[VALUE]';
    $triggerId = '[TRIGGER_ID]';
    $validateOnly = false;

    create_trigger_sample(
        $formattedParent,
        $triggerName,
        $triggerEventFiltersAttribute,
        $triggerEventFiltersValue,
        $triggerId,
        $validateOnly
    );
}
// [END eventarc_v1_generated_Eventarc_CreateTrigger_sync]
