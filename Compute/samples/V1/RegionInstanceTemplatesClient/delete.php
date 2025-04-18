<?php
/*
 * Copyright 2023 Google LLC
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

// [START compute_v1_generated_RegionInstanceTemplates_Delete_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Compute\V1\Client\RegionInstanceTemplatesClient;
use Google\Cloud\Compute\V1\DeleteRegionInstanceTemplateRequest;
use Google\Rpc\Status;

/**
 * Deletes the specified instance template. Deleting an instance template is permanent and cannot be undone.
 *
 * @param string $instanceTemplate The name of the instance template to delete.
 * @param string $project          Project ID for this request.
 * @param string $region           The name of the region for this request.
 */
function delete_sample(string $instanceTemplate, string $project, string $region): void
{
    // Create a client.
    $regionInstanceTemplatesClient = new RegionInstanceTemplatesClient();

    // Prepare the request message.
    $request = (new DeleteRegionInstanceTemplateRequest())
        ->setInstanceTemplate($instanceTemplate)
        ->setProject($project)
        ->setRegion($region);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $regionInstanceTemplatesClient->delete($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            printf('Operation completed successfully.' . PHP_EOL);
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
    $instanceTemplate = '[INSTANCE_TEMPLATE]';
    $project = '[PROJECT]';
    $region = '[REGION]';

    delete_sample($instanceTemplate, $project, $region);
}
// [END compute_v1_generated_RegionInstanceTemplates_Delete_sync]
