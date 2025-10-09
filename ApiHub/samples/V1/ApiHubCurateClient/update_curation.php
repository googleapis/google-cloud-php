<?php
/*
 * Copyright 2025 Google LLC
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

// [START apihub_v1_generated_ApiHubCurate_UpdateCuration_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\ApiHub\V1\ApplicationIntegrationEndpointDetails;
use Google\Cloud\ApiHub\V1\Client\ApiHubCurateClient;
use Google\Cloud\ApiHub\V1\Curation;
use Google\Cloud\ApiHub\V1\Endpoint;
use Google\Cloud\ApiHub\V1\UpdateCurationRequest;

/**
 * Update a curation resource in the API hub. The following fields in the
 * [curation][google.cloud.apihub.v1.Curation] can be updated:
 *
 * * [display_name][google.cloud.apihub.v1.Curation.display_name]
 * * [description][google.cloud.apihub.v1.Curation.description]
 *
 * The
 * [update_mask][google.cloud.apihub.v1.UpdateApiRequest.update_mask]
 * should be used to specify the fields being updated.
 *
 * @param string $curationDisplayName                                            The display name of the curation.
 * @param string $curationEndpointApplicationIntegrationEndpointDetailsUri       The endpoint URI should be a valid REST URI for triggering an
 *                                                                               Application Integration. Format:
 *                                                                               `https://integrations.googleapis.com/v1/{name=projects/&#42;/locations/&#42;/integrations/*}:execute`
 *                                                                               or
 *                                                                               `https://{location}-integrations.googleapis.com/v1/{name=projects/&#42;/locations/&#42;/integrations/*}:execute`
 * @param string $curationEndpointApplicationIntegrationEndpointDetailsTriggerId The API trigger ID of the Application Integration workflow.
 */
function update_curation_sample(
    string $curationDisplayName,
    string $curationEndpointApplicationIntegrationEndpointDetailsUri,
    string $curationEndpointApplicationIntegrationEndpointDetailsTriggerId
): void {
    // Create a client.
    $apiHubCurateClient = new ApiHubCurateClient();

    // Prepare the request message.
    $curationEndpointApplicationIntegrationEndpointDetails = (new ApplicationIntegrationEndpointDetails())
        ->setUri($curationEndpointApplicationIntegrationEndpointDetailsUri)
        ->setTriggerId($curationEndpointApplicationIntegrationEndpointDetailsTriggerId);
    $curationEndpoint = (new Endpoint())
        ->setApplicationIntegrationEndpointDetails($curationEndpointApplicationIntegrationEndpointDetails);
    $curation = (new Curation())
        ->setDisplayName($curationDisplayName)
        ->setEndpoint($curationEndpoint);
    $request = (new UpdateCurationRequest())
        ->setCuration($curation);

    // Call the API and handle any network failures.
    try {
        /** @var Curation $response */
        $response = $apiHubCurateClient->updateCuration($request);
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
    $curationDisplayName = '[DISPLAY_NAME]';
    $curationEndpointApplicationIntegrationEndpointDetailsUri = '[URI]';
    $curationEndpointApplicationIntegrationEndpointDetailsTriggerId = '[TRIGGER_ID]';

    update_curation_sample(
        $curationDisplayName,
        $curationEndpointApplicationIntegrationEndpointDetailsUri,
        $curationEndpointApplicationIntegrationEndpointDetailsTriggerId
    );
}
// [END apihub_v1_generated_ApiHubCurate_UpdateCuration_sync]
