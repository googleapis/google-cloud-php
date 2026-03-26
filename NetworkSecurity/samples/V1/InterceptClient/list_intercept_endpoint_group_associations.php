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

// [START networksecurity_v1_generated_Intercept_ListInterceptEndpointGroupAssociations_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\NetworkSecurity\V1\Client\InterceptClient;
use Google\Cloud\NetworkSecurity\V1\InterceptEndpointGroupAssociation;
use Google\Cloud\NetworkSecurity\V1\ListInterceptEndpointGroupAssociationsRequest;

/**
 * Lists associations in a given project and location.
 * See https://google.aip.dev/132.
 *
 * @param string $formattedParent The parent, which owns this collection of associations.
 *                                Example: `projects/123456789/locations/global`.
 *                                See https://google.aip.dev/132 for more details. Please see
 *                                {@see InterceptClient::locationName()} for help formatting this field.
 */
function list_intercept_endpoint_group_associations_sample(string $formattedParent): void
{
    // Create a client.
    $interceptClient = new InterceptClient();

    // Prepare the request message.
    $request = (new ListInterceptEndpointGroupAssociationsRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $interceptClient->listInterceptEndpointGroupAssociations($request);

        /** @var InterceptEndpointGroupAssociation $element */
        foreach ($response as $element) {
            printf('Element data: %s' . PHP_EOL, $element->serializeToJsonString());
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
    $formattedParent = InterceptClient::locationName('[PROJECT]', '[LOCATION]');

    list_intercept_endpoint_group_associations_sample($formattedParent);
}
// [END networksecurity_v1_generated_Intercept_ListInterceptEndpointGroupAssociations_sync]
