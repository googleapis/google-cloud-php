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

// [START containeranalysis_v1_generated_Grafeas_CreateOccurrence_sync]
use Google\ApiCore\ApiException;
use Grafeas\V1\Client\GrafeasClient;
use Grafeas\V1\CreateOccurrenceRequest;
use Grafeas\V1\Occurrence;

/**
 * Creates a new occurrence.
 *
 * @param string $formattedParent The name of the project in the form of `projects/[PROJECT_ID]`, under which
 *                                the occurrence is to be created. Please see
 *                                {@see GrafeasClient::projectName()} for help formatting this field.
 */
function create_occurrence_sample(string $formattedParent): void
{
    // Create a client.
    $grafeasClient = new GrafeasClient();

    // Prepare the request message.
    $occurrence = new Occurrence();
    $request = (new CreateOccurrenceRequest())
        ->setParent($formattedParent)
        ->setOccurrence($occurrence);

    // Call the API and handle any network failures.
    try {
        /** @var Occurrence $response */
        $response = $grafeasClient->createOccurrence($request);
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
    $formattedParent = GrafeasClient::projectName('[PROJECT]');

    create_occurrence_sample($formattedParent);
}
// [END containeranalysis_v1_generated_Grafeas_CreateOccurrence_sync]
