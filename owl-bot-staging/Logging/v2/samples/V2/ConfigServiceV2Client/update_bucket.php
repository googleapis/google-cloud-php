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

// [START logging_v2_generated_ConfigServiceV2_UpdateBucket_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Logging\V2\ConfigServiceV2Client;
use Google\Cloud\Logging\V2\LogBucket;
use Google\Protobuf\FieldMask;

/**
 * Updates a log bucket. This method replaces the following fields in the
 * existing bucket with values from the new bucket: `retention_period`
 *
 * If the retention period is decreased and the bucket is locked,
 * `FAILED_PRECONDITION` will be returned.
 *
 * If the bucket has a `lifecycle_state` of `DELETE_REQUESTED`, then
 * `FAILED_PRECONDITION` will be returned.
 *
 * After a bucket has been created, the bucket's location cannot be changed.
 *
 * @param string $formattedName The full resource name of the bucket to update.
 *
 *                              "projects/[PROJECT_ID]/locations/[LOCATION_ID]/buckets/[BUCKET_ID]"
 *                              "organizations/[ORGANIZATION_ID]/locations/[LOCATION_ID]/buckets/[BUCKET_ID]"
 *                              "billingAccounts/[BILLING_ACCOUNT_ID]/locations/[LOCATION_ID]/buckets/[BUCKET_ID]"
 *                              "folders/[FOLDER_ID]/locations/[LOCATION_ID]/buckets/[BUCKET_ID]"
 *
 *                              For example:
 *
 *                              `"projects/my-project/locations/global/buckets/my-bucket"`
 *                              Please see {@see ConfigServiceV2Client::logBucketName()} for help formatting this field.
 */
function update_bucket_sample(string $formattedName): void
{
    // Create a client.
    $configServiceV2Client = new ConfigServiceV2Client();

    // Prepare any non-scalar elements to be passed along with the request.
    $bucket = new LogBucket();
    $updateMask = new FieldMask();

    // Call the API and handle any network failures.
    try {
        /** @var LogBucket $response */
        $response = $configServiceV2Client->updateBucket($formattedName, $bucket, $updateMask);
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
    $formattedName = ConfigServiceV2Client::logBucketName('[PROJECT]', '[LOCATION]', '[BUCKET]');

    update_bucket_sample($formattedName);
}
// [END logging_v2_generated_ConfigServiceV2_UpdateBucket_sync]
