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

// [START designcenter_v1_generated_DesignCenter_CreateConnection_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DesignCenter\V1\Client\DesignCenterClient;
use Google\Cloud\DesignCenter\V1\Connection;
use Google\Cloud\DesignCenter\V1\CreateConnectionRequest;

/**
 * Creates a connection.
 *
 * @param string $formattedParent                            The parent resource in which to create a connection. Please see
 *                                                           {@see DesignCenterClient::componentName()} for help formatting this field.
 * @param string $connectionId                               The ID of the connection to create.
 * @param string $formattedConnectionDestinationComponentUri The destination component URI used to generate the connection.
 *                                                           Format is
 *                                                           `projects/$project/locations/$location/spaces/$space/applicationTemplates/$application_template/components/$component`
 *                                                           Please see {@see DesignCenterClient::componentName()} for help formatting this field.
 */
function create_connection_sample(
    string $formattedParent,
    string $connectionId,
    string $formattedConnectionDestinationComponentUri
): void {
    // Create a client.
    $designCenterClient = new DesignCenterClient();

    // Prepare the request message.
    $connection = (new Connection())
        ->setDestinationComponentUri($formattedConnectionDestinationComponentUri);
    $request = (new CreateConnectionRequest())
        ->setParent($formattedParent)
        ->setConnectionId($connectionId)
        ->setConnection($connection);

    // Call the API and handle any network failures.
    try {
        /** @var Connection $response */
        $response = $designCenterClient->createConnection($request);
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
    $formattedParent = DesignCenterClient::componentName(
        '[PROJECT]',
        '[LOCATION]',
        '[SPACE]',
        '[APPLICATION_TEMPLATE]',
        '[COMPONENT]'
    );
    $connectionId = '[CONNECTION_ID]';
    $formattedConnectionDestinationComponentUri = DesignCenterClient::componentName(
        '[PROJECT]',
        '[LOCATION]',
        '[SPACE]',
        '[APPLICATION_TEMPLATE]',
        '[COMPONENT]'
    );

    create_connection_sample(
        $formattedParent,
        $connectionId,
        $formattedConnectionDestinationComponentUri
    );
}
// [END designcenter_v1_generated_DesignCenter_CreateConnection_sync]
