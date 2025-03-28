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

// [START analyticsadmin_v1alpha_generated_AnalyticsAdminService_UpdateEventEditRule_sync]
use Google\Analytics\Admin\V1alpha\Client\AnalyticsAdminServiceClient;
use Google\Analytics\Admin\V1alpha\EventEditRule;
use Google\Analytics\Admin\V1alpha\MatchingCondition;
use Google\Analytics\Admin\V1alpha\MatchingCondition\ComparisonType;
use Google\Analytics\Admin\V1alpha\ParameterMutation;
use Google\Analytics\Admin\V1alpha\UpdateEventEditRuleRequest;
use Google\ApiCore\ApiException;
use Google\Protobuf\FieldMask;

/**
 * Updates an EventEditRule.
 *
 * @param string $eventEditRuleDisplayName                      The display name of this event edit rule. Maximum of 255
 *                                                              characters.
 * @param string $eventEditRuleEventConditionsField             The name of the field that is compared against for the condition.
 *                                                              If 'event_name' is specified this condition will apply to the name of the
 *                                                              event.  Otherwise the condition will apply to a parameter with the
 *                                                              specified name.
 *
 *                                                              This value cannot contain spaces.
 * @param int    $eventEditRuleEventConditionsComparisonType    The type of comparison to be applied to the value.
 * @param string $eventEditRuleEventConditionsValue             The value being compared against for this condition.  The runtime
 *                                                              implementation may perform type coercion of this value to evaluate this
 *                                                              condition based on the type of the parameter value.
 * @param string $eventEditRuleParameterMutationsParameter      The name of the parameter to mutate.
 *                                                              This value must:
 *                                                              * be less than 40 characters.
 *                                                              * be unique across across all mutations within the rule
 *                                                              * consist only of letters, digits or _ (underscores)
 *                                                              For event edit rules, the name may also be set to 'event_name' to modify
 *                                                              the event_name in place.
 * @param string $eventEditRuleParameterMutationsParameterValue The value mutation to perform.
 *                                                              * Must be less than 100 characters.
 *                                                              * To specify a constant value for the param, use the value's string.
 *                                                              * To copy value from another parameter, use syntax like
 *                                                              "[[other_parameter]]" For more details, see this [help center
 *                                                              article](https://support.google.com/analytics/answer/10085872#modify-an-event&zippy=%2Cin-this-article%2Cmodify-parameters).
 */
function update_event_edit_rule_sample(
    string $eventEditRuleDisplayName,
    string $eventEditRuleEventConditionsField,
    int $eventEditRuleEventConditionsComparisonType,
    string $eventEditRuleEventConditionsValue,
    string $eventEditRuleParameterMutationsParameter,
    string $eventEditRuleParameterMutationsParameterValue
): void {
    // Create a client.
    $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();

    // Prepare the request message.
    $matchingCondition = (new MatchingCondition())
        ->setField($eventEditRuleEventConditionsField)
        ->setComparisonType($eventEditRuleEventConditionsComparisonType)
        ->setValue($eventEditRuleEventConditionsValue);
    $eventEditRuleEventConditions = [$matchingCondition,];
    $parameterMutation = (new ParameterMutation())
        ->setParameter($eventEditRuleParameterMutationsParameter)
        ->setParameterValue($eventEditRuleParameterMutationsParameterValue);
    $eventEditRuleParameterMutations = [$parameterMutation,];
    $eventEditRule = (new EventEditRule())
        ->setDisplayName($eventEditRuleDisplayName)
        ->setEventConditions($eventEditRuleEventConditions)
        ->setParameterMutations($eventEditRuleParameterMutations);
    $updateMask = new FieldMask();
    $request = (new UpdateEventEditRuleRequest())
        ->setEventEditRule($eventEditRule)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var EventEditRule $response */
        $response = $analyticsAdminServiceClient->updateEventEditRule($request);
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
    $eventEditRuleDisplayName = '[DISPLAY_NAME]';
    $eventEditRuleEventConditionsField = '[FIELD]';
    $eventEditRuleEventConditionsComparisonType = ComparisonType::COMPARISON_TYPE_UNSPECIFIED;
    $eventEditRuleEventConditionsValue = '[VALUE]';
    $eventEditRuleParameterMutationsParameter = '[PARAMETER]';
    $eventEditRuleParameterMutationsParameterValue = '[PARAMETER_VALUE]';

    update_event_edit_rule_sample(
        $eventEditRuleDisplayName,
        $eventEditRuleEventConditionsField,
        $eventEditRuleEventConditionsComparisonType,
        $eventEditRuleEventConditionsValue,
        $eventEditRuleParameterMutationsParameter,
        $eventEditRuleParameterMutationsParameterValue
    );
}
// [END analyticsadmin_v1alpha_generated_AnalyticsAdminService_UpdateEventEditRule_sync]
