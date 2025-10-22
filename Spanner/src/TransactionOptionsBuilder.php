<?php
/**
 * Copyright 2025 Google Inc.
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

use Google\ApiCore\ArrayTrait;
use Google\Cloud\Spanner\V1\TransactionOptions;
use Google\Cloud\Spanner\V1\TransactionOptions\PBReadOnly;
use Google\Protobuf\Duration;

/**
 * Configure transaction selection for read, executeSql, rollback and commit.
 *
 * @internal
 */
class TransactionOptionsBuilder
{
    private const TYPE_ID = 'transactionId';
    private const TYPE_SINGLE_USE = 'singleUseTransaction';
    private const TYPE_ILB = 'begin'; // Inline Begin Transaction

    use ArrayTrait;

    /**
     * Format a transaction from read or execute.
     *
     * Depending on given options, can be singleUse or begin, and can be read
     * or read/write.
     *
     * @see V1\TransactionSelector
     *
     * @param array $options call options.
     * @param PBReadOnly $txnLevelReadOnlyOptions Previously given call options (for single-use snapshots).
     * @return array{array<string, array>, string}
     */
    public function transactionSelector(array $options, ?PBReadOnly $txnLevelReadOnlyOptions = null): array
    {
        [$transactionOptions, $selector, $context] = $this->transactionOptions(
            $options + ['transactionType' => Database::CONTEXT_READ],
            $txnLevelReadOnlyOptions
        );

        // TransactionSelector uses a different key name for singleUseTransaction
        // and transactionId than CommitRequest, so we'll rewrite those here
        // so transactionOptions works as expected for commitRequest.
        $commitSelector = match ($selector) {
            self::TYPE_ID => 'id',
            self::TYPE_SINGLE_USE => 'singleUse',
            self::TYPE_ILB => 'begin',
        };
        return [
            [$commitSelector => $transactionOptions],
            $context
        ];
    }

    /**
     * Return transaction options based on given configuration options.
     *
     * @see V1\TransactionOptions
     *
     * @param array $options call options
     *
     * @param PBReadOnly $txnLevelReadOnlyOptions Previously given call options (for single-use snapshots).
     * @return array{mixed, 'transactionId'|'begin'|'singleUseTransaction', string}
     * @throws \BadMethodCallException
     */
    public function transactionOptions(array $options, ?PBReadOnly $txnLevelReadOnlyOptions = null): array
    {
        [$id, $begin, $context] = [
            $options['transactionId'] ?? null,
            $options['begin'] ?? [],
            $options['transactionType'] ?? Database::CONTEXT_READWRITE,
        ];

        $selector = match ($id !== null) {
            true => self::TYPE_ID,
            false => !empty($begin) ? self::TYPE_ILB : self::TYPE_SINGLE_USE,
        };

        if ($selector === self::TYPE_ID) {
            return [$id, $selector, $context];
        }

        if ($context === Database::CONTEXT_READ) {
            if ($selector === self::TYPE_SINGLE_USE) {
                $options['singleUse'] = true;
            }
            $transactionOptions = $this->configureReadOnlyTransactionOptions(
                $options,
                $txnLevelReadOnlyOptions
            );

            return [$transactionOptions, $selector, $context];
        }

        if ($context === Database::CONTEXT_READWRITE) {
            $beginOptions = $selector === self::TYPE_ILB && $begin !== true ? $begin : [];
            $transactionOptions = $this->configureReadWriteTransactionOptions($beginOptions);

            return [$transactionOptions, $selector, $context];
        }

        throw new \BadMethodCallException(sprintf(
            'Invalid transaction context %s',
            $context
        ));
    }

    /**
     * Configure the DirectedReadOptions.
     *
     * Request level DirectedReadOptions takes precedence over client level DirectedReadOptions.
     * Client level DirectedReadOptions apply only to read-only and single-use transactions.
     *
     * @param array $requestOptions Request level options.
     * @param array $clientOptions Client level Directed Read Options.
     * @return array
     */
    public function configureDirectedReadOptions(array $requestOptions, array $clientOptions): array
    {
        if (isset($requestOptions['directedReadOptions'])) {
            return $requestOptions['directedReadOptions'];
        }

        if (isset($requestOptions['transaction']['singleUse']) || (
            ($requestOptions['transactionContext'] ?? null) == Database::CONTEXT_READ
        ) || isset($requestOptions['transactionOptions']['readOnly'])
        ) {
            if (isset($clientOptions['includeReplicas'])) {
                return ['includeReplicas' => $clientOptions['includeReplicas']];
            } elseif (isset($clientOptions['excludeReplicas'])) {
                return ['excludeReplicas' => $clientOptions['excludeReplicas']];
            }
        }

        return [];
    }

    public function configureReadWriteTransactionOptions(array|TransactionOptions $options): array
    {
        $excludeTxn = $options instanceof TransactionOptions
            ? $options->getExcludeTxnFromChangeStreams()
            : $options['excludeTxnFromChangeStreams'] ?? null;
        $isolationLevel = $options instanceof TransactionOptions
            ? $options->getIsolationLevel()
            : $options['isolationLevel'] ?? null;
        $readLockMode = $options instanceof TransactionOptions
            ? $options->getReadWrite()->getReadLockMode()
            : $options['readLockMode'] ?? $options['readWrite']['readLockMode'] ?? null;
        return array_filter([
            'excludeTxnFromChangeStreams' => $excludeTxn,
            'isolationLevel' => $isolationLevel,
            'readWrite' => array_filter(['readLockMode' => $readLockMode]),
        ]) + ['readWrite' => []];
    }

    /**
     * Configure a Read-Only transaction.
     *
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     See [ReadOnly](https://cloud.google.com/spanner/reference/rpc/google.spanner.v1#google.spanner.v1.TransactionOptions.ReadOnly)
     *     for detailed description of available options.
     *
     *     Please note that only one of `$strong`, `$readTimestamp` or
     *     `$exactStaleness` may be set in a request.
     *
     *     @type bool $returnReadTimestamp If true, the Cloud Spanner-selected
     *           read timestamp is included in the Transaction message that
     *           describes the transaction.
     *     @type bool $strong Read at a timestamp where all previously committed
     *           transactions are visible.
     *     @type Timestamp $readTimestamp Executes all reads at the given
     *           timestamp.
     *     @type Duration $exactStaleness Represents a number of seconds. Executes
     *           all reads at a timestamp that is $exactStaleness old.
     *     @type Timestamp $minReadTimestamp Executes all reads at a
     *           timestamp >= min_read_timestamp. Only available when
     *           `$options.singleUse` is true.
     *     @type Duration $maxStaleness Read data at a timestamp >= NOW - max_staleness
     *           seconds. Guarantees that all writes that have committed more
     *           than the specified number of seconds ago are visible. Only
     *           available when `$options.singleUse` is true.
     *     @type bool $singleUse If true, a Transaction ID will not be allocated
     *           up front. Instead, the transaction will be considered
     *           "single-use", and may be used for only a single operation.
     *           **Defaults to** `false`.
     * }
     * @param PBReadOnly $txnLevelReadOnlyOptions Previously given call options (for single-use snapshots).
     * @return array
     */
    public function configureReadOnlyTransactionOptions(
        array $options,
        ?PBReadOnly $txnLevelReadOnlyOptions = null
    ): array {
        // select only the PBReadOnly fields from $options
        $readOnly = $this->pluckArray([
            'minReadTimestamp',
            'readTimestamp',
            'returnReadTimestamp',
            'exactStaleness',
            'maxStaleness',
            'strong'
        ], $options);

        // Validate options types
        if ($this->validateOptionType($readOnly, 'minReadTimestamp', Timestamp::class)) {
            $readOnly['minReadTimestamp'] = $readOnly['minReadTimestamp']->formatAsString();
        }

        if ($this->validateOptionType($readOnly, 'readTimestamp', Timestamp::class)) {
            $readOnly['readTimestamp'] = $readOnly['readTimestamp']->formatAsString();
        }

        $this->validateOptionType($readOnly, 'exactStaleness', Duration::class);
        $this->validateOptionType($readOnly, 'maxStaleness', Duration::class);

        // These are only available in single-use transactions.
        if (!($options['singleUse'] ?? false)
            && (!empty($readOnly['maxStaleness']) || !empty($readOnly['minReadTimestamp']))
        ) {
            throw new \BadMethodCallException(
                'maxStaleness and minReadTimestamp are only available in single-use transactions.'
            );
        }

        if ($txnLevelReadOnlyOptions && empty($readOnly)) {
            $readOnly = $txnLevelReadOnlyOptions;
        }

        if (empty($readOnly)) {
            $readOnly['strong'] = true;
        }

        return ['readOnly' => $readOnly];
    }

    /**
     * @throws \BadMethodCallException
     */
    private function validateOptionType(array $options, string $field, string $type): bool
    {
        if (!isset($options[$field])) {
            return false;
        }

        if (!$options[$field] instanceof $type) {
            throw new \BadMethodCallException(sprintf(
                'Read Only Transaction Configuration Field %s must be an instance of `%s`.',
                $field,
                $type
            ));
        }

        return true;
    }
}
