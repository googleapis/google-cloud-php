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

use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Spanner\Session\SessionPoolInterface;

/**
 * Configure transaction selection for read, executeSql, rollback and commit.
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
     * @param array $options call options.
     * @param array $previous Previously given call options (for single-use snapshots).
     * @return array [(array) transaction selector, (string) context]
     */
    private function transactionSelector(array &$options, array $previous = [])
    {
        $options += [
            'begin' => false,
            'transactionType' => SessionPoolInterface::CONTEXT_READ,
        ];

        $res = $this->transactionOptions($options, $previous);

        // TransactionSelector uses a different key name for singleUseTransaction
        // and transactionId than transactionOptions, so we'll rewrite those here
        // so transactionOptions works as expected for commitRequest.

        $type = $res[1];
        if ($type === 'singleUseTransaction') {
            $type = 'singleUse';
        } elseif ($type === 'transactionId') {
            $type = 'id';
        }

        return [
            [$type => $res[0]],
            $res[2]
        ];
    }

    /**
     * Return transaction options based on given configuration options.
     *
     * @param array $options call options.
     * @param array $previous Previously given call options (for single-use snapshots).
     * @return array [(array) transaction options, (string) transaction type, (string) context]
     */
    private function transactionOptions(array &$options, array $previous = [])
    {
        $options += [
            'begin' => false,
            'transactionType' => SessionPoolInterface::CONTEXT_READWRITE,
            'transactionId' => null,
        ];

        $type = null;

        $context = $this->pluck('transactionType', $options);
        $id = $this->pluck('transactionId', $options);

        if (!is_null($id)) {
            $type = 'transactionId';
            $transactionOptions = $id;
        } elseif ($context === SessionPoolInterface::CONTEXT_READ) {
            $transactionOptions = $this->configureSnapshotOptions($options, $previous);
        } elseif ($context === SessionPoolInterface::CONTEXT_READWRITE) {
            $transactionOptions = $this->configureTransactionOptions();
        } else {
            throw new \BadMethodCallException(sprintf(
                'Invalid transaction context %s',
                $context
            ));
        }

        $begin = $this->pluck('begin', $options);
        if (is_null($type)) {
            $type = ($begin) ? 'begin' : 'singleUseTransaction';
        }

        return [$transactionOptions, $type, $context];
    }

    private function configureTransactionOptions()
    {
        return [
            'readWrite' => []
        ];
    }

    /**
     * Configure a Read-Only transaction.
     *
     * @param array $options Configuration Options.
     * @param array $previous Previously given call options (for single-use snapshots).
     * @return array
     */
    private function configureSnapshotOptions(array &$options, array $previous = [])
    {
        $options += [
            'singleUse' => false,
            'returnReadTimestamp' => null,
            'strong' => null,
            'readTimestamp' => null,
            'exactStaleness' => null,
            'minReadTimestamp' => null,
            'maxStaleness' => null,
        ];

        $previousOptions = isset($previous['transactionOptions']['readOnly'])
            ? $previous['transactionOptions']['readOnly']
            : [];

        // These are only available in single-use transactions.
        if (!$options['singleUse'] && ($options['maxStaleness'] || $options['minReadTimestamp'])) {
            throw new \BadMethodCallException(
                'maxStaleness and minReadTimestamp are only available in single-use transactions.'
            );
        }

        $transactionOptions = [
            'readOnly' => $this->arrayFilterRemoveNull([
                'returnReadTimestamp' => $this->pluck('returnReadTimestamp', $options),
                'strong' => $this->pluck('strong', $options),
                'minReadTimestamp' => $this->pluck('minReadTimestamp', $options),
                'maxStaleness' => $this->pluck('maxStaleness', $options),
                'readTimestamp' => $this->pluck('readTimestamp', $options),
                'exactStaleness' => $this->pluck('exactStaleness', $options),
            ]) + $previousOptions
        ];

        if (empty($transactionOptions['readOnly'])) {
            $transactionOptions['readOnly']['strong'] = true;
        }

        $timestampFields = [
            'minReadTimestamp',
            'readTimestamp'
        ];

        $durationFields = [
            'exactStaleness',
            'maxStaleness'
        ];

        foreach ($timestampFields as $tsf) {
            if (isset($transactionOptions['readOnly'][$tsf]) && !isset($previousOptions[$tsf])) {
                $field = $transactionOptions['readOnly'][$tsf];
                if (!($field instanceof Timestamp)) {
                    throw new \BadMethodCallException(sprintf(
                        'Read Only Transaction Configuration Field %s must be an instance of Timestamp',
                        $tsf
                    ));
                }

                $transactionOptions['readOnly'][$tsf] = $field->formatAsString();
            }
        }

        foreach ($durationFields as $df) {
            if (isset($transactionOptions['readOnly'][$df]) && !isset($previousOptions[$df])) {
                $field = $transactionOptions['readOnly'][$df];
                if (!($field instanceof Duration)) {
                    throw new \BadMethodCallException(sprintf(
                        'Read Only Transaction Configuration Field %s must be an instance of Duration',
                        $df
                    ));
                }

                $transactionOptions['readOnly'][$df] = $field->get();
            }
        }

        return $transactionOptions;
    }
}
