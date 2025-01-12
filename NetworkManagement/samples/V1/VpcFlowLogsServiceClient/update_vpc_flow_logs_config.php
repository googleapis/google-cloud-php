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

// [START networkmanagement_v1_generated_VpcFlowLogsService_UpdateVpcFlowLogsConfig_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\NetworkManagement\V1\Client\VpcFlowLogsServiceClient;
use Google\Cloud\NetworkManagement\V1\UpdateVpcFlowLogsConfigRequest;
use Google\Cloud\NetworkManagement\V1\VpcFlowLogsConfig;
use Google\Protobuf\FieldMask;
use Google\Rpc\Status;

/**
 * Updates an existing `VpcFlowLogsConfig`.
 * If a configuration with the exact same settings already exists (even if the
 * ID is different), the creation fails.
 * Notes:
 *
 * 1. Updating a configuration with state=DISABLED will fail.
 * 2. The following fields are not considered as `settings` for the purpose
 * of the check mentioned above, therefore - updating another configuration
 * with the same fields but different values for the following fields will
 * fail as well:
 * * name
 * * create_time
 * * update_time
 * * labels
 * * description
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function update_vpc_flow_logs_config_sample(): void
{
    // Create a client.
    $vpcFlowLogsServiceClient = new VpcFlowLogsServiceClient();

    // Prepare the request message.
    $updateMask = new FieldMask();
    $vpcFlowLogsConfig = new VpcFlowLogsConfig();
    $request = (new UpdateVpcFlowLogsConfigRequest())
        ->setUpdateMask($updateMask)
        ->setVpcFlowLogsConfig($vpcFlowLogsConfig);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $vpcFlowLogsServiceClient->updateVpcFlowLogsConfig($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var VpcFlowLogsConfig $result */
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
// [END networkmanagement_v1_generated_VpcFlowLogsService_UpdateVpcFlowLogsConfig_sync]
