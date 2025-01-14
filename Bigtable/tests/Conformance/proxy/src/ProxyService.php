<?php
/**
 * Sample GRPC PHP server.
 */

use Google\Bigtable\Testproxy;
use Google\ApiCore\Serializer;
use Google\ApiCore\InsecureCredentialsWrapper;
use Google\Cloud\Bigtable\BigtableClient;
use Google\Cloud\Bigtable\V2\Client\BigtableClient as BigtableGapicClient;
use Google\Cloud\Bigtable\V2\ReadRowsRequest;
use Google\Cloud\Bigtable\V2\CheckAndMutateRowResponse;
use Google\Cloud\Bigtable\V2\MutateRowsResponse\Entry;
use Google\Cloud\Bigtable\V2\MutateRowResponse;
use Google\Cloud\Bigtable\V2\MutateRowsResponse;
use Google\Cloud\Bigtable\V2\RowSet;
use Google\Cloud\Bigtable\V2\Row;
use Google\Cloud\Bigtable\ChunkFormatter;
use Grpc\ChannelCredentials;
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Spiral\RoadRunner\GRPC;
use Spiral\RoadRunner\KeyValue\Cache;
use Spiral\RoadRunner\KeyValue\Factory;
use Spiral\Goridge\RPC\RPC;
use Google\Rpc\Status;
use Google\Protobuf\Internal\RepeatedField;
use Google\ApiCore\ServerStream;
use Google\Cloud\Bigtable\Mutations;
use Google\Cloud\Bigtable\Exception\BigtableDataOperationException;

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
        [$client, $config] = $this->getClientAndConfig($in->getClientId());

        $tableName = BigtableClient::tableName($config->getProjectId(), $config->getInstanceId(), $in->getTableName());
        $request = new ReadRowsRequest([
            'table_name' => $tableName,
            'filter' => $in->getFilter(),
            'app_profile_id' => $config->getProfileId(),
            'rows' => $this->serializer->decodeMessage(
                new RowSet(),
                ['rowKeys' => [$in->getRowKey()]],
            ),
        ]);
        $chunkFormatter = new ChunkFormatter($client, $request, [
            'timeoutMillis' => $this->getTimeoutMillis($config->getPerOperationTimeout()),
        ]);
        $out = new Testproxy\RowResult();
        foreach ($chunkFormatter->readAll() as $row) {
            $row = $this->serializer->decodeMessage(new Row(), $row);
            $out->setRow($row);
            break;
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
        [$client, $config] = $this->getClientAndConfig($in->getClientId());

        $request = $in->getRequest();
        $chunkFormatter = new ChunkFormatter($client, $request, [
            'timeoutMillis' => $this->getTimeoutMillis($config->getPerOperationTimeout()),
        ]);
        $rows = [];
        $i = 0;
        foreach ($chunkFormatter->readAll() as $row) {
            if ($i++ >= $in->getCancelAfterRows()) {
                break;
            }
            $rows[] = $this->serializer->decodeMessage(new Row(), $row);
        }
        $out = new Testproxy\RowsResult(['rows' => $rows]);

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

        try {
            $stream = $table->mutateRows($mutations, [
                'timeoutMillis' => $this->getTimeoutMillis($config->getPerOperationTimeout())
            ]);
        } catch (BigtableDataOperationException $e) {
            var_dump($e);
            $failedEntries = [];
            foreach ($e->getMetadata() as $metadata) {
                $status = new Status([
                    'code' => $metadata['statusCode'],
                    'message' => $metadata['message'],
                ]);
                $failedEntries[] = new Entry([
                    'index' => (int) $metadata['index'],
                    'status' => $status,
                ]);
            }
            return $out->setEntries($failedEntries);
        } catch (\Google\ApiCore\ApiException $e) {
            var_dump($e);
            return $out->setStatus(new Status([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ]));
        }
        echo "HERE";

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
        return new Testproxy\SampleRowKeysResult();
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
        // NEXT
        return new Testproxy\RowResult();
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
        return new Testproxy\ExecuteQueryResult();
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

    private function protoToMutations(RepeatedField|null $protoMutations): Mutations|null
    {
        if (!$protoMutations) {
            return null;
        }
        $mutations = new Mutations();
        $reflection = new \ReflectionClass($mutations);
        $property = $reflection->getProperty('mutations');
        $property->setAccessible(true);
        $property->setValue($mutations, $protoMutations);

        return $mutations;
    }
}
