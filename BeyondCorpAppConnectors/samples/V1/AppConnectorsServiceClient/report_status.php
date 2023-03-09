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

// [START beyondcorp_v1_generated_AppConnectorsService_ReportStatus_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\BeyondCorp\AppConnectors\V1\AppConnector;
use Google\Cloud\BeyondCorp\AppConnectors\V1\AppConnectorsServiceClient;
use Google\Cloud\BeyondCorp\AppConnectors\V1\ResourceInfo;
use Google\Rpc\Status;

/**
 * Report status for a given connector.
 *
 * @param string $formattedAppConnector BeyondCorp Connector name using the form:
 *                                      `projects/{project_id}/locations/{location_id}/connectors/{connector}`
 *                                      Please see {@see AppConnectorsServiceClient::appConnectorName()} for help formatting this field.
 * @param string $resourceInfoId        Unique Id for the resource.
 */
function report_status_sample(string $formattedAppConnector, string $resourceInfoId): void
{
    // Create a client.
    $appConnectorsServiceClient = new AppConnectorsServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $resourceInfo = (new ResourceInfo())
        ->setId($resourceInfoId);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $appConnectorsServiceClient->reportStatus($formattedAppConnector, $resourceInfo);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var AppConnector $result */
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
    $formattedAppConnector = AppConnectorsServiceClient::appConnectorName(
        '[PROJECT]',
        '[LOCATION]',
        '[APP_CONNECTOR]'
    );
    $resourceInfoId = '[ID]';

    report_status_sample($formattedAppConnector, $resourceInfoId);
}
// [END beyondcorp_v1_generated_AppConnectorsService_ReportStatus_sync]
