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

// [START analyticsadmin_v1alpha_generated_AnalyticsAdminService_UpdateEventCreateRule_sync]
use Google\Analytics\Admin\V1alpha\AnalyticsAdminServiceClient;
use Google\Analytics\Admin\V1alpha\EventCreateRule;
use Google\Analytics\Admin\V1alpha\MatchingCondition;
use Google\Analytics\Admin\V1alpha\MatchingCondition\ComparisonType;
use Google\ApiCore\ApiException;
use Google\Protobuf\FieldMask;

/**
 * Updates an EventCreateRule.
 *
 * @param string $eventCreateRuleDestinationEvent              The name of the new event to be created.
 *
 *                                                             This value must:
 *                                                             * be less than 40 characters
 *                                                             * consist only of letters, digits or _ (underscores)
 *                                                             * start with a letter
 * @param string $eventCreateRuleEventConditionsField          The name of the field that is compared against for the condition.
 *                                                             If 'event_name' is specified this condition will apply to the name of the
 *                                                             event.  Otherwise the condition will apply to a parameter with the
 *                                                             specified name.
 *
 *                                                             This value cannot contain spaces.
 * @param int    $eventCreateRuleEventConditionsComparisonType The type of comparison to be applied to the value.
 * @param string $eventCreateRuleEventConditionsValue          The value being compared against for this condition.  The runtime
 *                                                             implementation may perform type coercion of this value to evaluate this
 *                                                             condition based on the type of the parameter value.
 */
function update_event_create_rule_sample(
    string $eventCreateRuleDestinationEvent,
    string $eventCreateRuleEventConditionsField,
    int $eventCreateRuleEventConditionsComparisonType,
    string $eventCreateRuleEventConditionsValue
): void {
    // Create a client.
    $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $matchingCondition = (new MatchingCondition())
        ->setField($eventCreateRuleEventConditionsField)
        ->setComparisonType($eventCreateRuleEventConditionsComparisonType)
        ->setValue($eventCreateRuleEventConditionsValue);
    $eventCreateRuleEventConditions = [$matchingCondition,];
    $eventCreateRule = (new EventCreateRule())
        ->setDestinationEvent($eventCreateRuleDestinationEvent)
        ->setEventConditions($eventCreateRuleEventConditions);
    $updateMask = new FieldMask();

    // Call the API and handle any network failures.
    try {
        /** @var EventCreateRule $response */
        $response = $analyticsAdminServiceClient->updateEventCreateRule($eventCreateRule, $updateMask);
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
    $eventCreateRuleDestinationEvent = '[DESTINATION_EVENT]';
    $eventCreateRuleEventConditionsField = '[FIELD]';
    $eventCreateRuleEventConditionsComparisonType = ComparisonType::COMPARISON_TYPE_UNSPECIFIED;
    $eventCreateRuleEventConditionsValue = '[VALUE]';

    update_event_create_rule_sample(
        $eventCreateRuleDestinationEvent,
        $eventCreateRuleEventConditionsField,
        $eventCreateRuleEventConditionsComparisonType,
        $eventCreateRuleEventConditionsValue
    );
}
// [END analyticsadmin_v1alpha_generated_AnalyticsAdminService_UpdateEventCreateRule_sync]
