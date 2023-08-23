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

// [START clouddebugger_v2_generated_Debugger2_SetBreakpoint_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Debugger\V2\Breakpoint;
use Google\Cloud\Debugger\V2\Debugger2Client;
use Google\Cloud\Debugger\V2\SetBreakpointResponse;

/**
 * Sets the breakpoint to the debuggee.
 *
 * @param string $debuggeeId    ID of the debuggee where the breakpoint is to be set.
 * @param string $clientVersion The client version making the call.
 *                              Schema: `domain/type/version` (e.g., `google.com/intellij/v1`).
 */
function set_breakpoint_sample(string $debuggeeId, string $clientVersion): void
{
    // Create a client.
    $debugger2Client = new Debugger2Client();

    // Prepare any non-scalar elements to be passed along with the request.
    $breakpoint = new Breakpoint();

    // Call the API and handle any network failures.
    try {
        /** @var SetBreakpointResponse $response */
        $response = $debugger2Client->setBreakpoint($debuggeeId, $breakpoint, $clientVersion);
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
    $clientVersion = '[CLIENT_VERSION]';

    set_breakpoint_sample($debuggeeId, $clientVersion);
}
// [END clouddebugger_v2_generated_Debugger2_SetBreakpoint_sync]
