<?php
/*
 * Copyright 2026 Google LLC
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

// [START designcenter_v1_generated_DesignCenter_CreateApplication_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\AppHub\V1\Scope;
use Google\Cloud\AppHub\V1\Scope\Type;
use Google\Cloud\DesignCenter\V1\Application;
use Google\Cloud\DesignCenter\V1\Client\DesignCenterClient;
use Google\Cloud\DesignCenter\V1\CreateApplicationRequest;
use Google\Cloud\DesignCenter\V1\DeploymentSource;

/**
 * Creates an application.
 *
 * @param string $formattedParent      The parent resource in which to create the application.
 *                                     Format: `projects/$project/locations/$location/spaces/$space`
 *                                     Please see {@see DesignCenterClient::spaceName()} for help formatting this field.
 * @param string $applicationId        The ID of the application to create.
 * @param int    $applicationScopeType Scope Type.
 */
function create_application_sample(
    string $formattedParent,
    string $applicationId,
    int $applicationScopeType
): void {
    // Create a client.
    $designCenterClient = new DesignCenterClient();

    // Prepare the request message.
    $applicationSource = new DeploymentSource();
    $applicationScope = (new Scope())
        ->setType($applicationScopeType);
    $application = (new Application())
        ->setSource($applicationSource)
        ->setScope($applicationScope);
    $request = (new CreateApplicationRequest())
        ->setParent($formattedParent)
        ->setApplicationId($applicationId)
        ->setApplication($application);

    // Call the API and handle any network failures.
    try {
        /** @var Application $response */
        $response = $designCenterClient->createApplication($request);
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
    $formattedParent = DesignCenterClient::spaceName('[PROJECT]', '[LOCATION]', '[SPACE]');
    $applicationId = '[APPLICATION_ID]';
    $applicationScopeType = Type::TYPE_UNSPECIFIED;

    create_application_sample($formattedParent, $applicationId, $applicationScopeType);
}
// [END designcenter_v1_generated_DesignCenter_CreateApplication_sync]
