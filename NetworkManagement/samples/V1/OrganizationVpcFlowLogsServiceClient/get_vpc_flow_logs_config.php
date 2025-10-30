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

// [START networkmanagement_v1_generated_OrganizationVpcFlowLogsService_GetVpcFlowLogsConfig_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\NetworkManagement\V1\Client\OrganizationVpcFlowLogsServiceClient;
use Google\Cloud\NetworkManagement\V1\GetVpcFlowLogsConfigRequest;
use Google\Cloud\NetworkManagement\V1\VpcFlowLogsConfig;

/**
 * Gets the details of a specific `VpcFlowLogsConfig`.
 *
 * @param string $formattedName The resource name of the VpcFlowLogsConfig,
 *                              in one of the following formats:
 *
 *                              - For project-level resources:
 *                              `projects/{project_id}/locations/global/vpcFlowLogsConfigs/{vpc_flow_logs_config_id}`
 *
 *                              - For organization-level resources:
 *                              `organizations/{organization_id}/locations/global/vpcFlowLogsConfigs/{vpc_flow_logs_config_id}`
 *                              Please see {@see OrganizationVpcFlowLogsServiceClient::vpcFlowLogsConfigName()} for help formatting this field.
 */
function get_vpc_flow_logs_config_sample(string $formattedName): void
{
    // Create a client.
    $organizationVpcFlowLogsServiceClient = new OrganizationVpcFlowLogsServiceClient();

    // Prepare the request message.
    $request = (new GetVpcFlowLogsConfigRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var VpcFlowLogsConfig $response */
        $response = $organizationVpcFlowLogsServiceClient->getVpcFlowLogsConfig($request);
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
    $formattedName = OrganizationVpcFlowLogsServiceClient::vpcFlowLogsConfigName(
        '[PROJECT]',
        '[LOCATION]',
        '[VPC_FLOW_LOGS_CONFIG]'
    );

    get_vpc_flow_logs_config_sample($formattedName);
}
// [END networkmanagement_v1_generated_OrganizationVpcFlowLogsService_GetVpcFlowLogsConfig_sync]
