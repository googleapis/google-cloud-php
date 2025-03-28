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

// [START apphub_v1_generated_AppHub_CreateServiceProjectAttachment_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\AppHub\V1\Client\AppHubClient;
use Google\Cloud\AppHub\V1\CreateServiceProjectAttachmentRequest;
use Google\Cloud\AppHub\V1\ServiceProjectAttachment;
use Google\Rpc\Status;

/**
 * Attaches a service project to the host project.
 *
 * @param string $formattedParent                                 Host project ID and location to which service project is being
 *                                                                attached. Only global location is supported. Expected format:
 *                                                                `projects/{project}/locations/{location}`. Please see
 *                                                                {@see AppHubClient::locationName()} for help formatting this field.
 * @param string $serviceProjectAttachmentId                      The service project attachment identifier must contain the
 *                                                                project id of the service project specified in the
 *                                                                service_project_attachment.service_project field.
 * @param string $formattedServiceProjectAttachmentServiceProject Immutable. Service project name in the format: `"projects/abc"`
 *                                                                or `"projects/123"`. As input, project name with either project id or
 *                                                                number are accepted. As output, this field will contain project number. Please see
 *                                                                {@see AppHubClient::projectName()} for help formatting this field.
 */
function create_service_project_attachment_sample(
    string $formattedParent,
    string $serviceProjectAttachmentId,
    string $formattedServiceProjectAttachmentServiceProject
): void {
    // Create a client.
    $appHubClient = new AppHubClient();

    // Prepare the request message.
    $serviceProjectAttachment = (new ServiceProjectAttachment())
        ->setServiceProject($formattedServiceProjectAttachmentServiceProject);
    $request = (new CreateServiceProjectAttachmentRequest())
        ->setParent($formattedParent)
        ->setServiceProjectAttachmentId($serviceProjectAttachmentId)
        ->setServiceProjectAttachment($serviceProjectAttachment);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $appHubClient->createServiceProjectAttachment($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ServiceProjectAttachment $result */
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
    $formattedParent = AppHubClient::locationName('[PROJECT]', '[LOCATION]');
    $serviceProjectAttachmentId = '[SERVICE_PROJECT_ATTACHMENT_ID]';
    $formattedServiceProjectAttachmentServiceProject = AppHubClient::projectName('[PROJECT]');

    create_service_project_attachment_sample(
        $formattedParent,
        $serviceProjectAttachmentId,
        $formattedServiceProjectAttachmentServiceProject
    );
}
// [END apphub_v1_generated_AppHub_CreateServiceProjectAttachment_sync]
