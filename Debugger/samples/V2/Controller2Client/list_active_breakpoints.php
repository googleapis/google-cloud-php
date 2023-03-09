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

// [START clouddebugger_v2_generated_Controller2_ListActiveBreakpoints_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Debugger\V2\Controller2Client;
use Google\Cloud\Debugger\V2\ListActiveBreakpointsResponse;

/**
 * Returns the list of all active breakpoints for the debuggee.
 *
 * The breakpoint specification (`location`, `condition`, and `expressions`
 * fields) is semantically immutable, although the field values may
 * change. For example, an agent may update the location line number
 * to reflect the actual line where the breakpoint was set, but this
 * doesn't change the breakpoint semantics.
 *
 * This means that an agent does not need to check if a breakpoint has changed
 * when it encounters the same breakpoint on a successive call.
 * Moreover, an agent should remember the breakpoints that are completed
 * until the controller removes them from the active list to avoid
 * setting those breakpoints again.
 *
 * @param string $debuggeeId Identifies the debuggee.
 */
function list_active_breakpoints_sample(string $debuggeeId): void
{
    // Create a client.
    $controller2Client = new Controller2Client();

    // Call the API and handle any network failures.
    try {
        /** @var ListActiveBreakpointsResponse $response */
        $response = $controller2Client->listActiveBreakpoints($debuggeeId);
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

    list_active_breakpoints_sample($debuggeeId);
}
// [END clouddebugger_v2_generated_Controller2_ListActiveBreakpoints_sync]
