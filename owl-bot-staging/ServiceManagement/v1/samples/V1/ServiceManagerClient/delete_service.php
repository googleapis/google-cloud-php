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

// [START servicemanagement_v1_generated_ServiceManager_DeleteService_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\ServiceManagement\V1\ServiceManagerClient;
use Google\Rpc\Status;

/**
 * Deletes a managed service. This method will change the service to the
 * `Soft-Delete` state for 30 days. Within this period, service producers may
 * call
 * [UndeleteService][google.api.servicemanagement.v1.ServiceManager.UndeleteService]
 * to restore the service. After 30 days, the service will be permanently
 * deleted.
 *
 * Operation<response: google.protobuf.Empty>
 *
 * @param string $serviceName The name of the service.  See the
 *                            [overview](https://cloud.google.com/service-infrastructure/docs/overview) for naming requirements.  For
 *                            example: `example.googleapis.com`.
 */
function delete_service_sample(string $serviceName): void
{
    // Create a client.
    $serviceManagerClient = new ServiceManagerClient();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $serviceManagerClient->deleteService($serviceName);
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
    $serviceName = '[SERVICE_NAME]';

    delete_service_sample($serviceName);
}
// [END servicemanagement_v1_generated_ServiceManager_DeleteService_sync]
