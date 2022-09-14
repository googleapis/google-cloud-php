<?php
/*
 * Copyright 2019 Google LLC
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
 * This file was generated from the file
 * https://github.com/google/googleapis/blob/master/google/firestore/v1/firestore.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * @experimental
 */

namespace Google\Cloud\Firestore\V1;

use Google\ApiCore\PathTemplate;
use Google\ApiCore\ValidationException;
use Google\Cloud\Firestore\V1\Gapic\FirestoreGapicClient;

/**
 * {@inheritdoc}
 */
class FirestoreClient extends FirestoreGapicClient
{
    /**
     * @see FirestoreClient::partitionQueryPaginated
     * @return \Google\Cloud\Firestore\V1\PartitionQueryResponse
     * @deprecated use partitionQueryPaginated instead
     */
    public function partitionQuery(array $optionalArgs = [])
    {
        return $this->partitionQueryPaginated($optionalArgs)->getPage()->getResponseObject();
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a any_path resource.
     *
     * @param string $project
     * @param string $database
     * @param string $document
     * @param string $anyPath
     *
     * @return string The formatted any_path resource.
     * @deprecated
     */
    public static function anyPathName($project, $database, $document, $anyPath)
    {
        return (new PathTemplate('projects/{project}/databases/{database}/documents/{document}/{any_path=**}'))->render([
            'project' => $project,
            'database' => $database,
            'document' => $document,
            'any_path' => $anyPath,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a database_root resource.
     *
     * @param string $project
     * @param string $database
     *
     * @return string The formatted database_root resource.
     * @deprecated
     */
    public static function databaseRootName($project, $database)
    {
        return (new PathTemplate('projects/{project}/databases/{database}'))->render([
            'project' => $project,
            'database' => $database,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a document_path resource.
     *
     * @param string $project
     * @param string $database
     * @param string $documentPath
     *
     * @return string The formatted document_path resource.
     * @deprecated
     */
    public static function documentPathName($project, $database, $documentPath)
    {
        return (new PathTemplate('projects/{project}/databases/{database}/documents/{document_path=**}'))->render([
            'project' => $project,
            'database' => $database,
            'document_path' => $documentPath,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a document_root resource.
     *
     * @param string $project
     * @param string $database
     *
     * @return string The formatted document_root resource.
     * @deprecated
     */
    public static function documentRootName($project, $database)
    {
        return (new PathTemplate('projects/{project}/databases/{database}/documents'))->render([
            'project' => $project,
            'database' => $database,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - anyPath: projects/{project}/databases/{database}/documents/{document}/{any_path=**}
     * - databaseRoot: projects/{project}/databases/{database}
     * - documentPath: projects/{project}/databases/{database}/documents/{document_path=**}
     * - documentRoot: projects/{project}/databases/{database}/documents.
     *
     * The optional $template argument can be supplied to specify a particular pattern, and must
     * match one of the templates listed above. If no $template argument is provided, or if the
     * $template argument does not match one of the templates listed, then parseName will check
     * each of the supported templates, and return the first match.
     *
     * @param string $formattedName The formatted name string
     * @param string $template      Optional name of template to match
     *
     * @return array An associative array from name component IDs to component values.
     *
     * @throws ValidationException If $formattedName could not be matched.
     * @deprecated
     */
    public static function parseName($formattedName, $template = null)
    {
        $templateMap = [
            'anyPath' => new PathTemplate('projects/{project}/databases/{database}/documents/{document_path=**}'),
            'databaseRoot' => new PathTemplate('projects/{project}/databases/{database}'),
            'documentPath' => new PathTemplate('projects/{project}/databases/{database}/documents/{document_path=**}'),
            'documentRoot' => new PathTemplate('projects/{project}/databases/{database}/documents'),
        ];

        if ($template) {
            if (!isset($templateMap[$template])) {
                throw new ValidationException("Template name $template does not exist");
            }

            return $templateMap[$template]->match($formattedName);
        }

        foreach ($templateMap as $templateName => $pathTemplate) {
            try {
                return $pathTemplate->match($formattedName);
            } catch (ValidationException $ex) {
                // Swallow the exception to continue trying other path templates
            }
        }
        throw new ValidationException("Input did not match any known format. Input: $formattedName");
    }
}
