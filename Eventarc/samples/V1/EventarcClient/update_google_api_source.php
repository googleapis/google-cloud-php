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

// [START eventarc_v1_generated_Eventarc_UpdateGoogleApiSource_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Eventarc\V1\Client\EventarcClient;
use Google\Cloud\Eventarc\V1\GoogleApiSource;
use Google\Cloud\Eventarc\V1\UpdateGoogleApiSourceRequest;
use Google\Rpc\Status;

/**
 * Update a single GoogleApiSource.
 *
 * @param string $formattedGoogleApiSourceDestination Destination is the message bus that the GoogleApiSource is
 *                                                    delivering to. It must be point to the full resource name of a MessageBus.
 *                                                    Format:
 *                                                    "projects/{PROJECT_ID}/locations/{region}/messagesBuses/{MESSAGE_BUS_ID)
 *                                                    Please see {@see EventarcClient::messageBusName()} for help formatting this field.
 */
function update_google_api_source_sample(string $formattedGoogleApiSourceDestination): void
{
    // Create a client.
    $eventarcClient = new EventarcClient();

    // Prepare the request message.
    $googleApiSource = (new GoogleApiSource())
        ->setDestination($formattedGoogleApiSourceDestination);
    $request = (new UpdateGoogleApiSourceRequest())
        ->setGoogleApiSource($googleApiSource);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $eventarcClient->updateGoogleApiSource($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var GoogleApiSource $result */
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
    $formattedGoogleApiSourceDestination = EventarcClient::messageBusName(
        '[PROJECT]',
        '[LOCATION]',
        '[MESSAGE_BUS]'
    );

    update_google_api_source_sample($formattedGoogleApiSourceDestination);
}
// [END eventarc_v1_generated_Eventarc_UpdateGoogleApiSource_sync]
