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

// [START analyticsadmin_v1beta_generated_AnalyticsAdminService_AcknowledgeUserDataCollection_sync]
use Google\Analytics\Admin\V1beta\AcknowledgeUserDataCollectionResponse;
use Google\Analytics\Admin\V1beta\AnalyticsAdminServiceClient;
use Google\ApiCore\ApiException;

/**
 * Acknowledges the terms of user data collection for the specified property.
 *
 * This acknowledgement must be completed (either in the Google Analytics UI
 * or through this API) before MeasurementProtocolSecret resources may be
 * created.
 *
 * @param string $formattedProperty The property for which to acknowledge user data collection. Please see
 *                                  {@see AnalyticsAdminServiceClient::propertyName()} for help formatting this field.
 * @param string $acknowledgement   An acknowledgement that the caller of this method understands the
 *                                  terms of user data collection.
 *
 *                                  This field must contain the exact value:
 *                                  "I acknowledge that I have the necessary privacy disclosures and rights
 *                                  from my end users for the collection and processing of their data,
 *                                  including the association of such data with the visitation information
 *                                  Google Analytics collects from my site and/or app property."
 */
function acknowledge_user_data_collection_sample(
    string $formattedProperty,
    string $acknowledgement
): void {
    // Create a client.
    $analyticsAdminServiceClient = new AnalyticsAdminServiceClient();

    // Call the API and handle any network failures.
    try {
        /** @var AcknowledgeUserDataCollectionResponse $response */
        $response = $analyticsAdminServiceClient->acknowledgeUserDataCollection(
            $formattedProperty,
            $acknowledgement
        );
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
    $formattedProperty = AnalyticsAdminServiceClient::propertyName('[PROPERTY]');
    $acknowledgement = '[ACKNOWLEDGEMENT]';

    acknowledge_user_data_collection_sample($formattedProperty, $acknowledgement);
}
// [END analyticsadmin_v1beta_generated_AnalyticsAdminService_AcknowledgeUserDataCollection_sync]
