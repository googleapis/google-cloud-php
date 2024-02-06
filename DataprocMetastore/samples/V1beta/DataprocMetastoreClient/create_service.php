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

// [START metastore_v1beta_generated_DataprocMetastore_CreateService_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Metastore\V1beta\DataprocMetastoreClient;
use Google\Cloud\Metastore\V1beta\Service;
use Google\Rpc\Status;

/**
 * Creates a metastore service in a project and location.
 *
 * @param string $formattedParent The relative resource name of the location in which to create a
 *                                metastore service, in the following form:
 *
 *                                `projects/{project_number}/locations/{location_id}`. Please see
 *                                {@see DataprocMetastoreClient::locationName()} for help formatting this field.
 * @param string $serviceId       The ID of the metastore service, which is used as the final
 *                                component of the metastore service's name.
 *
 *                                This value must be between 2 and 63 characters long inclusive, begin with a
 *                                letter, end with a letter or number, and consist of alpha-numeric
 *                                ASCII characters or hyphens.
 */
function create_service_sample(string $formattedParent, string $serviceId): void
{
    // Create a client.
    $dataprocMetastoreClient = new DataprocMetastoreClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $service = new Service();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $dataprocMetastoreClient->createService($formattedParent, $serviceId, $service);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Service $result */
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
    $formattedParent = DataprocMetastoreClient::locationName('[PROJECT]', '[LOCATION]');
    $serviceId = '[SERVICE_ID]';

    create_service_sample($formattedParent, $serviceId);
}
// [END metastore_v1beta_generated_DataprocMetastore_CreateService_sync]
