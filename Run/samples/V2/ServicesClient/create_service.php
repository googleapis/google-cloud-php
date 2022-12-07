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

// [START run_v2_generated_Services_CreateService_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Run\V2\RevisionTemplate;
use Google\Cloud\Run\V2\Service;
use Google\Cloud\Run\V2\ServicesClient;
use Google\Rpc\Status;

/**
 * Creates a new Service in a given project and location.
 *
 * @param string $formattedParent The location and project in which this service should be created.
 *                                Format: projects/{project}/locations/{location}, where {project} can be
 *                                project id or number. Only lowercase characters, digits, and hyphens. Please see
 *                                {@see ServicesClient::locationName()} for help formatting this field.
 * @param string $serviceId       The unique identifier for the Service. It must begin with letter,
 *                                and cannot end with hyphen; must contain fewer than 50 characters.
 *                                The name of the service becomes {parent}/services/{service_id}.
 */
function create_service_sample(string $formattedParent, string $serviceId): void
{
    // Create a client.
    $servicesClient = new ServicesClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $serviceTemplate = new RevisionTemplate();
    $service = (new Service())
        ->setTemplate($serviceTemplate);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $servicesClient->createService($formattedParent, $service, $serviceId);
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
    $formattedParent = ServicesClient::locationName('[PROJECT]', '[LOCATION]');
    $serviceId = '[SERVICE_ID]';

    create_service_sample($formattedParent, $serviceId);
}
// [END run_v2_generated_Services_CreateService_sync]
