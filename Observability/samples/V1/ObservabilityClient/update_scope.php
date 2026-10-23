<?php
/*
 * Copyright 2026 Google LLC
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

// [START observability_v1_generated_Observability_UpdateScope_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Observability\V1\Client\ObservabilityClient;
use Google\Cloud\Observability\V1\Scope;
use Google\Cloud\Observability\V1\UpdateScopeRequest;

/**
 * Updates the parameters of a single Scope.
 *
 * @param string $scopeLogScope   The full resource name of the `logging.googleapis.com/LogScope`.
 *                                For example:
 *
 *                                //logging.googleapis.com/projects/myproject/locations/global/logScopes/my-log-scope
 * @param string $scopeTraceScope The unqualified resource name of the
 *                                `cloudtrace.googleapis.com/TraceScope`. For example:
 *
 *                                projects/myproject/locations/global/traceScopes/my-trace-scope
 */
function update_scope_sample(string $scopeLogScope, string $scopeTraceScope): void
{
    // Create a client.
    $observabilityClient = new ObservabilityClient();

    // Prepare the request message.
    $scope = (new Scope())
        ->setLogScope($scopeLogScope)
        ->setTraceScope($scopeTraceScope);
    $request = (new UpdateScopeRequest())
        ->setScope($scope);

    // Call the API and handle any network failures.
    try {
        /** @var Scope $response */
        $response = $observabilityClient->updateScope($request);
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
    $scopeLogScope = '[LOG_SCOPE]';
    $scopeTraceScope = '[TRACE_SCOPE]';

    update_scope_sample($scopeLogScope, $scopeTraceScope);
}
// [END observability_v1_generated_Observability_UpdateScope_sync]
