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

// [START cloudkms_v1_generated_AutokeyAdmin_ListLocations_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\Kms\V1\Client\AutokeyAdminClient;
use Google\Cloud\Location\ListLocationsRequest;
use Google\Cloud\Location\Location;

/**
 * Lists information about the supported locations for this service.

This method lists locations based on the resource scope provided in
the [ListLocationsRequest.name] field:

* **Global locations**: If `name` is empty, the method lists the
public locations available to all projects. * **Project-specific
locations**: If `name` follows the format
`projects/{project}`, the method lists locations visible to that
specific project. This includes public, private, or other
project-specific locations enabled for the project.

For gRPC and client library implementations, the resource name is
passed as the `name` field. For direct service calls, the resource
name is
incorporated into the request path based on the specific service
implementation and version.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function list_locations_sample(): void
{
    // Create a client.
    $autokeyAdminClient = new AutokeyAdminClient();

    // Prepare the request message.
    $request = new ListLocationsRequest();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $autokeyAdminClient->listLocations($request);

        /** @var Location $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
        }
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END cloudkms_v1_generated_AutokeyAdmin_ListLocations_sync]
