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

// [START datacatalog_v1_generated_DataCatalog_CreateTag_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\DataCatalog\V1\DataCatalogClient;
use Google\Cloud\DataCatalog\V1\Tag;

/**
 * Creates a tag and assigns it to:
 *
 * * An [Entry][google.cloud.datacatalog.v1.Entry] if the method name is
 * `projects.locations.entryGroups.entries.tags.create`.
 * * Or [EntryGroup][google.cloud.datacatalog.v1.EntryGroup]if the method
 * name is `projects.locations.entryGroups.tags.create`.
 *
 * Note: The project identified by the `parent` parameter for the [tag]
 * (https://cloud.google.com/data-catalog/docs/reference/rest/v1/projects.locations.entryGroups.entries.tags/create#path-parameters)
 * and the [tag template]
 * (https://cloud.google.com/data-catalog/docs/reference/rest/v1/projects.locations.tagTemplates/create#path-parameters)
 * used to create the tag must be in the same organization.
 *
 * @param string $formattedParent The name of the resource to attach this tag to.
 *
 *                                Tags can be attached to entries or entry groups. An entry can have up to
 *                                1000 attached tags.
 *
 *                                Note: The tag and its child resources might not be stored in
 *                                the location specified in its name. Please see
 *                                {@see DataCatalogClient::entryName()} for help formatting this field.
 * @param string $tagTemplate     The resource name of the tag template this tag uses. Example:
 *
 *                                `projects/{PROJECT_ID}/locations/{LOCATION}/tagTemplates/{TAG_TEMPLATE_ID}`
 *
 *                                This field cannot be modified after creation.
 */
function create_tag_sample(string $formattedParent, string $tagTemplate): void
{
    // Create a client.
    $dataCatalogClient = new DataCatalogClient();

    // Prepare any non-scalar elements to be passed along with the request.
    $tagFields = [];
    $tag = (new Tag())
        ->setTemplate($tagTemplate)
        ->setFields($tagFields);

    // Call the API and handle any network failures.
    try {
        /** @var Tag $response */
        $response = $dataCatalogClient->createTag($formattedParent, $tag);
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
    $formattedParent = DataCatalogClient::entryName(
        '[PROJECT]',
        '[LOCATION]',
        '[ENTRY_GROUP]',
        '[ENTRY]'
    );
    $tagTemplate = '[TEMPLATE]';

    create_tag_sample($formattedParent, $tagTemplate);
}
// [END datacatalog_v1_generated_DataCatalog_CreateTag_sync]
