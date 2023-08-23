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

// [START clouddebugger_v2_generated_Controller2_RegisterDebuggee_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Debugger\V2\Controller2Client;
use Google\Cloud\Debugger\V2\Debuggee;
use Google\Cloud\Debugger\V2\RegisterDebuggeeResponse;

/**
 * Registers the debuggee with the controller service.
 *
 * All agents attached to the same application must call this method with
 * exactly the same request content to get back the same stable `debuggee_id`.
 * Agents should call this method again whenever `google.rpc.Code.NOT_FOUND`
 * is returned from any controller method.
 *
 * This protocol allows the controller service to disable debuggees, recover
 * from data loss, or change the `debuggee_id` format. Agents must handle
 * `debuggee_id` value changing upon re-registration.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function register_debuggee_sample(): void
{
    // Create a client.
    $controller2Client = new Controller2Client();

    // Prepare any non-scalar elements to be passed along with the request.
    $debuggee = new Debuggee();

    // Call the API and handle any network failures.
    try {
        /** @var RegisterDebuggeeResponse $response */
        $response = $controller2Client->registerDebuggee($debuggee);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END clouddebugger_v2_generated_Controller2_RegisterDebuggee_sync]
