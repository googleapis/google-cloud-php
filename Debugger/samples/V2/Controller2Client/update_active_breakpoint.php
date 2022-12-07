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

// [START clouddebugger_v2_generated_Controller2_UpdateActiveBreakpoint_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Debugger\V2\Breakpoint;
use Google\Cloud\Debugger\V2\Controller2Client;
use Google\Cloud\Debugger\V2\UpdateActiveBreakpointResponse;

/**
 * Updates the breakpoint state or mutable fields.
 * The entire Breakpoint message must be sent back to the controller service.
 *
 * Updates to active breakpoint fields are only allowed if the new value
 * does not change the breakpoint specification. Updates to the `location`,
 * `condition` and `expressions` fields should not alter the breakpoint
 * semantics. These may only make changes such as canonicalizing a value
 * or snapping the location to the correct line of code.
 *
 * @param string $debuggeeId Identifies the debuggee being debugged.
 */
function update_active_breakpoint_sample(string $debuggeeId): void
{
    // Create a client.
    $controller2Client = new Controller2Client();

    // Prepare any non-scalar elements to be passed along with the request.
    $breakpoint = new Breakpoint();

    // Call the API and handle any network failures.
    try {
        /** @var UpdateActiveBreakpointResponse $response */
        $response = $controller2Client->updateActiveBreakpoint($debuggeeId, $breakpoint);
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
    $debuggeeId = '[DEBUGGEE_ID]';

    update_active_breakpoint_sample($debuggeeId);
}
// [END clouddebugger_v2_generated_Controller2_UpdateActiveBreakpoint_sync]
