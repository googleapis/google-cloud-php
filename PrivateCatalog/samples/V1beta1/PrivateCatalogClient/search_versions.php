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

// [START cloudprivatecatalog_v1beta1_generated_PrivateCatalog_SearchVersions_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\PagedListResponse;
use Google\Cloud\PrivateCatalog\V1beta1\PrivateCatalogClient;
use Google\Cloud\PrivateCatalog\V1beta1\Version;

/**
 * Search [Version][google.cloud.privatecatalog.v1beta1.Version] resources that consumers have access to, within the
 * scope of the consumer cloud resource hierarchy context.
 *
 * @param string $resource The name of the resource context. See [SearchCatalogsRequest.resource][google.cloud.privatecatalog.v1beta1.SearchCatalogsRequest.resource]
 *                         for details.
 * @param string $query    The query to filter the versions.
 *
 *                         The supported queries are:
 *                         * List versions under a product:
 *                         `parent=catalogs/{catalog}/products/{product}`
 *                         * Get a version by name:
 *                         `name=catalogs/{catalog}/products/{product}/versions/{version}`
 */
function search_versions_sample(string $resource, string $query): void
{
    // Create a client.
    $privateCatalogClient = new PrivateCatalogClient();

    // Call the API and handle any network failures.
    try {
        /** @var PagedListResponse $response */
        $response = $privateCatalogClient->searchVersions($resource, $query);

        /** @var Version $element */
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
    $resource = '[RESOURCE]';
    $query = '[QUERY]';

    search_versions_sample($resource, $query);
}
// [END cloudprivatecatalog_v1beta1_generated_PrivateCatalog_SearchVersions_sync]
