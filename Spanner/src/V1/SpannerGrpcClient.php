<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2021 Google LLC
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//     http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.
//
namespace Google\Cloud\Spanner\V1;

/**
 * Cloud Spanner API
 *
 * The Cloud Spanner API can be used to manage sessions and execute
 * transactions on data stored in Cloud Spanner databases.
 */
class SpannerGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a new session. A session can be used to perform
     * transactions that read and/or modify data in a Cloud Spanner database.
     * Sessions are meant to be reused for many consecutive
     * transactions.
     *
     * Sessions can only execute one transaction at a time. To execute
     * multiple concurrent read-write/write-only transactions, create
     * multiple sessions. Note that standalone reads and queries use a
     * transaction internally, and count toward the one transaction
     * limit.
     *
     * Active sessions use additional server resources, so it is a good idea to
     * delete idle and unneeded sessions.
     * Aside from explicit deletes, Cloud Spanner may delete sessions for which no
     * operations are sent for more than an hour. If a session is deleted,
     * requests to it return `NOT_FOUND`.
     *
     * Idle sessions can be kept alive by sending a trivial SQL query
     * periodically, e.g., `"SELECT 1"`.
     * @param \Google\Cloud\Spanner\V1\CreateSessionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateSession(\Google\Cloud\Spanner\V1\CreateSessionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.spanner.v1.Spanner/CreateSession',
        $argument,
        ['\Google\Cloud\Spanner\V1\Session', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates multiple new sessions.
     *
     * This API can be used to initialize a session cache on the clients.
     * See https://goo.gl/TgSFN2 for best practices on session cache management.
     * @param \Google\Cloud\Spanner\V1\BatchCreateSessionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BatchCreateSessions(\Google\Cloud\Spanner\V1\BatchCreateSessionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.spanner.v1.Spanner/BatchCreateSessions',
        $argument,
        ['\Google\Cloud\Spanner\V1\BatchCreateSessionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a session. Returns `NOT_FOUND` if the session does not exist.
     * This is mainly useful for determining whether a session is still
     * alive.
     * @param \Google\Cloud\Spanner\V1\GetSessionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetSession(\Google\Cloud\Spanner\V1\GetSessionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.spanner.v1.Spanner/GetSession',
        $argument,
        ['\Google\Cloud\Spanner\V1\Session', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all sessions in a given database.
     * @param \Google\Cloud\Spanner\V1\ListSessionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListSessions(\Google\Cloud\Spanner\V1\ListSessionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.spanner.v1.Spanner/ListSessions',
        $argument,
        ['\Google\Cloud\Spanner\V1\ListSessionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Ends a session, releasing server resources associated with it. This will
     * asynchronously trigger cancellation of any operations that are running with
     * this session.
     * @param \Google\Cloud\Spanner\V1\DeleteSessionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteSession(\Google\Cloud\Spanner\V1\DeleteSessionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.spanner.v1.Spanner/DeleteSession',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Executes an SQL statement, returning all results in a single reply. This
     * method cannot be used to return a result set larger than 10 MiB;
     * if the query yields more data than that, the query fails with
     * a `FAILED_PRECONDITION` error.
     *
     * Operations inside read-write transactions might return `ABORTED`. If
     * this occurs, the application should restart the transaction from
     * the beginning. See [Transaction][google.spanner.v1.Transaction] for more details.
     *
     * Larger result sets can be fetched in streaming fashion by calling
     * [ExecuteStreamingSql][google.spanner.v1.Spanner.ExecuteStreamingSql] instead.
     * @param \Google\Cloud\Spanner\V1\ExecuteSqlRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ExecuteSql(\Google\Cloud\Spanner\V1\ExecuteSqlRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.spanner.v1.Spanner/ExecuteSql',
        $argument,
        ['\Google\Cloud\Spanner\V1\ResultSet', 'decode'],
        $metadata, $options);
    }

    /**
     * Like [ExecuteSql][google.spanner.v1.Spanner.ExecuteSql], except returns the result
     * set as a stream. Unlike [ExecuteSql][google.spanner.v1.Spanner.ExecuteSql], there
     * is no limit on the size of the returned result set. However, no
     * individual row in the result set can exceed 100 MiB, and no
     * column value can exceed 10 MiB.
     * @param \Google\Cloud\Spanner\V1\ExecuteSqlRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\ServerStreamingCall
     */
    public function ExecuteStreamingSql(\Google\Cloud\Spanner\V1\ExecuteSqlRequest $argument,
      $metadata = [], $options = []) {
        return $this->_serverStreamRequest('/google.spanner.v1.Spanner/ExecuteStreamingSql',
        $argument,
        ['\Google\Cloud\Spanner\V1\PartialResultSet', 'decode'],
        $metadata, $options);
    }

    /**
     * Executes a batch of SQL DML statements. This method allows many statements
     * to be run with lower latency than submitting them sequentially with
     * [ExecuteSql][google.spanner.v1.Spanner.ExecuteSql].
     *
     * Statements are executed in sequential order. A request can succeed even if
     * a statement fails. The [ExecuteBatchDmlResponse.status][google.spanner.v1.ExecuteBatchDmlResponse.status] field in the
     * response provides information about the statement that failed. Clients must
     * inspect this field to determine whether an error occurred.
     *
     * Execution stops after the first failed statement; the remaining statements
     * are not executed.
     * @param \Google\Cloud\Spanner\V1\ExecuteBatchDmlRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ExecuteBatchDml(\Google\Cloud\Spanner\V1\ExecuteBatchDmlRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.spanner.v1.Spanner/ExecuteBatchDml',
        $argument,
        ['\Google\Cloud\Spanner\V1\ExecuteBatchDmlResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Reads rows from the database using key lookups and scans, as a
     * simple key/value style alternative to
     * [ExecuteSql][google.spanner.v1.Spanner.ExecuteSql].  This method cannot be used to
     * return a result set larger than 10 MiB; if the read matches more
     * data than that, the read fails with a `FAILED_PRECONDITION`
     * error.
     *
     * Reads inside read-write transactions might return `ABORTED`. If
     * this occurs, the application should restart the transaction from
     * the beginning. See [Transaction][google.spanner.v1.Transaction] for more details.
     *
     * Larger result sets can be yielded in streaming fashion by calling
     * [StreamingRead][google.spanner.v1.Spanner.StreamingRead] instead.
     * @param \Google\Cloud\Spanner\V1\ReadRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Read(\Google\Cloud\Spanner\V1\ReadRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.spanner.v1.Spanner/Read',
        $argument,
        ['\Google\Cloud\Spanner\V1\ResultSet', 'decode'],
        $metadata, $options);
    }

    /**
     * Like [Read][google.spanner.v1.Spanner.Read], except returns the result set as a
     * stream. Unlike [Read][google.spanner.v1.Spanner.Read], there is no limit on the
     * size of the returned result set. However, no individual row in
     * the result set can exceed 100 MiB, and no column value can exceed
     * 10 MiB.
     * @param \Google\Cloud\Spanner\V1\ReadRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\ServerStreamingCall
     */
    public function StreamingRead(\Google\Cloud\Spanner\V1\ReadRequest $argument,
      $metadata = [], $options = []) {
        return $this->_serverStreamRequest('/google.spanner.v1.Spanner/StreamingRead',
        $argument,
        ['\Google\Cloud\Spanner\V1\PartialResultSet', 'decode'],
        $metadata, $options);
    }

    /**
     * Begins a new transaction. This step can often be skipped:
     * [Read][google.spanner.v1.Spanner.Read], [ExecuteSql][google.spanner.v1.Spanner.ExecuteSql] and
     * [Commit][google.spanner.v1.Spanner.Commit] can begin a new transaction as a
     * side-effect.
     * @param \Google\Cloud\Spanner\V1\BeginTransactionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BeginTransaction(\Google\Cloud\Spanner\V1\BeginTransactionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.spanner.v1.Spanner/BeginTransaction',
        $argument,
        ['\Google\Cloud\Spanner\V1\Transaction', 'decode'],
        $metadata, $options);
    }

    /**
     * Commits a transaction. The request includes the mutations to be
     * applied to rows in the database.
     *
     * `Commit` might return an `ABORTED` error. This can occur at any time;
     * commonly, the cause is conflicts with concurrent
     * transactions. However, it can also happen for a variety of other
     * reasons. If `Commit` returns `ABORTED`, the caller should re-attempt
     * the transaction from the beginning, re-using the same session.
     *
     * On very rare occasions, `Commit` might return `UNKNOWN`. This can happen,
     * for example, if the client job experiences a 1+ hour networking failure.
     * At that point, Cloud Spanner has lost track of the transaction outcome and
     * we recommend that you perform another read from the database to see the
     * state of things as they are now.
     * @param \Google\Cloud\Spanner\V1\CommitRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Commit(\Google\Cloud\Spanner\V1\CommitRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.spanner.v1.Spanner/Commit',
        $argument,
        ['\Google\Cloud\Spanner\V1\CommitResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Rolls back a transaction, releasing any locks it holds. It is a good
     * idea to call this for any transaction that includes one or more
     * [Read][google.spanner.v1.Spanner.Read] or [ExecuteSql][google.spanner.v1.Spanner.ExecuteSql] requests and
     * ultimately decides not to commit.
     *
     * `Rollback` returns `OK` if it successfully aborts the transaction, the
     * transaction was already aborted, or the transaction is not
     * found. `Rollback` never returns `ABORTED`.
     * @param \Google\Cloud\Spanner\V1\RollbackRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Rollback(\Google\Cloud\Spanner\V1\RollbackRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.spanner.v1.Spanner/Rollback',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a set of partition tokens that can be used to execute a query
     * operation in parallel.  Each of the returned partition tokens can be used
     * by [ExecuteStreamingSql][google.spanner.v1.Spanner.ExecuteStreamingSql] to specify a subset
     * of the query result to read.  The same session and read-only transaction
     * must be used by the PartitionQueryRequest used to create the
     * partition tokens and the ExecuteSqlRequests that use the partition tokens.
     *
     * Partition tokens become invalid when the session used to create them
     * is deleted, is idle for too long, begins a new transaction, or becomes too
     * old.  When any of these happen, it is not possible to resume the query, and
     * the whole operation must be restarted from the beginning.
     * @param \Google\Cloud\Spanner\V1\PartitionQueryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function PartitionQuery(\Google\Cloud\Spanner\V1\PartitionQueryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.spanner.v1.Spanner/PartitionQuery',
        $argument,
        ['\Google\Cloud\Spanner\V1\PartitionResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a set of partition tokens that can be used to execute a read
     * operation in parallel.  Each of the returned partition tokens can be used
     * by [StreamingRead][google.spanner.v1.Spanner.StreamingRead] to specify a subset of the read
     * result to read.  The same session and read-only transaction must be used by
     * the PartitionReadRequest used to create the partition tokens and the
     * ReadRequests that use the partition tokens.  There are no ordering
     * guarantees on rows returned among the returned partition tokens, or even
     * within each individual StreamingRead call issued with a partition_token.
     *
     * Partition tokens become invalid when the session used to create them
     * is deleted, is idle for too long, begins a new transaction, or becomes too
     * old.  When any of these happen, it is not possible to resume the read, and
     * the whole operation must be restarted from the beginning.
     * @param \Google\Cloud\Spanner\V1\PartitionReadRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function PartitionRead(\Google\Cloud\Spanner\V1\PartitionReadRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.spanner.v1.Spanner/PartitionRead',
        $argument,
        ['\Google\Cloud\Spanner\V1\PartitionResponse', 'decode'],
        $metadata, $options);
    }

}
