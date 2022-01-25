<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Spanner;

use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Session\SessionPoolInterface;

/**
 * Shared methods for reads inside a transaction.
 */
trait TransactionalReadTrait
{
    use TransactionConfigurationTrait;

    /**
     * @var Operation
     */
    private $operation;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var string
     */
    private $transactionId;

    /**
     * @var string
     */
    private $context;

    /**
     * @var int
     */
    private $type;

    /**
     * @var int
     */
    private $state = self::STATE_ACTIVE;

    /**
     * @var array
     */
    private $options = [];

    /**
     * @var int
     */
    private $seqno = 1;

    /**
     * @var string
     */
    private $tag = null;

    /**
     * Run a query.
     *
     * Google Cloud PHP will infer parameter types for all primitive types and
     * all values implementing {@see Google\Cloud\Spanner\ValueInterface}, with
     * the exception of `null`. Non-associative arrays will be interpreted as
     * a Spanner ARRAY type, and must contain only a single type of value.
     * Associative arrays or values of type {@see Google\Cloud\Spanner\StructValue}
     * will be interpreted as Spanner STRUCT type. Structs MUST always explicitly
     * define their field types.
     *
     * In any case where the value of a parameter may be `null`, you MUST
     * explicitly define the parameter's type.
     *
     * With the exception of arrays and structs, types are defined using a type
     * constant defined on {@see Google\Cloud\Spanner\Database}. Examples include
     * but are not limited to `Database::TYPE_STRING` and `Database::TYPE_INT64`.
     *
     * Arrays, when explicitly typing, should use an instance of
     * {@see Google\Cloud\Spanner\ArrayType} to declare their type and the types
     * of any values contained within the array elements.
     *
     * Structs must always declare their type using an instance of
     * {@see Google\Cloud\Spanner\StructType}. Struct values may be expressed as
     * an associative array, however if the struct contains any unnamed fields,
     * or any fields with duplicate names, the struct must be expressed using an
     * instance of {@see Google\Cloud\Spanner\StructValue}. Struct value types
     * may be inferred with the same caveats as top-level parameters (in other
     * words, so long as they are not nullable and do not contain nested structs).
     *
     * Example:
     * ```
     * $result = $transaction->execute('SELECT * FROM Posts WHERE ID = @postId', [
     *     'parameters' => [
     *         'postId' => 1337
     *     ]
     * ]);
     *
     * $firstRow = $result->rows()->current();
     * ```
     *
     * ```
     * // Parameters which may be null must include an expected parameter type.
     * use Google\Cloud\Spanner\Database;
     * use Google\Cloud\Spanner\Timestamp;
     *
     * $values = [
     *     new Timestamp(new \DateTimeImmutable),
     *     null
     * ];
     *
     * $result = $transaction->execute('SELECT @timestamp as timestamp', [
     *     'parameters' => [
     *         'timestamp' => array_rand($values)
     *     ],
     *     'types' => [
     *         'timestamp' => Database::TYPE_TIMESTAMP
     *     ]
     * ]);
     *
     * $timestamp = $result->rows()->current()['timestamp'];
     * ```
     *
     * ```
     * // Array parameters which may be null or empty must include the array value type.
     * use Google\Cloud\Spanner\ArrayType;
     * use Google\Cloud\Spanner\Database;
     *
     * $result = $transaction->execute('SELECT @emptyArrayOfIntegers as numbers', [
     *     'parameters' => [
     *         'emptyArrayOfIntegers' => []
     *     ],
     *     'types' => [
     *         'emptyArrayOfIntegers' => new ArrayType(Database::TYPE_INT64)
     *     ]
     * ]);
     *
     * $row = $result->rows()->current();
     * $emptyArray = $row['numbers'];
     * ```
     *
     * ```
     * // Struct parameters provide a type definition. Fields within a Struct may
     * // be inferred following the same rules as top-level parameters. Any
     * // nested structs must be an instance of `Google\Cloud\Spanner\StructType`,
     * // and any values which could be of type `null` must explicitly specify
     * // their type.
     * use Google\Cloud\Spanner\Database;
     * use Google\Cloud\Spanner\StructType;
     *
     * $result = $transaction->execute('SELECT @userStruct.firstName, @userStruct.lastName', [
     *     'parameters' => [
     *         'userStruct' => [
     *             'firstName' => 'John',
     *             'lastName' => 'Testuser'
     *         ]
     *     ],
     *     'types' => [
     *         'userStruct' => (new StructType())
     *             ->add('firstName', Database::TYPE_STRING)
     *             ->add('lastName', Database::TYPE_STRING)
     *     ]
     * ]);
     *
     * $row = $result->rows()->current();
     * $fullName = $row['firstName'] . ' ' . $row['lastName']; // `John Testuser`
     * ```
     *
     * ```
     * // If a struct contains unnamed fields, or multiple fields with the same
     * // name, it must be defined using {@see Google\Cloud\Spanner\StructValue}.
     * use Google\Cloud\Spanner\Database;
     * use Google\Cloud\Spanner\Result;
     * use Google\Cloud\Spanner\StructValue;
     * use Google\Cloud\Spanner\StructType;
     *
     * $res = $transaction->execute('SELECT * FROM UNNEST(ARRAY(SELECT @structParam))', [
     *     'parameters' => [
     *         'structParam' => (new StructValue)
     *             ->add('foo', 'bar')
     *             ->add('foo', 2)
     *             ->addUnnamed('this field is unnamed')
     *     ],
     *     'types' => [
     *         'structParam' => (new StructType)
     *             ->add('foo', Database::TYPE_STRING)
     *             ->add('foo', Database::TYPE_INT64)
     *             ->addUnnamed(Database::TYPE_STRING)
     *     ]
     * ])->rows(Result::RETURN_NAME_VALUE_PAIR)->current();
     *
     * echo $res[0]['name'] . ': ' . $res[0]['value'] . PHP_EOL; // "foo: bar"
     * echo $res[1]['name'] . ': ' . $res[1]['value'] . PHP_EOL; // "foo: 2"
     * echo $res[2]['name'] . ': ' . $res[2]['value'] . PHP_EOL; // "2: this field is unnamed"
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.v1#google.spanner.v1.ExecuteStreamingSqlRequest ExecuteStreamingSqlRequest
     * @codingStandardsIgnoreEnd
     *
     * @codingStandardsIgnoreStart
     * @param string $sql The query string to execute.
     * @param array $options [optional] {
     *     Configuration Options.
     *     See [TransactionOptions](https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.v1#google.spanner.v1.TransactionOptions)
     *     for detailed description of available transaction options. Please
     *     note that only one of `$strong`, `$minReadTimestamp`,
     *     `$maxStaleness`, `$readTimestamp` or `$exactStaleness` may be set in
     *     a request.
     *
     *     @type array $parameters A key/value array of Query Parameters, where
     *           the key is represented in the query string prefixed by a `@`
     *           symbol.
     *     @type array $types A key/value array of Query Parameter types.
     *           Generally, Google Cloud PHP can infer types. Explicit type
     *           declarations are required in the case of struct parameters,
     *           or when a null value exists as a parameter.
     *           Accepted values for primitive types are defined as constants on
     *           {@see Google\Cloud\Spanner\Database}, and are as follows:
     *           `Database::TYPE_BOOL`, `Database::TYPE_INT64`,
     *           `Database::TYPE_FLOAT64`, `Database::TYPE_TIMESTAMP`,
     *           `Database::TYPE_DATE`, `Database::TYPE_STRING`,
     *           `Database::TYPE_BYTES`. If the value is an array, use
     *           {@see Google\Cloud\Spanner\ArrayType} to declare the array
     *           parameter types. Likewise, for structs, use
     *           {@see Google\Cloud\Spanner\StructType}.
     *     @type array $queryOptions Query optimizer configuration.
     *     @type string $queryOptions.optimizerVersion An option to control the
     *           selection of optimizer version. This parameter allows
     *           individual queries to pick different query optimizer versions.
     *           Specifying "latest" as a value instructs Cloud Spanner to use
     *           the latest supported query optimizer version. If not specified,
     *           Cloud Spanner uses optimizer version set at the client level
     *           options or set by the `SPANNER_OPTIMIZER_VERSION` environment
     *           variable. Any other positive integer (from the list of supported
     *           optimizer versions) overrides the default optimizer version for
     *           query execution. Executing a SQL statement with an invalid
     *           optimizer version will fail with a syntax error
     *           (`INVALID_ARGUMENT`) status.
     *     @type array $requestOptions Request options.
     *         For more information on available options, please see
     *         [the upstream documentation](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *         Please note, if using the `priority` setting you may utilize the constants available
     *         on {@see Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     *         Please note, the `transactionTag` setting will be ignored as the transaction tag should have already
     *         been set when creating the transaction.
     * }
     * @codingStandardsIgnoreEnd
     * @return Result
     */
    public function execute($sql, array $options = [])
    {
        $this->singleUseState();
        $this->checkReadContext();

        $options['transactionId'] = $this->transactionId;
        $options['transactionType'] = $this->context;
        $options['seqno'] = $this->seqno;
        $this->seqno++;

        $selector = $this->transactionSelector($options, $this->options);

        $options['transaction'] = $selector[0];

        unset($options['requestOptions']['transactionTag']);
        if (isset($this->tag)) {
            $options += [
                'requestOptions' => []
            ];
            $options['requestOptions']['transactionTag'] = $this->tag;
        }

        return $this->operation->execute($this->session, $sql, $options);
    }

    /**
     * Lookup rows in a table.
     *
     * Example:
     * ```
     * use Google\Cloud\Spanner\KeySet;
     *
     * $keySet = new KeySet([
     *     'keys' => [1337]
     * ]);
     *
     * $columns = ['ID', 'title', 'content'];
     *
     * $result = $transaction->read('Posts', $keySet, $columns);
     *
     * $firstRow = $result->rows()->current();
     * ```
     *
     * @see https://cloud.google.com/spanner/reference/rpc/google.spanner.v1#google.spanner.v1.ReadRequest ReadRequest
     *
     * @param string $table The table name.
     * @param KeySet $keySet The KeySet to select rows.
     * @param array $columns A list of column names to return.
     * @param array $options [optional] {
     *     Configuration Options.
     *
     *     @type string $index The name of an index on the table.
     *     @type int $limit The number of results to return.
     *     @type array $requestOptions Request options.
     *         For more information on available options, please see
     *         [the upstream documentation](https://cloud.google.com/spanner/docs/reference/rest/v1/RequestOptions).
     *         Please note, if using the `priority` setting you may utilize the constants available
     *         on {@see Google\Cloud\Spanner\V1\RequestOptions\Priority} to set a value.
     *         Please note, the `transactionTag` setting will be ignored as the transaction tag should have already
     *         been set when creating the transaction.
     * }
     * @return Result
     */
    public function read($table, KeySet $keySet, array $columns, array $options = [])
    {
        $this->singleUseState();
        $this->checkReadContext();

        $options['transactionId'] = $this->transactionId;
        $options['transactionType'] = $this->context;
        $options += $this->options;
        $selector = $this->transactionSelector($options, $this->options);

        $options['transaction'] = $selector[0];

        unset($options['requestOptions']['transactionTag']);
        if (isset($this->tag)) {
            $options += [
                'requestOptions' => []
            ];
            $options['requestOptions']['transactionTag'] = $this->tag;
        }

        return $this->operation->read($this->session, $table, $keySet, $columns, $options);
    }

    /**
     * Retrieve the Transaction ID.
     *
     * Example:
     * ```
     * $id = $transaction->id();
     * ```
     *
     * @return string|null
     */
    public function id()
    {
        return $this->transactionId;
    }

    /**
     * Get the Transaction Type.
     *
     * @access private
     * @return int
     */
    public function type()
    {
        return $this->type;
    }

    /**
     * Get the Transaction Session
     *
     * @access private
     * @return Session
     */
    public function session()
    {
        return $this->session;
    }

    /**
     * Check the transaction state, and update as necessary for single-use transactions.
     *
     * @return bool true if transaction is single use, false otherwise.
     * @throws \BadMethodCallException
     */
    private function singleUseState()
    {
        if ($this->type === self::TYPE_SINGLE_USE) {
            if ($this->state === self::STATE_SINGLE_USE_USED) {
                throw new \BadMethodCallException('This single-use transaction has already been used.');
            }

            $this->state = self::STATE_SINGLE_USE_USED;

            return true;
        }

        return false;
    }

    /**
     * Check whether the context is valid for a read operation. Reads are not
     * allowed in single-use read-write transactions.
     *
     * @throws \BadMethodCallException
     */
    private function checkReadContext()
    {
        if ($this->type === self::TYPE_SINGLE_USE && $this->context === SessionPoolInterface::CONTEXT_READWRITE) {
            throw new \BadMethodCallException('Cannot use a single-use read-write transaction for read or execute.');
        }
    }
}
