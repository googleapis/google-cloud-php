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

// [START artifactregistry_v1_generated_ArtifactRegistry_CreateAttachment_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\ArtifactRegistry\V1\Attachment;
use Google\Cloud\ArtifactRegistry\V1\Client\ArtifactRegistryClient;
use Google\Cloud\ArtifactRegistry\V1\CreateAttachmentRequest;
use Google\Rpc\Status;

/**
 * Creates an attachment. The returned Operation will finish once the
 * attachment has been created. Its response will be the created attachment.
 *
 * @param string $formattedParent                 The name of the parent resource where the attachment will be
 *                                                created. Please see
 *                                                {@see ArtifactRegistryClient::repositoryName()} for help formatting this field.
 * @param string $attachmentId                    The attachment id to use for this attachment.
 * @param string $attachmentTarget                The target the attachment is for, can be a Version, Package or
 *                                                Repository. E.g.
 *                                                `projects/p1/locations/us-central1/repositories/repo1/packages/p1/versions/v1`.
 * @param string $formattedAttachmentFilesElement The files that belong to this attachment.
 *                                                If the file ID part contains slashes, they are escaped. E.g.
 *                                                `projects/p1/locations/us-central1/repositories/repo1/files/sha:<sha-of-file>`. Please see
 *                                                {@see ArtifactRegistryClient::fileName()} for help formatting this field.
 */
function create_attachment_sample(
    string $formattedParent,
    string $attachmentId,
    string $attachmentTarget,
    string $formattedAttachmentFilesElement
): void {
    // Create a client.
    $artifactRegistryClient = new ArtifactRegistryClient();

    // Prepare the request message.
    $formattedAttachmentFiles = [$formattedAttachmentFilesElement,];
    $attachment = (new Attachment())
        ->setTarget($attachmentTarget)
        ->setFiles($formattedAttachmentFiles);
    $request = (new CreateAttachmentRequest())
        ->setParent($formattedParent)
        ->setAttachmentId($attachmentId)
        ->setAttachment($attachment);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $artifactRegistryClient->createAttachment($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var Attachment $result */
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
    $formattedParent = ArtifactRegistryClient::repositoryName(
        '[PROJECT]',
        '[LOCATION]',
        '[REPOSITORY]'
    );
    $attachmentId = '[ATTACHMENT_ID]';
    $attachmentTarget = '[TARGET]';
    $formattedAttachmentFilesElement = ArtifactRegistryClient::fileName(
        '[PROJECT]',
        '[LOCATION]',
        '[REPOSITORY]',
        '[FILE]'
    );

    create_attachment_sample(
        $formattedParent,
        $attachmentId,
        $attachmentTarget,
        $formattedAttachmentFilesElement
    );
}
// [END artifactregistry_v1_generated_ArtifactRegistry_CreateAttachment_sync]
