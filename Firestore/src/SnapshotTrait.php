<?php
/**
 * Copyright 2017 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Firestore;

use Google\ApiCore\Serializer;
use Google\Cloud\Core\ApiHelperTrait;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\RequestHandler;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\DocumentReference;
use Google\Cloud\Firestore\V1\BatchGetDocumentsRequest;
use Google\Cloud\Firestore\V1\Client\FirestoreClient;

/**
 * Methods common to representing Document Snapshots.
 */
trait SnapshotTrait
{
    use ApiHelperTrait;
    use PathTrait;

    /**
     * Execute a service request to retrieve a document snapshot.
     *
     * @param ConnectionInterface $connection A Connection to Cloud Firestore.
     *        This object is created by FirestoreClient,
     *        and should not be instantiated outside of this client.
     * @param RequestHandler $requestHandler The request handler responsible for sending
     *        requests and serializing responses into relevant classes.
     * @param Serializer $serializer The serializer instance to encode/decode messages.
     * @param ValueMapper $valueMapper A Firestore Value Mapper.
     * @param DocumentReference $reference The parent document.
     * @param array $options {
     *     Configuration Options
     *
     *     @type string $transaction The transaction ID to fetch the snapshot.
     * }
     * @return DocumentSnapshot
     */
    private function createSnapshot(
        ConnectionInterface $connection,
        RequestHandler $requestHandler,
        Serializer $serializer,
        ValueMapper $valueMapper,
        DocumentReference $reference,
        array $options = []
    ) {
        $document = [];
        $fields = [];
        $exists = true;

        try {
            $document = $this->getSnapshot(
                $connection,
                $requestHandler,
                $serializer,
                $reference->name(),
                $options
            );
        } catch (NotFoundException $e) {
            $exists = false;
        }

        return $this->createSnapshotWithData($valueMapper, $reference, $document, $exists);
    }

    /**
     * Create a document snapshot by providing a dataset.
     *
     * This method will not perform a service request.
     *
     * @codingStandardsIgnoreStart
     * @param ValueMapper $valueMapper A Firestore Value Mapper.
     * @param DocumentReference $reference The parent document.
     * @param array $document [Document](https://cloud.google.com/firestore/docs/reference/rpc/google.firestore.v1beta1#google.firestore.v1beta1.Document)
     * @param bool $exists Whether the document exists. **Defaults to** `true`.
     * @codingStandardsIgnoreEnd
     */
    private function createSnapshotWithData(
        ValueMapper $valueMapper,
        DocumentReference $reference,
        array $document,
        $exists = true
    ) {
        $fields = $exists
            ? $valueMapper->decodeValues($this->pluck('fields', $document))
            : [];

        return new DocumentSnapshot($reference, $valueMapper, $document, $fields, $exists);
    }

    /**
     * Send a service request for a snapshot, and return the raw data
     *
     * @param ConnectionInterface $connection A Connection to Cloud Firestore
     * @param RequestHandler $requestHandler The request handler responsible for sending
     *        requests and serializing responses into relevant classes.
     * @param Serializer $serializer The serializer instance to encode/decode messages.
     * @param string $name The document name.
     * @param array $options Configuration options.
     * @return array
     * @throws \InvalidArgumentException if an invalid `$options.readTime` is
     *     specified.
     * @throws NotFoundException If the document does not exist.
     */
    private function getSnapshot(
        ConnectionInterface $connection,
        RequestHandler $requestHandler,
        Serializer $serializer,
        $name,
        array $options = []
    ) {
        list($data, $optionalArgs) = $this->splitOptionalArgs($options);
        $data += [
            'database' => $this->databaseFromName($name),
            'documents' => [$name],
        ];
        $request = $serializer->decodeMessage(new BatchGetDocumentsRequest(), $data);
        $snapshot = $requestHandler->sendRequest(
            FirestoreClient::class,
            'batchGetDocuments',
            $request,
            $optionalArgs
        )->current();

        if (!isset($snapshot['found'])) {
            throw new NotFoundException(sprintf(
                'Document %s does not exist',
                $name
            ));
        }

        return $snapshot['found'];
    }

    /**
     * Fetches a list of documents by their paths, orders them to match the
     * input order, creates a list of snapshots (whether the document exists or
     * not), and returns.
     *
     * @param ConnectionInterface $connection A connection to Cloud Firestore.
     * @param RequestHandler $requestHandler The request handler responsible for sending
     *        requests and serializing responses into relevant classes.
     * @param Serializer $serializer The serializer instance to encode/decode messages.
     * @param ValueMapper $mapper A Firestore value mapper.
     * @param string $projectId The current project id.
     * @param string $database The database id.
     * @param string[]|DocumentReference[] $paths A list of fully-qualified
     *        firestore document paths or DocumentReference instances.
     * @param array $options Configuration options.
     * @return DocumentSnapshot[]
     */
    private function getDocumentsByPaths(
        ConnectionInterface $connection,
        RequestHandler $requestHandler,
        Serializer $serializer,
        ValueMapper $mapper,
        $projectId,
        $database,
        array $paths,
        array $options
    ) {
        $documentNames = [];
        foreach ($paths as $path) {
            if ($path instanceof DocumentReference) {
                $path = $path->name();
            }

            if (!is_string($path)) {
                throw new \InvalidArgumentException(
                    'All members of $paths must be strings or instances of DocumentReference.'
                );
            }

            $path = $this->isRelative($path)
                ? $this->fullName($projectId, $database, $path)
                : $path;

            $documentNames[] = $path;
        }

        list($data, $optionalArgs) = $this->splitOptionalArgs($options);
        $data += [
            'database' => $this->databaseName($projectId, $database),
            'documents' => $documentNames,
        ];
        $request = $serializer->decodeMessage(new BatchGetDocumentsRequest(), $data);
        $documents = $requestHandler->sendRequest(
            FirestoreClient::class,
            'batchGetDocuments',
            $request,
            $optionalArgs
        );

        $res = [];
        foreach ($documents as $document) {
            $exists = isset($document['found']);
            $data = $exists
                ? $document['found'] + ['readTime' => $document['readTime']]
                : ['readTime' => $document['readTime']];

            $name = $exists
                ? $document['found']['name']
                : $document['missing'];

            $ref = $this->getDocumentReference(
                $connection,
                $requestHandler,
                $serializer,
                $mapper,
                $projectId,
                $database,
                $name
            );

            $res[$name] = $this->createSnapshotWithData(
                $mapper,
                $ref,
                $data,
                $exists
            );
        }

        $out = [];
        foreach ($documentNames as $path) {
            $out[] = $res[$path];
        }

        return $out;
    }

    /**
     * Creates a DocumentReference object.
     *
     * @param ConnectionInterface $connection A connection to Cloud Firestore.
     * @param RequestHandler $requestHandler The request handler responsible for sending
     *        requests and serializing responses into relevant classes.
     * @param Serializer $serializer The serializer instance to encode/decode messages.
     * @param ValueMapper $mapper A Firestore value mapper.
     * @param string $projectId The current project id.
     * @param string $database The database id.
     * @param string $name The document name, in absolute form, or relative to the database.
     * @return DocumentReference
     * @throws \InvalidArgumentException if an invalid path is provided.
     */
    private function getDocumentReference(
        ConnectionInterface $connection,
        RequestHandler $requestHandler,
        Serializer $serializer,
        ValueMapper $mapper,
        $projectId,
        $database,
        $name
    ) {
        if ($this->isRelative($name)) {
            $name = $this->fullName($projectId, $database, $name);
        }

        if (!$this->isDocument($name)) {
            throw new \InvalidArgumentException('Given path is not a valid document path.');
        }

        return new DocumentReference(
            $connection,
            $requestHandler,
            $serializer,
            $mapper,
            $this->getCollectionReference(
                $connection,
                $requestHandler,
                $serializer,
                $mapper,
                $projectId,
                $database,
                $this->parentPath($name)
            ),
            $name
        );
    }

    /**
     * Creates a CollectionReference object.
     *
     * @param ConnectionInterface $connection A connection to Cloud Firestore.
     * @param RequestHandler $requestHandler The request handler responsible for sending
     *        requests and serializing responses into relevant classes.
     * @param Serializer $serializer The serializer instance to encode/decode messages.
     * @param ValueMapper $mapper A Firestore value mapper.
     * @param string $projectId The current project id.
     * @param string $database The database id.
     * @param string $name The collection name, in absolute form, or relative to the database.
     * @return CollectionReference
     * @throws \InvalidArgumentException if an invalid path is provided.
     */
    private function getCollectionReference(
        ConnectionInterface $connection,
        RequestHandler $requestHandler,
        Serializer $serializer,
        ValueMapper $mapper,
        $projectId,
        $database,
        $name
    ) {
        if ($this->isRelative($name)) {
            $name = $this->fullName($projectId, $database, $name);
        }

        if (!$this->isCollection($name)) {
            throw new \InvalidArgumentException(sprintf(
                'Given path `%s` is not a valid collection path.',
                $name
            ));
        }

        return new CollectionReference(
            $connection,
            $requestHandler,
            $serializer,
            $mapper,
            $name
        );
    }
}
