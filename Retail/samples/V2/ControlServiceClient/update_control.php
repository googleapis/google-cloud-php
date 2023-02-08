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

// [START retail_v2_generated_ControlService_UpdateControl_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Retail\V2\Control;
use Google\Cloud\Retail\V2\ControlServiceClient;
use Google\Cloud\Retail\V2\SolutionType;

/**
 * Updates a Control.
 *
 * [Control][google.cloud.retail.v2.Control] cannot be set to a different
 * oneof field, if so an INVALID_ARGUMENT is returned. If the
 * [Control][google.cloud.retail.v2.Control] to update does not exist, a
 * NOT_FOUND error is returned.
 *
 * @param string $controlDisplayName          The human readable control display name. Used in Retail UI.
 *
 *                                            This field must be a UTF-8 encoded string with a length limit of 128
 *                                            characters. Otherwise, an INVALID_ARGUMENT error is thrown.
 * @param int    $controlSolutionTypesElement Immutable. The solution types that the control is used for.
 *                                            Currently we support setting only one type of solution at creation time.
 *
 *                                            Only `SOLUTION_TYPE_SEARCH` value is supported at the moment.
 *                                            If no solution type is provided at creation time, will default to
 *                                            [SOLUTION_TYPE_SEARCH][google.cloud.retail.v2.SolutionType.SOLUTION_TYPE_SEARCH].
 */
function update_control_sample(string $controlDisplayName, int $controlSolutionTypesElement): void
{
    // Create a client.
    $controlServiceClient = new ControlServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $controlSolutionTypes = [$controlSolutionTypesElement,];
    $control = (new Control())
        ->setDisplayName($controlDisplayName)
        ->setSolutionTypes($controlSolutionTypes);

    // Call the API and handle any network failures.
    try {
        /** @var Control $response */
        $response = $controlServiceClient->updateControl($control);
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
    $controlDisplayName = '[DISPLAY_NAME]';
    $controlSolutionTypesElement = SolutionType::SOLUTION_TYPE_UNSPECIFIED;

    update_control_sample($controlDisplayName, $controlSolutionTypesElement);
}
// [END retail_v2_generated_ControlService_UpdateControl_sync]
