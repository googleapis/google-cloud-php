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

// [START run_v2_generated_SourceUpload_UploadSource_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Run\V2\Client\SourceUploadClient;
use Google\Cloud\Run\V2\UploadSourceRequest;
use Google\Cloud\Run\V2\UploadSourceResponse;

/**
 * Uploads a source archive to a Google Cloud Storage bucket through Cloud
 * Run. The uploaded source object should be used for Cloud Run resource
 * deployments. User is responsible for managing the lifecycle of the uploaded
 * object.
 * If uploading through the Cloud Run API to Cloud Storage is not desired, you
 * can use the IAM Deny Policy to deny the `run.locations.uploadSource`
 * permission for all principals.
 *
 * @param string $formattedParent The project and location in which the source archive should be
 *                                uploaded to, specified in the format `projects/&#42;/locations/*`. Please see
 *                                {@see SourceUploadClient::locationName()} for help formatting this field.
 */
function upload_source_sample(string $formattedParent): void
{
    // Create a client.
    $sourceUploadClient = new SourceUploadClient();

    // Prepare the request message.
    $request = (new UploadSourceRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var UploadSourceResponse $response */
        $response = $sourceUploadClient->uploadSource($request);
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
    $formattedParent = SourceUploadClient::locationName('[PROJECT]', '[LOCATION]');

    upload_source_sample($formattedParent);
}
// [END run_v2_generated_SourceUpload_UploadSource_sync]
