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

use Google\ApiCore\ArrayTrait;
use Google\Cloud\Spanner\V1\TransactionOptions;
use Google\Cloud\Spanner\V1\TransactionOptions\PBReadOnly;
use Google\Protobuf\Duration;

/**
 * Configure transaction selection for read, executeSql, rollback and commit.
 *
 * @internal
 */
trait TransactionConfigurationTrait
{
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
     * @param PBReadOnly $transactionLevelReadOnlyOptions Previously given call options (for single-use snapshots).
     * @return array [(array) transaction selector, (string) context]
     */
    private function transactionSelector(array &$options, ?PBReadOnly $transactionLevelReadOnlyOptions = null): array
    {
        $options += [
            'begin' => false,
            'transactionType' => Database::CONTEXT_READ,
        ];

        [$transactionOptions, $type, $context] = $this->transactionOptions($options, $transactionLevelReadOnlyOptions);

        // TransactionSelector uses a different key name for singleUseTransaction
        // and transactionId than CommitRequest, so we'll rewrite those here
        // so transactionOptions works as expected for commitRequest.

        if ($type === 'singleUseTransaction') {
            $type = 'singleUse';
        } elseif ($type === 'transactionId') {
            $type = 'id';
        }

        return [
            [$type => $transactionOptions],
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
     * @param PBReadOnly $transactionLevelReadOnlyOptions Previously given call options (for single-use snapshots).
     * @return array [(array) transaction options, (string) transaction type, (string) context]
     */
    private function transactionOptions(array &$options, ?PBReadOnly $transactionLevelReadOnlyOptions = null): array
    {
        // @TODO: Remove $options being passed by reference

        $type = null;
        $begin = $options['begin'] ?? [];
        $context = $options['transactionType'] ?? Database::CONTEXT_READWRITE;
        $id = $options['transactionId'] ?? null;

        if ($id === null) {
            if ($begin) {
                $type = 'begin';
            } else {
                $type = 'singleUseTransaction';
                $options['singleUse'] = true;
            }
        }

        if ($id !== null) {
            $type = 'transactionId';
            $transactionOptions = $id;
        } elseif ($context === Database::CONTEXT_READ) {
            $options += ['singleUse' => null];
            $transactionOptions = $this->configureReadOnlyTransactionOptions(
                $options,
                $transactionLevelReadOnlyOptions
            );
        } elseif ($context === Database::CONTEXT_READWRITE) {
            $transactionOptions = $this->configureReadWriteTransactionOptions(
                // TODO: Find out when $begin is a bool and fix it
                $type == 'begin' && !is_bool($begin) ? $begin : []
            );
        } else {
            throw new \BadMethodCallException(sprintf(
                'Invalid transaction context %s',
                $context
            ));
        }

        // @TODO: Remove this once $options is no longer passed by reference
        unset(
            $options['begin'],
            $options['transactionType'],
            $options['transactionId'],
        );

        // For backwards compatibility - remove all PBReadOnly fields
        // This was previously being done in configureReadOnlyTransactionOptions
        // @TODO: Remove this once $options is no longer passed by reference
        unset(
            $options['returnReadTimestamp'],
            $options['strong'],
            $options['readTimestamp'],
            $options['exactStaleness'],
            $options['minReadTimestamp'],
            $options['maxStaleness'],
        );

        return [$transactionOptions, $type, $context];
    }

    // Init readWrite options array with any necessary defaults for its nested options
    private function initReadWriteTransactionOptions(): array
    {
        return ['readWrite' => []];
    }

    private function configureReadWriteTransactionOptions(array|TransactionOptions $options): array
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
        ]) + $this->initReadWriteTransactionOptions();
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
     * @param PBReadOnly $transactionLevelReadOnlyOptions Previously given call options (for single-use snapshots).
     * @return array
     */
    private function configureReadOnlyTransactionOptions(
        array $options,
        ?PBReadOnly $transactionLevelReadOnlyOptions = null
    ): array {
        // select only the PBReadOnly fields from $options
        $readOnly = array_intersect_key($options, array_flip([
            'minReadTimestamp',
            'readTimestamp',
            'returnReadTimestamp',
            'exactStaleness',
            'maxStaleness',
            'strong'
        ]));

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

        if ($transactionLevelReadOnlyOptions && empty($readOnly)) {
            $readOnly = $transactionLevelReadOnlyOptions;
        }

        if (empty($readOnly)) {
            $readOnly['strong'] = true;
        }

        return ['readOnly' => $readOnly];
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
    private function configureDirectedReadOptions(array $requestOptions, array $clientOptions): array
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
