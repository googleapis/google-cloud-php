<?php
/*
 * Copyright 2023 Google LLC
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

// [START logging_v2_generated_ConfigServiceV2_CreateBucket_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Logging\V2\ConfigServiceV2Client;
use Google\Cloud\Logging\V2\LogBucket;

/**
 * Creates a log bucket that can be used to store log entries. After a bucket
 * has been created, the bucket's location cannot be changed.
 *
 * @param string $formattedParent The resource in which to create the log bucket:
 *
 *                                "projects/[PROJECT_ID]/locations/[LOCATION_ID]"
 *
 *                                For example:
 *
 *                                `"projects/my-project/locations/global"`
 *                                Please see {@see ConfigServiceV2Client::organizationLocationName()} for help formatting this field.
 * @param string $bucketId        A client-assigned identifier such as `"my-bucket"`. Identifiers are limited
 *                                to 100 characters and can include only letters, digits, underscores,
 *                                hyphens, and periods.
 */
function create_bucket_sample(string $formattedParent, string $bucketId): void
{
    // Create a client.
    $configServiceV2Client = new ConfigServiceV2Client();

    // Prepare any non-scalar elements to be passed along with the request.
    $bucket = new LogBucket();

    // Call the API and handle any network failures.
    try {
        /** @var LogBucket $response */
        $response = $configServiceV2Client->createBucket($formattedParent, $bucketId, $bucket);
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
    $formattedParent = ConfigServiceV2Client::organizationLocationName('[ORGANIZATION]', '[LOCATION]');
    $bucketId = '[BUCKET_ID]';

    create_bucket_sample($formattedParent, $bucketId);
}
// [END logging_v2_generated_ConfigServiceV2_CreateBucket_sync]
