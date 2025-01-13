<?php
/**
 * Sample GRPC PHP server.
 */

use Google\Bigtable\Testproxy;
use Google\ApiCore\Serializer;
use Google\ApiCore\InsecureCredentialsWrapper;
use Google\Cloud\Bigtable\V2\Client\BigtableClient;
use Google\Cloud\Bigtable\V2\ReadRowsRequest;
use Google\Cloud\Bigtable\V2\RowSet;
use Google\Cloud\Bigtable\V2\Row;
use Google\Cloud\Bigtable\ChunkFormatter;
use Spiral\RoadRunner\GRPC;

class ProxyService implements Testproxy\CloudBigtableV2TestProxyInterface
{
    /** @var CreateClientRequest[] */
    private array $clientConfigs = [];

    /** @var BigtableClient[] */
    private array $clients = [];

    private Serializer $serializer;

    public function __construct()
    {
        $this->serializer = new Serializer();
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
        $this->clientConfigs[$in->getClientId()] = $in;

        $this->clients[$in->getClientId()] = new BigtableClient([
            'projectId' => $in->getProjectId(),
            'apiEndpoint' => $in->getDataTarget(),
            'credentials' => new InsecureCredentialsWrapper(),
            'hasEmulator' => true,
        ]);

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
        [$client, $_] = $this->getClientAndConfig($in->getClientId());
        $client->close();

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
        unset($this->clientConfigs[$in->getClientId()]);
        unset($this->clients[$in->getClientId()]);

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
            'app_profile_id' => $config->getAppProfileId(),
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
        return new Testproxy\MutateRowResult();
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
        return new Testproxy\MutateRowsResult();
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
        [$client, $config] = $this->getClientAndConfig($in->getClientId());
        $response = $client->checkAndMutateRow($in->getRequest(), [
            'timeoutMillis' => $this->getTimeoutMillis($config->getPerOperationTimeout()),
        ]);

        return new Testproxy\CheckAndMutateRowResult(['result' => $response]);
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
     * @return array{0:BigtableClient, 1:CreateClientRequest}
     */
    private function getClientAndConfig(string $clientId): array
    {
        if (!isset($this->clients[$clientId]) || !isset($this->clients[$clientId])) {
            throw new \Exception(sprintf('Client ID "%s" not found', $clientId));
        }

        $client = $this->clients[$clientId];
        $config = $this->clientConfigs[$clientId];

        return [$client, $config];
    }

    public function getTimeoutMillis(?\Google\Protobuf\Duration $timeout): ?int
    {
        if ($timeout === null) {
            return null;
        }
        return ($timeout->getSeconds() * 1000) + ($timeout->getNanos() / 1000000);
    }
}
