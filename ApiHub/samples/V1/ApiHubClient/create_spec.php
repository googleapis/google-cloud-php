<?php
/*
 * Copyright 2024 Google LLC
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

// [START apihub_v1_generated_ApiHub_CreateSpec_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ApiHub\V1\AttributeValues;
use Google\Cloud\ApiHub\V1\Client\ApiHubClient;
use Google\Cloud\ApiHub\V1\CreateSpecRequest;
use Google\Cloud\ApiHub\V1\Spec;

/**
 * Add a spec to an API version in the API hub.
 * Multiple specs can be added to an API version.
 * Note, while adding a spec, at least one of `contents` or `source_uri` must
 * be provided. If `contents` is provided, then `spec_type` must also be
 * provided.
 *
 * On adding a spec with contents to the version, the operations present in it
 * will be added to the version.Note that the file contents in the spec should
 * be of the same type as defined in the
 * `projects/{project}/locations/{location}/attributes/system-spec-type`
 * attribute associated with spec resource. Note that specs of various types
 * can be uploaded, however parsing of details is supported for OpenAPI spec
 * currently.
 *
 * In order to access the information parsed from the spec, use the
 * [GetSpec][google.cloud.apihub.v1.ApiHub.GetSpec] method.
 * In order to access the raw contents for a particular spec, use the
 * [GetSpecContents][google.cloud.apihub.v1.ApiHub.GetSpecContents] method.
 * In order to access the operations parsed from the spec, use the
 * [ListAPIOperations][google.cloud.apihub.v1.ApiHub.ListApiOperations]
 * method.
 *
 * @param string $formattedParent The parent resource for Spec.
 *                                Format:
 *                                `projects/{project}/locations/{location}/apis/{api}/versions/{version}`
 *                                Please see {@see ApiHubClient::versionName()} for help formatting this field.
 * @param string $specDisplayName The display name of the spec.
 *                                This can contain the file name of the spec.
 */
function create_spec_sample(string $formattedParent, string $specDisplayName): void
{
    // Create a client.
    $apiHubClient = new ApiHubClient();

    // Prepare the request message.
    $specSpecType = new AttributeValues();
    $spec = (new Spec())
        ->setDisplayName($specDisplayName)
        ->setSpecType($specSpecType);
    $request = (new CreateSpecRequest())
        ->setParent($formattedParent)
        ->setSpec($spec);

    // Call the API and handle any network failures.
    try {
        /** @var Spec $response */
        $response = $apiHubClient->createSpec($request);
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
    $formattedParent = ApiHubClient::versionName('[PROJECT]', '[LOCATION]', '[API]', '[VERSION]');
    $specDisplayName = '[DISPLAY_NAME]';

    create_spec_sample($formattedParent, $specDisplayName);
}
// [END apihub_v1_generated_ApiHub_CreateSpec_sync]
