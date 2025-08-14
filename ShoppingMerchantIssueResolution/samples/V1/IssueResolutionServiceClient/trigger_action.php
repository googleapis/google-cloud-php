<?php
/*
 * Copyright 2025 Google LLC
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

// [START merchantapi_v1_generated_IssueResolutionService_TriggerAction_sync]
use Google\ApiCore\ApiException;
use Google\Shopping\Merchant\IssueResolution\V1\ActionInput;
use Google\Shopping\Merchant\IssueResolution\V1\Client\IssueResolutionServiceClient;
use Google\Shopping\Merchant\IssueResolution\V1\InputValue;
use Google\Shopping\Merchant\IssueResolution\V1\TriggerActionPayload;
use Google\Shopping\Merchant\IssueResolution\V1\TriggerActionRequest;
use Google\Shopping\Merchant\IssueResolution\V1\TriggerActionResponse;

/**
 * Start an action. The action can be requested by a business in
 * third-party application. Before the business can request the action, the
 * third-party application needs to show them action specific content and
 * display a user input form.
 *
 * The action can be successfully started only once all `required` inputs are
 * provided. If any `required` input is missing, or invalid value was
 * provided, the service will return 400 error. Validation errors will contain
 * [Ids][google.shopping.merchant.issueresolution.v1.InputField.id] for all
 * problematic field together with translated, human readable error messages
 * that can be shown to the user.
 *
 * @param string $formattedName                             The business's account that is triggering the action.
 *                                                          Format: `accounts/{account}`
 *                                                          Please see {@see IssueResolutionServiceClient::accountName()} for help formatting this field.
 * @param string $payloadActionContext                      The
 *                                                          [context][google.shopping.merchant.issueresolution.v1.BuiltInUserInputAction.action_context]
 *                                                          from the selected action. The value is obtained from rendered issues and
 *                                                          needs to be sent back to identify the
 *                                                          [action][google.shopping.merchant.issueresolution.v1.Action.builtin_user_input_action]
 *                                                          that is being triggered.
 * @param string $payloadActionInputActionFlowId            [Id][google.shopping.merchant.issueresolution.v1.ActionFlow.id]
 *                                                          of the selected action flow.
 * @param string $payloadActionInputInputValuesInputFieldId [Id][google.shopping.merchant.issueresolution.v1.InputField.id]
 *                                                          of the corresponding input field.
 */
function trigger_action_sample(
    string $formattedName,
    string $payloadActionContext,
    string $payloadActionInputActionFlowId,
    string $payloadActionInputInputValuesInputFieldId
): void {
    // Create a client.
    $issueResolutionServiceClient = new IssueResolutionServiceClient();

    // Prepare the request message.
    $inputValue = (new InputValue())
        ->setInputFieldId($payloadActionInputInputValuesInputFieldId);
    $payloadActionInputInputValues = [$inputValue,];
    $payloadActionInput = (new ActionInput())
        ->setActionFlowId($payloadActionInputActionFlowId)
        ->setInputValues($payloadActionInputInputValues);
    $payload = (new TriggerActionPayload())
        ->setActionContext($payloadActionContext)
        ->setActionInput($payloadActionInput);
    $request = (new TriggerActionRequest())
        ->setName($formattedName)
        ->setPayload($payload);

    // Call the API and handle any network failures.
    try {
        /** @var TriggerActionResponse $response */
        $response = $issueResolutionServiceClient->triggerAction($request);
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
    $formattedName = IssueResolutionServiceClient::accountName('[ACCOUNT]');
    $payloadActionContext = '[ACTION_CONTEXT]';
    $payloadActionInputActionFlowId = '[ACTION_FLOW_ID]';
    $payloadActionInputInputValuesInputFieldId = '[INPUT_FIELD_ID]';

    trigger_action_sample(
        $formattedName,
        $payloadActionContext,
        $payloadActionInputActionFlowId,
        $payloadActionInputInputValuesInputFieldId
    );
}
// [END merchantapi_v1_generated_IssueResolutionService_TriggerAction_sync]
