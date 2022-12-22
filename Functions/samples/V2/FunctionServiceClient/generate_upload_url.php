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

// [START cloudfunctions_v2_generated_FunctionService_GenerateUploadUrl_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Functions\V2\FunctionServiceClient;
use Google\Cloud\Functions\V2\GenerateUploadUrlResponse;

/**
 * Returns a signed URL for uploading a function source code.
 * For more information about the signed URL usage see:
 * https://cloud.google.com/storage/docs/access-control/signed-urls.
 * Once the function source code upload is complete, the used signed
 * URL should be provided in CreateFunction or UpdateFunction request
 * as a reference to the function source code.
 *
 * When uploading source code to the generated signed URL, please follow
 * these restrictions:
 *
 * * Source file type should be a zip file.
 * * No credentials should be attached - the signed URLs provide access to the
 * target bucket using internal service identity; if credentials were
 * attached, the identity from the credentials would be used, but that
 * identity does not have permissions to upload files to the URL.
 *
 * When making a HTTP PUT request, these two headers need to be specified:
 *
 * * `content-type: application/zip`
 *
 * And this header SHOULD NOT be specified:
 *
 * * `Authorization: Bearer YOUR_TOKEN`
 *
 * @param string $formattedParent The project and location in which the Google Cloud Storage signed URL
 *                                should be generated, specified in the format `projects/&#42;/locations/*`. Please see
 *                                {@see FunctionServiceClient::locationName()} for help formatting this field.
 */
function generate_upload_url_sample(string $formattedParent): void
{
    // Create a client.
    $functionServiceClient = new FunctionServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var GenerateUploadUrlResponse $response */
        $response = $functionServiceClient->generateUploadUrl($formattedParent);
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
    $formattedParent = FunctionServiceClient::locationName('[PROJECT]', '[LOCATION]');

    generate_upload_url_sample($formattedParent);
}
// [END cloudfunctions_v2_generated_FunctionService_GenerateUploadUrl_sync]
