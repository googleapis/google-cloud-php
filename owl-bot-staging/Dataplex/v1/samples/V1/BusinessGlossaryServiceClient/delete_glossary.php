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

// [START dataplex_v1_generated_BusinessGlossaryService_DeleteGlossary_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\Dataplex\V1\Client\BusinessGlossaryServiceClient;
use Google\Cloud\Dataplex\V1\DeleteGlossaryRequest;
use Google\Rpc\Status;

/**
 * Deletes a Glossary resource. All the categories and terms within the
 * Glossary must be deleted before the Glossary can be deleted.
 *
 * @param string $formattedName The name of the Glossary to delete.
 *                              Format:
 *                              projects/{project_id_or_number}/locations/{location_id}/glossaries/{glossary_id}
 *                              Please see {@see BusinessGlossaryServiceClient::glossaryName()} for help formatting this field.
 */
function delete_glossary_sample(string $formattedName): void
{
    // Create a client.
    $businessGlossaryServiceClient = new BusinessGlossaryServiceClient();

    // Prepare the request message.
    $request = (new DeleteGlossaryRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $businessGlossaryServiceClient->deleteGlossary($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            printf('Operation completed successfully.' . PHP_EOL);
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
    $formattedName = BusinessGlossaryServiceClient::glossaryName(
        '[PROJECT]',
        '[LOCATION]',
        '[GLOSSARY]'
    );

    delete_glossary_sample($formattedName);
}
// [END dataplex_v1_generated_BusinessGlossaryService_DeleteGlossary_sync]
