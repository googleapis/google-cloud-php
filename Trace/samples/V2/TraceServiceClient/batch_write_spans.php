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

// [START cloudtrace_v2_generated_TraceService_BatchWriteSpans_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Trace\V2\Span;
use Google\Cloud\Trace\V2\TraceServiceClient;
use Google\Cloud\Trace\V2\TruncatableString;
use Google\Protobuf\Timestamp;

/**
 * Batch writes new spans to new or existing traces. You cannot update
 * existing spans.
 *
 * @param string $formattedName The name of the project where the spans belong. The format is
 *                              `projects/[PROJECT_ID]`. Please see
 *                              {@see TraceServiceClient::projectName()} for help formatting this field.
 * @param string $spansName     The resource name of the span in the following format:
 *
 *                              * `projects/[PROJECT_ID]/traces/[TRACE_ID]/spans/[SPAN_ID]`
 *
 *                              `[TRACE_ID]` is a unique identifier for a trace within a project;
 *                              it is a 32-character hexadecimal encoding of a 16-byte array. It should
 *                              not be zero.
 *
 *                              `[SPAN_ID]` is a unique identifier for a span within a trace; it
 *                              is a 16-character hexadecimal encoding of an 8-byte array. It should not
 *                              be zero.
 *                              .
 * @param string $spansSpanId   The `[SPAN_ID]` portion of the span's resource name.
 */
function batch_write_spans_sample(
    string $formattedName,
    string $spansName,
    string $spansSpanId
): void {
    // Create a client.
    $traceServiceClient = new TraceServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $spansDisplayName = new TruncatableString();
    $spansStartTime = new Timestamp();
    $spansEndTime = new Timestamp();
    $span = (new Span())
        ->setName($spansName)
        ->setSpanId($spansSpanId)
        ->setDisplayName($spansDisplayName)
        ->setStartTime($spansStartTime)
        ->setEndTime($spansEndTime);
    $spans = [$span,];

    // Call the API and handle any network failures.
    try {
        $traceServiceClient->batchWriteSpans($formattedName, $spans);
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
    $formattedName = TraceServiceClient::projectName('[PROJECT]');
    $spansName = '[NAME]';
    $spansSpanId = '[SPAN_ID]';

    batch_write_spans_sample($formattedName, $spansName, $spansSpanId);
}
// [END cloudtrace_v2_generated_TraceService_BatchWriteSpans_sync]
