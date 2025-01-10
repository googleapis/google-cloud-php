<?php
/**
 * Sample GRPC PHP server.
 */

use Google\Bigtable\Testproxy\CloudBigtableV2TestProxyInterface;
use Google\Bigtable\Testproxy\CreateClientResponse;
use Google\Bigtable\Testproxy\CloseClientResponse;
use Google\Bigtable\Testproxy\RemoveClientResponse;
use Google\Bigtable\Testproxy\RowResult;
use Google\Bigtable\Testproxy\RowsResult;
use Google\Bigtable\Testproxy\MutateRowResult;
use Google\Bigtable\Testproxy\MutateRowsResult;
use Google\Bigtable\Testproxy\CheckAndMutateRowResult;
use Google\Bigtable\Testproxy\SampleRowKeysResult;
use Google\Bigtable\Testproxy\ExecuteQueryResult;
use Google\Bigtable\Testproxy\CreateClientRequest;
use Google\Bigtable\Testproxy\CloseClientRequest;
use Google\Bigtable\Testproxy\RemoveClientRequest;
use Google\Bigtable\Testproxy\ReadRowRequest as ProxyReadRowRequest;
use Google\Bigtable\Testproxy\ReadRowsRequest as ProxyReadRowsRequest;
use Google\Bigtable\Testproxy\MutateRowRequest;
use Google\Bigtable\Testproxy\MutateRowsRequest;
use Google\Bigtable\Testproxy\CheckAndMutateRowRequest;
use Google\Bigtable\Testproxy\SampleRowKeysRequest;
use Google\Bigtable\Testproxy\ReadModifyWriteRowRequest;
use Google\Bigtable\Testproxy\ExecuteQueryRequest;
use Google\Cloud\Bigtable\V2\Client\BigtableClient;
use Google\Cloud\Bigtable\V2\ReadRowsRequest;
use Google\Cloud\Bigtable\V2\RowSet;
use Google\Cloud\Bigtable\V2\Row;
use Google\ApiCore\Serializer;
use Google\Cloud\Bigtable\ChunkFormatter;
use Spiral\RoadRunner\GRPC;

class ProxyService implements CloudBigtableV2TestProxyInterface
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
    public function CreateClient(GRPC\ContextInterface $ctx, CreateClientRequest $in): CreateClientResponse
    {
        $this->clientConfigs[$in->getClientId()] = $in;

        $this->clients[$in->getClientId()] = new BigtableClient([
            'projectId' => $in->getProjectId(),
            'apiEndpoint' => $in->getDataTarget(),
        ]);

        return new CreateClientResponse();
    }

    /**
    * @param GRPC\ContextInterface $ctx
    * @param CloseClientRequest $in
    * @return CloseClientResponse
    *
    * @throws GRPC\Exception\InvokeException
    */
    public function CloseClient(GRPC\ContextInterface $ctx, CloseClientRequest $in): CloseClientResponse
    {
        [$client, $_] = $this->getClientAndConfig($in->getClientId());
        $client->close();

        return new CloseClientResponse();
    }

    /**
    * @param GRPC\ContextInterface $ctx
    * @param RemoveClientRequest $in
    * @return RemoveClientResponse
    *
    * @throws GRPC\Exception\InvokeException
    */
    public function RemoveClient(GRPC\ContextInterface $ctx, RemoveClientRequest $in): RemoveClientResponse
    {
        unset($this->clientConfigs[$in->getClientId()]);
        unset($this->clients[$in->getClientId()]);

        return new RemoveClientResponse();
    }

    /**
    * @param GRPC\ContextInterface $ctx
    * @param ReadRowRequest $in
    * @return RowResult
    *
    * @throws GRPC\Exception\InvokeException
    */
    public function ReadRow(GRPC\ContextInterface $ctx, ProxyReadRowRequest $in): RowResult
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
            'timeout' => $config->getPerOperationTimeout(),
        ]);
        $out = new RowResult();
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
    public function ReadRows(GRPC\ContextInterface $ctx, ProxyReadRowsRequest $in): RowsResult
    {
        [$client, $config] = $this->getClientAndConfig($in->getClientId());

        $request = $in->getRequest();
        $chunkFormatter = new ChunkFormatter($client, $request, [
            'timeout' => $config->getPerOperationTimeout(),
        ]);
        $rows = [];
        $i = 0;
        foreach ($chunkFormatter->readAll() as $row) {
            if ($i++ >= $in->getCancelAfterRows()) {
                break;
            }
            $rows[] = $this->serializer->decodeMessage(new Row(), $row);
        }
        $out = new RowsResult(['rows' => $rows]);

        return $out;
    }

    /**
    * @param GRPC\ContextInterface $ctx
    * @param MutateRowRequest $in
    * @return MutateRowResult
    *
    * @throws GRPC\Exception\InvokeException
    */
    public function MutateRow(GRPC\ContextInterface $ctx, MutateRowRequest $in): MutateRowResult
    {
        return new MutateRowResult();
    }

    /**
    * @param GRPC\ContextInterface $ctx
    * @param MutateRowsRequest $in
    * @return MutateRowsResult
    *
    * @throws GRPC\Exception\InvokeException
    */
    public function BulkMutateRows(GRPC\ContextInterface $ctx, MutateRowsRequest $in): MutateRowsResult
    {
        return new MutateRowsResult();
    }

    /**
    * @param GRPC\ContextInterface $ctx
    * @param CheckAndMutateRowRequest $in
    * @return CheckAndMutateRowResult
    *
    * @throws GRPC\Exception\InvokeException
    */
    public function CheckAndMutateRow(GRPC\ContextInterface $ctx, CheckAndMutateRowRequest $in): CheckAndMutateRowResult
    {
        return new CheckAndMutateRowResult();
    }

    /**
    * @param GRPC\ContextInterface $ctx
    * @param SampleRowKeysRequest $in
    * @return SampleRowKeysResult
    *
    * @throws GRPC\Exception\InvokeException
    */
    public function SampleRowKeys(GRPC\ContextInterface $ctx, SampleRowKeysRequest $in): SampleRowKeysResult
    {
        return new SampleRowKeysResult();
    }

    /**
    * @param GRPC\ContextInterface $ctx
    * @param ReadModifyWriteRowRequest $in
    * @return RowResult
    *
    * @throws GRPC\Exception\InvokeException
    */
    public function ReadModifyWriteRow(GRPC\ContextInterface $ctx, ReadModifyWriteRowRequest $in): RowResult
    {
        return new RowResult();
    }

    /**
    * @param GRPC\ContextInterface $ctx
    * @param ExecuteQueryRequest $in
    * @return ExecuteQueryResult
    *
    * @throws GRPC\Exception\InvokeException
    */
    public function ExecuteQuery(GRPC\ContextInterface $ctx, ExecuteQueryRequest $in): ExecuteQueryResult
    {
        return new ExecuteQueryResult();
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
}
