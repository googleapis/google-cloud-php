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

// [START recommendationengine_v1beta1_generated_UserEventService_ImportUserEvents_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\RecommendationEngine\V1beta1\ImportUserEventsResponse;
use Google\Cloud\RecommendationEngine\V1beta1\InputConfig;
use Google\Cloud\RecommendationEngine\V1beta1\UserEventServiceClient;
use Google\Rpc\Status;

/**
 * Bulk import of User events. Request processing might be
 * synchronous. Events that already exist are skipped.
 * Use this method for backfilling historical user events.
 *
 * Operation.response is of type ImportResponse. Note that it is
 * possible for a subset of the items to be successfully inserted.
 * Operation.metadata is of type ImportMetadata.
 *
 * @param string $formattedParent Required.
 *                                `projects/1234/locations/global/catalogs/default_catalog/eventStores/default_event_store`
 *                                Please see {@see UserEventServiceClient::eventStoreName()} for help formatting this field.
 */
function import_user_events_sample(string $formattedParent): void
{
    // Create a client.
    $userEventServiceClient = new UserEventServiceClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $inputConfig = new InputConfig();

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $userEventServiceClient->importUserEvents($formattedParent, $inputConfig);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ImportUserEventsResponse $result */
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
    $formattedParent = UserEventServiceClient::eventStoreName(
        '[PROJECT]',
        '[LOCATION]',
        '[CATALOG]',
        '[EVENT_STORE]'
    );

    import_user_events_sample($formattedParent);
}
// [END recommendationengine_v1beta1_generated_UserEventService_ImportUserEvents_sync]
