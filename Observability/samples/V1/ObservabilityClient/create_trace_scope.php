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

// [START observability_v1_generated_Observability_CreateTraceScope_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Observability\V1\Client\ObservabilityClient;
use Google\Cloud\Observability\V1\CreateTraceScopeRequest;
use Google\Cloud\Observability\V1\TraceScope;

/**
 * Create a new TraceScope.
 *
 * @param string $formattedParent                The full resource name of the location where the trace scope
 *                                               should be created
 *
 *                                               projects/[PROJECT_ID]/locations/[LOCATION_ID]
 *
 *                                               For example:
 *
 *                                               projects/my-project/locations/global
 *                                               Please see {@see ObservabilityClient::locationName()} for help formatting this field.
 * @param string $traceScopeId                   A client-assigned identifier for the trace scope.
 * @param string $traceScopeResourceNamesElement Names of the projects that are included in this trace scope.
 *
 *                                               *  `projects/[PROJECT_ID]`
 *
 *                                               A trace scope can include a maximum of 20 projects.
 */
function create_trace_scope_sample(
    string $formattedParent,
    string $traceScopeId,
    string $traceScopeResourceNamesElement
): void {
    // Create a client.
    $observabilityClient = new ObservabilityClient();

    // Prepare the request message.
    $traceScopeResourceNames = [$traceScopeResourceNamesElement];
    $traceScope = (new TraceScope())
        ->setResourceNames($traceScopeResourceNames);
    $request = (new CreateTraceScopeRequest())
        ->setParent($formattedParent)
        ->setTraceScopeId($traceScopeId)
        ->setTraceScope($traceScope);

    // Call the API and handle any network failures.
    try {
        /** @var TraceScope $response */
        $response = $observabilityClient->createTraceScope($request);
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
    $formattedParent = ObservabilityClient::locationName('[PROJECT]', '[LOCATION]');
    $traceScopeId = '[TRACE_SCOPE_ID]';
    $traceScopeResourceNamesElement = '[RESOURCE_NAMES]';

    create_trace_scope_sample($formattedParent, $traceScopeId, $traceScopeResourceNamesElement);
}
// [END observability_v1_generated_Observability_CreateTraceScope_sync]
