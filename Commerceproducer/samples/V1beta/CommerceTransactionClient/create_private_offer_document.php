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

// [START commerceproducer_v1beta_generated_CommerceTransaction_CreatePrivateOfferDocument_sync]
use Google\ApiCore\ApiException;
use Google\Cloud\Commerceproducer\V1beta\Client\CommerceTransactionClient;
use Google\Cloud\Commerceproducer\V1beta\CreatePrivateOfferDocumentRequest;
use Google\Cloud\Commerceproducer\V1beta\PrivateOfferDocument;
use Google\Cloud\Commerceproducer\V1beta\PrivateOfferDocument\DocumentType;

/**
 * Creates a new PrivateOfferDocument in a given project and location.
 *
 * @param string $formattedParent                  Value for parent. Please see
 *                                                 {@see CommerceTransactionClient::privateOfferName()} for help formatting this field.
 * @param int    $privateOfferDocumentDocumentType The classification type of the document.
 *                                                 Used to distinguish between different types of documents that may be
 *                                                 attached to a private offer for different business purposes.
 */
function create_private_offer_document_sample(
    string $formattedParent,
    int $privateOfferDocumentDocumentType
): void {
    // Create a client.
    $commerceTransactionClient = new CommerceTransactionClient();

    // Prepare the request message.
    $privateOfferDocument = (new PrivateOfferDocument())
        ->setDocumentType($privateOfferDocumentDocumentType);
    $request = (new CreatePrivateOfferDocumentRequest())
        ->setParent($formattedParent)
        ->setPrivateOfferDocument($privateOfferDocument);

    // Call the API and handle any network failures.
    try {
        /** @var PrivateOfferDocument $response */
        $response = $commerceTransactionClient->createPrivateOfferDocument($request);
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
    $formattedParent = CommerceTransactionClient::privateOfferName(
        '[PROJECT]',
        '[LOCATION]',
        '[PRIVATE_OFFER]'
    );
    $privateOfferDocumentDocumentType = DocumentType::DOCUMENT_TYPE_UNSPECIFIED;

    create_private_offer_document_sample($formattedParent, $privateOfferDocumentDocumentType);
}
// [END commerceproducer_v1beta_generated_CommerceTransaction_CreatePrivateOfferDocument_sync]
