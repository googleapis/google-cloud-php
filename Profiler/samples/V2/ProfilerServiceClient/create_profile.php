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

// [START cloudprofiler_v2_generated_ProfilerService_CreateProfile_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Profiler\V2\Client\ProfilerServiceClient;
use Google\Cloud\Profiler\V2\CreateProfileRequest;
use Google\Cloud\Profiler\V2\Profile;

/**
 * CreateProfile creates a new profile resource in the online mode.
 *
 * _Direct use of this API is discouraged, please use a [supported
 * profiler
 * agent](https://cloud.google.com/profiler/docs/about-profiler#profiling_agent)
 * instead for profile collection._
 *
 * The server ensures that the new profiles are created at a constant rate per
 * deployment, so the creation request may hang for some time until the next
 * profile session is available.
 *
 * The request may fail with ABORTED error if the creation is not available
 * within ~1m, the response will indicate the duration of the backoff the
 * client should take before attempting creating a profile again. The backoff
 * duration is returned in google.rpc.RetryInfo extension on the response
 * status. To a gRPC client, the extension will be return as a
 * binary-serialized proto in the trailing metadata item named
 * "google.rpc.retryinfo-bin".
 *
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function create_profile_sample(): void
{
    // Create a client.
    $profilerServiceClient = new ProfilerServiceClient();

    // Prepare the request message.
    $request = new CreateProfileRequest();

    // Call the API and handle any network failures.
    try {
        /** @var Profile $response */
        $response = $profilerServiceClient->createProfile($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END cloudprofiler_v2_generated_ProfilerService_CreateProfile_sync]
