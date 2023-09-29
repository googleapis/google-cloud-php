<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\BigQuery;

use Google\Cloud\BigQuery\Connection\ConnectionInterface;
use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\ConcurrencyControlTrait;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Iterator\ItemIterator;
use Google\Cloud\Core\Iterator\PageIterator;

/**
 * [Datasets](https://cloud.google.com/bigquery/docs/datasets-intro) allow
 * you to organize and control access to your tables.
 */
class Dataset
{
    use ArrayTrait;
    use ConcurrencyControlTrait;

    /**
     * @var ConnectionInterface Represents a connection to BigQuery.
     * @internal
     */
    private $connection;

    /**
     * @var array The dataset's identity.
     */
    private $identity;

    /**
     * @var array The dataset's metadata.
     */
    private $info;

    /**
     * @var string|null A default geographic location.
     */
    private $location;

    /**
     * @var ValueMapper Maps values between PHP and BigQuery.
     */
    private $mapper;

    /**
     * @param ConnectionInterface $connection Represents a connection to
     *        BigQuery. This object is created by BigQueryClient,
     *        and should not be instantiated outside of this client.
     * @param string $id The dataset's ID.
     * @param string $projectId The project's ID.
     * @param array $info [optional] The dataset's metadata.
     * @param string|null $location [optional] A default geographic location,
     *        used when no dataset metadata exists.
     */
    public function __construct(
        ConnectionInterface $connection,
        $id,
        $projectId,
        ValueMapper $mapper,
        array $info = [],
        $location = null
    ) {
        $this->connection = $connection;
        $this->info = $info;
        $this->mapper = $mapper;
        $this->identity = [
            'datasetId' => $id,
            'projectId' => $projectId
        ];
        $this->location = $location;
    }

    /**
     * Check whether or not the dataset exists.
     *
     * Example:
     * ```
     * echo $dataset->exists();
     * ```
     *
     * @return bool
     */
    public function exists()
    {
        try {
            $this->connection->getDataset($this->identity + ['fields' => 'datasetReference']);
        } catch (NotFoundException $ex) {
            return false;
        }

        return true;
    }

    /**
     * Delete the dataset.
     *
     * Please note that by default the library will not attempt to retry this
     * call on your behalf.
     *
     * Example:
     * ```
     * $dataset->delete();
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/datasets/delete Datasets delete API documentation.
     *
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type bool $deleteContents If true, delete all the tables in the
     *           dataset. If false and the dataset contains tables, the request
     *           will fail. **Defaults to** `false`.
     * }
     */
    public function delete(array $options = [])
    {
        $this->connection->deleteDataset(
            $options
            + ['retries' => 0]
            + $this->identity
        );
    }

    /**
     * Update the dataset.
     *
     * Providing an `etag` key as part of `$metadata` will enable simultaneous
     * update protection. This is useful in preventing override of modifications
     * made by another user. The resource's current etag can be obtained via a
     * GET request on the resource.
     *
     * Please note that by default this call will not automatically retry on
     * your behalf unless an `etag` is set.
     *
     * Example:
     * ```
     * $dataset->update([
     *     'friendlyName' => 'A fanciful dataset.'
     * ]);
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/datasets/patch Datasets patch API documentation.
     * @see https://cloud.google.com/bigquery/docs/api-performance#patch Patch (Partial Update)
     *
     * @param array $metadata The available options for metadata are outlined
     *        at the [Dataset Resource API docs](https://cloud.google.com/bigquery/docs/reference/rest/v2/datasets)
     * @param array $options [optional] Configuration options.
     */
    public function update(array $metadata, array $options = [])
    {
        $options = $this->applyEtagHeader(
            $metadata
            + $this->identity
            + $options
        );

        if (!isset($options['etag']) && !isset($options['retries'])) {
            $options['retries'] = 0;
        }

        return $this->info = $this->connection->patchDataset($options);
    }

    /**
     * Lazily instantiates a table.
     *
     * There are no network requests made at this point. To see the operations
     * that can be performed on a dataset please see {@see Table}.
     *
     * Example:
     * ```
     * $table = $dataset->table('myTableId');
     * ```
     *
     * @param string $id The id of the table to request.
     * @return Table
     */
    public function table($id)
    {
        return new Table(
            $this->connection,
            $id,
            $this->identity['datasetId'],
            $this->identity['projectId'],
            $this->mapper,
            [],
            isset($this->info['location'])
                ? $this->info['location']
                : $this->location
        );
    }

    /**
     * Fetches tables in the dataset.
     *
     * Example:
     * ```
     * $tables = $dataset->tables();
     *
     * foreach ($tables as $table) {
     *     echo $table->id() . PHP_EOL;
     * }
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/tables/list Tables list API documentation.
     *
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type int $maxResults Maximum number of results to return per page.
     *     @type int $resultLimit Limit the number of results returned in total.
     *           **Defaults to** `0` (return all results).
     *     @type string $pageToken A previously-returned page token used to
     *           resume the loading of results from a specific point.
     * }
     * @return ItemIterator<Table>
     */
    public function tables(array $options = [])
    {
        $resultLimit = $this->pluck('resultLimit', $options, false);

        return new ItemIterator(
            new PageIterator(
                function (array $table) {
                    return new Table(
                        $this->connection,
                        $table['tableReference']['tableId'],
                        $this->identity['datasetId'],
                        $this->identity['projectId'],
                        $this->mapper,
                        $table
                    );
                },
                [$this->connection, 'listTables'],
                $options + $this->identity,
                [
                    'itemsKey' => 'tables',
                    'resultLimit' => $resultLimit
                ]
            )
        );
    }

    /**
     * Creates a table.
     *
     * Please note that by default the library will not attempt to retry this
     * call on your behalf.
     *
     * Example:
     * ```
     * $table = $dataset->createTable('aTable');
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/tables/insert Tables insert API documentation.
     *
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type array $metadata The available options for metadata are outlined
     *           at the
     *           [Table Resource API docs](https://cloud.google.com/bigquery/docs/reference/rest/v2/tables)
     * }
     * @return Table
     */
    public function createTable($id, array $options = [])
    {
        if (isset($options['metadata'])) {
            $options += $options['metadata'];
            unset($options['metadata']);
        }

        $response = $this->connection->insertTable(
            [
                'projectId' => $this->identity['projectId'],
                'datasetId' => $this->identity['datasetId'],
                'tableReference' => $this->identity + ['tableId' => $id]
            ]
            + $options
            + ['retries' => 0]
        );

        return new Table(
            $this->connection,
            $id,
            $this->identity['datasetId'],
            $this->identity['projectId'],
            $this->mapper,
            $response
        );
    }

    /**
     * Lazily instantiates a machine learning model in the dataset.
     *
     * There are no network requests made at this point. To see the operations
     * that can be performed on a model, please see {@see Model}.
     *
     * Example:
     * ```
     * $model = $dataset->model('my_model');
     * echo $model->id();
     * ```
     *
     * @param string $id The model's ID.
     * @param array $info [optional] The model resource data.
     * @return Model
     */
    public function model($id, array $info = [])
    {
        return new Model(
            $this->connection,
            $id,
            $this->identity['datasetId'],
            $this->identity['projectId'],
            $info,
            isset($this->info['location'])
                ? $this->info['location']
                : $this->location
        );
    }

    /**
     * Fetches all of the models in the dataset.
     *
     * Please note that Model instances obtained from this method contain only a
     * subset of the resource representation. Fields returned include
     * `modelReference`, `modelType`, `creationTime`, `lastModifiedTime` and
     * `labels`. To obtain a full representation, call
     * {@see Model::reload()}.
     *
     * Example:
     * ```
     * $models = $dataset->models();
     *
     * foreach ($models as $model) {
     *     echo $model->id() . PHP_EOL;
     * }
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/models/list Models list API documentation.
     *
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type int $maxResults Maximum number of results to return per page.
     *     @type int $resultLimit Limit the number of results returned in total.
     *           **Defaults to** `0` (return all results).
     *     @type string $pageToken A previously-returned page token used to
     *           resume the loading of results from a specific point.
     * }
     * @return ItemIterator<Model>
     */
    public function models(array $options = [])
    {
        $resultLimit = $this->pluck('resultLimit', $options, false);
        $datasetId = $this->identity['datasetId'];
        $projectId = $this->identity['projectId'];

        return new ItemIterator(
            new PageIterator(
                function (array $model) {
                    return $this->model($model['modelReference']['modelId'], $model);
                },
                [$this->connection, 'listModels'],
                ['projectId' => $projectId, 'datasetId' => $datasetId] + $options,
                [
                    'itemsKey' => 'models',
                    'resultLimit' => $resultLimit
                ]
            )
        );
    }

    /**
     * Lazily instantiates a routine.
     *
     * There are no network requests made at this point. To see the operations
     * that can be performed on a routine, please see
     * {@see Routine}.
     *
     * Example:
     * ```
     * $routine = $dataset->routine('my_routine');
     * echo $routine->identity()['routineId'];
     * ```
     *
     * @param string $id The routine's ID.
     * @param array $info [optional] The routine resource data.
     * @return Routine
     */
    public function routine($id, array $info = [])
    {
        return new Routine(
            $this->connection,
            $id,
            $this->identity['datasetId'],
            $this->identity['projectId'],
            $info
        );
    }

    /**
     * Fetches all of the routines in the dataset.
     *
     * Please note that Routine instances obtained from this method contain only a
     * subset of the resource representation. Fields returned include `etag`,
     * `projectId`, `datasetId`, `routineId`, `routineType`, `creationTime`,
     * `lastModifiedTime` and `language`. To obtain a full representation, call
     * {@see Routine::reload()}.
     *
     * Example:
     * ```
     * $routines = $dataset->routines();
     *
     * foreach ($routines as $routine) {
     *     echo $routine->identity()['routineId'] . PHP_EOL;
     * }
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/routines/list List Routines API documentation.
     *
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type int $maxResults Maximum number of results to return per page.
     *     @type int $resultLimit Limit the number of results returned in total.
     *           **Defaults to** `0` (return all results).
     *     @type string $pageToken A previously-returned page token used to
     *           resume the loading of results from a specific point.
     * }
     * @return ItemIterator<Model>
     */
    public function routines(array $options = [])
    {
        $resultLimit = $this->pluck('resultLimit', $options, false);

        return new ItemIterator(
            new PageIterator(
                function (array $routine) {
                    return $this->routine($routine['routineReference']['routineId'], $routine);
                },
                [$this->connection, 'listRoutines'],
                $this->identity + $options,
                [
                    'itemsKey' => 'routines',
                    'resultLimit' => $resultLimit
                ]
            )
        );
    }

    /**
     * Creates a routine.
     *
     * Please note that by default the library will not attempt to retry this
     * call on your behalf.
     *
     * Example:
     * ```
     * $routine = $dataset->createRoutine('my_routine', [
     *     'routineType' => 'SCALAR_FUNCTION',
     *     'definitionBody' => 'concat(x, "\n", y)',
     *     'arguments' => [
     *         [
     *             'name' => 'x',
     *             'dataType' => [
     *                 'typeKind' => 'STRING'
     *             ]
     *         ], [
     *             'name' => 'y',
     *             'dataType' => [
     *                 'typeKind' => 'STRING'
     *             ]
     *         ]
     *     ]
     * ]);
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/routines/insert Insert Routines API documentation.
     *
     * @param string $id The routine ID.
     * @param array $metadata The available options for metadata are outlined at the
     *        [Routine Resource API docs](https://cloud.google.com/bigquery/docs/reference/rest/v2/routines).
     *        Omit `routineReference` as it is computed and appended by the
     *        client.
     * @param array $options [optional] Configuration options.
     * @return Routine
     */
    public function createRoutine($id, array $metadata, array $options = [])
    {
        $metadata = [
            'routineReference' => $this->identity + ['routineId' => $id]
        ] + $metadata;

        $response = $this->connection->insertRoutine(
            $this->identity
            + $metadata
            + $options
            + ['retries' => 0]
        );

        return $this->routine($id, $response);
    }

    /**
     * Retrieves the dataset's details. If no dataset data is cached a network
     * request will be made to retrieve it.
     *
     * Example:
     * ```
     * $info = $dataset->info();
     * echo $info['selfLink'];
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/datasets Datasets resource documentation.
     *
     * @param array $options [optional] Configuration options.
     * @return array
     */
    public function info(array $options = [])
    {
        if (!$this->info) {
            $this->reload($options);
        }

        return $this->info;
    }

    /**
     * Triggers a network request to reload the dataset's details.
     *
     * Example:
     * ```
     * $dataset->reload();
     * $info = $dataset->info();
     * echo $info['selfLink'];
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/rest/v2/datasets/get Datasets get API documentation.
     *
     * @param array $options [optional] Configuration options.
     * @return array
     */
    public function reload(array $options = [])
    {
        return $this->info = $this->connection->getDataset($options + $this->identity);
    }

    /**
     * Retrieves the dataset's ID.
     *
     * Example:
     * ```
     * echo $dataset->id();
     * ```
     *
     * @return string
     */
    public function id()
    {
        return $this->identity['datasetId'];
    }

    /**
     * Retrieves the dataset's identity.
     *
     * An identity provides a description of a resource that is nested in nature.
     *
     * Example:
     * ```
     * echo $dataset->identity()['projectId'];
     * ```
     *
     * @return array
     */
    public function identity()
    {
        return $this->identity;
    }
}
