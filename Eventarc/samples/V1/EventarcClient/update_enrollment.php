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

// [START eventarc_v1_generated_Eventarc_UpdateEnrollment_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Eventarc\V1\Client\EventarcClient;
use Google\Cloud\Eventarc\V1\Enrollment;
use Google\Cloud\Eventarc\V1\UpdateEnrollmentRequest;
use Google\Rpc\Status;

/**
 * Update a single Enrollment.
 *
 * @param string $enrollmentCelMatch            A CEL expression identifying which messages this enrollment
 *                                              applies to.
 * @param string $formattedEnrollmentMessageBus Resource name of the message bus identifying the source of the
 *                                              messages. It matches the form
 *                                              projects/{project}/locations/{location}/messageBuses/{messageBus}. Please see
 *                                              {@see EventarcClient::messageBusName()} for help formatting this field.
 * @param string $enrollmentDestination         Destination is the Pipeline that the Enrollment is delivering to.
 *                                              It must point to the full resource name of a Pipeline. Format:
 *                                              "projects/{PROJECT_ID}/locations/{region}/pipelines/{PIPELINE_ID)"
 */
function update_enrollment_sample(
    string $enrollmentCelMatch,
    string $formattedEnrollmentMessageBus,
    string $enrollmentDestination
): void {
    // Create a client.
    $eventarcClient = new EventarcClient();

    // Prepare the request message.
    $enrollment = (new Enrollment())
        ->setCelMatch($enrollmentCelMatch)
        ->setMessageBus($formattedEnrollmentMessageBus)
        ->setDestination($enrollmentDestination);
    $request = (new UpdateEnrollmentRequest())
        ->setEnrollment($enrollment);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $eventarcClient->updateEnrollment($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Enrollment $result */
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
    $enrollmentCelMatch = '[CEL_MATCH]';
    $formattedEnrollmentMessageBus = EventarcClient::messageBusName(
        '[PROJECT]',
        '[LOCATION]',
        '[MESSAGE_BUS]'
    );
    $enrollmentDestination = '[DESTINATION]';

    update_enrollment_sample(
        $enrollmentCelMatch,
        $formattedEnrollmentMessageBus,
        $enrollmentDestination
    );
}
// [END eventarc_v1_generated_Eventarc_UpdateEnrollment_sync]
