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

// [START dataplex_v1_generated_BusinessGlossaryService_DeleteGlossaryTerm_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dataplex\V1\Client\BusinessGlossaryServiceClient;
use Google\Cloud\Dataplex\V1\DeleteGlossaryTermRequest;

/**
 * Deletes a GlossaryTerm resource.
 *
 * @param string $formattedName The name of the GlossaryTerm to delete.
 *                              Format:
 *                              projects/{project_id_or_number}/locations/{location_id}/glossaries/{glossary_id}/terms/{term_id}
 *                              Please see {@see BusinessGlossaryServiceClient::glossaryTermName()} for help formatting this field.
 */
function delete_glossary_term_sample(string $formattedName): void
{
    // Create a client.
    $businessGlossaryServiceClient = new BusinessGlossaryServiceClient();

    // Prepare the request message.
    $request = (new DeleteGlossaryTermRequest())
        ->setName($formattedName);

    // Call the API and handle any network failures.
    try {
        $businessGlossaryServiceClient->deleteGlossaryTerm($request);
        printf('Call completed successfully.' . PHP_EOL);
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
    $formattedName = BusinessGlossaryServiceClient::glossaryTermName(
        '[PROJECT]',
        '[LOCATION]',
        '[GLOSSARY]',
        '[GLOSSARY_TERM]'
    );

    delete_glossary_term_sample($formattedName);
}
// [END dataplex_v1_generated_BusinessGlossaryService_DeleteGlossaryTerm_sync]
