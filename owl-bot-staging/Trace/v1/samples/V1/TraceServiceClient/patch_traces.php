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

// [START cloudtrace_v1_generated_TraceService_PatchTraces_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Trace\V1\Client\TraceServiceClient;
use Google\Cloud\Trace\V1\PatchTracesRequest;
use Google\Cloud\Trace\V1\Traces;

/**
 * Sends new traces to Stackdriver Trace or updates existing traces. If the ID
 * of a trace that you send matches that of an existing trace, any fields
 * in the existing trace and its spans are overwritten by the provided values,
 * and any new fields provided are merged with the existing trace data. If the
 * ID does not match, a new trace is created.
 *
 * @param string $projectId ID of the Cloud project where the trace data is stored.
 */
function patch_traces_sample(string $projectId): void
{
    // Create a client.
    $traceServiceClient = new TraceServiceClient();

    // Prepare the request message.
    $traces = new Traces();
    $request = (new PatchTracesRequest())
        ->setProjectId($projectId)
        ->setTraces($traces);

    // Call the API and handle any network failures.
    try {
        $traceServiceClient->patchTraces($request);
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
    $projectId = '[PROJECT_ID]';

    patch_traces_sample($projectId);
}
// [END cloudtrace_v1_generated_TraceService_PatchTraces_sync]
