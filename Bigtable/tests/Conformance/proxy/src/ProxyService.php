<?php
/**
 * Sample GRPC PHP server.
 */

use Google\ApiCore\Serializer;
use Google\ApiCore\InsecureCredentialsWrapper;
use Google\Bigtable\Testproxy;
use Google\Cloud\Bigtable\BigtableClient;
use Google\Cloud\Bigtable\Mutations;
use Google\Cloud\Bigtable\ReadModifyWriteRowRules;
use Google\Cloud\Bigtable\Exception\BigtableDataOperationException;
use Google\Cloud\Bigtable\V2\Cell;
use Google\Cloud\Bigtable\V2\Client\BigtableClient as BigtableGapicClient;
use Google\Cloud\Bigtable\V2\CheckAndMutateRowResponse;
use Google\Cloud\Bigtable\V2\Column;
use Google\Cloud\Bigtable\V2\Family;
use Google\Cloud\Bigtable\V2\MutateRowsResponse\Entry;
use Google\Cloud\Bigtable\V2\ProtoRows;
use Google\Cloud\Bigtable\V2\ReadModifyWriteRule;
use Google\Cloud\Bigtable\V2\ReadRowsRequest;
use Google\Cloud\Bigtable\V2\Row;
use Google\Cloud\Bigtable\V2\SampleRowKeysResponse;
use Google\Protobuf\RepeatedField;
use Google\Rpc\Status;
use Grpc\ChannelCredentials;
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Spiral\RoadRunner\GRPC;
use Spiral\RoadRunner\KeyValue\Cache;
use Spiral\RoadRunner\KeyValue\Factory;
use Spiral\Goridge\RPC\RPC;

class ProxyService implements Testproxy\CloudBigtableV2TestProxyInterface
{
    private Serializer $serializer;

    private Logger $logger;

    private Cache $cache;

    public function __construct()
    {
        $this->serializer = new Serializer();

        // create a log channel
        $this->logger = new Logger('name');
        $this->logger->pushHandler(new StreamHandler('php://stderr'), Level::Debug);

        // create a shared cache between workers
        // Manual configuration
        $rpc = RPC::create('tcp://127.0.0.1:6001');
        $factory = new Factory($rpc);

        $this->cache = $factory->select('memory-cache');
    }

    /**
    * @param GRPC\ContextInterface $ctx
    * @param CreateClientRequest $in
    * @return CreateClientResponse
    *
    * @throws GRPC\Exception\InvokeException
    */
    public function CreateClient(GRPC\ContextInterface $ctx, Testproxy\CreateClientRequest $in): Testproxy\CreateClientResponse
    {
        $this->logger->debug($in->serializeToJsonString());

        $this->cache->set($in->getClientId(), $in);

        return new Testproxy\CreateClientResponse();
    }

    /**
    * @param GRPC\ContextInterface $ctx
    * @param CloseClientRequest $in
    * @return CloseClientResponse
    *
    * @throws GRPC\Exception\InvokeException
    */
    public function CloseClient(GRPC\ContextInterface $ctx, Testproxy\CloseClientRequest $in): Testproxy\CloseClientResponse
    {
        $this->getClientAndConfig($in->getClientId());

        // Because our caching cannot store open channels, we implement a workaround here to close
        // the client when its retrieved from the cache.
        $this->cache->set($in->getClientId() . '-closed', true);

        return new Testproxy\CloseClientResponse();
    }

    /**
    * @param GRPC\ContextInterface $ctx
    * @param RemoveClientRequest $in
    * @return RemoveClientResponse
    *
    * @throws GRPC\Exception\InvokeException
    */
    public function RemoveClient(GRPC\ContextInterface $ctx, Testproxy\RemoveClientRequest $in): Testproxy\RemoveClientResponse
    {
        $this->cache->delete($in->getClientId());
        $this->cache->delete($in->getClientId() . '-closed');

        return new Testproxy\RemoveClientResponse();
    }

    /**
    * @param GRPC\ContextInterface $ctx
    * @param ReadRowRequest $in
    * @return RowResult
    *
    * @throws GRPC\Exception\InvokeException
    */
    public function ReadRow(GRPC\ContextInterface $ctx, Testproxy\ReadRowRequest $in): Testproxy\RowResult
    {
        $this->logger->debug($in->serializeToJsonString());

        $out = new Testproxy\RowResult();

        [$client, $config] = $this->getClientAndConfig($in->getClientId());

        if (!$client) {
            // This is a workaround to simulate when the client is closed.
            return $out->setStatus(new Status([
                'code' => 1,
                'message' => 'Client is closed',
            ]));
        }

        $parts = BigtableGapicClient::parseName($in->getTableName());
        $table = $client->table($parts['instance'], $parts['table'], [
            'appProfileId' => $config->getAppProfileId(),
        ]);

        $timeoutMillis = $this->getTimeoutMillis($config->getPerOperationTimeout());
        try {
            $rowData = $table->readRow($in->getRowKey(), [
                'filter' => $in->getFilter(),
                'retrySettings' => [
                    // set total timeout for the operation (including retries)
                    'totalTimeoutMillis' => $timeoutMillis,
                ],
                // the conformance tests check for this, but I'm not sure why
                'rowsLimit' => 1,
            ]);
        } catch (\Google\ApiCore\ApiException $e) {
            return $out->setStatus(new Status([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ]));
        }

        if ($rowData) {
            $row = $this->arrayToRowProto($rowData);
            $row->setKey($in->getRowKey());
            $out->setRow($row);
        } else {
            $this->logger->debug(json_encode($rowData));
        }

        return $out;
    }

    /**
    * @param GRPC\ContextInterface $ctx
    * @param ReadRowsRequest $in
    * @return RowsResult
    *
    * @throws GRPC\Exception\InvokeException
    */
    public function ReadRows(GRPC\ContextInterface $ctx, Testproxy\ReadRowsRequest $in): Testproxy\RowsResult
    {
        $this->logger->debug($in->serializeToJsonString());

        $out = new Testproxy\RowsResult();

        [$client, $config] = $this->getClientAndConfig($in->getClientId());

        if (!$client) {
            // This is a workaround to simulate when the client is closed.
            return $out->setStatus(new Status([
                'code' => 1,
                'message' => 'Client is closed',
            ]));
        }

        $request = $in->getRequest();
        $parts = BigtableGapicClient::parseName($request->getTableName());
        $table = $client->table($parts['instance'], $parts['table'], [
            'appProfileId' => $config->getAppProfileId(),
        ]);

        $ranges = [];
        $rowKeys = [];
        if ($rowSet = $request->getRows()) {
            $rowKeys = iterator_to_array($rowSet->getRowKeys());
            foreach ($rowSet->getRowRanges() as $range) {
                $this->logger->debug($range->serializeToJsonString());
                $ranges[] = array_filter([
                    'startKeyOpen' => $range->getStartKeyOpen(),
                    'startKeyClosed' => $range->getStartKeyClosed(),
                    'endKeyOpen' => $range->getEndKeyOpen(),
                    'endKeyClosed' => $range->getEndKeyClosed(),
                ]);
            }
        }

        $this->logger->debug(json_encode($rowKeys));

        $timeoutMillis = $this->getTimeoutMillis($config->getPerOperationTimeout());
        $stream = $table->readRows([
            'rowKeys' => $rowKeys,
            'rowRanges' => $ranges,
            'filter' => $request->getFilter(),
            'rowsLimit' => $request->getRowsLimit(),
            'reversed' => $request->getReversed(),
            'retrySettings' => [
                'totalTimeoutMillis' => $timeoutMillis,
            ],
        ]);

        $rows = [];
        $rowCount = 0;
        $cancelAfterRows = $in->getCancelAfterRows();
        try {
            foreach ($stream as $key => $rowData) {
                $row = $this->arrayToRowProto($rowData);
                $row->setKey($key);
                $rows[] = $row;
                if ($cancelAfterRows && ++$rowCount >= $cancelAfterRows) {
                    break;
                }
            }
        } catch (\Google\ApiCore\ApiException $e) {
            return $out->setStatus(new Status([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ]));
        }

        $out->setRows($rows);

        $this->logger->debug($out->serializeToJsonString());

        return $out;
    }

    /**
    * @param GRPC\ContextInterface $ctx
    * @param MutateRowRequest $in
    * @return MutateRowResult
    *
    * @throws GRPC\Exception\InvokeException
    */
    public function MutateRow(GRPC\ContextInterface $ctx, Testproxy\MutateRowRequest $in): Testproxy\MutateRowResult
    {
        $this->logger->debug($in->serializeToJsonString());

        $out = new Testproxy\MutateRowResult();

        [$client, $config] = $this->getClientAndConfig($in->getClientId());

        if (!$client) {
            // This is a workaround to simulate when the client is closed.
            return $out->setStatus(new Status([
                'code' => 1,
                'message' => 'Client is closed',
            ]));
        }

        $request = $in->getRequest();
        $parts = BigtableGapicClient::parseName($request->getTableName());
        $table = $client->table($parts['instance'], $parts['table'], [
            'appProfileId' => $config->getAppProfileId(),
        ]);

        try {
            $table->mutateRow(
                $request->getRowKey(),
                $this->protoToMutations($request->getMutations()),
                ['timeoutMillis' => $this->getTimeoutMillis($config->getPerOperationTimeout())],
            );
        } catch (\Google\ApiCore\ApiException $e) {
            return $out->setStatus(new Status([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ]));
        }

        return $out;
    }

    /**
    * @param GRPC\ContextInterface $ctx
    * @param MutateRowsRequest $in
    * @return MutateRowsResult
    *
    * @throws GRPC\Exception\InvokeException
    */
    public function BulkMutateRows(GRPC\ContextInterface $ctx, Testproxy\MutateRowsRequest $in): Testproxy\MutateRowsResult
    {
        $this->logger->debug($in->serializeToJsonString());

        $out = new Testproxy\MutateRowsResult();

        [$client, $config] = $this->getClientAndConfig($in->getClientId());

        if (!$client) {
            // This is a workaround to simulate when the client is closed.
            return $out->setStatus(new Status([
                'code' => 1,
                'message' => 'Client is closed',
            ]));
        }

        $request = $in->getRequest();
        $parts = BigtableGapicClient::parseName($request->getTableName());
        $table = $client->table($parts['instance'], $parts['table'], [
            'appProfileId' => $config->getAppProfileId(),
        ]);

        $mutations = [];
        foreach ($request->getEntries() as $entry) {
            $mutations[$entry->getRowKey()] = $this->protoToMutations($entry->getMutations());
        }

        $timeoutMillis = $this->getTimeoutMillis($config->getPerOperationTimeout());
        try {
            $table->mutateRows($mutations, [
                'retrySettings' => [
                    'totalTimeoutMillis' => $timeoutMillis,
                ]
            ]);
        } catch (BigtableDataOperationException $e) {
            $failedEntries = [];
            foreach ($e->getMetadata() as $metadata) {
                $failedEntries[] = new Entry([
                    'index' => $metadata['index'] ?? 0,
                    'status' => new Status([
                        'code' => $metadata['statusCode'],
                        'message' => $metadata['message'],
                    ]),
                ]);
            }
            $out->setEntries($failedEntries);
            $out->setStatus(new Status([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ]));
        } catch (\Google\ApiCore\ApiException $e) {
            $out->setStatus(new Status([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ]));
        }

        $this->logger->debug($out->serializeToJsonString());

        return $out;
    }

    /**
    * @param GRPC\ContextInterface $ctx
    * @param CheckAndMutateRowRequest $in
    * @return CheckAndMutateRowResult
    *
    * @throws GRPC\Exception\InvokeException
    */
    public function CheckAndMutateRow(GRPC\ContextInterface $ctx, Testproxy\CheckAndMutateRowRequest $in): Testproxy\CheckAndMutateRowResult
    {
        $this->logger->debug($in->serializeToJsonString());

        $out = new Testproxy\CheckAndMutateRowResult();

        [$client, $config] = $this->getClientAndConfig($in->getClientId());

        if (!$client) {
            // This is a workaround to simulate when the client is closed.
            return $out->setStatus(new Status([
                'code' => 1,
                'message' => 'Client is closed',
            ]));
        }

        $request = $in->getRequest();
        $parts = BigtableGapicClient::parseName($request->getTableName());
        $table = $client->table($parts['instance'], $parts['table'], [
            'appProfileId' => $config->getAppProfileId(),
        ]);

        try {
            $predicateMatched = $table->checkAndMutateRow($request->getRowKey(), [
                'trueMutations' => $this->protoToMutations($request->getTrueMutations()),
                'falseMutations' => $this->protoToMutations($request->getFalseMutations()),
                'timeoutMillis' => $this->getTimeoutMillis($config->getPerOperationTimeout()),
            ]);
        } catch (\Google\ApiCore\ApiException $e) {
            return $out->setStatus(new Status([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ]));
        }

        $result = new CheckAndMutateRowResponse();
        $result->setPredicateMatched($predicateMatched);

        return $out->setResult($result);
    }

    /**
    * @param GRPC\ContextInterface $ctx
    * @param SampleRowKeysRequest $in
    * @return SampleRowKeysResult
    *
    * @throws GRPC\Exception\InvokeException
    */
    public function SampleRowKeys(GRPC\ContextInterface $ctx, Testproxy\SampleRowKeysRequest $in): Testproxy\SampleRowKeysResult
    {
        $this->logger->debug($in->serializeToJsonString());

        $out = new Testproxy\SampleRowKeysResult();

        [$client, $config] = $this->getClientAndConfig($in->getClientId());

        if (!$client) {
            // This is a workaround to simulate when the client is closed.
            return $out->setStatus(new Status([
                'code' => 1,
                'message' => 'Client is closed',
            ]));
        }

        $request = $in->getRequest();
        $parts = BigtableGapicClient::parseName($request->getTableName());
        $table = $client->table($parts['instance'], $parts['table'], [
            'appProfileId' => $config->getAppProfileId(),
        ]);

        $sampleRows = $table->sampleRowKeys([
            'authorizedViewName' => $request->getAuthorizedViewName(),
            'timeoutMillis' => $this->getTimeoutMillis($config->getPerOperationTimeout()),
        ]);

        try {
            $responses = [];
            foreach ($sampleRows as $sampleRow) {
                $response = new SampleRowKeysResponse();
                $response->setRowKey($sampleRow['rowKey']);
                $response->setOffsetBytes($sampleRow['offset']);
                $responses[] = $response;
            }
        } catch (\Google\ApiCore\ApiException $e) {
            return $out->setStatus(new Status([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ]));
        }

        return $out->setSamples($responses);
    }

    /**
    * @param GRPC\ContextInterface $ctx
    * @param ReadModifyWriteRowRequest $in
    * @return RowResult
    *
    * @throws GRPC\Exception\InvokeException
    */
    public function ReadModifyWriteRow(GRPC\ContextInterface $ctx, Testproxy\ReadModifyWriteRowRequest $in): Testproxy\RowResult
    {
        $this->logger->debug($in->serializeToJsonString());

        $out = new Testproxy\RowResult();

        [$client, $config] = $this->getClientAndConfig($in->getClientId());

        if (!$client) {
            // This is a workaround to simulate when the client is closed.
            return $out->setStatus(new Status([
                'code' => 1,
                'message' => 'Client is closed',
            ]));
        }

        $request = $in->getRequest();
        $parts = BigtableGapicClient::parseName($request->getTableName());
        $table = $client->table($parts['instance'], $parts['table'], [
            'appProfileId' => $config->getAppProfileId(),
        ]);

        try {
            $rowData = $table->readModifyWriteRow(
                $request->getRowKey(),
                $this->protoToRowRules($request->getRules()),
                [
                    'timeoutMillis' => $this->getTimeoutMillis($config->getPerOperationTimeout()),
                ]
            );
        } catch (\Google\ApiCore\ApiException $e) {
            return $out->setStatus(new Status([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ]));
        }

        $row = $this->arrayToRowProto($rowData);
        $row->setKey($request->getRowKey());

        return $out->setRow($row);
    }

    /**
    * @param GRPC\ContextInterface $ctx
    * @param ExecuteQueryRequest $in
    * @return ExecuteQueryResult
    *
    * @throws GRPC\Exception\InvokeException
    */
    public function ExecuteQuery(GRPC\ContextInterface $ctx, Testproxy\ExecuteQueryRequest $in): Testproxy\ExecuteQueryResult
    {
        $this->logger->debug($in->serializeToJsonString());

        $out = new Testproxy\ExecuteQueryResult();

        [$client, $config] = $this->getClientAndConfig($in->getClientId());

        if (!$client) {
            // This is a workaround to simulate when the client is closed.
            return $out->setStatus(new Status([
                'code' => 1,
                'message' => 'Client is closed',
            ]));
        }

        // There is no ExecuteQuery method in the Bigtable handwritten client, so we will test the
        // GAPIC generated client directly.
        $client = new BigtableGapicClient([
            'projectId' => $config->getProjectId(),
            'apiEndpoint' => $config->getDataTarget(),
            'credentials' => new InsecureCredentialsWrapper(),
            'transportConfig' => [
                'grpc' => [
                    'stubOpts' => [
                        'credentials' => ChannelCredentials::createInsecure()
                    ]
                ]
            ],
        ]);

        $request = $in->getRequest();

        try {
            $stream = $client->executeQuery($request);
        } catch (\Google\ApiCore\ApiException $e) {
            return $out->setStatus(new Status([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ]));
        }

        $rows = [];
        $columns = [];
        /** @var ExecuteQueryResponse $response */
        foreach ($stream->readAll() as $response) {
            if ($metadata = $response->getMetadata()) {
                $columns = $metadata->getProtoSchema()->getColumns();
            }

            if ($partialResultSet = $response->getResults()) {
                $partialRows = $partialResultSet->getProtoRowsBatch();
                $data = $partialRows->getBatchData();
                $protoRows = new ProtoRows();
                $protoRows->mergeFromString($data);
                $row = new Testproxy\SqlRow();
                $row->setValues($protoRows->getValues());
                $rows[] = $row;
            }
        }

        $out->setRows($rows);
        $out->setMetadata(new Testproxy\ResultSetMetadata([
            'columns' => $columns,
        ]));

        return $out;
    }

    /**
     * @return array{0:?BigtableClient, 1:CreateClientRequest}
     */
    private function getClientAndConfig(string $clientId): array
    {
        if (!$this->cache->has($clientId)) {
            throw new \Exception(sprintf('Client ID "%s" not found', $clientId));
        }

        $config = $this->cache->get($clientId);

        // @see self::CloseClient
        if ($this->cache->has($clientId . '-closed')) {
            return [null, $config];
        }

        $client = new BigtableClient([
            'projectId' => $config->getProjectId(),
            'apiEndpoint' => $config->getDataTarget(),
            'credentials' => new InsecureCredentialsWrapper(),
            'transportConfig' => [
                'grpc' => [
                    'stubOpts' => [
                        'credentials' => ChannelCredentials::createInsecure()
                    ]
                ]
            ],
        ]);

        return [$client, $config];
    }

    private function getTimeoutMillis(?\Google\Protobuf\Duration $timeout): ?int
    {
        if ($timeout === null) {
            return null;
        }
        return ($timeout->getSeconds() * 1000) + ($timeout->getNanos() / 1000000);
    }

    /**
     * @param RepeatedField<Mutation> $protoRowRules
     * @return Mutations
     */
    private function protoToMutations(RepeatedField|null $protoMutations): Mutations|null
    {
        if (!$protoMutations) {
            return null;
        }
        $mutations = new Mutations();
        $reflection = new \ReflectionClass($mutations);
        $property = $reflection->getProperty('mutations');
        $property->setValue($mutations, $protoMutations);

        return $mutations;
    }

    /**
     * @param RepeatedField<ReadModifyWriteRule> $protoRowRules
     * @return ReadModifyWriteRowRules
     */
    private function protoToRowRules(RepeatedField $protoRowRules): ReadModifyWriteRowRules
    {
        $rowRules = new ReadModifyWriteRowRules();
        $reflection = new \ReflectionClass($rowRules);
        $property = $reflection->getProperty('rules');
        $property->setValue($rowRules, $protoRowRules);

        return $rowRules;
    }

    private function arrayToRowProto(array $rowData): Row
    {
        $row = new Row();
        $families = [];
        foreach ($rowData as $familyName => $qualifiers) {
            $f = new Family(['name' => $familyName]);
            $columns = [];
            foreach ($qualifiers as $qualifier => $values) {
                $column = new Column(['qualifier' => $qualifier]);
                $cells = [];
                foreach ($values as $value) {
                    $cell = new Cell();
                    $cell->setValue($value['value']);
                    $cell->setTimestampMicros($value['timeStamp']);
                    $cell->setLabels($value['labels'] ?: []);
                    $cells[] = $cell;
                }
                $column->setCells($cells);
                $columns[] = $column;
            }
            $f->setColumns($columns);
            $families[] = $f;
        }
        return $row->setFamilies($families);
    }
}
