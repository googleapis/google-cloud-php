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

// [START discoveryengine_v1beta_generated_SiteSearchEngineService_CreateTargetSite_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\DiscoveryEngine\V1beta\Client\SiteSearchEngineServiceClient;
use Google\Cloud\DiscoveryEngine\V1beta\CreateTargetSiteRequest;
use Google\Cloud\DiscoveryEngine\V1beta\TargetSite;
use Google\Rpc\Status;

/**
 * Creates a [TargetSite][google.cloud.discoveryengine.v1beta.TargetSite].
 *
 * @param string $formattedParent              Parent resource name of
 *                                             [TargetSite][google.cloud.discoveryengine.v1beta.TargetSite], such as
 *                                             `projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}/siteSearchEngine`. Please see
 *                                             {@see SiteSearchEngineServiceClient::siteSearchEngineName()} for help formatting this field.
 * @param string $targetSiteProvidedUriPattern Input only. The user provided URI pattern from which the
 *                                             `generated_uri_pattern` is generated.
 */
function create_target_site_sample(
    string $formattedParent,
    string $targetSiteProvidedUriPattern
): void {
    // Create a client.
    $siteSearchEngineServiceClient = new SiteSearchEngineServiceClient();

    // Prepare the request message.
    $targetSite = (new TargetSite())
        ->setProvidedUriPattern($targetSiteProvidedUriPattern);
    $request = (new CreateTargetSiteRequest())
        ->setParent($formattedParent)
        ->setTargetSite($targetSite);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $siteSearchEngineServiceClient->createTargetSite($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var TargetSite $result */
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
    $formattedParent = SiteSearchEngineServiceClient::siteSearchEngineName(
        '[PROJECT]',
        '[LOCATION]',
        '[DATA_STORE]'
    );
    $targetSiteProvidedUriPattern = '[PROVIDED_URI_PATTERN]';

    create_target_site_sample($formattedParent, $targetSiteProvidedUriPattern);
}
// [END discoveryengine_v1beta_generated_SiteSearchEngineService_CreateTargetSite_sync]
