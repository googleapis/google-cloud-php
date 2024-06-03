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

// [START cloudprofiler_v2_generated_ProfilerService_UpdateProfile_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Profiler\V2\Client\ProfilerServiceClient;
use Google\Cloud\Profiler\V2\Profile;
use Google\Cloud\Profiler\V2\UpdateProfileRequest;

/**
 * UpdateProfile updates the profile bytes and labels on the profile resource
 * created in the online mode. Updating the bytes for profiles created in the
 * offline mode is currently not supported: the profile content must be
 * provided at the time of the profile creation.
 *
 * _Direct use of this API is discouraged, please use a [supported
 * profiler
 * agent](https://cloud.google.com/profiler/docs/about-profiler#profiling_agent)
 * instead for profile collection._
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_profile_sample(): void
{
    // Create a client.
    $profilerServiceClient = new ProfilerServiceClient();

    // Prepare the request message.
    $request = new UpdateProfileRequest();

    // Call the API and handle any network failures.
    try {
        /** @var Profile $response */
        $response = $profilerServiceClient->updateProfile($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END cloudprofiler_v2_generated_ProfilerService_UpdateProfile_sync]
