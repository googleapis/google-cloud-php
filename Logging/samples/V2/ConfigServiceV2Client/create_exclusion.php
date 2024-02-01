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

// [START logging_v2_generated_ConfigServiceV2_CreateExclusion_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Logging\V2\Client\ConfigServiceV2Client;
use Google\Cloud\Logging\V2\CreateExclusionRequest;
use Google\Cloud\Logging\V2\LogExclusion;

/**
 * Creates a new exclusion in the _Default sink in a specified parent
 * resource. Only log entries belonging to that resource can be excluded. You
 * can have up to 10 exclusions in a resource.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function create_exclusion_sample(): void
{
    // Create a client.
    $configServiceV2Client = new ConfigServiceV2Client();

    // Prepare the request message.
    $request = new CreateExclusionRequest();

    // Call the API and handle any network failures.
    try {
        /** @var LogExclusion $response */
        $response = $configServiceV2Client->createExclusion($request);
        printf('Response data: %s' . PHP_EOL, $response->serializeToJsonString());
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END logging_v2_generated_ConfigServiceV2_CreateExclusion_sync]
