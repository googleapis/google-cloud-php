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

// [START apihub_v1_generated_ApiHub_UpdateVersion_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ApiHub\V1\Client\ApiHubClient;
use Google\Cloud\ApiHub\V1\UpdateVersionRequest;
use Google\Cloud\ApiHub\V1\Version;
use Google\Protobuf\FieldMask;

/**
 * Update API version. The following fields in the
 * [version][google.cloud.apihub.v1.Version] can be updated currently:
 *
 * * [display_name][google.cloud.apihub.v1.Version.display_name]
 * * [description][google.cloud.apihub.v1.Version.description]
 * * [documentation][google.cloud.apihub.v1.Version.documentation]
 * * [deployments][google.cloud.apihub.v1.Version.deployments]
 * * [lifecycle][google.cloud.apihub.v1.Version.lifecycle]
 * * [compliance][google.cloud.apihub.v1.Version.compliance]
 * * [accreditation][google.cloud.apihub.v1.Version.accreditation]
 * * [attributes][google.cloud.apihub.v1.Version.attributes]
 *
 * The
 * [update_mask][google.cloud.apihub.v1.UpdateVersionRequest.update_mask]
 * should be used to specify the fields being updated.
 *
 * @param string $versionDisplayName The display name of the version.
 */
function update_version_sample(string $versionDisplayName): void
{
    // Create a client.
    $apiHubClient = new ApiHubClient();

    // Prepare the request message.
    $version = (new Version())
        ->setDisplayName($versionDisplayName);
    $updateMask = new FieldMask();
    $request = (new UpdateVersionRequest())
        ->setVersion($version)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var Version $response */
        $response = $apiHubClient->updateVersion($request);
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
    $versionDisplayName = '[DISPLAY_NAME]';

    update_version_sample($versionDisplayName);
}
// [END apihub_v1_generated_ApiHub_UpdateVersion_sync]
