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

// [START analyticsadmin_v1alpha_generated_AnalyticsAdminService_ReorderEventEditRules_sync]
use Google\Analytics\Admin\V1alpha\Client\AnalyticsAdminServiceClient;
use Google\Analytics\Admin\V1alpha\ReorderEventEditRulesRequest;
use Google\ApiCore\ApiException;

/**
 * Changes the processing order of event edit rules on the specified stream.
 *
 * @param string $formattedParent       Example format: properties/123/dataStreams/456
 *                                      Please see {@see AnalyticsAdminServiceClient::dataStreamName()} for help formatting this field.
 * @param string $eventEditRulesElement EventEditRule resource names for the specified data stream, in
 *                                      the needed processing order. All EventEditRules for the stream must be
 *                                      present in the list.
 */
function reorder_event_edit_rules_sample(
    string $formattedParent,
    string $eventEditRulesElement
): void {
    // Create a client.
    $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();

    // Prepare the request message.
    $eventEditRules = [$eventEditRulesElement,];
    $request = (new ReorderEventEditRulesRequest())
        ->setParent($formattedParent)
        ->setEventEditRules($eventEditRules);

    // Call the API and handle any network failures.
    try {
        $analyticsAdminServiceClient->reorderEventEditRules($request);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedParent = AnalyticsAdminServiceClient::dataStreamName('[PROPERTY]', '[DATA_STREAM]');
    $eventEditRulesElement = '[EVENT_EDIT_RULES]';

    reorder_event_edit_rules_sample($formattedParent, $eventEditRulesElement);
}
// [END analyticsadmin_v1alpha_generated_AnalyticsAdminService_ReorderEventEditRules_sync]
