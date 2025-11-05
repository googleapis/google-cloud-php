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

// [START dataplex_v1_generated_BusinessGlossaryService_UpdateGlossaryTerm_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Dataplex\V1\Client\BusinessGlossaryServiceClient;
use Google\Cloud\Dataplex\V1\GlossaryTerm;
use Google\Cloud\Dataplex\V1\UpdateGlossaryTermRequest;
use Google\Protobuf\FieldMask;

/**
 * Updates a GlossaryTerm resource.
 *
 * @param string $formattedTermParent The immediate parent of the GlossaryTerm in the
 *                                    resource-hierarchy. It can either be a Glossary or a GlossaryCategory.
 *                                    Format:
 *                                    projects/{project_id_or_number}/locations/{location_id}/glossaries/{glossary_id}
 *                                    OR
 *                                    projects/{project_id_or_number}/locations/{location_id}/glossaries/{glossary_id}/categories/{category_id}
 *                                    Please see {@see BusinessGlossaryServiceClient::glossaryName()} for help formatting this field.
 */
function update_glossary_term_sample(string $formattedTermParent): void
{
    // Create a client.
    $businessGlossaryServiceClient = new BusinessGlossaryServiceClient();

    // Prepare the request message.
    $term = (new GlossaryTerm())
        ->setParent($formattedTermParent);
    $updateMask = new FieldMask();
    $request = (new UpdateGlossaryTermRequest())
        ->setTerm($term)
        ->setUpdateMask($updateMask);

    // Call the API and handle any network failures.
    try {
        /** @var GlossaryTerm $response */
        $response = $businessGlossaryServiceClient->updateGlossaryTerm($request);
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
    $formattedTermParent = BusinessGlossaryServiceClient::glossaryName(
        '[PROJECT]',
        '[LOCATION]',
        '[GLOSSARY]'
    );

    update_glossary_term_sample($formattedTermParent);
}
// [END dataplex_v1_generated_BusinessGlossaryService_UpdateGlossaryTerm_sync]
