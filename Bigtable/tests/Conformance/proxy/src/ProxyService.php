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
use Google\Bigtable\Testproxy\ReadRowRequest;
use Google\Bigtable\Testproxy\ReadRowsRequest;
use Google\Bigtable\Testproxy\MutateRowRequest;
use Google\Bigtable\Testproxy\MutateRowsRequest;
use Google\Bigtable\Testproxy\CheckAndMutateRowRequest;
use Google\Bigtable\Testproxy\SampleRowKeysRequest;
use Google\Bigtable\Testproxy\ReadModifyWriteRowRequest;
use Google\Bigtable\Testproxy\ExecuteQueryRequest;
use Spiral\RoadRunner\GRPC;

class ProxyService implements CloudBigtableV2TestProxyInterface
{

    /**
    * @param GRPC\ContextInterface $ctx
    * @param CreateClientRequest $in
    * @return CreateClientResponse
    *
    * @throws GRPC\Exception\InvokeException
    */
    public function CreateClient(GRPC\ContextInterface $ctx, CreateClientRequest $in): CreateClientResponse
    {
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
        return new RemoveClientResponse();
    }

    /**
    * @param GRPC\ContextInterface $ctx
    * @param ReadRowRequest $in
    * @return RowResult
    *
    * @throws GRPC\Exception\InvokeException
    */
    public function ReadRow(GRPC\ContextInterface $ctx, ReadRowRequest $in): RowResult
    {
        return new RowResult();
    }

    /**
    * @param GRPC\ContextInterface $ctx
    * @param ReadRowsRequest $in
    * @return RowsResult
    *
    * @throws GRPC\Exception\InvokeException
    */
    public function ReadRows(GRPC\ContextInterface $ctx, ReadRowsRequest $in): RowsResult
    {
        return new RowsResult();
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

    // public function Ping(ContextInterface $ctx, Message $in): Message
    // {
    //     $out = new Message();

    //     return $out->setMsg(date('Y-m-d H:i:s').': PONG');
    // }
}
