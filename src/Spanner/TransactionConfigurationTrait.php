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

use Google\Cloud\ArrayTrait;
use Google\Cloud\Spanner\Session\SessionPoolInterface;

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
     * @return array
     */
    private function transactionSelector(array &$options)
    {
        $options += [
            'begin' => false,
            'transactionType' => SessionPoolInterface::CONTEXT_READ,
            'transactionId' => null
        ];

        $type = null;

        $context = $this->pluck('transactionType', $options);
        $id = $this->pluck('transactionId', $options);
        if (!is_null($id)) {
            $type = 'id';
            $transactionOptions = $id;
        } elseif ($context === SessionPoolInterface::CONTEXT_READ) {
            $transactionOptions = $this->configureSnapshotOptions($options);
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
            $type = ($begin) ? 'begin' : 'singleUse';
        }

        return [
            [$type => $transactionOptions],
            $context
        ];
    }

    private function configureTransactionOptions()
    {
        return [
            'readWrite' => []
        ];
    }

    /**
     * Create a Read Only single use transaction.
     *
     * @param array $options Configuration Options.
     * @return array
     */
    private function configureSnapshotOptions(array &$options)
    {
        $options += [
            'returnReadTimestamp' => null,
            'strong' => null,
            'readTimestamp' => null,
            'exactStaleness' => null,
            'minReadTimestamp' => null,
            'maxStaleness' => null,
        ];

        $transactionOptions = [
            'readOnly' => $this->arrayFilterRemoveNull([
                'returnReadTimestamp' => $this->pluck('returnReadTimestamp', $options),
                'strong' => $this->pluck('strong', $options),
                'minReadTimestamp' => $this->pluck('minReadTimestamp', $options),
                'maxStaleness' => $this->pluck('maxStaleness', $options),
                'readTimestamp' => $this->pluck('readTimestamp', $options),
                'exactStaleness' => $this->pluck('exactStaleness', $options),
            ])
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
            if (isset($transactionOptions['readOnly'][$tsf])) {
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
            if (isset($transactionOptions['readOnly'][$df])) {
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
