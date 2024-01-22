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

// [START serviceusage_v1_generated_ServiceUsage_ListServices_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\ServiceUsage\V1\Client\ServiceUsageClient;
use Google\Cloud\ServiceUsage\V1\ListServicesRequest;
use Google\Cloud\ServiceUsage\V1\Service;

/**
 * List all services available to the specified project, and the current
 * state of those services with respect to the project. The list includes
 * all public services, all services for which the calling user has the
 * `servicemanagement.services.bind` permission, and all services that have
 * already been enabled on the project. The list can be filtered to
 * only include services in a specific state, for example to only include
 * services enabled on the project.
 *
 * WARNING: If you need to query enabled services frequently or across
 * an organization, you should use
 * [Cloud Asset Inventory
 * API](https://cloud.google.com/asset-inventory/docs/apis), which provides
 * higher throughput and richer filtering capability.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function list_services_sample(): void
{
    // Create a client.
    $serviceUsageClient = new ServiceUsageClient();

    // Prepare the request message.
    $request = new ListServicesRequest();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $serviceUsageClient->listServices($request);

        /** @var Service $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
        }
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}
// [END serviceusage_v1_generated_ServiceUsage_ListServices_sync]
