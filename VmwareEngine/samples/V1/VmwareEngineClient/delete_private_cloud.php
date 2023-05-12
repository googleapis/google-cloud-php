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

// [START vmwareengine_v1_generated_VmwareEngine_DeletePrivateCloud_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\VmwareEngine\V1\Client\VmwareEngineClient;
use Google\Cloud\VmwareEngine\V1\DeletePrivateCloudRequest;
use Google\Cloud\VmwareEngine\V1\PrivateCloud;
use Google\Rpc\Status;

/**
 * Schedules a `PrivateCloud` resource for deletion.
 *
 * A `PrivateCloud` resource scheduled for deletion has `PrivateCloud.state`
 * set to `DELETED` and `expireTime` set to the time when deletion is final
 * and can no longer be reversed. The delete operation is marked as done
 * as soon as the `PrivateCloud` is successfully scheduled for deletion
 * (this also applies when `delayHours` is set to zero), and the operation is
 * not kept in pending state until `PrivateCloud` is purged.
 * `PrivateCloud` can be restored using `UndeletePrivateCloud` method before
 * the `expireTime` elapses. When `expireTime` is reached, deletion is final
 * and all private cloud resources are irreversibly removed and billing stops.
 * During the final removal process, `PrivateCloud.state` is set to `PURGING`.
 * `PrivateCloud` can be polled using standard `GET` method for the whole
 * period of deletion and purging. It will not be returned only
 * when it is completely purged.
 *
 * @param string $formattedName The resource name of the private cloud to delete.
 *                              Resource names are schemeless URIs that follow the conventions in
 *                              https://cloud.google.com/apis/design/resource_names.
 *                              For example:
 *                              `projects/my-project/locations/us-central1-a/privateClouds/my-cloud`
 *                              Please see {@see VmwareEngineClient::privateCloudName()} for help formatting this field.
 */
function delete_private_cloud_sample(string $formattedName): void
{
    // Create a client.
    $vmwareEngineClient = new VmwareEngineClient();

    // Prepare the request message.
    $request = (new DeletePrivateCloudRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $vmwareEngineClient->deletePrivateCloud($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var PrivateCloud $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
        }
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
    $formattedName = VmwareEngineClient::privateCloudName('[PROJECT]', '[LOCATION]', '[PRIVATE_CLOUD]');

    delete_private_cloud_sample($formattedName);
}
// [END vmwareengine_v1_generated_VmwareEngine_DeletePrivateCloud_sync]
