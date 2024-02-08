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

// [START discoveryengine_v1beta_generated_SiteSearchEngineService_BatchVerifyTargetSites_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\DiscoveryEngine\V1beta\BatchVerifyTargetSitesRequest;
use Google\Cloud\DiscoveryEngine\V1beta\BatchVerifyTargetSitesResponse;
use Google\Cloud\DiscoveryEngine\V1beta\Client\SiteSearchEngineServiceClient;
use Google\Rpc\Status;

/**
 * Verify target sites' ownership and validity.
 * This API sends all the target sites under site search engine for
 * verification.
 *
 * @param string $formattedParent The parent resource shared by all TargetSites being verified.
 *                                `projects/{project}/locations/{location}/collections/{collection}/dataStores/{data_store}/siteSearchEngine`. Please see
 *                                {@see SiteSearchEngineServiceClient::siteSearchEngineName()} for help formatting this field.
 */
function batch_verify_target_sites_sample(string $formattedParent): void
{
    // Create a client.
    $siteSearchEngineServiceClient = new SiteSearchEngineServiceClient();

    // Prepare the request message.
    $request = (new BatchVerifyTargetSitesRequest())
        ->setParent($formattedParent);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $siteSearchEngineServiceClient->batchVerifyTargetSites($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var BatchVerifyTargetSitesResponse $result */
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

    batch_verify_target_sites_sample($formattedParent);
}
// [END discoveryengine_v1beta_generated_SiteSearchEngineService_BatchVerifyTargetSites_sync]
